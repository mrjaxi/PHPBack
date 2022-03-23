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

//        $this->verifyBanning();
    }

    public function auto_redirect(){
        $url = $_GET['url'];
        $userBase64 = $_GET['user'];

        if (!empty($userBase64) and !empty($url)) {
            $user = $this->decodeBase64User($userBase64);
            $email = $user[0];
            $pass  = $user[1];
            $isLogin = $this->get->isLoginEmailHashPass($email, $pass);
            if(!empty($isLogin->id)){
                $result = $this->get->login($email, $pass);
                if ($result !== 0) {
                    $user = $this->get->getUser($result);
                    $this->get->setSessionUserValues($user);

                    if (@isset($_POST['rememberme']) && $_POST['rememberme']) {
                        $this->get->setSessionCookie();
                    }
                }
            }
        }

        header('Location: ' . $url);

        $this->autoLoginByCookie();
    }

    public function register() {
        $votes = $this->get->getSetting('maxvotes');

        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $name = $_POST['name'];

        if (!empty($email) and !empty($pass)) {
            if(empty($name)){
                $name = "Незнакомец";
            }
            if ($this->post->add_user($name, $email, $pass, $votes, false)) {
                $result = $this->get->login($email, $pass);

                if ($result !== 0) {
                    return $this->setResponse(array(
                        "success" => "Вы успешно зарегистрировались",
                    ));
                } else {
                    return $this->setResponse(array(
                        "error" => "Не получилось авторизоваться",
                    ));
                }
            } else {
                return $this->setResponse(array(
                    "error" => "Такой пользователь уже существует",
                ));
            }
        } else {
            return $this->setResponse(array(
                "error" => "Не отправлены поля pass или email",
            ));
        }
    }

    public function login() {
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        if (!empty($email) and !empty($pass)) {
            $result = $this->get->login($email, $pass);

            if ($result !== 0) {
                return $this->setResponse(array(
                    "success" => "Вы успешно вошли",
                ));
            }
            else {
                return $this->setResponse(array(
                    "error" => "Неверный логин или пароль",
                ));
            }
        } else {
            return $this->setResponse(array(
                "error" => "Вы не отправили email или pass",
            ));
        }
    }

    public function setUsername(){
        $email = $_POST['email'];
        $name = $_POST['name'];

        if (!empty($email) and !empty($name)) {

            if ($this->post->update_username_api($name, $email)) {
                return $this->setResponse(array(
                    "success" => "Вы успешно сменили имя",
                ));
            } else {
                return $this->setResponse(array(
                    "error" => "Такого пользователя не существует",
                ));
            }
        } else {
            return $this->setResponse(array(
                "error" => "Вы не отправили логин или пароль",
            ));
        }
    }

    public function add_idea(){
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $catid = $_POST['category'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        if(empty($title) or empty($desc) or empty($catid) or empty($email)){
            return $this->setResponse(array(
                "error" => "Не введены значения title, description, category, email",
            ));
        }
        if($catid < 1){
            return $this->setResponse(array(
                "error" => "Неверно выбрана категория",
            ));
        }
        if(strlen($title) < 5){
            return $this->setResponse(array(
                "error" => "Заголовок не может быть меньше 5 символов",
            ));
        }
        if(strlen($desc) < 10){
            return $this->setResponse(array(
                "error" => "Описание не может быть меньше 10 символов",
            ));
        }
        $user = $this->get->getUserByEmail($email);
        if(empty($user)){
            if(empty($pass)){
                return $this->setResponse(array(
                    "error" => "Нет пароля чтобы зарегистрировать нового пользователя",
                ));
            }
            $votes = $this->get->getSetting('maxvotes');
            if($this->post->add_user("Незнакомец", $email, $pass, $votes, false)){
                $user = $this->get->getUserByEmail($email);
                $idea = $this->post->add_idea($title, $desc, $user->id, $catid);
                $userBase64 = $this->encodeBase64User($user->email, $user->pass);
                return $this->setResponse(array(
                    "success" => "Идея успешно добавлена",
                    "url" => base_url() . "api/auto_redirect" .
                        "?url=" . base_url() . "home/idea/" . $idea->id .
                        "&user=" . $userBase64
                ));
            } else {
                return $this->setResponse(array(
                    "error" => "Не удалось зарегистрировать нового пользователя",
                ));
            }
        }

        $idea = $this->post->add_idea($title, $desc, $user->id, $catid);
        $userBase64 = $this->encodeBase64User($user->email, $user->pass);
        return $this->setResponse(array(
            "success" => "Идея успешно добавлена",
            "url" => base_url() . "api/auto_redirect" .
                "?url=" . base_url() . "home/idea/" . $idea->id .
                "&user=" . $userBase64
        ));
    }

    public function getCategories(){
        return $this->setResponse(array(
            "categories" => $this->get->getCategories()
        ));
    }

    private function setResponse($data = array()){
        $response["response"] = $data;
        return $this->load->view('api/json', $response);
    }

    private function decodeBase64User($userBase64){
        return explode(":", base64_decode(strtr($userBase64, '._-', '+/=')));
    }

    private function encodeBase64User($email, $pass){
        return strtr(base64_encode($email . ':' . $pass), '+/=', '._-');
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
                exit;
            }
        }
    }
}