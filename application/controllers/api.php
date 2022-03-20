<?php


/*********************************************************************
 * PHPBack
 * Ivan Diaz <ivan@phpback.org>
 * Copyright (c) 2014 PHPBack
 * http://www.phpback.org
 * Released under the GNU General Public License WITHOUT ANY WARRANTY.
 * See LICENSE.TXT for details.
 **********************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        session_start();

        $this->load->helper('url');
        $this->load->model('get');
        $this->load->model('post');

        $this->lang->load('default', $this->get->getSetting('language'));

        $this->verifyBanning();
    }

    public function index() {
        $this->load->view('api/index');
    }

    public function register() {
        require_once('public/recaptcha/recaptchalib.php');

        header("content-type: application/json");

        $votes = $this->get->getSetting('maxvotes');
        $title = $this->get->getSetting('title');
        $mainmail = $this->get->getSetting('mainmail');

        $email = $_GET['email'];
        $pass = $_GET['pass'];
        $name = $_GET['name'];

        if ($email !== null and $pass !== null and $name !== null) {
            if ($this->get->getSetting('recaptchapublic') != "") {
                $resp = recaptcha_check_answer($this->get->getSetting('recaptchaprivate'),
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["recaptcha_challenge_field"],
                    $_POST["recaptcha_response_field"]);

                if (!$resp->is_valid) {
                    header('Location: ' . base_url() . 'home/register/recaptcha');
                    return;
                }
            }

            if (strlen($name) < 3) {
                $login_data["response"] = array(
                    "error" => "Имя пользователя не может быть меньше 3 символов",
                );

                $this->load->view('api/json', $login_data);
                return;
            }
            if (!preg_match("/^([a-zA-Z0-9._-]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$/", $email)) {
                $login_data["response"] = array(
                    "error" => "Неправильная почта",
                );

                $this->load->view('api/json', $login_data);
                return;
            }
            if (strlen($pass) < 6) {
                $login_data["response"] = array(
                    "error" => "Пароль не может быть меньше 6 символов",
                );

                $this->load->view('api/json', $login_data);
                return;
            }

            if ($this->post->add_user($name, $email, $pass, $votes, false)) {
                $message = "Добро пожаловать в систему обратной связи: $title\n\nВаш Email: $email\nВаш пароль: $pass\n\n\nПожалуйста, авторизуйтесь:" . base_url() . "home/login\n";
                $this->load->library('email');

                $this->email->initialize($this->get->email_config());

                $this->email->from($mainmail, 'PHPBack');
                $this->email->to($email);

                $this->email->subject("New account - $title");
                $this->email->message($message);

                $this->email->send();

                $result = $this->get->login($email, $pass);

                if ($result !== 0) {
                    $user = $this->get->getUser($result);
                    $this->get->setSessionUserValues($user);

                    if (@isset($_POST['rememberme']) && $_POST['rememberme']) {
                        $this->get->setSessionCookie();
                    }
                }

                $login_data["response"] = array(
                    "success" => "Вы успешно зарегистрировались",
                );

                $this->load->view('api/json', $login_data);
                return;
            } else {
                $login_data["response"] = array(
                    "error" => "Такой пользователь уже существует",
                );

                $this->load->view('api/json', $login_data);
            }
        } else {
            $login_data["response"] = array(
                "error" => "Не отправлены поля name, pass или email",
            );

            $this->load->view('api/json', $login_data);
        }
    }

    public function login() {
        header("content-type: application/json");

        $email = $_GET['email'];
        $pass = $_GET['pass'];

        if ($email !== null and $pass !== null) {
            $result = $this->get->login($email, $pass);

            if ($result !== 0) {
                $user = $this->get->getUser($result);
                $this->get->setSessionUserValues($user);

                if (@isset($_POST['rememberme']) && $_POST['rememberme']) {
                    $this->get->setSessionCookie();
                }

                $login_data["response"] = array(
                    "success" => "Вы успешно вошли",
                );

                $this->load->view('api/json', $login_data);
            }
            else {
                $login_data["response"] = array(
                    "error" => "Неверный логин или пароль",
                );

                $this->load->view('api/json', $login_data);
            }
        } else {
            $login_data["response"] = array(
                "error" => "Вы не отправили логин или пароль",
            );

            $this->load->view('api/json', $login_data);
        }
    }

    public function add_idea(){
        header("content-type: application/json");
        if(!isset($_SESSION['phpback_userid'])){
            $login_data["response"] = array(
                "error" => "Вы не авторизованы",
            );

            $this->load->view('api/json', $login_data);
            return;
        }

        $title = $_GET['title'];
        $desc = $_GET['description'];
        $catid = $_GET['category'];

        if($catid == 0){
            $login_data["response"] = array(
                "error" => "Неверно выбрана категория",
            );

            $this->load->view('api/json', $login_data);
            return;
        }
        if(strlen($title) < 9){
            $login_data["response"] = array(
                "error" => "Заголовок не может быть меньше 9 символов",
            );

            $this->load->view('api/json', $login_data);
            return;
        }
        if(strlen($desc) < 20){
            $login_data["response"] = array(
                "error" => "Описание не может быть меньше 20 символов",
            );

            $this->load->view('api/json', $login_data);
            return;
        }

        if(@isset($_SESSION['phpback_userid']))
            $this->post->add_idea($title, $desc, $_SESSION['phpback_userid'], $catid);
    }

    private function verifyBanning() {
        if (@isset($_SESSION['phpback_userid']) && ($ban = $this->get->getBanValue($_SESSION['phpback_userid'])) != 0) {
            date_default_timezone_set('America/Los_Angeles');

            //Remove ban if ban expired
            if ($ban <= date("Ymd") && $ban != -1) {
                $this->post->unban($_SESSION['phpback_userid']);
                return;
            }

            session_destroy();
            $this->destroyUserCookie();

            if ($ban != -1) {
                for($i = 0; $i < 366; $i++){
                    if(date('Ymd', strtotime("+$i days")) == $ban) break;
                }
            }
            else $i = -1;

            header('Location: '. base_url() .'home/login/banned/' . $i);
            exit;
        }
    }
}