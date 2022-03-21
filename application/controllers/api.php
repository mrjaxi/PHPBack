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
    private $banned = null;

    public function __construct() {
        parent::__construct();
        session_start();
        header("content-type: application/json");

        $this->load->helper('url');
        $this->load->model('get');
        $this->load->model('post');

        $this->lang->load('default', $this->get->getSetting('language'));

        $this->verifyBanning();
        if($this->banned){
            $response["response"] = array(
                "error" => $this->banned,
            );

            $this->load->view('api/json', $response);
            exit;
        }
    }

    public function index() {
        $this->load->view('api/index');
    }

    public function register() {
        $votes = $this->get->getSetting('maxvotes');
        $title = $this->get->getSetting('title');
        $mainmail = $this->get->getSetting('mainmail');

        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $name = $_POST['name'];

        if (!empty($email) and !empty($pass)) {
            if(empty($name)){
                $name = "Незнакомец";
            }
            if (!preg_match("/^([a-zA-Z0-9._-]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$/", $email)) {
                $login_data["response"] = array(
                    "error" => "Неправильная почта",
                );

                $this->load->view('api/json', $login_data);
                return;
            }

            if ($this->post->add_user($name, $email, $pass, $votes, false)) {
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
                "error" => "Не отправлены поля pass или email",
            );

            $this->load->view('api/json', $login_data);
        }
    }

    public function login() {
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        if (!empty($email) and !empty($pass)) {
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
                "error" => "Вы не отправили email или pass",
            );

            $this->load->view('api/json', $login_data);
        }
    }

    public function add_idea(){
        if(!isset($_SESSION['phpback_userid'])){
            $login_data["response"] = array(
                "error" => "Вы не авторизованы",
            );

            $this->load->view('api/json', $login_data);
            return;
        }

        $title = $_POST['title'];
        $desc = $_POST['description'];
        $catid = $_POST['category'];

        if(empty($title) and empty($desc) and empty($catid)){
            $login_data["response"] = array(
                "error" => "Не введены значения title, description, category",
            );
            $this->load->view('api/json', $login_data);
            return;
        }
        if($catid < 1){
            $login_data["response"] = array(
                "error" => "Неверно выбрана категория",
            );
            $this->load->view('api/json', $login_data);
            return;
        }
        if(strlen($title) < 5){
            $login_data["response"] = array(
                "error" => "Заголовок не может быть меньше 5 символов",
            );

            $this->load->view('api/json', $login_data);
            return;
        }
        if(strlen($desc) < 10){
            $login_data["response"] = array(
                "error" => "Описание не может быть меньше 10 символов",
            );

            $this->load->view('api/json', $login_data);
            return;
        }

        if(@isset($_SESSION['phpback_userid']))
            $this->post->add_idea($title, $desc, $_SESSION['phpback_userid'], $catid);
    }

    public function get_Category(){

    }

    private function verifyBanning() {
        if (@isset($_SESSION['phpback_userid']) && ($ban = $this->get->getBanValue($_SESSION['phpback_userid'])) != 0) {
            date_default_timezone_set('America/Los_Angeles');

            // Remove ban if ban expired
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
            else $i = -1; // -1 на неопределенный срок

//            header('Location: '. base_url() .'home/login/banned/' . $i);
            $this->banned = $lang['error_banned_inf'];
            exit;
        }
    }

    private function destroyUserCookie() {
        if(@isset($_COOKIE['phpback_sessionid'])){
            $this->get->verifyToken($_COOKIE['phpback_sessionid']);
            setcookie('phpback_sessionid', '', time()-3600, '/');
        }
    }

    private function autoLoginByCookie() {
        if(@!isset($_SESSION['phpback_userid']) && @isset($_COOKIE['phpback_sessionid'])) {
            $result = $this->get->verifyToken($_COOKIE['phpback_sessionid']);
            if($result != 0) {
                $user = $this->get->getUser($result);
                $_SESSION['phpback_userid'] = $user->id;
                $_SESSION['phpback_username'] = $user->name;
                $_SESSION['phpback_useremail'] = $user->email;
                setcookie('phpback_sessionid',  $this->get->new_token($_SESSION['phpback_userid']), time()+3600*24*30, '/');
                header('Location: '. base_url() .'home');
                exit;
            }
        }
    }
}