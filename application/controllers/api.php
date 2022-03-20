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
        $this->load->view('api/register');
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

                $this->load->view('api/login', $login_data);
            }
        } else {
            $login_data["response"] = array(
                "error" => "Вы не отправили логин или пароль",
            );

            $this->load->view('api/json', $login_data);
        }
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