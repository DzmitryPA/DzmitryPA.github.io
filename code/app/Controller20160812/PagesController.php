<?php

class PagesController extends AppController {

    public $uses = array('Admin', 'Page', 'Emailtemplate','Setting', 'User');
    public $helpers = array('Html', 'Form', 'Fck', 'Paginator', 'Javascript', 'Ajax', 'Text', 'Number');
    public $paginate = array('limit' => '10', 'page' => '1', 'order' => array('Page.static_page_title' => 'asc'));
    public $components = array('RequestHandler', 'Email', 'Captcha');
    public $layout = 'admin';

    function beforeFilter() {
        $loggedAdminId = $this->Session->read("adminid");
        if (isset($this->params['admin']) && $this->params['admin'] && !$loggedAdminId) {
            $returnUrlAdmin = $this->params->url;
            $this->Session->write("returnUrlAdmin", $returnUrlAdmin);
            $this->redirect(array('controller' => 'admins', 'action' => 'login', ''));
        }
    }

    public function admin_index() { 
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Manage Text Pages");
        $this->set('default', '1');
        $this->layout = "admin";
        $this->set('page_list', 'active');
        $condition = array();
        $separator = array();
        $urlSeparator = array();

        $separator = implode("/", $separator);

        if (!empty($this->passedArgs)) {
            if (isset($this->passedArgs["page"])) {
                $urlSeparator[] = 'page:' . $this->passedArgs["page"];
            }
            if (isset($this->passedArgs["sort"])) {
                $urlSeparator[] = 'sort:' . $this->passedArgs["sort"];
            }
            if (isset($this->passedArgs["direction"])) {
                $urlSeparator[] = 'direction:' . $this->passedArgs["direction"];
            }
        }

        $urlSeparator = implode("/", $urlSeparator);
        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);
        $this->set('staticpages', $this->paginate('Page', $condition));
        //pr($this->paginate('Page', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/page/';
            $this->render('index');
        }
    }

    public function admin_editPage($title = null) {
        $this->layout = "admin";
        $this->set('default', '1');
        $this->set('page_list', 'active');
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Edit Page");
        $msgString = '';
        if ($this->data) {
            //pr($this->data); exit;
            if (trim($this->data["Page"]["static_page_title"]) == '') {
                $msgString .= "- Page title is required field.<br>";
            }

            if (strtolower($this->data["Page"]["pageOldName"]) != strtolower(trim($this->data["Page"]["static_page_title"]))) {
                 $new_slug=$this->data['Page']['static_page_title'];
                if ($this->Page->isRecordUniquepage($new_slug) == false) {
                    $msgString .="- Page name already exists.<br>";
                }
            }
            $description = str_replace("&nbsp;", '', $this->data["Page"]["static_page_description"]);
            $page_des = trim($description);
            if ($page_des == '' || $page_des == '<p></p>' || $page_des == '<p> </p>') {
                $msgString .="- Page description is required field.<br>";
            }

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data["Page"]["static_page_title"] = trim($this->data["Page"]["static_page_title"]);
                $this->request->data["Page"]["static_page_description"] = trim($this->data["Page"]["static_page_description"]);
             
                if ($this->Page->save($this->data)) {
                     $this->Session->setFlash('Page details updated successfully', 'success_msg');
                    $this->redirect('/admin/pages/index');
                }
            }
        } elseif ($title != '') {
            $page = $this->Page->find('first', array('conditions' => array('Page.static_page_heading' => $title), 'fields' => array('id')));
            //print_r($card);exit;
            if($page){
                $this->Page->id = $page['Page']['id'];
                $this->data = $this->Page->read();
                $this->request->data["Page"]["pageOldName"] = $this->data["Page"]["static_page_title"];
            }else{
                $this->redirect('/homes/error');
            }
        }
    }

    /**
     *
     * @abstract This function is define to delete page from backend.
     * @access Public
     * @author Logicspice (info@logicspice)
     * @since 1.0.0 16-03-2012
     */
    public function admin_deletepage($id = NULL) {
        if ($id > 0) {
            $this->Page->delete($id);
            $this->viewPath = 'elements' . DS . 'admin';
            $this->Session->setFlash('Page deleted successfully', 'success_msg');
            $this->redirect('/admin/pages/index');
        }
    }

   
    public function underconstruction() {
        $this->layout = "";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Undercounstruction");
    }
	
    public function staticpage($page = null) {
        $this->layout = "home";
        
        $this->set('header_act', $page);
        if($page=='how-it-works')
        {
           $this->set('howitworksAct',1); 
        }if($page=='pricing')
        {
           $this->set('pricingAct',1); 
        }if($page=='faq')
        {
           $this->set('faqAct',1); 
        }
        
        $condition = array('conditions' => array('Page.static_page_heading' => $page));
        $pagedetails = $this->Page->find('first', $condition);
        if (empty($pagedetails)) {
            $this->redirect('/homes/error');
        }
        $this->set('title_for_layout',TITLE_FOR_PAGES . $pagedetails['Page']['static_page_title']);

        $this->set('pagedetails', $pagedetails);
    }
    
    public function site_link() {
        $this->layout = "client";
    }

    function getPageDetail($page_name = null) {
        $condition = array('conditions' => array('Page.static_page_heading' => $page_name));
        return $this->Page->find('first', $condition);
    }

    public function convertHeading($string = null) {

        $specialCharacters = array('#', '$', '%', '@', '.', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', ' ');
        $toReplace = "-";
        $string = str_replace($specialCharacters, $toReplace, $string);
        $replace = str_replace("&", "and", $string);
        return strtolower($replace);
    }

    public function index($page = null) {
        $this->layout = "client";
        $this->set('slug', $page);
       
        $condition = array('conditions' => array('Page.static_page_heading' => $page));
        $pagedetails = $this->Page->find('first', $condition);
        $lang = $_SESSION['Config']['language'];

        $this->set('title_for_layout', TITLE_FOR_PAGES . $pagedetails['Page']['static_page_title']);

        $this->set('pagedetails', $pagedetails);
        if ($page == 'about-us') {
            $this->set('topactive', 'aboutus');
        }
        if ($page == 'connect') {
            $this->set('active', 'connect');
        }
        if ($page == 'our-fabric') {
            $this->set('active', 'ourfabric');
        }
        if ($page == 'privacy-policy') {
            //$this->set('topactive', '');
        }
        if ($page == 'under') {
            $this->set('under', 1);
        }
        $this->layout = "client";
        $this->set('slug', $page);
        $this->set('header_act', $page);
        $condition = array('conditions' => array('Page.static_page_heading' => $page));
        $pagedetails = $this->Page->find('first', $condition);
        $this->set('page_set', $pagedetails['Page']['static_page_heading']);

        if (!empty($pagedetails)) {
            $this->set('title_for_layout', TITLE_FOR_PAGES . $pagedetails['Page']['static_page_title']);
            $this->set('pagedetails', $pagedetails);
        } else {
            $this->set('title_for_layout', TITLE_FOR_PAGES . 'Page not found');
            $this->set('pagedetails', '');
            $this->set('under', '1');
        }
    }
    
    public function captcha() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        if (!isset($this->Captcha)) {
            App::import('Component', 'Captcha'); //load it
            $this->Captcha = new CaptchaComponent(); //make instance
            $this->Captcha->startup($this); //and do some manually calling
        }
        $this->Captcha->create();
    }

    public function contactUs() {
        $msgString = '';
        $this->layout = "staticpage";
        App::import('Component', 'Captcha');
        $this->set("active", "contact_us");
        $this->set("top_active", "contact_us");
        $this->set('active', 'contact_us');
        $this->set('contact_us', 'active');
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Contact Us');
        global $extentions_file;
        $this->Captcha = new CaptchaComponent();
        $this->Captcha->startup($this);

        $contact_details = $this->Admin->find('first');
        $this->set('contact_details',$contact_details);
        
        if ($this->data) { 
            if (empty($this->data["User"]["name"])) {
                $msgString .="- Name is required field.<br>";
            }
            if (empty($this->data["User"]["email"])) {
                $msgString .="- Email Address is required field.<br>";
            } elseif ($this->User->checkEmail($this->data["User"]["email"]) == false) {
                $msgString .="- Email Address is not valid.<br>";
            }
            if (empty($this->data["User"]["subject"])) {
                $msgString .="- Subject is required field.<br>";
            }
            $this->request->data["User"]["message"] = trim($this->data["User"]["message"]);
            if (empty($this->data["User"]["message"])) {
                $msgString .="- Message is required field.<br>";
            }
            $captcha = $this->Captcha->getVerCode();
            if ($this->data['User']['captcha'] == "") {
                $msgString .="- Please Enter security code<br>";
            } elseif ($this->data['User']['captcha'] != $captcha) {
                $msgString .="- Please Enter correct security code.<br>";
            }
            //print_r($msgString);exit;
            if (isset($msgString) && $msgString != '') {
                 $this->Session->setFlash($msgString, 'error_msg');
            } else {
                                
                $username = $this->data["User"]["name"];
                $email = $this->data["User"]["email"];
                $message = $this->data["User"]["message"];
                $this->Email->to = $contact_details['Admin']['email'];
                $emailtemplateMessage = $this->Emailtemplate->find("first", array("conditions" => "Emailtemplate.id='6'"));
                $this->Email->subject = $this->data["User"]['subject'];
                $this->Email->replyTo = SITE_TITLE  . "<" . MAIL_FROM . ">";
                $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";
                $currentYear = date('Y', time());
                $sitelink = '<a style="color:#000; text-decoration: underline;" href="mailto:' . MAIL_FROM . '">' . MAIL_FROM . '</a>';
                $toRepArray = array('[!username!]','[!email!]', '[!message!]', '[!DATE!]', '[!HTTP_PATH!]', '[!SITE_TITLE!]', '[!SITE_LINK!]', '[!SITE_URL!]');
                $fromRepArray = array($username,$email, $message, $currentYear, HTTP_PATH, SITE_TITLE, $sitelink, SITE_URL);
                $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                
             
               $this->Email->layout = 'default';
                $this->set('messageToSend', $messageToSend);
                $this->Email->template = 'email_template';
                $this->Email->sendAs = 'html';
                $this->Email->send();
                
                $this->Email->reset();
                
                $this->Email->to = $email;
                //$this->Email->cc =$this->Admin->field('cc_email', array('Admin.id' => 1));
                $emailtemplateMessage = $this->Emailtemplate->find("first", array("conditions" => "Emailtemplate.id='19'"));
                $this->Email->subject = $this->data["User"]['subject'];
                $this->Email->replyTo = SITE_TITLE  . "<" . MAIL_FROM . ">";
                $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";
                $currentYear = date('Y', time());
                $sitelink = '<a style="color:#000; text-decoration: underline;" href="mailto:' . MAIL_FROM . '">' . MAIL_FROM . '</a>';
                $toRepArray = array('[!username!]','[!email!]', '[!message!]', '[!DATE!]', '[!HTTP_PATH!]', '[!SITE_TITLE!]', '[!SITE_LINK!]', '[!SITE_URL!]','[!subject!]');
                $fromRepArray = array($username,$email, $message, $currentYear, HTTP_PATH, SITE_TITLE, $sitelink, SITE_URL,$this->data["User"]["subject"]);
                $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
              
                $this->Email->layout = 'default';
                $this->set('messageToSend', $messageToSend);
                $this->Email->template = 'email_template';
                $this->Email->sendAs = 'html';
                $this->Email->send();  
                //exit;
                $this->Session->setFlash('Your enquiry has been successfully sent to us!', 'success_msg');
                //$this->Session->write('success_sup_msg', 'Your enquiry has been successfully sent to us!');
                //$this->redirect('/thankyou');
            }
        }
    }
    
    public function feedback() {
        $msgString = '';
        $this->layout = "client";
        App::import('Component', 'Captcha');
        
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Feedback');
        global $extentions_file;
        $this->Captcha = new CaptchaComponent();
        $this->Captcha->startup($this);

        $contact_details = $this->Admin->find('first');
        $this->set('contact_details',$contact_details);
        
        if ($this->data) { 
            if (empty($this->data["User"]["name"])) {
                $msgString .="- Name is required field.<br>";
            }
            if (empty($this->data["User"]["email"])) {
                $msgString .="- Email Address is required field.<br>";
            } elseif ($this->User->checkEmail($this->data["User"]["email"]) == false) {
                $msgString .="- Email Address is not valid.<br>";
            }
            if (empty($this->data["User"]["subject"])) {
                $msgString .="- Subject is required field.<br>";
            }
            $this->request->data["User"]["message"] = trim($this->data["User"]["message"]);
            if (empty($this->data["User"]["message"])) {
                $msgString .="- Message is required field.<br>";
            }
            $captcha = $this->Captcha->getVerCode();
            if ($this->data['User']['captcha'] == "") {
                $msgString .="- Please Enter security code<br>";
            } elseif ($this->data['User']['captcha'] != $captcha) {
                $msgString .="- Please Enter correct security code.<br>";
            }
            //print_r($msgString);exit;
            if (isset($msgString) && $msgString != '') {
                 $this->Session->setFlash($msgString, 'error_msg');
            } else {
                                
                $username = $this->data["User"]["name"];
                $email = $this->data["User"]["email"];
                $message = $this->data["User"]["message"];
                $this->Email->to = $contact_details['Admin']['email'];
                
                $emailtemplateMessage = $this->Emailtemplate->find("first", array("conditions" => "Emailtemplate.id='20'"));
                $this->Email->subject = $this->data["User"]['subject'];
                $this->Email->replyTo = SITE_TITLE  . "<" . MAIL_FROM . ">";
                $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";
                $currentYear = date('Y', time());
                $sitelink = '<a style="color:#000; text-decoration: underline;" href="mailto:' . MAIL_FROM . '">' . MAIL_FROM . '</a>';
                $toRepArray = array('[!username!]','[!email!]', '[!message!]', '[!DATE!]', '[!HTTP_PATH!]', '[!SITE_TITLE!]', '[!SITE_LINK!]', '[!SITE_URL!]');
                $fromRepArray = array($username,$email, $message, $currentYear, HTTP_PATH, SITE_TITLE, $sitelink, SITE_URL);
                $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                $this->Email->layout = 'default';
                $this->set('messageToSend', $messageToSend);
                $this->Email->template = 'email_template';
                $this->Email->sendAs = 'html';
                $this->Email->send();
                
                $this->Email->to = $email;
                //$this->Email->cc =$this->Admin->field('cc_email', array('Admin.id' => 1));
                $emailtemplateMessage = $this->Emailtemplate->find("first", array("conditions" => "Emailtemplate.id='21'"));
                $this->Email->subject = $this->data["User"]['subject'];
                $this->Email->replyTo = SITE_TITLE  . "<" . MAIL_FROM . ">";
                $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";
                $currentYear = date('Y', time());
                $sitelink = '<a style="color:#000; text-decoration: underline;" href="mailto:' . MAIL_FROM . '">' . MAIL_FROM . '</a>';
                $toRepArray = array('[!username!]','[!email!]', '[!message!]', '[!DATE!]', '[!HTTP_PATH!]', '[!SITE_TITLE!]', '[!SITE_LINK!]', '[!SITE_URL!]');
                $fromRepArray = array($username,$email, $message, $currentYear, HTTP_PATH, SITE_TITLE, $sitelink, SITE_URL);
                $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                $this->Email->layout = 'default';
                $this->set('messageToSend', $messageToSend);
                $this->Email->template = 'email_template';
                $this->Email->sendAs = 'html';
                $this->Email->send();  
                
                
                $this->Session->setFlash('Your feedback has been successfully sent to us!', 'success_msg');
                //$this->Session->write('success_sup_msg', 'Your enquiry has been successfully sent to us!');
                //$this->redirect('/feedback');
            }
        }
    }

    public function terms_and_conditions() {
        $this->layout = "";
        $pageContent = $this->Page->find("first", array("conditions" => "Page.static_page_heading='terms-and-condition'"));
        $this->set("pageContent", $pageContent);
        $this->set("title_for_layout", TITLE_FOR_PAGES . $pageContent['Page']['static_page_title']);
        // pr($pageContent);exit;
    }
    public function privacy_policy() {
        $this->layout = "client";
        $pageContent = $this->Page->find("first", array("conditions" => "Page.static_page_heading='privacy_policy'"));
        $this->set("pageContent", $pageContent);
        $this->set("title_for_layout", TITLE_FOR_PAGES . $pageContent['Page']['static_page_title']);
         //print_r($pageContent);exit;
    }
   
   
    public function sitemap() {
        $this->layout = "client";
        $this->set("title_for_layout", TITLE_FOR_PAGES . 'Site Map');
    }
	
  
    public function mailto() {
        $to = 'dinesh.dhaker@logicspice.com';
        $subject = 'the subject';
        $message = 'test email for all';
        $headers = 'From: dinesh.dhaker@logicspice.com' . "\r\n" .
                'Reply-To: dinesh.dhaker@logicspice.com' . "\r\n" .
                'CC: santosh.mittal@logicspice.com ' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

       mail($to, $subject, $message, $headers); 
       exit;
       
    }
    
    
    public function features() { 
        $this->layout = "home";
        $this->set('title_for_layout', TITLE_FOR_PAGES.' Features');
        $this->set('featureAct', 1);
    }
    
    public function faq() { 
        $this->layout = "home";
        $this->set('title_for_layout', TITLE_FOR_PAGES.' FAQ');
        $this->set('faqAct', 1);
    }
	
}
?>