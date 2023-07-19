<?php

class AdminsController extends AppController {

    var $uses = array('Admin', 'User', 'Emailtemplate', 'Setting', 'Industry');
    public $helpers = array('Html', 'Form', 'Fck', 'Javascript', 'Ajax', 'Text', 'Number');
    var $components = array('RequestHandler', 'Email', 'Captcha', 'Upload', 'PImageTest', 'PImage');
    var $layout = 'admin';

    function beforeFilter() {
        if ($this->action != 'admin_forgotPassword' && $this->action != 'admin_logout') {
            $loggedAdminId = $this->Session->read("adminid");
            if (!$loggedAdminId && $this->params['action'] != "admin_login" && $this->params['action'] != 'admin_captcha') {
                $returnUrlAdmin = $this->params->url;
                $this->Session->write("returnUrlAdmin", $returnUrlAdmin);
                $this->redirect(array('controller' => 'admins', 'action' => 'login', ''));
            }
        }
    }

    function admin_index() {
        $this->layout = 'admin';
        $this->redirect(array('controller' => 'admins', 'action' => 'login', ''));
    }

    function admin_captcha() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        if (!isset($this->Captcha)) {
            App::import('Component', 'Captcha'); //load it
            $this->Captcha = new CaptchaComponent(); //make instance
            $this->Captcha->startup($this); //and do some manually calling
        }
        $this->Captcha->create();
    }

    public function admin_login() {
        
        $this->layout = 'admin_login';
        $this->set('title_for_layout', TITLE_FOR_PAGES. " Administration Login");
        $msgString = "";
        if ($this->Session->check('adminid')) {
            $this->redirect(array('controller' => 'admins', 'action' => 'dashboard'));
        }
       
        if (!empty($this->data)) {
            
            if ($this->data["Admin"]["username"] =='') {
                $msgString .= "- Username is required field.<br>";
            } 

            if ($this->data["Admin"]["password"] =='') {
                $msgString .= "- Password is required field.<br>";
            } 

            if ($msgString != '') {
                echo $msgString; exit;
            } else {
                $username = $this->data['Admin']['username'];
                $password = $this->data['Admin']['password'];
                $time1 = date("Y-m-d H:i:s", time() - 60 * 60 * 24);
                $adminDetail = $this->Admin->find('first', array('conditions' => array("(Admin.username = '" . addslashes($username) . "') AND (Admin.status = 1 OR Admin.modified <= '" . $time1 . "')")));

                //$adminDetail = $this->Admin->find('first', array('conditions' =>array("Admin.username" => $username)));
                if ($adminDetail['Admin']['status'] == 1 || $adminDetail['Admin']['modified'] <= $time1) {
                    
                        if (is_array($adminDetail) && !empty($adminDetail) && crypt($password, $adminDetail['Admin']['password']) == $adminDetail['Admin']['password']) {

                            $this->Session->write("adminid", $adminDetail['Admin']['id']);
                            $this->Session->write("groupid", $adminDetail['Admin']['id']);
                            $this->Session->write("admin_username", $adminDetail['Admin']['username']);

                            if (isset($this->data['Admin']['remember']) && $this->data['Admin']['remember'] == '1') {
                                setcookie("admin_username", $this->data['Admin']['username'], time() + 60 * 60 * 24 * 100, "/");
                                setcookie("admin_password", $this->data['Admin']['password'], time() + 60 * 60 * 24 * 100, "/");
                            } else {
                                setcookie("admin_username", '', time() + 60 * 60 * 24 * 100, "/");
                                setcookie("admin_password", '', time() + 60 * 60 * 24 * 100, "/");
                            }

                            $adminrecord['Admin']['id'] = 1;
                            $adminrecord['Admin']['status'] = 1;

                            $this->Admin->save($adminrecord);
                            $this->Session->delete('Adminloginstatus');
                            echo '1';
                            exit;
                        } else {
                            $i = $this->Session->read('Adminloginstatus');
                            if ($i < 3) {
                                $i = 1 + $i;
                                $this->Session->write('Adminloginstatus', $i);
                            }
                            if ($i == 1) {
                                echo 'Invalid username and/or password. You have two more attempts now.'; exit;
                            }
                            if ($i == 2) {
                                echo 'Invalid username and/or password. You have one more attempt now.';exit;
                            }
                            if ($i == 3) {
                                
                                $uid = $this->Admin->findById(1);
                                $email = $uid['Admin']['email'];
                                $username = $uid['Admin']['username'];
                              
                                $passwordPlain = $this->rand_string(8);
                                $salt = uniqid(mt_rand(), true);

                                $new_password = crypt($passwordPlain, '$2a$07$' . $salt . '$');
                                $this->Admin->updateAll(array('Admin.password' => "'" . $new_password . "'"), array('Admin.id' => 1));
                                
                                $this->Email->to = $email;
                                $emailtemplateMessage = $this->Emailtemplate->findById(5);
                                $this->Email->subject = $emailtemplateMessage['Emailtemplate']['subject'];
                                $this->Email->replyTo = SITE_TITLE . "<" . MAIL_FROM . ">";
                                $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";
                                $toRepArray = array('[!email!]', '[!username!]', '[!password!]', '[!HTTP_PATH!]');
                                $fromRepArray = array($email, $username, $passwordPlain, HTTP_PATH);
                                $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                                $this->Email->layout = 'default';
                                $this->set('messageToSend', $messageToSend);
                                $this->Email->template = 'email_template';
                                $this->Email->sendAs = 'html';
                                $this->Email->send();
                                echo 'You have reached maximum number of wrong login attempts.';
                                exit;
                                
                                $adminrecord['Admin']['id'] = 1;
                                $adminrecord['Admin']['status'] = 0;
                                $this->Admin->save($adminrecord);
                                echo 'Invalid username and/or password. Your account got temporary disabled. Please login after 24 hours.'; exit;
                            }
                        }
                    } else {
                        echo 'Your account got temporary disabled. Please login after 24 hours.';
                        exit;
                    }
            }
        }else{
            if (isset($_COOKIE["admin_username"]) && isset($_COOKIE["admin_password"])) {
                $this->request->data['Admin']['username'] = $_COOKIE["admin_username"];
                $this->request->data['Admin']['password'] = $_COOKIE["admin_password"];
                $this->request->data['Admin']['remember'] = 1;
            }
        }
      
    }
    
    public function admin_forgotPassword() {
        
        $this->layout = 'admin';
        if (!empty($this->data)) {
            if (trim($this->data['Admin']['email']) == '') {
                echo 'Email is required field'; exit;
            }else if ($this->Admin->checkEmail($this->data['Admin']['email']) == false) {
                echo 'Please enter valid email address'; exit;
            } else {
                $adminInfo = $this->Admin->find('first', array('conditions' => array('Admin.email' => $this->data['Admin']['email'])));
                if (empty($adminInfo)) {
                    echo 'Please enter correct email address'; exit;
                } elseif ($adminInfo['Admin']['status'] != '1') {
                    echo 'Your account might be temporarily disabled.'; exit;
                } else {
                    $email = $adminInfo['Admin']['email'];
                    $username = $adminInfo['Admin']['username'];
                    $password = $adminInfo['Admin']['password'];

                    $passwordPlain = $this->rand_string(8);
                    $salt = uniqid(mt_rand(), true);
                    $new_password = crypt($passwordPlain, '$2a$07$' . $salt . '$');
                    $this->Admin->updateAll(array('Admin.password' => "'" . $new_password . "'"), array('Admin.email' => $this->data['Admin']['email']));

                    $this->Email->to = $email;
                    $emailtemplateMessage = $this->Emailtemplate->findById(1);
                    $this->Email->subject = $emailtemplateMessage['Emailtemplate']['subject'];
                    $this->Email->replyTo = SITE_TITLE . "<" . MAIL_FROM . ">";
                    $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";
                    $toRepArray = array('[!email!]', '[!username!]', '[!password!]', '[!HTTP_PATH!]');
                    $fromRepArray = array($email, $username, $passwordPlain, HTTP_PATH);
                    $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                    $this->Email->layout = 'default';
                    $this->set('messageToSend', $messageToSend);
                    $this->Email->template = 'email_template';
                    $this->Email->sendAs = 'html';
                    $this->Email->send();
                    echo '1';exit;
                }
            }
        }
      
    }
    
    public function admin_logout() { 
        session_destroy();
        $this->Session->setFlash('Logout successfully.', 'success_msg');
        $this->redirect(array('controller' => 'admins', 'action' => 'login', ''));
    }
    
   
    public function admin_dashboard() {
        $this->layout = 'admin';
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Dashboard");
        $this->set('dashboardAct', 1);
        
        $countCompanies = $this->User->find('count'); 
        $this->set('countCompanies', $countCompanies);
        $countIndustries = $this->Industry->find('count', array('conditions' => array('Industry.parent_id' => '0')));
        $this->set('countIndustries', $countIndustries);
    
    }

    
    public function admin_changeemail() {

        $this->layout = "admin";
        $this->set('title_for_layout', TITLE_FOR_PAGES .  'Change Email');
        $this->set('changeemail', 1);

        $id = $this->Session->read("adminid");
        $adminInfo = $this->Admin->findById($id);
        $this->set('adminInfo', $adminInfo);
        $msgString = "";

        if (!empty($this->data)) {
            if (empty($this->data["Admin"]["new_email"])) {
                $msgString = "- New Email is required field.<br>";
            } elseif ($this->Admin->checkEmail($this->data["Admin"]["new_email"]) == false) {
                $msgString .="- Please enter Valid New Email.<br>";
            } else if ($this->data["Admin"]["new_email"] == $adminInfo["Admin"]["email"]) {
                $msgString .="- You can not change new email same as current email.<br>";
            }

            if (empty($this->data["Admin"]["conf_email"])) {
                $msgString .="- Confirm Email is required field.<br>";
            } elseif ($this->Admin->checkEmail($this->data["Admin"]["conf_email"]) == false) {
                $msgString .="- Please enter confirm Valid Email.<br>";
            }

            if ($this->data['Admin']['new_email'] != $this->data['Admin']['conf_email']) {
                $msgString .="- New Email And Confirm Email Should be Match.<br>";
            }
            if ($this->data['Admin']['new_email'] != $this->data['Admin']['old_email']) {
                if ($this->Admin->isRecordUniqueemail($this->data["Admin"]["new_email"]) == false) {
                    $msgString .="- Email already exists.<br>";
                }
            }
            if (isset($msgString) && $msgString != '') {
                 $this->Session->setFlash($msgString, 'error_msg');
                 $this->request->data["Admin"]["new_email"] = '';
                 $this->request->data["Admin"]["conf_email"] = '';
            } else {
                $this->request->data["Admin"]["email"] = $this->data["Admin"]["new_email"];
                $this->request->data["Admin"]["id"] = $id;
                if ($this->Admin->save($this->data)) {
                    $this->Session->setFlash('Admin Email Updated Successfully.', 'success_msg');
                    $this->redirect(array('controller' => 'admins', 'action' => 'changeemail'));
                }
            }
        }
    }

    public function admin_changepassword() {
        $this->layout = 'admin';
        $this->set('changepassword', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Change Password');
        $msgString = '';
        if ($this->data) {
            if (empty($this->data["Admin"]["old_password"])) {
                $msgString .="- Current Password is required field.<br>";
            } else {
                if ($this->Admin->isPasswordExist($this->data["Admin"]["old_password"], $this->Session->read("adminid")) == false) {
                    $msgString .="- Current Password Incorrect.<br>";
                }
            }

            if (empty($this->data["Admin"]["password"])) {
                $msgString .="- New Password is required field.<br>";
            }

            if (empty($this->data["Admin"]["confirm_password"])) {
                $msgString .="- Confirm  Password is required field.<br>";
            }
            $password = $this->data["Admin"]["password"];
            $confirmpassword = $this->data["Admin"]["confirm_password"];

            if ($password != $confirmpassword) {
                $msgString.= "- New Password &amp; Confirm Password didn't Match.<br>";
            }

            if ($this->Admin->isPasswordExist($this->data["Admin"]["old_password"], $this->Session->read("adminid")) == true && ($this->data["Admin"]["old_password"] == $this->data["Admin"]["password"])) {
                $msgString.= "- You can not change new password same as current password.<br>";
            }

            if (!empty($msgString) && isset($msgString)) {
                $this->Session->setFlash($msgString, 'error_msg');
                $this->request->data["Admin"]["password"] = '';
                $this->request->data["Admin"]["confirm_password"] = '';
            }else{
                $salt = uniqid(mt_rand(), true);
                $this->request->data['Admin']['password'] = crypt($this->data['Admin']['password'], '$2a$07$' . $salt . '$');
                $this->request->data["Admin"]["id"] = $this->Session->read("adminid");
                if ($this->Admin->save($this->data)) {
                    $this->Session->setFlash('Your password changed Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'admins', 'action' => 'changepassword'));
                }
            }
        }
    }

    public function admin_changeusername() {

        $this->layout = "admin";
        $this->set('changeusername', 'active');
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Change Username');
        
        $id = $this->Session->read("adminid");
        $adminInfo = $this->Admin->findById($id);
        $this->set('adminInfo', $adminInfo);

        $msgString = "";

        if (!empty($this->data)) {
            
            if (empty($this->data["Admin"]["new_username"])) {
                $msgString = "- New Username is required field.<br>";
            } else if (strtolower($this->data["Admin"]["new_username"]) == strtolower($adminInfo["Admin"]["username"])) {
                $msgString .="- You can not change new username same as current username.<br>";
            }else if (trim($this->data['Admin']['new_username']) != trim($this->data['Admin']['old_username'])) {
                $conditions["Admin.username"] = trim($this->data["Admin"]["new_username"]);
                if ($this->Admin->isEmailExist($conditions) == false) {
                    $msgString .="- Username already exists.<br>";
                }
            }
            if (empty($this->data["Admin"]["conf_username"])) {
                $msgString .="- Confirm Username is required field.<br>";
            }

            if (trim($this->data['Admin']['new_username']) != trim($this->data['Admin']['conf_username'])) {
                $msgString .="- New Username And Confirm Username Should be Match.<br>";
            }
            
            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
                $this->request->data["Admin"]["new_username"] = '';
                $this->request->data["Admin"]["conf_username"] = '';
            } else {

                $this->request->data["Admin"]["username"] = $this->data["Admin"]["new_username"];
                $this->request->data["Admin"]["id"] = $this->Session->read("adminid");
                if ($this->Admin->save($this->data)) {
                    $this->Session->write("admin_username", $this->data["Admin"]["new_username"]);
                    $this->Session->setFlash('Admin username updated successfully.', 'success_msg');
                    $this->redirect(array('controller' => 'admins', 'action' => 'changeusername'));
                }
            }
        }
    }

    public function admin_contactInfo() {

        $this->layout = "admin";
        $this->set('contactInfo', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Change Contact Information');
        
        $id = $this->Session->read("adminid");
        $adminInfo = $this->Admin->findById($id);
        $this->set('adminInfo', $adminInfo);

        $msgString = "";

        if (!empty($this->data)) {
            
            if (empty($this->data["Admin"]["company_name"])) {
                $msgString = "- Company name is required field.<br>";
            }
            if (empty($this->data["Admin"]["contact_email"])) {
                $msgString = "- Contact email is required field.<br>";
            }
            
            if (empty($this->data["Admin"]["phone"])) {
                $msgString .="- Contact number is required field.<br>";
            }
            if (empty($this->data["Admin"]["address"])) {
                $msgString .="- Address is required field.<br>";
            }

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data["Admin"]["id"] = $id;
                if ($this->Admin->save($this->data)) {
                    $this->Session->setFlash('Contact information updated successfully.', 'success_msg');
                    $this->redirect(array('controller' => 'admins', 'action' => 'contactInfo'));
                }
            }
        }else{
           $this->request->data["Admin"] = $adminInfo['Admin'];
        }
    }
    
    
    public function admin_companyChart($dayCount=2){ 
        
        switch ($dayCount) {
            case 0:
                $dayCount = 1;
                $today = date('Y-m-d').' 23:59:00';
                $lastday = date('Y-m-d').' 00:00:00';
                break;
            case 1:
                $dayCount = 1;
                $today = date('Y-m-d', strtotime("-1 day", strtotime(date('Y-m-d')))).' 23:59:00';
                $lastday = date('Y-m-d', strtotime("-1 day", strtotime(date('Y-m-d')))).' 00:00:00';
                break;
            case 2:
                $dayCount = 31;
                $today = date('Y-m-d').' 23:59:00';
                $lastday = date('Y-m-d', strtotime("-30 day", strtotime(date('Y-m-d')))).' 00:00:00';
                break;
            case 3:
                $dayCount = 365;
                $today = date('Y-m-d').' 23:59:00';
                $lastday = date('Y-m-d', strtotime("-365 day", strtotime(date('Y-m-d')))).' 00:00:00';
                break;
        }
        
        $catArray = array();
        $CTempArray = array();
        
        if($dayCount == 365){
            $countUserArray = $this->User->find('all', array('conditions' => array('User.created <='=>$today,'User.created >='=>$lastday ), 'fields' => array('User.created', 'COUNT(*) as count') , 'order' => array('User.created ASC'), 'group'=>array('MONTH(User.created)')));
            foreach ($countUserArray as $countArr){
                $CTempArray[ date("Y-m", strtotime($countArr['User']['created']))] = $countArr['0']['count'];
            }
           // pr($CTempArray);exit;
            $finalArray = array();
            $catArray = array();
            $strtotime = strtotime($lastday);
            for($i = 0; $i <= 12; $i++){
                $value = 0;
                $date = date('Y-m', $strtotime);
                if(array_key_exists($date, $CTempArray)){
                    $value =  $CTempArray[$date];
                }
                $finalArray[] = $value;
                $catArray[] = "'".date('M', $strtotime)."'";
                $strtotime = strtotime("+1month", $strtotime);
            }
        }else{
            $countUserArray = $this->User->find('all', array('conditions' => array('User.created <='=>$today,'User.created >='=>$lastday ), 'fields' => array('User.created', 'COUNT(*) as count') , 'order' => array('User.created ASC'), 'group'=>array('DAY(User.created)')));
            $CTempArray = array();
            foreach ($countUserArray as $countArr){
                $CTempArray[ date("Y-m-d", strtotime($countArr['User']['created']))] = $countArr['0']['count'];
            }
//            pr($countUserArray);
//            pr($CTempArray);exit;
            $finalArray = array();
            $strtotime = strtotime($lastday);
            for($i = 0; $i < $dayCount; $i++){
                $value = 0;
                $date = date('Y-m-d', $strtotime);
                if(array_key_exists($date, $CTempArray)){
                    $value =  $CTempArray[$date];
                }
                $datea = date('Y, m-1, d', $strtotime);
                $finalArray[] = "Date.UTC($datea), ". $value;
                $strtotime = $strtotime + 24*3600;
            } 
        }
//        pr($catArray);
//        pr($finalArray);exit;
//        
        $this->set('dayCount', $dayCount);
        $this->set('finalArray', "[".implode('],[', $finalArray)."]");
        $this->set('catArray', implode(', ',$catArray));
        
        $this->layout = '';
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/chart/';
            $this->render('company_chart');
        }
    }
}

?>
