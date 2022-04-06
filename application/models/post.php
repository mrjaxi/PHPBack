<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*********************************************************************
PHPBack
Ivan Diaz <ivan@phpback.org>
Copyright (c) 2014 PHPBack
http://www.phpback.org
Released under the GNU General Public License WITHOUT ANY WARRANTY.
See LICENSE.TXT for details.
 **********************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('email');

        $this->lang->load('log', $this->getSetting('language'));
        $this->lang->load('default', $this->get->getSetting('language'));
    }

    public function add_category($name, $description){
        if(!$this->categoryExists($name)){
            $data = array(
                'name' => $name,
                'description' => $description,
                'ideas' => 0,
            );
            $this->db->insert('categories', $data);
        }
    }

    public function add_type($name, $description = null){
        if(!$this->typeExists($name)){
            $data = array(
                'name' => $name,
                'description' => $description,
                'ideas' => 0,
            );
            $this->db->insert('types', $data);
        }
    }

    public function add_user($name, $email, $pass, $votes, $isadmin){
        $pass = $this->hashing->hash($pass);
        $votes = (int) $votes;
        $isadmin = (int) $isadmin;
        if($votes < 1) return false;

        $sql = $this->db->query("SELECT id FROM users WHERE email=" . $this->db->escape($email));

        if($sql->num_rows()) return false;

        if($isadmin){
            $data = array(
                'name' => $name,
                'email' => $email,
                'pass' => $pass,
                'votes' => $votes,
                'isadmin' => $isadmin,
                'banned' => '0'
            );
        }
        else{
            $data = array(
                'name' => $name,
                'email' => $email,
                'pass' => $pass,
                'votes' => $votes,
                'isadmin' => '0',
                'banned' => '0'
            );
        }

        $this->db->insert('users', $data);
        $this->log($this->lang->language['log_user_registered'] . ": $name($email)", "general", 0);
        return true;
    }

    public function add_idea($title, $content, $author_id, $category_id, $type_id = null, $photo = null, $href = null){
        $author_id = (int) $author_id;
        $category_id = (int) $category_id;
        $type_id = (int) $type_id;
        if($author_id < 1 || $category_id < 1 || $type_id < 1) return false;

        $date = date("d/m/y H:i");
        $data = array(
            'title' => $title,
            'content' => $content,
            'authorid' => $author_id,
            'date' => $date,
            'votes' => '0',
            'comments' => '0',
            'status' => 'new',
            'categoryid' => $category_id,
            'typeid' => $type_id,
            'photo' => $photo,
            'href' => $href
        );
        $this->db->insert('ideas', $data);
        $idea = $this->db->query("SELECT * FROM ideas WHERE date='$date'")->result()[0];

        $this->log($this->lang->language['log_new_idea'] . ": $title", "user", $author_id);

        $message = $this->lang->language['log_new_idea'] . ": $title\n\nСсылка: " . base_url() . "home/idea/" . $idea->id;
        $this->sendEmail($message);

        return $idea;
    }

    public function add_comment($idea_id, $comment, $user_id){
        $idea_id = (int) $idea_id;
        $user_id = (int) $user_id;
        if($idea_id < 1 || $user_id < 1) return false;

        $data = array(
            'content' => $comment,
            'ideaid' => $idea_id,
            'userid' => $user_id,
            'date' => date("d/m/y H:i"),
        );
        $this->db->insert('comments', $data);
        $newcomment = $this->db->query("select * from comments ORDER BY id DESC limit 1")->row();

        $idea = $this->db->query("SELECT * FROM ideas WHERE id='$idea_id'")->row();
        $ideaUser = $this->db->query("SELECT * FROM users WHERE id='" . $idea->authorid . "'")->row();
        $this->update_by_id('ideas', 'comments', $idea->comments + 1, $idea_id);
        $this->log(str_replace('%s', '#' . $idea_id, $this->lang->language['log_commented']), "user", $user_id);

        $message = "К вашему отзыву оставили новый комментарий: $comment\n\nСсылка: " . base_url() . "home/idea/" . $idea->id . "#comment" . $newcomment->id;
        $this->sendEmail($message, "Новый комментарий", $ideaUser->email);
        return true;
    }

    public function flag($cid, $userid){
        $cid = (int) $cid;
        $userid = (int) $userid;
        if($cid < 1 || $userid < 1) return false;
        $sql = $this->db->query("SELECT * FROM flags WHERE userid='$userid' AND toflagid='$cid'");
        if($sql->num_rows() != 0) return false;

        $data = array(
//            'id' => '',
            'toflagid' => $cid,
            'userid' => $userid,
            'date' => date("d/m/y H:i"),
        );
        $this->db->insert('flags', $data);
        return true;
    }

    public function update_username_api($name, $email){
        $sql = $this->db->query("SELECT id FROM users WHERE email=" . $this->db->escape($email));

        if($sql->num_rows() == 0) return false;

        $this->db->query("UPDATE users SET name='" . $name . "' WHERE email=" . $this->db->escape($email));

        return true;
    }

    public function update_by_id($table, $field, $value, $id){
        $id = (int) $id;
        $value = $this->db->escape($value);

        if(!$this->isAlphaNumeric($table)) return false;
        if(!$this->isAlphaNumeric($field)) return false;

        $query = "UPDATE $table SET $field=$value WHERE id='$id'";
        $this->db->query($query);
    }

    public function updateadmin($id, $level){
        $id = (int) $id;
        $sql = $this->db->query("SELECT id FROM users WHERE id='$id'");
        if($sql->num_rows()){
            if($level == 0 || $level == 1 || $level == 2 || $level == 3){
                $this->update_by_id('users', 'isadmin', $level, $id);
                return true;
            }
        }
        return false;
    }

    public function vote($idea_id, $user_id, $votes){
        $idea_id = (int) $idea_id;
        $user_id = (int) $user_id;
        $votes = (int) $votes;
        if($idea_id < 1 || $user_id < 1) return false;
        if($votes !== 1) return false;

        $USER = $this->get_row_by_id('users', $user_id);
        $idea = $this->get_row_by_id('ideas', $idea_id);

        if($idea->status == 'completed' || $idea->status == 'declined') return false;

        $sql = $this->db->query("SELECT * FROM votes WHERE userid='$user_id' AND ideaid='$idea_id'");

        if(!$sql->num_rows()){
            if($votes <= $USER->votes){
                $data = array(
                    'ideaid' => $idea_id,
                    'userid' => $user_id,
                    'number' => $votes,
                );
                $this->db->insert('votes', $data);
                $this->update_by_id('ideas', 'votes', $idea->votes + $votes, $idea_id);
                $this->log(str_replace(array('%s1', '%s2'), array("#$idea_id", $votes), $this->lang->language['log_idea_voted']), "user", $user_id);
                return true;
            }
            else return false;
        }
        else{
            $array = $sql->row();
            if($USER->votes + $array->number >= $votes){
                $this->update_by_id('votes', 'number', $votes, $array->id);
                $this->update_by_id('users', 'votes', $USER->votes - ($votes - $array->number), $user_id);
                $this->update_by_id('ideas', 'votes', $idea->votes + ($votes - $array->number), $idea_id);
                return true;
            }
            else return false;
        }
    }

    public function delete_row_by_id($table, $id){
        $id = (int) $id;
        if(!$this->isAlphaNumeric($table)) return false;


        $this->db->query("DELETE FROM $table WHERE id='$id'");
    }

    public function do_ban($id, $date){
        $id = (int) $id;
        $date = (int) $date;
        $this->update_by_id('users', 'banned', $date, $id);
    }

    public function delete_category($id){
        $id = (int) $id;
        $this->db->query("DELETE FROM categories WHERE id='$id'");
    }

    public function delete_type($id){
        $id = (int) $id;
        $this->db->query("DELETE FROM types WHERE id='$id'");
    }

    public function deletecomment($id){
        $id = (int) $id;
        $comment = $this->get_row_by_id('comments', $id);
        $idea = $this->get_row_by_id('ideas', $comment->ideaid);
        //Reduce in -1 commments from idea
        $this->update_by_id('ideas', 'comments', $idea->comments - 1, $idea->id);

        $this->db->query("DELETE FROM comments WHERE id='$id'");
        $this->db->query("DELETE FROM flags WHERE toflagid='$id'");
    }

    public function deleteidea($id){
        $id = (int) $id;
        $idea = $this->get_row_by_id('ideas', $id);
        $sql = $this->db->query("SELECT * FROM comments WHERE ideaid='$id'");
        $comments = $sql->result();

        $ideas = $this->db->query("SELECT photo FROM ideas WHERE id='$id'");
        $photo = $ideas->result();

        for ($i = 0; $i < count(explode(";", $photo[0]->photo)) - 1; $i++){
            if (file_exists(explode(";", $photo[0]->photo)[$i])){
                unlink(explode(";", $photo[0]->photo)[$i]);
            }
        }

        foreach ($comments as $comment) {
            $commentid = $comment->id;
            $this->db->query("DELETE FROM flags WHERE toflagid='$commentid'");
        }
        $this->db->query("DELETE FROM comments WHERE ideaid='$id'");
        $sql = $this->db->query("SELECT * FROM votes where ideaid='$id'");
        $votes = $sql->result();
        foreach ($votes as $vote) {
            $user = $this->get_row_by_id('users', $vote->userid);
            $this->update_by_id('users', 'votes', $user->votes + $vote->number, $vote->userid);
        }

        $cat = $this->get_row_by_id('categories', $idea->categoryid);
        $type = $this->get_row_by_id('types', $idea->typeid);

        if ($idea->status !== 'new' && $idea->status !== 'declined') {
            $this->update_by_id('categories', 'ideas', $cat->ideas - 1, $cat->id);
            $this->update_by_id('types', 'ideas', $type->ideas - 1, $type->id);
        }

        $this->db->query("DELETE FROM ideas WHERE id='$id'");
        $this->db->query("DELETE FROM votes WHERE ideaid='$id'");
    }


    public function unban($id){
        $id = (int) $id;
        $this->update_by_id('users', 'banned', '0', $id);
    }

    public function change_status($ideaid, $status){
        $ideaid = (int) $ideaid;
        $idea = $this->db->query("SELECT * FROM ideas WHERE id='$ideaid'")->row();
        $ideaUser = $this->db->query("SELECT * FROM users WHERE id='" . $idea->authorid . "'")->row();
        $status_text = $idea->status;
        switch ($status) {
            case 'considered':
                $status_text = $this->lang->language['idea_considered'];
                break;
            case 'declined':
                $status_text = $this->lang->language['idea_declined'];
                break;
            case 'started':
                $status_text = $this->lang->language['idea_started'];
                break;
            case 'planned':
                $status_text = $this->lang->language['idea_planned'];
                break;
            case 'completed':
                $status_text = $this->lang->language['idea_completed'];
                break;
            case 'new':
                $status_text = $this->lang->language['idea_new'];
                break;
        }

        $category = $this->get_row_by_id('categories', $idea->categoryid);
        $type = $this->get_row_by_id('types', $idea->typeid);

        if ($idea->status != 'completed' && $idea->status != 'declined' && $idea->status !== 'new') {
            if ($status == 'completed' || $status == 'declined' || $status == 'new') {
                $this->update_by_id('categories', 'ideas', $category->ideas - 1, $category->id);
                $this->update_by_id('types', 'ideas', $type->ideas - 1, $type->id);
            }
        }
        if($idea->status == 'completed' || $idea->status == 'declined' || $idea->status == 'new'){
            if($status != 'completed' && $status != 'declined' && $status != 'new') {
                $this->update_by_id('categories', 'ideas', $category->ideas + 1, $category->id);
                $this->update_by_id('types', 'ideas', $type->ideas + 1, $type->id);
            }
        }
        $this->update_by_id('ideas', 'status', $status, $ideaid);

        $message = "Статус вашего отзыва изменён на '$status_text'.\n\nСсылка: " . base_url() . "home/idea/" . $idea->id;
        $this->sendEmail($message, "Статус отзыва изменён", $ideaUser->email);
    }

    public function approveidea($id){
        $id = (int) $id;
        $idea = $this->db->query("SELECT * FROM ideas WHERE id='$id'")->row();
        $category = $this->get_row_by_id('categories', $idea->categoryid);
        $type = $this->get_row_by_id('types', $idea->typeid);

        $this->change_status($id, 'considered');
        $this->update_by_id('categories', 'ideas', $category->ideas + 1, $category->id);
        $this->update_by_id('types', 'ideas', $type->ideas + 1, $type->id);

        if($type->name == "Сообщить о проблеме") {
            $this->curl("https://gitlab.atma.company/api/v4/projects/96/issues", "POST", array(
                "title" => $idea->title,
                "description" => $idea->content
            ));
        }
    }

    public function log($string, $to, $toid){
        $toid = (int) $toid;
        $data = array(
            'content' => $string,
            'date' => date("d/m/y H:i"),
            'type' => $to,
            'toid' => $toid,
        );
        $this->db->insert('logs', $data);
    }

    private function categoryExists($name) {
        $name = (string) $name;
        $result = $this->db->query("SELECT id FROM categories WHERE name='$name'");
        if($result->num_rows() == 0) return false;
        return true;
    }

    private function typeExists($name) {
        $name = (string) $name;
        $result = $this->db->query("SELECT id FROM types WHERE name='$name'");
        if($result->num_rows() == 0) return false;
        return true;
    }

    private function get_row_by_id($table, $id){
        $id = (int) $id;
        if(!$this->isAlphaNumeric($table)) return false;
        $sql = $this->db->query("SELECT * FROM $table WHERE id='$id'");
        return $sql->row();
    }

    private function getSetting($name){
        $sql = $this->db->query("SELECT * FROM settings WHERE name=" . $this->db->escape($name));
        $data = $sql->row();
        if(@isset($data->value)) return $data->value;
        else return false;
    }

    private function isAlphaNumeric($text) {
        return ctype_alnum($text);
    }

    private function email_config() {
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = $this->getSetting('smtp-host');
        $config['smtp_port']    = $this->getSetting('smtp-port');
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = $this->getSetting('smtp-user');
        $config['smtp_pass']    = $this->getSetting('smtp-pass');
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['mailtype']     = 'text'; // or html
        $config['validation']   = FALSE;

        return $config;
    }

    private function sendEmail($message, $subject="Новый отзыв", $tomail="damedvedev@atmapro.ru"){
//        $message = "Добро пожаловать в систему обратной связи: $title\n\nВаш Email: $email\nВаш пароль: $pass\n\n\nПожалуйста, авторизуйтесь:" . base_url() . "home/login\n";
        $this->email->initialize($this->email_config());

        $this->email->from($this->getSetting('mainmail'), 'Атмагуру FeedBack');
        $this->email->to($tomail);

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();

        $this->log("На почту $tomail отправлено: $message", "email", 0);
    }

    private function curl($url, $method, $params=array()){
        $api_key = "va1wkw9GXs4NhbzgQkGs";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/JSON",
                "Private-Token: " . $api_key
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}

