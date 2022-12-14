<?php
/*********************************************************************
PHPBack
Ivan Diaz <ivan@phpback.org>
Copyright (c) 2014 PHPBack
http://www.phpback.org
Released under the GNU General Public License WITHOUT ANY WARRANTY.
See LICENSE.TXT for details.
 **********************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('get');
        $this->load->model('post');
    }
    public function register(){
        require_once('public/recaptcha/recaptchalib.php');

        $votes = $this->get->getSetting('maxvotes');
        $title = $this->get->getSetting('title');
        $mainmail = $this->get->getSetting('mainmail');

        $email = $this->input->post('email', true);
        $pass = $this->input->post('password', true);
        $pass2 = $this->input->post('password2', true);
        $name = $this->input->post('name', true);

        if($this->get->getSetting('recaptchapublic') != ""){
            $resp = recaptcha_check_answer($this->get->getSetting('recaptchaprivate'),
                $_SERVER["REMOTE_ADDR"],
                $_POST["recaptcha_challenge_field"],
                $_POST["recaptcha_response_field"]);

            if(!$resp->is_valid){
                header('Location: '. base_url() .'home/register/recaptcha');
                return;
            }
        }
        if(strlen($name) < 3){
            header('Location: '. base_url() .'home/register/name');
            return;
        }
        if (!preg_match("/^([a-zA-Z0-9._-]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$/",$email)){
            header('Location: '. base_url() .'home/register/email');
            return;
        }
        if(strlen($pass) < 6){
            header('Location: '. base_url() .'home/register/pass');
            return;
        }
        if($pass != $pass2){
            header('Location: '. base_url() .'home/register/pass2');
            return;
        }

        if($this->post->add_user($name, $email, $pass, $votes, false)){
            $message = "?????????? ???????????????????? ?? ?????????????? ???????????????? ??????????: $title\n\n?????? Email: $email\n?????? ????????????: $pass\n\n\n????????????????????, ??????????????????????????:" . base_url() . "home/login\n";
            $this->load->library('email');

            $this->email->initialize($this->get->email_config());

            $this->email->from($mainmail, '???????????????? FeedBack');
            $this->email->to($email);

            $this->email->subject("?????????? ?????????????? - $title");
            $this->email->message($message);

            $this->email->send();

            header('Location: '. base_url() .'home/login/register');
        }
        else header('Location: '. base_url() .'home/register/exists');

    }

    public function login(){
        session_start();

        $email = $this->input->post('email', true);
        $pass = $this->input->post('password', true);
        $result = $this->get->login($email, $pass);

        if ($result != 0) {
            $user = $this->get->getUser($result);
            $this->get->setSessionUserValues($user);

            if(@isset($_POST['rememberme']) && $_POST['rememberme']){
                $this->get->setSessionCookie();
            }

            header('Location: ' . base_url() . 'home/');
        }
        else {
            header('Location: ' . base_url() . 'home/login/errorlogin/');
        }
    }

    public function logout(){
        session_start();
        session_destroy();
        if(@isset($_COOKIE['phpback_sessionid'])){
            $this->get->verifyToken($_COOKIE['phpback_sessionid']);
            setcookie('phpback_sessionid', '', time()-3600, '/');
        }
        header('Location: ' . base_url() . 'home/');
    }

    public function vote($votes, $ideaid){
        session_start();
        if(isset($_SESSION['phpback_userid'])){
            $this->post->vote($ideaid, $_SESSION['phpback_userid'], $votes);
        }
        else{
            header("Location: " . base_url() . 'home/login/');
            exit;
        }
        $idea = $this->get->getIdea($ideaid);
        header("Location: " . $idea->url);
    }

    public function unvote($voteId, $route = "profile"){
        session_start();
        $vote = $this->get->get_row_by_id('votes', $voteId);
        $idea = $this->get->getIdea($vote->ideaid);

        if ($vote && isset($_SESSION['phpback_userid']) && $_SESSION['phpback_userid'] == $vote->userid) {
            $this->post->update_by_id('ideas', 'votes', $idea->votes - $vote->number, $idea->id);
            $this->post->delete_row_by_id('votes', $voteId);
        }

        if($route == "profile"){
            header('Location:' . base_url() . 'home/profile/' . $vote->userid);
        } else {
            header("Location: " . $idea->url);
        }
    }

    public function changepassword()
    {
        session_start();
        if (!isset($_SESSION['phpback_userid'])) {
            header('Location: ' . base_url() . 'home');
            exit;
        }

        $old = $this->input->post('old', true);
        $new = $this->input->post('new', true);
        $rnew = $this->input->post('rnew', true);
        $toredirect = base_url() . 'home/profile/' . $_SESSION['phpback_userid'];
        if (strlen($new) > 5) {
            if ($new == $rnew) {
                $user = $this->get->getUser($_SESSION['phpback_userid']);

                if ($this->hashing->matches($old, $user->pass)) {
                    $this->post->update_by_id('users', 'pass', $this->hashing->hash($new), $user->id);
                    $message = "?????? ???????????? ?????????????? ???? ??????????: $new\n";
                    $this->load->library('email');
                    $this->email->initialize($this->get->email_config());

                    $mainmail = $this->get->getSetting('mainmail');
                    $title = $this->get->getSetting('title');

                    $this->email->from($mainmail, '???????????????? FeedBack');
                    $this->email->to($user->email);

                    $this->email->subject("???????????? ?????????????? - $title");
                    $this->email->message($message);

                    $this->email->send();

                    header('Location: ' . $toredirect);
                } else $this->redirectpost($toredirect, array('error' => 2));

            } else $this->redirectpost($toredirect, array('error' => 1));
        } else $this->redirectpost($toredirect, array('error' => 3));
    }

    public function newidea(){
        session_start();

        if(!isset($_SESSION['phpback_userid'])){
            header('Location: ' . base_url() . 'home');
            exit;
        }

        $title = $this->input->post('title', true);
        $desc = $this->input->post('description', true);
        $catid = $this->input->post('category', true);
        $typeid = $this->input->post('type', true);

        $photo = null;

        if($catid == 0){
            $this->redirectpost(base_url() . "home/postidea/errorcat", array('title' => $title, 'desc' => $desc, 'catid' => $catid, 'typeid' => $typeid));
            return;
        }
        if($typeid == 0){
            $this->redirectpost(base_url() . "home/postidea/errortype", array('title' => $title, 'desc' => $desc, 'catid' => $catid, 'typeid' => $typeid));
            return;
        }
        if(strlen($title) < 9){
            $this->redirectpost(base_url() . "home/postidea/errortitle", array('title' => $title, 'desc' => $desc, 'catid' => $catid, 'typeid' => $typeid));
            return;
        }
        if(strlen($desc) < 20){
            $this->redirectpost(base_url() . "home/postidea/errordesc", array('title' => $title, 'desc' => $desc, 'catid' => $catid, 'typeid' => $typeid));
            return;
        }

        if(!empty($_FILES['file']['name'][0])){
            for($i=0; $i < count($_FILES['file']['name']); $i++) {
                if ($_FILES['file']['size'][$i] > 2202009 or $_FILES['file']['size'][$i] == 0) {
                    $this->redirectpost(base_url() . "home/postidea/largefile", array('title' => $title, 'desc' => $desc, 'catid' => $catid, 'typeid' => $typeid));
                    return;
                }
            }

            for($i=0; $i < count($_FILES['file']['name']); $i++) {
                if ($_FILES['file']['error'][$i] == 0) {
                    $getMime = explode('.', $_FILES['file']['name'][$i]);
                    $mime = strtolower(end($getMime));
                    $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

                    if (!in_array($mime, $types)) {
                        $this->redirectpost(base_url() . "home/postidea/errorfiletype", array('title' => $title, 'desc' => $desc, 'catid' => $catid, 'typeid' => $typeid));
                        return;
                    }

                    $name = 'public/photo/' . md5(microtime() . rand(0, 9999)) . "." . $mime;

                    $photo = $photo . $name . ";";

                    copy($_FILES['file']['tmp_name'][$i], $name);
                }
            }
        }

        if(@isset($_SESSION['phpback_userid']))
            $this->post->add_idea($title, $desc, $_SESSION['phpback_userid'], $catid, $typeid, $photo);

        header("Location: " . base_url() . "home/profile/" . $_SESSION['phpback_userid']);
    }

    public function comment($idea_id){
        session_start();
        $idea_id = (int) $idea_id;
        $content = $this->input->post('content', true);
        if(isset($_SESSION['phpback_userid']))
            $this->post->add_comment($idea_id, $content, $_SESSION['phpback_userid']);
        header("Location: " . $this->get->getIdea($idea_id)->url);
    }

    public function flag($cid, $idea_id){
        session_start();
        if(!isset($_SESSION['phpback_userid'])){
            header("Location: " . base_url(). "home/login");
            exit;
        }
        $this->post->flag($cid, $_SESSION['phpback_userid']);
        header("Location: " . $this->get->getIdea($idea_id)->url);
    }

    private function redirectpost($url, array $data){

        echo '<html>
            <head>
                <script type="text/javascript">
                    function close() {
                        document.forms["redirectpost"].submit();
                    }
                </script>
                <title>????????????????????, ??????????????????...</title>
            </head>
            <body onload="close();">
            ??????????????????????????????...<br>
            <form name="redirectpost" method="post" action="' . $url .'">';
        if ( !is_null($data) ) {
            foreach ($data as $k => $v) {
                echo '<input type="hidden" name="' . $k . '" value="' . $v . '"> ';
            }
        }
        echo "</form>";
        "</body>";
        "</html>";
        exit;
    }

}

?>
