<?php

class HomesController extends AppController {

    public $uses = array('Admin', 'Page', 'Emailtemplate', 'User');
    public $helpers = array('Html', 'Form', 'Fck', 'Javascript', 'Ajax', 'Text', 'Number', 'Js');
    public $paginate = array('limit' => '20', 'page' => '1', 'order' => array('User.id' => 'DESC'));
    public $components = array('RequestHandler', 'Email', 'Upload', 'PImageTest', 'PImage', 'Captcha', 'Common');

    public function index() {
        $this->layout = "home";
        $this->set('title_for_layout', TITLE_FOR_PAGES . ' Welcome');

        // $this->set('homeAct', 1);
        // $adminInfo = $this->Admin->findById(1);
        // $this->set('adminInfo', $adminInfo);
        
        // $pageContent = $this->Page->find("first", array("conditions" => "Page.static_page_heading='about-us'"));
        // $this->set('pageContent', $pageContent);
    }

    public function error() {
        $this->layout = 'home';
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Page not found');
    }

}

?>