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

class Home extends CI_Controller {
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
        $this->autoLoginByCookie();

        //Use this function to parse $freename variables getDisplayHelpers();
        $data = $this->getDefaultData();
        $data['welcomeTitle'] = $this->get->getSetting('welcometext-title');
        $data['welcomeDescription'] = $this->get->getSetting('welcometext-description');

        $data['ideas'] = array(
            'completed' => $this->get->getIdeas('id', 1, 0, 10, array('completed')),
            'started' => $this->get->getIdeas('id', 1, 0, 10, array('started')),
            'planned' => $this->get->getIdeas('id', 1, 0, 10, array('planned')),
            'considered' => $this->get->getIdeas('id', 1, 0, 10, array('considered')),
        );

        $this->load->view('_templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);

    }

    public function category($id, $order = "id", $type = "desc", $page = '1', $status="") {
        if (!$this->get->categoryExists($id)){
            header('Location: ' . base_url() . 'home');
            return;
        }

        $data = $this->getDefaultData();
        $data['order'] = $order;
        $data['type'] = $type;
        $data['page'] = (int) $page;
        $data['status'] = $status;

        $data['ideas'] = $this->get->getIdeasByCategory($id, $order, $type, $page, $status);
        $data['category'] = $data['categories'][$id];

        $total = $this->get->getQuantityOfApprovedIdeas($id);
        $data['max_results'] = (int) $this->get->getSetting('max_results');
        $data['pages'] = (int) ($total / $data['max_results']);
        if(($total % $data['max_results']) > 0) $data['pages']++;

        $this->load->view('_templates/header', $data);
        $this->load->view('home/category_ideas', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);
    }

    public function type($id, $order = "id", $type = "desc", $page = '1', $status="") {
        if (!$this->get->typeExists($id)){
            header('Location: ' . base_url() . 'home');
            return;
        }

        $data = $this->getDefaultData();
        $data['order'] = $order;
        $data['type'] = $type;
        $data['page'] = (int) $page;
        $data['status'] = $status;

        $data['ideas'] = $this->get->getIdeasByType($id, $order, $type, $page, $status);
        $data['typetable'] = $data['types'][$id];

        $total = $this->get->getQuantityOfApprovedIdeasByType($id);
        $data['max_results'] = (int) $this->get->getSetting('max_results');
        $data['pages'] = (int) ($total / $data['max_results']);
        if(($total % $data['max_results']) > 0) $data['pages']++;

        $this->load->view('_templates/header', $data);
        $this->load->view('home/type_ideas', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);
    }

    public function search() {
        $data = $this->getDefaultData();

        $query = $this->input->post('query');
        $data['ideas'] = $this->get->getIdeasBySearchQuery($query);

        $this->load->view('_templates/header', $data);
        $this->load->view('home/search_results', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);
    }

    public function ideas($categoryid, $order = "date", $type = "desc", $page = '1'){
//        return var_dump($_GET);
        $data = $this->getDefaultData();
        $data['categoryid'] = $categoryid;
        $data['order'] = $order;
        $data['type'] = $type;
        $data['page'] = (int) $page;

        $limit = $this->get->getSetting('max_results');
        $from = ($page - 1) * $limit;

        if(empty($_GET)){
            var_dump("БАЗА ЗАПРОС");
            $data['form'] = array(
                "status-completed" => 1,
                "status-started" => 1,
                "status-planned" => 1,
                "status-considered" => 1,
                "status-declined" => 1,
            );

            $cat = array($categoryid);

            $types = array();
            foreach ($data['types'] as $t) {
                $types[] = $t->id;
                $s = "type-".$t->id;
                $data['form'][$s] = 1;
            }
            $data['typesdata'] = $types;

            $status = array("completed", "started", "planned", "considered", "declined");
            $data['status'] = $status;
            $data['toall'] = 0;
        } else{
            var_dump("GET ЗАПРОС");
//            return var_dump($_GET);
            $typesGET = $_GET['filter']['types'];
            $statusGET = $_GET['filter']['status'];
            $data['form'] = array(
                "status-completed" => in_array('completed', $statusGET) ? 1 : 0,
                "status-started" => in_array('started', $statusGET) ? 1 : 0,
                "status-planned" => in_array('planned', $statusGET) ? 1 : 0,
                "status-considered" => in_array('considered', $statusGET) ? 1 : 0,
                "status-declined" => in_array('declined', $statusGET) ? 1 : 0,
            );
            $status = array();
            if(in_array('completed', $statusGET)) $status[] = "completed";
            if(in_array('started', $statusGET)) $status[] = "started";
            if(in_array('planned', $statusGET)) $status[] = "planned";
            if(in_array('considered', $statusGET)) $status[] = "considered";
            if(in_array('declined', $statusGET)) $status[] = "declined";
            $data['status'] = $status;

            $cat = array($categoryid);

            $types = array();
            foreach ($data['types'] as $t) {
                $s = "type-".$t->id;
                if(in_array($t->id, $typesGET)){
                    $types[] = $t->id;
                    $data['form'][$s] = 1;
                }
                else{
                    $data['form'][$s] = 0;
                }
            }
            $data['typesdata'] = $types;
            $data['toall'] = 1;
        }

        $data['ideas'] = $this->get->getIdeas($order, $type, $from, $limit, $status, $cat, $types);
//var_dump($data['ideas']);
        $this->load->view('_templates/header', $data);
        $this->load->view('home/all_ideas', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);
    }

    public function idea($id) {
        $idea = $this->get->getIdea($id);

        if ($idea === false) {
            header('Location: ' . base_url() . 'home');
            return;
        }

        $ideaUserName = $this->get->getUser($idea->authorid)->name;
        $idea->user = $ideaUserName;
        $comments = $this->get->getCommentsByIdea($id);

        foreach($comments as $comment){
            $userName = $this->get->getUser($comment->userid)->name;
            $comment->user = $userName;
        }

        $data = $this->getDefaultData();
        if(@isset($_SESSION['phpback_userid'])){
            $data["user_is_vote"] = $this->get->isUserVoteIdea($_SESSION['phpback_userid'], $idea->id);
        } else {
            $data["user_is_vote"] = false;
        }
        $data['comments'] = $comments;
        $data['idea'] = $idea;
        if($data['idea']->photo != null){
            $data['idea']->photo = substr($idea->photo, 0, -1);
        }
//        return var_dump(json_encode(count(explode(";", $data['idea']->photo))));

        $this->load->view('_templates/header', $data);
        $this->load->view('home/view_idea', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);
    }


    public function profile($id, $error=0) {
        $data = $this->getDefaultData();

        $data['user'] = $this->get->getUser($id);

        if ($data['user'] === false) {
            header('Location: ' . base_url() . 'home');
            return;
        }

        $data['logs'] = $this->get->get_logs('user', $id);
        $data['comments'] = $this->get->getUserComments($id, 20);
        $data['ideas'] = $this->get->getUserIdeas($id);


        $data['error'] = $this->input->post('error', true);
        if(@isset($_SESSION['phpback_userid']) && $data['user']->id == $_SESSION['phpback_userid']){
            $data['votes'] = $this->get->getUserVotes($_SESSION['phpback_userid']);
        }

        $this->load->view('_templates/header', $data);
        $this->load->view('home/user', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);
    }


    public function login($error = "NULL", $ban=0) {
        if(@!isset($_SESSION['phpback_userid']) && @isset($_COOKIE['phpback_sessionid'])){
            $result = $this->get->verifyToken($_COOKIE['phpback_sessionid']);
            if($result != 0){
                $user = $this->get->getUser($result);
                $this->get->setSessionUserValues($user);
                $this->get->setSessionCookie();
                header('Location: '. base_url() .'home');
                return;
            }
        }

        if(@isset($_SESSION['phpback_userid'])) {
            header('Location: '. base_url() .'home');
            return;
        }

        $data = $this->getDefaultData();
        $data['error'] = $error;
        $data['ban'] = $ban;

        $this->load->view('_templates/header', $data);
        $this->load->view('home/login', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);
    }

    public function postidea($error = "none") {
        $data = $this->getDefaultData();
        $data['error'] = $error;
        $data['POST'] = array(
            'title' => $this->input->post('title'),
            'catid' => $this->input->post('catid'),
            'typeid'=> $this->input->post('typeid'),
            'desc'  => $this->input->post('desc')
        );

        $this->load->view('_templates/header', $data);
        $this->load->view('home/post_idea', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);
    }

    public function register($error = "NULL") {
        $data = $this->getDefaultData();
        $data['recaptchapublic'] = $this->get->getSetting('recaptchapublic');
        $data['error'] = $error;

        $this->load->view('_templates/header', $data);
        $this->load->view('home/register', $data);
        $this->load->view('_templates/menu', $data);
        $this->load->view('_templates/footer', $data);
    }

    private function getDefaultData() {
        return array(
            'title' => $this->get->getSetting('title'),
            'categories' => $this->get->getCategories(),
            'types' => $this->get->getTypes(),
            'lang' => $this->lang->language,
        );
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
