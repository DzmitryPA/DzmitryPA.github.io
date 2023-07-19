<?php

class FollowsController extends AppController {

    public $uses = array('Admin', 'Page', 'Emailtemplate', 'User', 'Setting', 'State', 'City', 'Industry', 'Follow');
    public $helpers = array('Html', 'Form', 'Fck', 'Javascript', 'Ajax', 'Text', 'Number', 'Js');
    public $paginate = array('limit' => '20', 'page' => '1', 'order' => array('User.id' => 'DESC'));
    public $components = array('RequestHandler', 'Email', 'Upload', 'PImageTest', 'PImage', 'Captcha', 'Common');
    public $layout = 'admin';

    function beforeFilter() {
        $loggedAdminId = $this->Session->read("adminid");
        if (isset($this->params['admin']) && $this->params['admin'] && !$loggedAdminId) {
            //$this->redirect("/admin/admins/login");
            $returnUrlAdmin = $this->params->url;
            $this->Session->write("returnUrlAdmin", $returnUrlAdmin);
            $this->redirect(array('controller' => 'admins', 'action' => 'login', ''));
        }
    }
    
    public function myFollowers() {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "My Followers");
        $this->layout = "client";
        $this->set('followersAct', 1);
        $this->userLoginCheck();

        
        $condition = array();
        $separator = array();
        $urlSeparator = array();
        $company_id = $this->Session->read('user_id');

        $condition = array('Follow.following_id' => $company_id);
        
        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);

        $this->paginate['Follow'] = array(
            'conditions' => $condition,
            'order' => array('Follow.id' => 'ASC'),
            'limit' => '30'
        );

        //pr($this->paginate('Follow'));exit;
        $this->set('users', $this->paginate('Follow', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'follows/';
            $this->render('follower');
        }
    }
    
    public function myFollowings() {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "My Followings");
        $this->layout = "client";
        $this->set('followingAct', 1);
        $this->userLoginCheck();

        
        $condition = array();
        $separator = array();
        $urlSeparator = array();
        $company_id = $this->Session->read('user_id');

        $condition = array('Follow.follower_id' => $company_id);
        
        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);

        $this->paginate['Follow'] = array(
            'conditions' => $condition,
            'order' => array('Follow.id' => 'ASC'),
            'limit' => '30'
        );

        //pr($this->paginate('Follow'));exit;
        $this->set('users', $this->paginate('Follow', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'follows/';
            $this->render('following');
        }
    }
    

    public function followCompany() {
        $this->layout = "";

        $ifExist = $this->Follow->field('id', array('Follow.following_id' => $this->data['following_id'], 'Follow.follower_id' => $this->Session->read('user_id')));
        if ($ifExist > 0) {
            $this->request->data['Follow']['id'] = $ifExist;
        }
        $this->request->data['Follow']['follower_id'] = $this->Session->read('user_id');
        $this->request->data['Follow']['following_id'] = $this->data['following_id'];
        $this->request->data['Follow']['status'] = '1';
        $this->request->data['Follow']['slug'] = date('YmdHis') . $this->Session->read('user_id') . $this->data['following_id'];
        //pr($this->data);exit;
        if ($this->Follow->save($this->data)) {
            $this->set('statuss', 1);
            $this->set('following_id', $this->data['following_id']);
            $this->set('follower_id', $this->Session->read('user_id'));
        }

        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'follows';
            $this->render('follow_company');
        }
    }

    public function unfollowCompany() {

        $this->layout = '';
        $ifExist = $this->Follow->field('id', array('Follow.following_id' => $this->data['following_id'], 'Follow.follower_id' => $this->Session->read('user_id')));
        if ($ifExist > 0) {
            if ($this->Follow->delete($ifExist)) {
                $this->set('statuss', 0);
                $this->set('following_id', $this->data['following_id']);
                $this->set('follower_id', $this->Session->read('user_id'));
            }
        }
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'follows';
            $this->render('follow_company');
        }
    }

    public function updateFollowers() {

        $this->layout = '';
        echo $followers = $this->Follow->field('COUNT(Follow.id)', array('Follow.following_id' => $this->data['following_id']));
        exit;
    }
    
}
