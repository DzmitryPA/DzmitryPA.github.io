<?php

class UsersController extends AppController {

    public $uses = array('Admin', 'Page', 'Emailtemplate', 'User', 'Setting', 'State', 'City', 'Industry', 'Follow', 'Watch', 'Timeline', 'Product', 'Service');
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

    /*     * ******** Backend end functions ******************** */

    public function admin_index() {
        $this->layout = "admin";
        $this->set('userListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Manage Companies');

        $condition = array();
        $separator = array();
        $urlSeparator = array();

        if (!empty($this->data)) {
            if (isset($this->data['User']['keyword']) && $this->data['User']['keyword'] != '') {
                $keyword = trim($this->data['User']['keyword']);
            }
            if (isset($this->data['User']['searchByDateFrom']) && $this->data['User']['searchByDateFrom'] != '') {
                $searchByDateFrom = trim($this->data['User']['searchByDateFrom']);
            }

            if (isset($this->data['User']['searchByDateTo']) && $this->data['User']['searchByDateTo'] != '') {
                $searchByDateTo = trim($this->data['User']['searchByDateTo']);
            }

            if (isset($this->data['User']['action'])) {
                $idList = $this->data['User']['idList'];
                if ($idList) {
                    if ($this->data['User']['action'] == "activate") {
                        $cnd = array("User.id IN ($idList) ");
                        $this->User->updateAll(array('User.status' => "'1'"), $cnd);
                    } elseif ($this->data['User']['action'] == "deactivate") {
                        $cnd = array("User.id IN ($idList) ");
                        $this->User->updateAll(array('User.status' => "'0'"), $cnd);
                    } elseif ($this->data['User']['action'] == "delete") {
                        $cnd = array("User.id IN ($idList) ");
                        $this->User->deleteAll($cnd);
                    }
                }
            }
        } elseif (!empty($this->params)) {
            if (isset($this->params['named']['keyword']) && $this->params['named']['keyword'] != '') {
                $keyword = urldecode(trim($this->params['named']['keyword']));
            }
            if (isset($this->params['named']['searchByDateFrom']) && $this->params['named']['searchByDateFrom'] != '') {
                $searchByDateFrom = urldecode(trim($this->params['named']['searchByDateFrom']));
            }
            if (isset($this->params['named']['searchByDateTo']) && $this->params['named']['searchByDateTo'] != '') {
                $searchByDateTo = urldecode(trim($this->params['named']['searchByDateTo']));
            }
        }

        if (isset($keyword) && $keyword != '') {
            $separator[] = 'keyword:' . urlencode($keyword);
            $condition[] = " (`User`.`company_name` LIKE '%" . addslashes($keyword) . "%'  or `User`.`chairman` LIKE '%" . addslashes($keyword) . "%' or `User`.`email_address` LIKE '%" . addslashes($keyword) . "%' ) ";
            $this->set('keyword', $keyword);
        }
        if (isset($searchByDateFrom) && $searchByDateFrom != '') {
            $separator[] = 'searchByDateFrom:' . urlencode($searchByDateFrom);
            $searchByDateFrom = str_replace('_', '\_', $searchByDateFrom);
            $searchByDate_con1 = date('Y-m-d', strtotime($searchByDateFrom));
            $condition[] = " (Date(User.created)>='$searchByDate_con1' ) ";
            $searchByDateFrom = str_replace('\_', '_', $searchByDateFrom);
        }

        if (isset($searchByDateTo) && $searchByDateTo != '') {
            $separator[] = 'searchByDateTo:' . urlencode($searchByDateTo);
            $searchByDateTo = str_replace('_', '\_', $searchByDateTo);
            $searchByDate_con2 = date('Y-m-d', strtotime($searchByDateTo));
            $condition[] = " (Date(User.created)<='$searchByDate_con2' ) ";
            $searchByDateTo = str_replace('\_', '_', $searchByDateTo);
        }

        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);

        $this->paginate['User'] = array(
            'conditions' => $condition,
            'order' => array('User.id' => 'DESC'),
            'limit' => '50'
        );

        $this->set('users', $this->paginate('User', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/users/';
            $this->render('index');
        }
    }

    public function admin_add() {
        $this->layout = "admin";
        $this->set('userAdd', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Add Company');
        $stateList = $this->State->getList();
        $this->set('stateList', $stateList);
        $cityList = array();
        $industryList = $this->Industry->getList();
        $this->set('industryList', $industryList);
        $subIndustryList = array();
        $msgString = '';
        if ($this->data) {
            //pr($this->data); exit;
            if (trim($this->data["User"]["company_name"]) == '') {
                $msgString .="- Company name is required field.<br>";
            } elseif ($this->User->isRecordCompany($this->data["User"]["company_name"]) == false) {
                $msgString .="- Company name already exists.<br>";
            }

            if (trim($this->data["User"]["email_address"]) == '') {
                $msgString .="- Email is required field.<br>";
            } elseif ($this->User->checkEmail($this->data["User"]["email_address"]) == false) {
                $msgString .="- Email Not Valid.<br>";
            } elseif ($this->User->isRecordUniqueemail($this->data["User"]["email_address"]) == false) {
                $msgString .="- Email already exists.<br>";
            }

            if (trim($this->data["User"]["unique_id"]) == '') {
                $msgString .="- Unique ID required field.<br>";
            } elseif ($this->User->isRecordUniqueID($this->data["User"]["unique_id"]) == false) {
                $msgString .="- Unique ID already exists.<br>";
            }

            if (empty($this->data["User"]["password"])) {
                $msgString .="- Password is required field.<br>";
            }
            if (empty($this->data["User"]["confirm_password"])) {
                $msgString .="- Retype password is required field.<br>";
            }

            if (empty($this->data["User"]["state_id"])) {
                $msgString .="- Satte is required field.<br>";
            }
            if (empty($this->data["User"]["city_id"])) {
                $msgString .="- City is required field.<br>";
            }
            if (empty($this->data["User"]["street"])) {
                $msgString .="- Street is required field.<br>";
            }
            if (empty($this->data["User"]["zipcode"])) {
                $msgString .="- Postalcode/ZIP is required field.<br>";
            }
            if (empty($this->data["User"]["chairman"])) {
                $msgString .="- Chairman is required field.<br>";
            }
            if (empty($this->data["User"]["industry_id"])) {
                $msgString .="- Industry is required field.<br>";
            }
            if (empty($this->data["User"]["subindustry_id"])) {
                $msgString .="- Sub industry category is required field.<br>";
            }
            if (empty($this->data["User"]["bank_account_number"])) {
                $msgString .="- Bank account number is required field.<br>";
            }
            if (empty($this->data["User"]["branch_name"])) {
                $msgString .="- branch is required field.<br>";
            }

            if ($this->data["User"]["certificates"]["name"]) {
                $getextention = $this->PImage->getExtension($this->data['User']['certificates']['name']);
                echo $extention = strtolower($getextention);
                global $certificatesextentions;
                if (!in_array($extention, $certificatesextentions)) {
                    $msgString .="- Not valid extention for certificates.<br>";
                } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                    $msgString .="- Max file size upload is 2MB for certificates.<br>";
                }
            }

            if ($this->data["User"]["company_logo"]["name"]) {
                $getextention = $this->PImage->getExtension($this->data['User']['company_logo']['name']);
                $extention = strtolower($getextention);
                global $imageextentions;
                if (!in_array($extention, $imageextentions)) {
                    $msgString .="- Not valid extention for company logo.<br>";
                } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                    $msgString .="- Max file size upload is 2MB for company logo.<br>";
                }
            }

            if ($this->data["User"]["background_img"]["name"]) {
                $getextention = $this->PImage->getExtension($this->data['User']['background_img']['name']);
                $extention = strtolower($getextention);
                global $imageextentions;
                if (!in_array($extention, $imageextentions)) {
                    $msgString .="- Not valid extention for background img.<br>";
                } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                    $msgString .="- Max file size upload is 2MB for background imgo.<br>";
                }
            }

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
                $cityList = $this->City->getList($this->data['User']['state_id']);
                $subIndustryList = $this->Industry->getSubIndustryList($this->data['User']['industry_id']);
            } else {
                $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                $toReplace = "-";

                if ($this->data["User"]["certificates"]["name"]) {
                    $this->request->data['User']['certificates']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['certificates']['name']);
                    $imageArray = $this->data['User']['certificates'];
                    $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_CRTIFICATE_PATH);
                    $this->request->data['User']['certificates'] = $returnedUploadImageArray[0];
                } else {
                    $this->request->data['User']['certificates'] = "";
                }

                if ($this->data["User"]["company_logo"]["name"]) {
                    $this->request->data['User']['company_logo']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['company_logo']['name']);
                    $imageArray = $this->data['User']['company_logo'];
                    $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_LOGO_PATH);
                    $this->request->data['User']['company_logo'] = $returnedUploadImageArray[0];
                } else {
                    $this->request->data['User']['company_logo'] = "";
                }

                if ($this->data["User"]["background_img"]["name"]) {
                    $this->request->data['User']['background_img']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['background_img']['name']);
                    $imageArray = $this->data['User']['background_img'];
                    $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_BACKGROUND_PATH);
                    $this->request->data['User']['background_img'] = $returnedUploadImageArray[0];
                } else {
                    $this->request->data['User']['background_img'] = "";
                }

                $slider = array();
                if (count($this->data["User"]["slider_img"]) > 0) {
                    foreach ($this->data["User"]["slider_img"] as $val) {
                        if ($val["name"]) {
                            $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                            $imageArray = $val;
                            $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_SLIDER_PATH);
                            $slider[] = $returnedUploadImageArray[0];
                        }
                    }

                    $this->request->data['User']['slider_img'] = implode(',', $slider);
                } else {
                    $this->request->data['User']['slider_img'] = '';
                }

                $passwordPlain = $this->data["User"]["password"];
                $salt = uniqid(mt_rand(), true);
                $new_password = crypt($passwordPlain, '$2a$07$' . $salt . '$');
                $this->request->data['User']['password'] = $new_password;
                $this->request->data['User']['activation_status'] = 1;
                $this->request->data['User']['status'] = 1;
                $this->request->data['User']['country_id'] = 2;
                $this->request->data['User']['slug'] = $this->stringToSlugUnique($this->data["User"]['company_name'], 'User', 'slug');

                if ($this->User->save($this->data)) {

                    $userId = $this->User->id;
                    $email = $this->data["User"]["email_address"];
                    $companyName = $this->data["User"]["company_name"];
                    $chairman = $this->data["User"]["chairman"];
                    $link = HTTP_PATH . "/users/confirmation/" . $userId . "/" . md5($userId) . "/" . urlencode($email);

                    $this->Email->to = $email;
                    $emailtemplateMessage = $this->Emailtemplate->findById(4);
                    $this->Email->subject = $emailtemplateMessage['Emailtemplate']['subject'];
                    $this->Email->replyTo = SITE_TITLE . "<" . MAIL_FROM . ">";
                    $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";
                    $toRepArray = array('[!email!]', '[!username!]', '[!company_name!]', '[!password!]', '[!LINK!]', '[!SITE_TITLE!]',);
                    $fromRepArray = array($email, $chairman, $companyName, $passwordPlain, $link, SITE_TITLE);
                    $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                    $this->Email->layout = 'default';
                    $this->set('messageToSend', $messageToSend);
                    //echo $messageToSend;exit;
                    $this->Email->template = 'email_template';
                    $this->Email->sendAs = 'html';
                    $this->Email->send();

                    $this->Session->setFlash('Company Added Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                }
            }
        }

        $termsConditions = $this->Page->findBySlug('terms-and-condition');
        $this->set('termsConditions', $termsConditions);
        $privacyPolicy = $this->Page->findBySlug('privacy-policy');
        $this->set('privacyPolicy', $privacyPolicy);
        $this->set('cityList', $cityList);
        $this->set('subIndustryList', $subIndustryList);
    }

    public function admin_edit($slug = null) {
        $this->layout = "admin";
        $this->set('userListAct', 'active');
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Edit Company');
        $stateList = $this->State->getList();
        $this->set('stateList', $stateList);
        $cityList = array();
        $industryList = $this->Industry->getList();
        $this->set('industryList', $industryList);
        $subIndustryList = array();
        $msgString = '';

        $userInfo = $this->User->findBySlug($slug);
        if (!$userInfo) {
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }


        if ($this->data) {
            //pr($this->data); exit;
            if (trim($this->data["User"]["company_name"]) == '') {
                $msgString .="- Company name is required field.<br>";
            } /* elseif ($this->User->isRecordCompany($this->data["User"]["company_name"]) == false) {
              $msgString .="- Company name already exists.<br>";
              } */

            if (trim($this->data["User"]["email_address"]) == '') {
                $msgString .="- Email is required field.<br>";
            } elseif ($this->User->checkEmail($this->data["User"]["email_address"]) == false) {
                $msgString .="- Email Not Valid.<br>";
            }/* elseif ($this->User->isRecordUniqueemail($this->data["User"]["email_address"]) == false) {
              $msgString .="- Email already exists.<br>";
              } */

            if (trim($this->data["User"]["unique_id"]) == '') {
                $msgString .="- Unique ID required field.<br>";
            }/* elseif ($this->User->isRecordUniqueID($this->data["User"]["unique_id"]) == false) {
              $msgString .="- Unique ID already exists.<br>";
              } */

            if (trim($this->data["User"]["new_password"]) != '') {
                if (strlen($this->data["User"]["new_password"]) < 8) {
                    $msgString .="- Password must be at least 8 characters.<br>";
                }
                if (trim($this->data["User"]["confirm_password"]) == '') {
                    $msgString .="- Confirm Password is required field.<br>";
                } else {
                    $password = $this->data["User"]["new_password"];
                    $conformpassword = $this->data["User"]["confirm_password"];

                    if ($password != $conformpassword) {
                        $msgString.= "- New password and confirm password mismatch.<br>";
                    } else {
                        $changedPassword = 1;
                        $passwordPlain = $this->data["User"]["new_password"];
                        $salt = uniqid(mt_rand(), true);
                        $new_password = crypt($passwordPlain, '$2a$07$' . $salt . '$');

                        $this->request->data['User']['password'] = $new_password;
                    }
                }
            } elseif (trim($this->data["User"]["confirm_password"]) != '') {
                $msgString .="-Please enter New Password first.<br>";
            }

            if (empty($this->data["User"]["state_id"])) {
                $msgString .="- Satte is required field.<br>";
            }
            if (empty($this->data["User"]["city_id"])) {
                $msgString .="- City is required field.<br>";
            }
            if (empty($this->data["User"]["street"])) {
                $msgString .="- Street is required field.<br>";
            }
            if (empty($this->data["User"]["zipcode"])) {
                $msgString .="- Postalcode/ZIP is required field.<br>";
            }
            if (empty($this->data["User"]["chairman"])) {
                $msgString .="- Chairman is required field.<br>";
            }
            if (empty($this->data["User"]["industry_id"])) {
                $msgString .="- Industry is required field.<br>";
            }
            if (empty($this->data["User"]["subindustry_id"])) {
                $msgString .="- Sub industry category is required field.<br>";
            }
            if (empty($this->data["User"]["bank_account_number"])) {
                $msgString .="- Bank account number is required field.<br>";
            }
            if (empty($this->data["User"]["branch_name"])) {
                $msgString .="- branch is required field.<br>";
            }

            if ($this->data["User"]["certificates"]["name"]) {
                $getextention = $this->PImage->getExtension($this->data['User']['certificates']['name']);
                echo $extention = strtolower($getextention);
                global $certificatesextentions;
                if (!in_array($extention, $certificatesextentions)) {
                    $msgString .="- Not valid extention for certificates.<br>";
                } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                    $msgString .="- Max file size upload is 2MB for certificates.<br>";
                }
            }

            if ($this->data["User"]["company_logo"]["name"]) {
                $getextention = $this->PImage->getExtension($this->data['User']['company_logo']['name']);
                $extention = strtolower($getextention);
                global $imageextentions;
                if (!in_array($extention, $imageextentions)) {
                    $msgString .="- Not valid extention for company logo.<br>";
                } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                    $msgString .="- Max file size upload is 2MB for company logo.<br>";
                }
            }

            if ($this->data["User"]["background_img"]["name"]) {
                $getextention = $this->PImage->getExtension($this->data['User']['background_img']['name']);
                $extention = strtolower($getextention);
                global $imageextentions;
                if (!in_array($extention, $imageextentions)) {
                    $msgString .="- Not valid extention for background img.<br>";
                } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                    $msgString .="- Max file size upload is 2MB for background imgo.<br>";
                }
            }
            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
                $cityList = $this->City->getList($this->data['User']['state_id']);
                $subIndustryList = $this->Industry->getSubIndustryList($this->data['User']['industry_id']);
                $this->set('cityList', $cityList);
                $this->set('subIndustryList', $subIndustryList);
            } else {
                //pr($this->data); exit;
                $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                $toReplace = "-";

                if (!empty($this->data["User"]["certificates"]["name"])) {
                    $this->request->data['User']['certificates']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['certificates']['name']);
                    $imageArray = $this->data['User']['certificates'];
                    $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_CRTIFICATE_PATH);
                    $this->request->data['User']['certificates'] = $returnedUploadImageArray[0];
                    if (!empty($this->data['User']['old_certificates'])) {
                        @unlink(UPLOAD_CRTIFICATE_PATH . $this->data['User']['old_certificates']);
                    }
                } else {
                    $this->request->data['User']['certificates'] = $this->data['User']['old_certificates'];
                }

                if (!empty($this->data["User"]["company_logo"]["name"])) {
                    $this->request->data['User']['company_logo']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['company_logo']['name']);
                    $imageArray = $this->data['User']['company_logo'];
                    $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_LOGO_PATH);
                    $this->request->data['User']['company_logo'] = $returnedUploadImageArray[0];
                    if (!empty($this->data['User']['old_company_logo'])) {
                        @unlink(UPLOAD_LOGO_PATH . $this->data['User']['old_company_logo']);
                    }
                } else {
                    $this->request->data['User']['company_logo'] = $this->data['User']['old_company_logo'];
                }

                if (!empty($this->data["User"]["background_img"]["name"])) {
                    $this->request->data['User']['background_img']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['background_img']['name']);
                    $imageArray = $this->data['User']['background_img'];
                    $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_BACKGROUND_PATH);
                    $this->request->data['User']['background_img'] = $returnedUploadImageArray[0];
                    if (!empty($this->data['User']['old_background_img'])) {
                        @unlink(UPLOAD_BACKGROUND_PATH . $this->data['User']['old_background_img']);
                    }
                } else {
                    $this->request->data['User']['background_img'] = $this->data['User']['old_background_img'];
                }

//                $slider = array();
//                if (count($this->data["User"]["slider_img"]) > 0) {
//                    foreach($this->data["User"]["slider_img"] as $val){
//                        if ($val["name"]) {
//                            $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
//                            $imageArray = $val;
//                            $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_SLIDER_PATH);
//                            $slider[] = $returnedUploadImageArray[0];
//                        }
//                    }
//                    
//                    $this->request->data['User']['slider_img'] = implode(',', $slider);
//                }else{
//                    $this->request->data['User']['slider_img'] = $this->data['User']['old_slider_img'];
//                }

                $this->request->data['User']['country_id'] = 2;

                if ($this->User->save($this->data)) {
                    $this->Session->setFlash('Company Updated Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                }
            }
        } elseif ($slug != '') {
            $id = $this->User->field('id', array('User.slug' => $slug));
            $this->set('user_id', $id);
            $this->User->id = $id;
            $this->data = $this->User->read();
            $this->request->data['User']['old_certificates'] = $this->data['User']['certificates'];
            $this->request->data['User']['old_company_logo'] = $this->data['User']['company_logo'];
            $this->request->data['User']['old_background_img'] = $this->data['User']['background_img'];
            $this->request->data['User']['old_slider_img'] = $this->data['User']['slider_img'];
            $this->request->data['User']['old_password'] = $this->data['User']['password'];
            $this->set('cityList', $this->City->getList($this->data['User']['state_id']));
            $this->set('subIndustryList', $this->Industry->getSubIndustryList($this->data['User']['industry_id']));
        }
    }

    public function admin_activateuser($slug = NULL, $parentSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->User->field('id', array('User.slug' => $slug));
            $cnd = array("User.id = $id");
            $this->User->updateAll(array('User.status' => "'1'", 'User.activation_status' => "'1'"), $cnd);
            $this->set('action', '/admin/users/deactivateuser/' . $slug);
            $this->set('id', $id);
            $this->set('status', 1);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_deactivateuser($slug = NULL, $parentSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->User->field('id', array('User.slug' => $slug));
            $cnd = array("User.id = $id");
            $this->User->updateAll(array('User.status' => "'0'"), $cnd);
            $this->set('action', '/admin/users/activateuser/' . $slug);
            $this->set('id', $id);
            $this->set('status', 0);


            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_delete($slug = null) {
        $id = $this->User->field('id', array('User.slug' => $slug));
        if ($id) {
            $this->User->delete($id);
            $this->Session->setFlash('Company Deleted Successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');
        }
        $this->redirect(array('controller' => 'users', 'action' => 'index', 'page' => $this->passedArgs["page"]));
    }

    /*     * ******** front end functions ******************** */

    public function register() {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "Sign Up");
        $this->layout = "home";
        $this->set('regAct', 1);

        $stateList = $this->State->getList();
        $this->set('stateList', $stateList);
        $cityList = array();
        $industryList = $this->Industry->getList();
        $this->set('industryList', $industryList);
        $subIndustryList = array();
        $msgString = '';
        if ($this->data) {
            if (trim($this->data["User"]["company_name"]) == '') {
                $msgString .="- Company name is required field.<br>";
            } elseif ($this->User->isRecordCompany($this->data["User"]["company_name"]) == false) {
                $msgString .="- Company name already exists.<br>";
            }

            if (trim($this->data["User"]["email_address"]) == '') {
                $msgString .="- Email is required field.<br>";
            } elseif ($this->User->checkEmail($this->data["User"]["email_address"]) == false) {
                $msgString .="- Email Not Valid.<br>";
            } elseif ($this->User->isRecordUniqueemail($this->data["User"]["email_address"]) == false) {
                $msgString .="- Email already exists.<br>";
            }

            if (trim($this->data["User"]["unique_id"]) == '') {
                $msgString .="- Unique ID required field.<br>";
            } elseif ($this->User->isRecordUniqueID($this->data["User"]["unique_id"]) == false) {
                $msgString .="- Unique ID already exists.<br>";
            }

            if (empty($this->data["User"]["password"])) {
                $msgString .="- Password is required field.<br>";
            }
            if (empty($this->data["User"]["confirm_password"])) {
                $msgString .="- Retype password is required field.<br>";
            }

            if (empty($this->data["User"]["state_id"])) {
                $msgString .="- Satte is required field.<br>";
            }
            if (empty($this->data["User"]["city_id"])) {
                $msgString .="- City is required field.<br>";
            }
            if (empty($this->data["User"]["street"])) {
                $msgString .="- Street is required field.<br>";
            }
            if (empty($this->data["User"]["zipcode"])) {
                $msgString .="- Postalcode/ZIP is required field.<br>";
            }
            if (empty($this->data["User"]["chairman"])) {
                $msgString .="- Chairman is required field.<br>";
            }
            if (empty($this->data["User"]["industry_id"])) {
                $msgString .="- Industry is required field.<br>";
            }
            if (empty($this->data["User"]["subindustry_id"])) {
                $msgString .="- Sub industry category is required field.<br>";
            }
            if (empty($this->data["User"]["bank_account_number"])) {
                $msgString .="- Bank account number is required field.<br>";
            }
            if (empty($this->data["User"]["branch_name"])) {
                $msgString .="- branch is required field.<br>";
            }

            if ($this->data["User"]["certificates"]["name"]) {
                $getextention = $this->PImage->getExtension($this->data['User']['certificates']['name']);
                $extention = strtolower($getextention);
                global $certificatesextentions;
                if (!in_array($extention, $certificatesextentions)) {
                    $msgString .="- Not valid extention for certificates.<br>";
                } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                    $msgString .="- Max file size upload is 2MB for certificates.<br>";
                }
            }

            if ($this->data["User"]["company_logo"]["name"]) {
                $getextention = $this->PImage->getExtension($this->data['User']['company_logo']['name']);
                $extention = strtolower($getextention);
                global $imageextentions;
                if (!in_array($extention, $imageextentions)) {
                    $msgString .="- Not valid extention for company logo.<br>";
                } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                    $msgString .="- Max file size upload is 2MB for company logo.<br>";
                }
            }

            if ($this->data["User"]["background_img"]["name"]) {
                $getextention = $this->PImage->getExtension($this->data['User']['background_img']['name']);
                $extention = strtolower($getextention);
                global $imageextentions;
                if (!in_array($extention, $imageextentions)) {
                    $msgString .="- Not valid extention for background img.<br>";
                } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                    $msgString .="- Max file size upload is 2MB for background imgo.<br>";
                }
            }

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
                $cityList = $this->City->getList($this->data['User']['state_id']);
                $subIndustryList = $this->Industry->getSubIndustryList($this->data['User']['industry_id']);
            } else {

                $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                $toReplace = "-";

                if ($this->data["User"]["certificates"]["name"]) {
                    $this->request->data['User']['certificates']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['certificates']['name']);
                    $imageArray = $this->data['User']['certificates'];
                    $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_CRTIFICATE_PATH);
                    $this->request->data['User']['certificates'] = $returnedUploadImageArray[0];
                } else {
                    $this->request->data['User']['certificates'] = '';
                }

                if ($this->data["User"]["company_logo"]["name"]) {
                    $this->request->data['User']['company_logo']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['company_logo']['name']);
                    $imageArray = $this->data['User']['company_logo'];
                    $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_LOGO_PATH);
                    $this->request->data['User']['company_logo'] = $returnedUploadImageArray[0];
                } else {
                    $this->request->data['User']['company_logo'] = '';
                }

                if ($this->data["User"]["background_img"]["name"]) {
                    $this->request->data['User']['background_img']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['background_img']['name']);
                    $imageArray = $this->data['User']['background_img'];
                    $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_BACKGROUND_PATH);
                    $this->request->data['User']['background_img'] = $returnedUploadImageArray[0];
                } else {
                    $this->request->data['User']['background_img'] = '';
                }

                $slider = array();
                if (count($this->data["User"]["slider_img"]) > 0) {
                    foreach ($this->data["User"]["slider_img"] as $val) {
                        if ($val["name"]) {
                            $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                            $imageArray = $val;
                            $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_SLIDER_PATH);
                            $slider[] = $returnedUploadImageArray[0];
                        }
                    }

                    $this->request->data['User']['slider_img'] = implode(',', $slider);
                } else {
                    $this->request->data['User']['slider_img'] = '';
                }

                $passwordPlain = $this->data["User"]["password"];
                $salt = uniqid(mt_rand(), true);
                $new_password = crypt($passwordPlain, '$2a$07$' . $salt . '$');
                $this->request->data['User']['password'] = $new_password;
                $this->request->data['User']['activation_status'] = 0;
                $this->request->data['User']['status'] = 0;
                $this->request->data['User']['country_id'] = 2;
                $this->request->data['User']['slug'] = $this->stringToSlugUnique($this->data["User"]['company_name'], 'User', 'slug');
                //pr($this->data);exit;
                if ($this->User->save($this->data)) {

                    $userId = $this->User->id;
                    $email = $this->data["User"]["email_address"];
                    $companyName = $this->data["User"]["company_name"];
                    $chairman = $this->data["User"]["chairman"];
                    $link = HTTP_PATH . "/users/confirmation/" . $userId . "/" . md5($userId) . "/" . urlencode($email);

                    $this->Email->to = $email;
                    $emailtemplateMessage = $this->Emailtemplate->findById(2);
                    $this->Email->subject = $emailtemplateMessage['Emailtemplate']['subject'];
                    $this->Email->replyTo = SITE_TITLE . "<" . MAIL_FROM . ">";
                    $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";
                    $toRepArray = array('[!email!]', '[!username!]', '[!company_name!]', '[!password!]', '[!LINK!]', '[!SITE_TITLE!]',);
                    $fromRepArray = array($email, $chairman, $companyName, $passwordPlain, $link, SITE_TITLE);
                    $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                    $this->Email->layout = 'default';
                    $this->set('messageToSend', $messageToSend);
                    //echo $messageToSend;exit;
                    $this->Email->template = 'email_template';
                    $this->Email->sendAs = 'html';
                    $this->Email->send();

                    $this->Session->setFlash('Your account has been successfully created. Please check your email for activation link. if you do not get it in few minutes please check your spam folder.', 'success_msg');
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
            }
        }

        $termsConditions = $this->Page->findBySlug('terms-and-condition');
        $this->set('termsConditions', $termsConditions);
        $privacyPolicy = $this->Page->findBySlug('privacy-policy');
        $this->set('privacyPolicy', $privacyPolicy);
        $this->set('cityList', $cityList);
        $this->set('subIndustryList', $subIndustryList);
    }

    public function checkCompanyName($cname = null) {
        $this->layout = '';
        $avl = 1;
        if ($cname) {
            $isCompanyExist = $this->User->find('first', array('conditions' => array('User.company_name' => $cname)));
            if ($isCompanyExist) {
                $avl = 0;
            }
        }
        echo $avl;
        exit;
    }

    public function checkEmail($cname = null) {
        $this->layout = '';
        $avl = 1;
        if ($cname) {
            $isCompanyExist = $this->User->find('first', array('conditions' => array('User.email_address' => $cname)));
            if ($isCompanyExist) {
                $avl = 0;
            }
        }
        echo $avl;
        exit;
    }

    public function checkUnique($cname = null) {
        $this->layout = '';
        $avl = 1;
        if ($cname) {
            $isCompanyExist = $this->User->find('first', array('conditions' => array('User.unique_id' => $cname)));
            if ($isCompanyExist) {
                $avl = 0;
            }
        }
        echo $avl;
        exit;
    }

    public function login() {

        $this->set("title_for_layout", TITLE_FOR_PAGES . "Login");
        $this->layout = "home";
        $this->set('loginAct', 1);
        $msgString = '';
        $this->userLoggedinCheck();

        if (isset($this->data) && !empty($this->data)) {

            if (empty($this->data['User']['email_address'])) {
                $msgString .= "- Email address is required field. <br>";
            }

            if (empty($this->data['User']['password'])) {
                $msgString .= "- Password is required field. <br>";
            }

            if (isset($msgString) && $msgString != '') {
                echo $msgString;
                exit;
            } else {

                $email_address = $this->data['User']['email_address'];
                $password = $this->data['User']['password'];
                $userCheck = $this->User->find("first", array("conditions" => array("User.email_address" => $email_address)));
                if (is_array($userCheck) && !empty($userCheck) && crypt($password, $userCheck['User']['password']) == $userCheck['User']['password']) {


                    if ($userCheck['User']['status'] == 1 && $userCheck['User']['activation_status'] == 1) {

                        if (isset($this->data['User']['rememberme']) && $this->data['User']['rememberme'] == '1') {
                            setcookie("cookname", $this->data['User']['email_address'], time() + 60 * 60 * 24 * 100, "/");
                            setcookie("cookpass", $this->data['User']['password'], time() + 60 * 60 * 24 * 100, "/");
                        } else {
                            setcookie("cookname", '', time() + 60 * 60 * 24 * 100, "/");
                            setcookie("cookpass", '', time() + 60 * 60 * 24 * 100, "/");
                        }

                        $this->Session->write("user_id", $userCheck['User']['id']);
                        $this->Session->write("email_address", $userCheck['User']['email_address']);
                        $this->Session->write("user_name", $userCheck['User']['chairman']);
                        $this->Session->write("company_name", $userCheck['User']['company_name']);

                        $t = time();
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $this->User->updateAll(array('User.last_login' => "'$t'", 'User.ip' => "'$ip'"), array("User.id" => $userCheck['User']['id']));
                        echo '1';
                        exit;
                    } else {
                        if ($userCheck['User']['activation_status'] == 0) {
                            $msgString .= 'Your account is not activated. Please check your email and activate your account first.';
                        } else {
                            $msgString .= 'Your account temporary disabled by admin, please contact to site administrator for more details via contact us.';
                        }
                        echo $msgString;
                        exit;
                    }
                } else {
                    $this->Session->delete('user_id');
                    echo $msgString = "You entered wrong email address or password.";
                    exit;
                }
            }
        } else {
            if (isset($_COOKIE["cookname"]) && isset($_COOKIE["cookpass"])) {
                $this->request->data['User']['email_address'] = $_COOKIE["cookname"];
                $this->request->data['User']['password'] = $_COOKIE["cookpass"];
                $this->request->data['User']['rememberme'] = 1;
            }
        }
    }

    public function forgotPassword() {
        $this->layout = "";
        $this->set("title_for_layout", TITLE_FOR_PAGES . "Login");
        $msgString = '';

        if (isset($this->data) && !empty($this->data)) {
            if (empty($this->data['User']['email_address'])) {
                $msgString .= "Please enter your email address.<br>";
            } elseif ($this->User->checkEmail($this->data["User"]["email_address"]) == false) {
                $msgString .= "Please enter valid email address.<br>";
            }
            if ($msgString == '') {
                $email = $this->data["User"]["email_address"];
                $userCheck = $this->User->find("first", array("conditions" => array("User.email_address" => $email)));
                if (is_array($userCheck) && !empty($userCheck)) {
                    $this->User->updateAll(array('User.forget_password_status' => 1), array('User.id' => $userCheck['User']['id']));
                    $email = $userCheck["User"]["email_address"];
                    $chairman = $userCheck["User"]["chairman"];
                    $link = HTTP_PATH . "/users/resetPassword/" . $userCheck['User']['id'] . "/" . md5($userCheck['User']['id']) . "/" . urlencode($email);
                    $this->Email->to = $email;
                    $emailtemplateMessage = $this->Emailtemplate->findById(3);
                    $this->Email->subject = $emailtemplateMessage['Emailtemplate']['subject'];
                    $this->Email->replyTo = SITE_TITLE . "<" . MAIL_FROM . ">";
                    $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";
                    $toRepArray = array('[!email!]', '[!username!]', '[!LINK!]', '[!SITE_TITLE!]');
                    $fromRepArray = array($email, $chairman, $link, SITE_TITLE);
                    $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                    $this->Email->layout = 'default';
                    $this->set('messageToSend', $messageToSend);
                    $this->Email->template = 'email_template';
                    $this->Email->sendAs = 'html';
                    $this->Email->send();
                    echo '1';
                    exit;
                } else {
                    echo 'Email address you have entered is not found in our database. Please correct email address.';
                    exit;
                }
            } else {
                echo $msgString;
                exit;
            }
        }
    }

    public function logout() {
        session_destroy();
        $this->Session->setFlash("Logout successfully.", 'success_msg');
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }

    public function resetPassword($id = null, $md5id = null, $email = null) {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "Reset Password");
        $this->layout = "home";
        $msgString = '';
        $this->userLoggedinCheck();

        $this->set("userId", $id);

        if (md5($id) == $md5id) {
            $userCheck = $this->User->find('first', array('conditions' => array('User.email_address' => urldecode($email), 'User.id' => $id), 'fields' => array('User.forget_password_status', 'User.password')));
            if ($userCheck['User']['forget_password_status'] == 1) {
                $this->set('userId', $id);
                if (isset($this->data) && !empty($this->data)) {
                    if (trim($this->data["User"]["password"]) == '') {
                        $msgString .="- New Password is required field.<br>";
                    } elseif (strlen($this->data["User"]["password"]) < 8) {
                        $msgString .="- New Password must be at least 6 characters.<br>";
                    }

                    $password = $this->data["User"]["password"];
                    $conformpassword = $this->data["User"]["confirm_password"];

                    if ($password != $conformpassword) {
                        $msgString.= "- New password and confirm password mismatch.<br>";
                    } elseif (crypt($this->data['User']['password'], $userCheck['User']['password']) == $userCheck['User']['password']) {// Checking the both password matched aur not
                        $msgString .="- You cannot put your old password for the new password!<br>";
                    } else {
                        $passwordPlain = $this->data["User"]["password"];
                        $salt = uniqid(mt_rand(), true);
                        $new_password = crypt($passwordPlain, '$2a$07$' . $salt . '$');
                        $this->request->data['User']['password'] = $new_password;
                    }

                    if (isset($msgString) && $msgString != '') {
                        $this->Session->setFlash($msgString, 'error_msg');
                    } else {
                        $this->request->data['User']['forget_password_status'] = 0;
                        $this->User->save($this->data);
                        $this->Session->setFlash('Password is reset successfully. Please Login !', 'success_msg');
                        $this->redirect(array('controller' => 'users', 'action' => 'login'));
                    }
                }
            } else {
                $this->Session->setFlash('You have already use this link!', 'error_msg');
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }
        } else {
            $this->redirect('/');
        }
    }

    public function confirmation($id = null, $md5id = null, $email = null) {
        if (md5($id) == $md5id) {
            $userCheck = $this->User->find('first', array('conditions' => array('User.email_address' => $email, 'User.id' => $id)));
            if ($userCheck['User']['status'] == 0 && $userCheck['User']['activation_status'] == 0 && !empty($userCheck)) {
                $cnd = array("User.id" => $id);
                $this->User->updateAll(array('User.status' => "'1'", 'User.activation_status' => "'1'"), $cnd);
                $this->Session->setFlash('Thanks for verifying your account.', 'success_msg');
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            } else {
                $this->Session->setFlash('Thanks for verifying your account.', 'success_msg');
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }
        }
    }

    public function dashboard() {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "Dashboard");
        $this->layout = "client";
        $this->set('dashboardAct', 0);
        $this->userLoginCheck();

        $userid = $this->Session->read("user_id");
        $userInfo = $this->User->findById($userid);
        $this->set('userInfo', $userInfo);

        /*          Start For Creating Follower Chart  */
        $dayCount = 31;
        $today = date('Y-m-d') . ' 23:59:00';
        $lastday = date('Y-m-d', strtotime("-30 day", strtotime(date('Y-m-d')))) . ' 00:00:00';

        $catArray = array();
        $CTempArray = array();

        $countUserArray = $this->Follow->find('all', array('conditions' => array('Follow.following_id' => $this->Session->read('user_id'), 'Follow.created <=' => $today, 'Follow.created >=' => $lastday), 'fields' => array('Follow.*', 'Follower.*', 'COUNT(*) as count'), 'order' => array('Follow.created ASC'), 'group' => array('DAY(Follow.created)')));
        $CTempArray = array();
        foreach ($countUserArray as $countArr) {
            $CTempArray[date("Y-m-d", strtotime($countArr['Follow']['created']))] = $countArr['0']['count'];
        }

        $finalArray = array();
        $finalArrayValues = array();
        $strtotime = strtotime($lastday);
        for ($i = 0; $i < $dayCount; $i++) {
            $value = 0;
            $date = date('Y-m-d', $strtotime);
            if (array_key_exists($date, $CTempArray)) {
                $value = $CTempArray[$date];
            }
            $datea = date('Y, m-1, d', $strtotime);
            $finalArray[] = "Date.UTC($datea), " . $value;
            $finalArrayValues[] = (int) $value;
            $strtotime = $strtotime + 24 * 3600;
        }

        $jsonFinalArray = json_encode($finalArrayValues);

        $this->set('jsonFinalArray', $jsonFinalArray);
        $this->set('countUserArray', $countUserArray);
        /*   End For Creating Follower Chart  */



        /* Start for Watch Profile Graph and Details */
        $watchCompanyDetail = $this->Watch->find('all', array('conditions' => array('Watch.to_watch_id' => $this->Session->read('user_id')), 'fields' => array('Industry.id', 'Industry.name', 'COUNT(*) as count'), 'order' => array('Watch.modified ASC'), 'limit' => 5, 'group' => array('Industry.name')));
        $watchCompArray = array();
        $newWatchArray = array();
        $pieDataColor = array('#90d44c', '#5fb4f1', '#f46554', '#eef455', '#c49ef4');
        $pieDataHighlight = array('#7fbd41', '#51a3dd', '#dd594a', '#d8de4a', '#ac88db');
        $k = 0;

        foreach ($watchCompanyDetail as $watchCompanyDet) {
            $watchCompArray[$watchCompanyDet['Industry']['name']] = $watchCompanyDet['0']['count'];
        }

        if (!empty($watchCompArray)) {
            arsort($watchCompArray);
            $finalWatchArray = array_slice($watchCompArray, 0, 5);
            $convertPerValue = number_format((float) (100 / array_sum($finalWatchArray)), 2, '.', '');

            foreach ($finalWatchArray as $key => $val) {
                $newWatchArray[$k]['value'] = $val * $convertPerValue;
                $newWatchArray[$k]['color'] = $pieDataColor[$k];
                $newWatchArray[$k]['highlight'] = $pieDataHighlight[$k];
                $newWatchArray[$k]['label'] = $key;
                ++$k;
            }
        } else {
            $newWatchArray[$k]['value'] = 100;
            $newWatchArray[$k]['color'] = $pieDataColor[$k];
            $newWatchArray[$k]['highlight'] = $pieDataHighlight[$k];
            $newWatchArray[$k]['label'] = 'No Watch';
        }

        $this->set('jsonFinalWatchArray', json_encode($newWatchArray));


        $watchCompanyList = $this->Watch->find('all', array('conditions' => array('Watch.to_watch_id' => $this->Session->read('user_id'), 'Watch.modified <=' => $today, 'Watch.modified >=' => $lastday), 'fields' => array('FromWatch.company_logo', 'FromWatch.company_name', 'FromWatch.unique_id', 'Industry.name', 'Watch.modified'), 'order' => array('Watch.modified ASC'), 'limit' => 5));
        $this->set('watchCompanyList', $watchCompanyList);
        //pr($watchCompanyList); exit;
        /* End for Watch Profile Graph and Details */


        $countProducts = $this->Product->find('count', array('conditions' => array('Product.user_id' => $userid)));
        $countServices = $this->Service->find('count', array('conditions' => array('Service.user_id' => $userid)));
        $countTrade = $this->Timeline->find('count', array('conditions' => array('Timeline.user_id' => $userid, 'Timeline.post_type' => '0')));
        $countNews = $this->Timeline->find('count', array('conditions' => array('Timeline.user_id' => $userid, 'Timeline.post_type' => '1')));
        $countLead = $this->Timeline->find('count', array('conditions' => array('Timeline.user_id' => $userid, 'Timeline.post_type' => '2')));

        if ($countProducts == 0 && $countServices == 0) {
            $addProduct = 0;
        } else {
            $addProduct = 10;
        }

        $postTrading = $countTrade > 0 ? 10 : 0;
        $postNews = $countNews > 0 ? 10 : 0;
        $postLead = $countLead > 0 ? 10 : 0;
        
        $this->set('addProduct', $addProduct);
        $this->set('postTrading', $postTrading);
        $this->set('postNews', $postNews);
        $this->set('postLead', $postLead);
    }

    public function profile($slug = null) {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "Profile");
        $this->set('profileAct', 1);
        $this->set('profilHeaderAct', 1);

        if ($slug == "") {
            $this->userLoginCheck();
            $this->layout = "client";
            $userid = $this->Session->read("user_id");
            $userInfo = $this->User->findById($userid);
        } else {
            if ($this->Session->read("user_id") > 0) {
                $this->layout = "client";
                $userInfo = $this->User->findBySlug($slug);
                if (empty($userInfo)) {
                    $this->redirect(array('controller' => 'users', 'action' => 'profile'));
                }
            } else {
                $this->layout = "home";
                $userInfo = $this->User->findBySlug($slug);
                if (empty($userInfo)) {
                    $this->Session->setFlash('Wrong URL Access, Please Login.', 'error_msg');
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
            }
        }


        $condition = array();
        $separator = array();
        $urlSeparator = array();
        $condition = array('Timeline.user_id' => $userInfo['User']['id'], 'Timeline.post_type' => 1);

        $this->set('slug', $slug);
        $this->set('userInfo', $userInfo);

        $this->paginate['Timeline'] = array(
            'conditions' => $condition,
            'order' => array('Timeline.id' => 'DESC'),
            'limit' => '20'
        );

//        pr($condition);
//        pr($this->paginate('Timeline', $condition)); exit;
        $this->set('timelines', $this->paginate('Timeline', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'timelines/';
            $this->render('index');
        }
    }

    public function aboutUs($slug = null) {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "About Us");
        $this->set('profileAct', 1);
        $this->set('aboutusHeaderAct', 1);


        if ($slug == "") {
            $this->userLoginCheck();
            $this->layout = "client";
            $userid = $this->Session->read("user_id");
            $userInfo = $this->User->findById($userid);
        } else {
            if ($this->Session->read("user_id") > 0) {
                $this->layout = "client";
                $userInfo = $this->User->findBySlug($slug);
                if (empty($userInfo)) {
                    $this->redirect(array('controller' => 'users', 'action' => 'profile'));
                }
            } else {
                $this->layout = "home";
                $userInfo = $this->User->findBySlug($slug);
                if (empty($userInfo)) {
                    $this->Session->setFlash('Wrong URL Access, Please Login.', 'error_msg');
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
            }
        }

        $this->set('slug', $slug);
        $this->set('userInfo', $userInfo);
    }

    public function contactUs($slug = null) {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "Contact Us");
        $this->set('profileAct', 1);
        $this->set('contactHeaderAct', 1);


        if ($slug == "") {
            $this->userLoginCheck();
            $this->layout = "client";
            $userid = $this->Session->read("user_id");
            $userInfo = $this->User->findById($userid);
        } else {
            if ($this->Session->read("user_id") > 0) {
                $this->layout = "client";
                $userInfo = $this->User->findBySlug($slug);
                if (empty($userInfo)) {
                    $this->redirect(array('controller' => 'users', 'action' => 'profile'));
                }
            } else {
                $this->layout = "home";
                $userInfo = $this->User->findBySlug($slug);
                if (empty($userInfo)) {
                    $this->Session->setFlash('Wrong URL Access, Please Login.', 'error_msg');
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
            }
        }


        if ($this->data) {
            if (empty($this->data["User"]["name"])) {
                $msgString .="- Name is required field.<br>";
            }
            if (empty($this->data["User"]["subject"])) {
                $msgString .="- Subject is required field.<br>";
            }
            if (empty($this->data["User"]["email"])) {
                $msgString .="- Email Address is required field.<br>";
            } elseif ($this->User->checkEmail($this->data["User"]["email"]) == false) {
                $msgString .="- Email Address is not valid.<br>";
            }

            $this->request->data["User"]["message"] = trim($this->data["User"]["message"]);
            if (empty($this->data["User"]["message"])) {
                $msgString .="- Message is required field.<br>";
            }

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {

                $username = $this->data["User"]["name"];
                $email = $this->data["User"]["email"];
                $message = $this->data["User"]["message"];
                $sbj = $this->data["User"]["subject"];
                $chairman = $userInfo['User']['chairman'];
                $this->Email->to = $userInfo['User']['email_address'];
                $emailtemplateMessage = $this->Emailtemplate->find("first", array("conditions" => "Emailtemplate.id='6'"));

                $currentYear = date('Y', time());
                $sitelink = '<a style="color:#000; text-decoration: underline;" href="mailto:' . MAIL_FROM . '">' . MAIL_FROM . '</a>';
                $toRepArray = array('[!chairman!]', '[!username!]', '[!email!]', '[!message!]', '[!sbj!]', '[!DATE!]', '[!HTTP_PATH!]', '[!SITE_TITLE!]', '[!SITE_LINK!]', '[!SITE_URL!]');
                $fromRepArray = array($chairman, $username, $email, $message, $sbj, $currentYear, HTTP_PATH, SITE_TITLE, $sitelink, SITE_URL);

                $subject = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['subject']);

                $this->Email->subject = $subject;
                $this->Email->replyTo = SITE_TITLE . "<" . MAIL_FROM . ">";
                $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";

                $toRepArray = array('[!chairman!]', '[!username!]', '[!email!]', '[!message!]', '[!sbj!]', '[!DATE!]', '[!HTTP_PATH!]', '[!SITE_TITLE!]', '[!SITE_LINK!]', '[!SITE_URL!]');
                $fromRepArray = array($chairman, $username, $email, $message, $sbj, $currentYear, HTTP_PATH, SITE_TITLE, $sitelink, SITE_URL);
                $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                $this->Email->layout = 'default';
                $this->set('messageToSend', $messageToSend);
                $this->Email->template = 'email_template';
                $this->Email->sendAs = 'html';
                $this->Email->send();

                $this->Email->to = $email;
                //$this->Email->cc =$this->Admin->field('cc_email', array('Admin.id' => 1));
                $emailtemplateMessage = $this->Emailtemplate->find("first", array("conditions" => "Emailtemplate.id='7'"));
                $currentYear = date('Y', time());
                $sitelink = '<a style="color:#000; text-decoration: underline;" href="mailto:' . MAIL_FROM . '">' . MAIL_FROM . '</a>';
                $toRepArray = array('[!username!]', '[!email!]', '[!message!]', '[!sbj!]', '[!DATE!]', '[!HTTP_PATH!]', '[!SITE_TITLE!]', '[!SITE_LINK!]', '[!SITE_URL!]');
                $fromRepArray = array($username, $email, $message, $sbj, $currentYear, HTTP_PATH, SITE_TITLE, $sitelink, SITE_URL);

                $subject = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['subject']);

                $this->Email->subject = $subject;
                $this->Email->replyTo = SITE_TITLE . "<" . MAIL_FROM . ">";
                $this->Email->from = SITE_TITLE . "<" . MAIL_FROM . ">";

                $toRepArray = array('[!username!]', '[!email!]', '[!message!]', '[!sbj!]', '[!DATE!]', '[!HTTP_PATH!]', '[!SITE_TITLE!]', '[!SITE_LINK!]', '[!SITE_URL!]');
                $fromRepArray = array($username, $email, $message, $sbj, $currentYear, HTTP_PATH, SITE_TITLE, $sitelink, SITE_URL);
                $messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
                $this->Email->layout = 'default';
                $this->set('messageToSend', $messageToSend);
                $this->Email->template = 'email_template';
                $this->Email->sendAs = 'html';
                $this->Email->send();

                $this->Session->setFlash('Your enquiry has been successfully sent to ' . $userInfo['User']['company_name'] . '!', 'success_msg');
                $this->redirect(array('controller' => 'users', 'action' => 'contactUs', $slug));
            }
        }

        $this->set('slug', $slug);
        $this->set('userInfo', $userInfo);

        $LoggedInUserId = $this->Session->read("user_id");
        if ($LoggedInUserId) {
            $LoggedInUserInfo = $this->User->findById($LoggedInUserId);
            $this->request->data['User']['name'] = $LoggedInUserInfo['User']['chairman'];
            $this->request->data['User']['email'] = $LoggedInUserInfo['User']['email_address'];
        }
    }

    public function searchCompanies() {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "Search Companies");
        $this->layout = "client";
        $this->set('searchCompaniesAct', 1);
        $this->userLoginCheck();

        $industryList = $this->Industry->getList();
        $this->set('industryList', $industryList);

        $condition = array();
        $separator = array();
        $urlSeparator = array();

        $condition = array('User.status' => '1', 'User.id !=' => $this->Session->read('user_id'));

        if (!empty($this->data)) {
            if (isset($this->data['User']['keyword']) && $this->data['User']['keyword'] != '') {
                $keyword = trim($this->data['User']['keyword']);
            }
            if (isset($this->data['User']['location']) && $this->data['User']['location'] != '') {
                $location = trim($this->data['User']['location']);
            }
            if (isset($this->data['User']['industry']) && $this->data['User']['industry'] != '') {
                $industry = trim($this->data['User']['industry']);
            }
        } elseif (!empty($this->params)) {
            if (isset($this->params['named']['keyword']) && $this->params['named']['keyword'] != '') {
                $keyword = urldecode(trim($this->params['named']['keyword']));
            }
            if (isset($this->params['named']['location']) && $this->params['named']['location'] != '') {
                $location = urldecode(trim($this->params['named']['location']));
            }
            if (isset($this->params['named']['industry']) && $this->params['named']['industry'] != '') {
                $industry = urldecode(trim($this->params['named']['industry']));
            }
        }

        if (isset($keyword) && $keyword != '') {
            $separator[] = 'keyword:' . urlencode($keyword);
            $condition[] = " (`User`.`company_name` LIKE '%" . addslashes($keyword) . "%'  or `User`.`chairman` LIKE '%" . addslashes($keyword) . "%' or `User`.`email_address` LIKE '%" . addslashes($keyword) . "%' ) ";
            $this->set('keyword', $keyword);
        }
        if (isset($location) && $location != '') {
            $separator[] = 'location:' . urlencode($location);
            $condition[] = " (`User`.`zipcode` LIKE '%" . addslashes($location) . "%'  or `City`.`city_name` LIKE '%" . addslashes($location) . "%' or `State`.`state_name` LIKE '%" . addslashes($location) . "%' or `Country`.`name` LIKE '%" . addslashes($location) . "%' ) ";
            $this->set('location', $location);
        }
        if (isset($industry) && $industry != '') {
            $separator[] = 'industry:' . urlencode($industry);
            $condition[] = " (`User`.`industry_id` LIKE '" . addslashes($industry) . "') ";
            $this->set('industry', $industry);
        }

        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);

        $this->paginate['User'] = array(
            'conditions' => $condition,
            'order' => array('User.company_name' => 'ASC'),
            'limit' => '30'
        );

        //pr($this->paginate('User'));exit;
        $this->set('users', $this->paginate('User', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'users/';
            $this->render('companies');
        }
    }

    public function setting() {
        $this->set("title_for_layout", TITLE_FOR_PAGES . "Settings");
        $this->layout = "client";
        $this->set('settingAct', 1);
        $this->userLoginCheck();

        $industryList = $this->Industry->getList();
        $this->set('industryList', $industryList);
        $stateList = $this->State->getList();
        $this->set('stateList', $stateList);

        if (isset($this->data) && !empty($this->data)) {
            //pr($this->data);exit;
            if (isset($this->data['editinfo']) && !empty($this->data['editinfo'])) {
                if (empty($this->data["User"]["industry_id"])) {
                    $msgString .="- Industry is required field.<br>";
                }
                if (empty($this->data["User"]["subindustry_id"])) {
                    $msgString .="- Sub industry category is required field.<br>";
                }
                if (empty($this->data["User"]["est_year"])) {
                    $msgString .="- Year Establishment is required field.<br>";
                }
                if (empty($this->data["User"]["employers"])) {
                    $msgString .="- Employers is required field.<br>";
                }
                if (empty($this->data["User"]["ein"])) {
                    $msgString .="- Employer Identification Number is required field.<br>";
                }

                if ($this->data["User"]["certificates"]["name"]) {
                    $getextention = $this->PImage->getExtension($this->data['User']['certificates']['name']);
                    $extention = strtolower($getextention);
                    global $certificatesextentions;
                    if (!in_array($extention, $certificatesextentions)) {
                        $msgString .="- Not valid extention for certificates.<br>";
                    } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                        $msgString .="- Max file size upload is 2MB for certificates.<br>";
                    }
                }
                if (empty($this->data["User"]["certificate_number"])) {
                    $msgString .="- Certificate Number is required field.<br>";
                }
                if (empty($this->data["User"]["chairman"])) {
                    $msgString .="- Chairman is required field.<br>";
                }
                if ($this->data["User"]["company_logo"]["name"]) {
                    $getextention = $this->PImage->getExtension($this->data['User']['company_logo']['name']);
                    $extention = strtolower($getextention);
                    global $imageextentions;
                    if (!in_array($extention, $imageextentions)) {
                        $msgString .="- Not valid extention for company logo.<br>";
                    } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                        $msgString .="- Max file size upload is 2MB for company logo.<br>";
                    }
                }
                if ($this->data["User"]["background_img"]["name"]) {
                    $getextention = $this->PImage->getExtension($this->data['User']['background_img']['name']);
                    $extention = strtolower($getextention);
                    global $imageextentions;
                    if (!in_array($extention, $imageextentions)) {
                        $msgString .="- Not valid extention for background img.<br>";
                    } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                        $msgString .="- Max file size upload is 2MB for background imgo.<br>";
                    }
                }

                if (isset($msgString) && $msgString != '') {
                    $this->Session->setFlash($msgString, 'error_msg');
                    $subIndustryList = $this->Industry->getSubIndustryList($this->data['User']['industry_id']);
                } else {
                    $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                    $toReplace = "-";

                    if ($this->data["User"]["certificates"]["name"]) {
                        $this->request->data['User']['certificates']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['certificates']['name']);
                        $imageArray = $this->data['User']['certificates'];
                        $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_CRTIFICATE_PATH);
                        $this->request->data['User']['certificates'] = $returnedUploadImageArray[0];
                    } else {
                        $this->request->data['User']['certificates'] = $this->data['User']['old_certificates'];
                    }

                    if (!empty($this->data["User"]["company_logo"]["name"])) {
                        $this->request->data['User']['company_logo']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['company_logo']['name']);
                        $imageArray = $this->data['User']['company_logo'];
                        $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_LOGO_PATH);
                        $this->request->data['User']['company_logo'] = $returnedUploadImageArray[0];
                        if (!empty($this->data['User']['old_company_logo'])) {
                            @unlink(UPLOAD_LOGO_PATH . $this->data['User']['old_company_logo']);
                        }
                    } else {
                        $this->request->data['User']['company_logo'] = $this->data['User']['old_company_logo'];
                    }


                    if (!empty($this->data["User"]["background_img"]["name"])) {
                        $this->request->data['User']['background_img']['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']['background_img']['name']);
                        $imageArray = $this->data['User']['background_img'];
                        $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_BACKGROUND_PATH);
                        $this->request->data['User']['background_img'] = $returnedUploadImageArray[0];
                    } else {
                        $this->request->data['User']['background_img'] = $this->data['User']['old_background_img'];
                    }
                    //pr($this->data);exit;
                    if ($this->User->save($this->data)) {
                        $this->Session->setFlash('Company Details Updated Successfully.', 'success_msg');
                        $this->redirect(array('controller' => 'users', 'action' => 'setting'));
                    }
                }
            } else if (isset($this->data['editAddress']) && !empty($this->data['editAddress'])) {
                if (empty($this->data["User"]["state_id"])) {
                    $msgString .="- State is required field.<br>";
                }
                if (empty($this->data["User"]["city_id"])) {
                    $msgString .="- City is required field.<br>";
                }
                if (empty($this->data["User"]["street"])) {
                    $msgString .="- Street is required field.<br>";
                }
                if (empty($this->data["User"]["building_number"])) {
                    $msgString .="- Building Number is required field.<br>";
                }
                if (empty($this->data["User"]["zipcode"])) {
                    $msgString .="- Zipcode is required field.<br>";
                }

                if (isset($msgString) && $msgString != '') {
                    $this->Session->setFlash($msgString, 'error_msg');
                    $this->set('cityList', $this->City->getList($this->data['User']['state_id']));
                } else {
                    if ($this->User->save($this->data)) {
                        $this->Session->setFlash('Company Address & Social Info Updated Successfully.', 'success_msg');
                        $this->redirect(array('controller' => 'users', 'action' => 'setting'));
                    }
                }
            } else if (isset($this->data['changePassword']) && !empty($this->data['changePassword'])) {
                if (empty($this->data["User"]["old_password"])) {
                    $msgString .="- Old Password is required field.<br>";
                }
                if (empty($this->data["User"]["new_password"])) {
                    $msgString .="- New Password is required field.<br>";
                } elseif (strlen($this->data["User"]["new_password"]) < 8) {
                    $msgString .="- Password must be at least 8 characters.<br>";
                }

                if (empty($this->data["User"]["conf_password"])) {
                    $msgString .="- Confirm Password is required field.<br>";
                } else {
                    if (crypt($this->data['User']['old_password'], $this->data["User"]["oldPassword"]) != $this->data["User"]["oldPassword"]) {// Matching the old password
                        $msgString .="- Old Password is not correct.<br>";
                    } else {
                        if (crypt($this->data['User']['new_password'], $this->data["User"]["oldPassword"]) == $this->data["User"]["oldPassword"]) {// Checking the both password matched aur not
                            $msgString .="- You cannot put your old password for the new password!<br>";
                        }
                    }
                }
                if ($this->data['User']['new_password'] != $this->data['User']['conf_password']) {// Checking the both password matched aur not
                    $msgString .="- New Password and Confirm Password mismatch.<br>";
                }
                if (isset($msgString) && $msgString != '') {
                    $this->Session->setFlash($msgString, 'error_msg');
                } else {
                    $this->request->data['User']['id'] = $this->data["User"]['id'];
                    $passwordPlain = $this->data["User"]["conf_password"];
                    $salt = uniqid(mt_rand(), true);
                    $new_password = crypt($passwordPlain, '$2a$07$' . $salt . '$');
                    $this->request->data['User']['password'] = $new_password;

                    if ($this->User->save($this->data)) {
                        $this->Session->setFlash('Password Changed Successfully.', 'success_msg');
                        $this->redirect(array('controller' => 'users', 'action' => 'setting'));
                    }
                }
            } else if (isset($this->data['editAboutUs']) && !empty($this->data['editAboutUs'])) {
                if (empty($this->data["User"]["about_us"])) {
                    $msgString .="- About Us is required field.<br>";
                }
                if (isset($msgString) && $msgString != '') {
                    $this->Session->setFlash($msgString, 'error_msg');
                } else {
                    if ($this->User->save($this->data)) {
                        $this->Session->setFlash('Company About Us Details Updated Successfully.', 'success_msg');
                        $this->redirect(array('controller' => 'users', 'action' => 'setting'));
                    }
                }
            } else if (isset($this->data['editSliderImage']) && !empty($this->data['editSliderImage'])) {
                //pr($this->data); exit;
                $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                $toReplace = "-";


                $oldSliderImgs = explode(',', $this->data['User']['old_slider_img']);
                $i = $this->data["counter"];
                $j = 0;
                $slider = array();
                while ($j < $i) {
                    ++$j;
                    if ($this->data["User"]["slider" . $j]["name"]) {
                        $this->request->data['User']['slider' . $j]['name'] = str_replace($specialCharacters, $toReplace, $this->data['User']["slider" . $j]['name']);
                        $imageArray = $this->data['User']['slider' . $j];
                        $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_SLIDER_PATH);
                        $slider[] = $returnedUploadImageArray[0];
                    }
                }

                if ($this->data['User']['old_slider_img'] == "") {
                    $finalSliderImgs = $slider;
                } else {
                    $finalSliderImgs = array_merge($oldSliderImgs, $slider);
                }

                if (sizeof($oldSliderImgs) == 5) {
                    $this->Session->setFlash('You already uploaded maximum images for slider', 'error_msg');
                    $this->redirect(array('controller' => 'users', 'action' => 'setting'));
                } else if (empty($slider)) {
                    $this->Session->setFlash('Please Upload Atleast One Image before submitting', 'error_msg');
                    $this->redirect(array('controller' => 'users', 'action' => 'setting'));
                } else {
                    $finalSliderImplode = implode(',', $finalSliderImgs);
                    $this->User->updateAll(array('User.slider_img' => "'$finalSliderImplode'"), array("User.id" => $this->Session->read("user_id")));
                    $this->Session->setFlash('Slider Image Updated Successfully.', 'success_msg');
                    $this->redirect(array('controller' => 'users', 'action' => 'setting'));
                }
            }
        }

        $userid = $this->Session->read("user_id");
        $this->User->id = $userid;

        $this->data = $this->User->read();
        $this->request->data['User']['old_certificates'] = $this->data['User']['certificates'];
        $this->request->data['User']['old_slider_img'] = $this->data['User']['slider_img'];
        $this->request->data['User']['old_company_logo'] = $this->data['User']['company_logo'];
        $this->request->data['User']['old_background_img'] = $this->data['User']['background_img'];
        $this->request->data['User']['oldPassword'] = $this->data['User']['password'];
        $this->set('subIndustryList', $this->Industry->getSubIndustryList($this->data['User']['industry_id']));
        $this->set('cityList', $this->City->getList($this->data['User']['state_id']));
//        $userInfo = $this->User->findById($userid);
//        $this->set('userInfo', $userInfo);
    }

    public function deleteSliderImage($image = null) {
        $this->layout = '';
        $userId = $this->Session->read('user_id');
        $userInfo = $this->User->findById($userId);
        if ($userInfo) {
            $sliderImgs = explode(',', $userInfo['User']['slider_img']);
            if (in_array($image, $sliderImgs)) {
                @unlink(UPLOAD_SLIDER_PATH . $image);
                $pos = array_search($image, $sliderImgs);
                unset($sliderImgs[$pos]);
                $finalSliderImages = implode(',', $sliderImgs);
                $this->User->updateAll(array('User.slider_img' => "'$finalSliderImages'"), array("User.id" => $userId));
                $this->Session->setFlash('Slider Image Deleted Successfully.', 'success_msg');
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    function admin_download($model = null, $field = null, $md5Id = null, $id = null) {
        if ($md5Id == md5($id)) {
            $filename = $this->$model->field($field, array($model . '.id' => $id));
            if ($filename) {
                //echo $filename;exit;
                $file_path = UPLOAD_CRTIFICATE_PATH . $filename;
                $file_type = $this->getExtension($filename);
                $this->Common->output_file($file_path, $filename, $file_type);
            }
        }
        exit;
    }

    function download($model = null, $field = null, $md5Id = null, $id = null) {
        if ($md5Id == md5($id)) {
            $filename = $this->$model->field($field, array($model . '.id' => $id));
            if ($filename) {
                //echo $filename;exit;
                $file_path = UPLOAD_CRTIFICATE_PATH . $filename;
                $file_type = $this->getExtension($filename);
                $this->Common->output_file($file_path, $filename, $file_type);
            }
        }
        exit;
    }

    public function watchProfile($company_id) {

        $this->layout = '';

        if (isset($_COOKIE["cookname_broserId"]) && $_COOKIE["cookname_broserId"] != '') {
            $browser_session_id = $_COOKIE["cookname_broserId"];
        } else {
            $browser_session_id = session_id();
            setcookie("cookname_broserId", $browser_session_id, time() + 60 * 60 * 24 * 7, "/");
        }

        $ifExist = $this->Watch->field('id', array('Watch.to_watch_id' => $company_id, 'Watch.from_watch_id' => $this->Session->read('user_id'), 'Watch.browser_session_id' => $browser_session_id));
        if ($ifExist > 0) {
            $this->request->data['Watch']['id'] = $ifExist;
        }

        $this->request->data['Watch']['from_watch_id'] = $this->Session->read('user_id');
        $this->request->data['Watch']['to_watch_id'] = $company_id;
        $this->request->data['Watch']['browser_session_id'] = $browser_session_id;

        if ($this->Watch->save($this->data)) {
            
        }
        exit;
    }

}

?>
