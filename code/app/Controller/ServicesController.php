<?php

class ServicesController extends AppController {

    public $name = 'Services';
    public $uses = array('Admin', 'User', 'Service', 'ServiceImage', 'Category');
    public $helpers = array('Html', 'Form', 'Paginator', 'Javascript', 'Ajax', 'Js', 'Text', 'Number');
    public $paginate = array('limit' => '50', 'page' => '1', 'order' => array('Service.name' => 'asc'));
    public $components = array('RequestHandler', 'Email', 'Upload', 'PImageTest', 'PImage', 'Captcha');
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
        $this->layout = "admin";
        $this->set('serviceListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Manage Services');
        $condition = array();
        $separator = array();
        $urlSeparator = array();

        if (!empty($this->data)) {
            //print_r($this->data);
            if (isset($this->data['Service']['keyword']) && $this->data['Service']['keyword'] != '') {
                $keyword = trim($this->data['Service']['keyword']);
            }
            if (isset($this->data['Service']['searchByDateFrom']) && $this->data['Service']['searchByDateFrom'] != '') {
                $searchByDateFrom = trim($this->data['Service']['searchByDateFrom']);
            }
            if (isset($this->data['Service']['searchByDateTo']) && $this->data['Service']['searchByDateTo'] != '') {
                $searchByDateTo = trim($this->data['Service']['searchByDateTo']);
            }

            if (isset($this->data['Service']['action'])) {
                $idList = $this->data['Service']['idList'];
                if ($idList) {
                    if ($this->data['Service']['action'] == "activate") {
                        $cnd = array("Service.id IN ($idList) ");
                        $this->Service->updateAll(array('Service.status' => "'1'"), $cnd);
                    } elseif ($this->data['Service']['action'] == "deactivate") {
                        $cnd = array("Service.id IN ($idList) ");
                        $this->Service->updateAll(array('Service.status' => "'0'"), $cnd);
                    } elseif ($this->data['Service']['action'] == "delete") {
                        $cnd = array("Service.id IN ($idList) ");
                        $this->Service->deleteAll($cnd);

                        $idListArray = explode(',', $idList);
                        foreach ($idListArray as $id) {
                            $service_image_list = $this->ServiceImage->find('list', array('conditions' => array('ServiceImage.service_id' => $id), 'fields' => array('ServiceImage.id', 'ServiceImage.image')));
                            if (!empty($service_image_list)) {
                                foreach ($service_image_list as $key => $value) {
                                    @unlink(UPLOAD_FULL_SERVICE_IMAGE_PATH . $value);
                                    @unlink(UPLOAD_SMALL_SERVICE_IMAGE_PATH . $value);
                                    @unlink(UPLOAD_THUMB_SERVICE_IMAGE_PATH . $value);

                                    $this->ServiceImage->delete($key);
                                }
                            }
                        }
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
            $condition[] = " (Service.name like '%" . addslashes($keyword) . "%' or User.company_name like '%" . addslashes($keyword) . "%')  ";
            $this->set('keyword', $keyword);
        }
        if (isset($searchByDateFrom) && $searchByDateFrom != '') {
            $separator[] = 'searchByDateFrom:' . urlencode($searchByDateFrom);
            $searchByDateFrom = str_replace('_', '\_', $searchByDateFrom);
            $searchByDate_con1 = date('Y-m-d', strtotime($searchByDateFrom));
            $condition[] = " (Date(Service.created)>='$searchByDate_con1' ) ";
            $searchByDateFrom = str_replace('\_', '_', $searchByDateFrom);
        }

        if (isset($searchByDateTo) && $searchByDateTo != '') {
            $separator[] = 'searchByDateTo:' . urlencode($searchByDateTo);
            $searchByDateTo = str_replace('_', '\_', $searchByDateTo);
            $searchByDate_con2 = date('Y-m-d', strtotime($searchByDateTo));
            $condition[] = " (Date(Service.created)<='$searchByDate_con2' ) ";
            $searchByDateTo = str_replace('\_', '_', $searchByDateTo);
        }

        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);


        $this->paginate['Service'] = array(
            'conditions' => $condition,
            'order' => array('Service.id' => 'DESC'),
            'limit' => '50'
        );

        $this->set('services', $this->paginate('Service', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/services/';
            $this->render('index');
        }
    }

    public function admin_add() {
        $this->layout = "admin";
        $this->set('serviceAdd', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Add Service');

        $userList = $this->User->getList();
        $this->set('userList', $userList);
        $categoryList = $this->Category->getList(1);
        $this->set('categoryList', $categoryList);
        $subCategoryList = array();

        $msgString = '';
        if ($this->data) {
            //pr($this->data); exit;
            if (empty($this->data["Service"]["user_id"])) {
                $msgString .="- Company is required field.<br>";
            }
            $this->request->data["Service"]["name"] = trim($this->data["Service"]["name"]);
            if (empty($this->data["Service"]["name"])) {
                $msgString .="- Service Name is required field.<br>";
            }
            if (empty($this->data["Service"]["category_id"])) {
                $msgString .="- Category is required field.<br>";
            }
            if (empty($this->data["Service"]["subcategory_id"])) {
                $msgString .="- Sub Category is required field.<br>";
            }
            if ($this->data["Service"]["price"] == "") {
                $msgString .="- Price is required field.<br>";
            }
            if ($this->data["Service"]["delivery_cost"] == "") {
                $msgString .="- Delivery Cost is required field.<br>";
            }
//            if (strip_tags($this->data["Service"]["description"]) == "") {
//                $msgString .="- Description is required field.<br>";
//            }

            if (isset($msgString) && $msgString != '') {
                $subCategoryList = $this->Category->getSubCategoryList($this->data['Service']['category_id']);
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data['Service']['slug'] = $this->stringToSlugUnique($this->data["Service"]["name"], 'Service');
                $this->request->data['Service']['status'] = '1';
                
                if ($this->data["Service"]["unit_type"] == 0) {
                     $this->request->data['Service']['unit_value'] = '';
                     $this->request->data['Service']['unit_of_measure'] = '';
                }

                if ($this->Service->save($this->data)) {
                    $serviceId = $this->Service->id;

                    $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                    $toReplace = "-";
                    if (count($this->data["Service"]["images"]) > 0) {
                        foreach ($this->data["Service"]["images"] as $val) {
                            if ($val["name"]) {
                                $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                                $imageArray = $val;
                                $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_FULL_SERVICE_IMAGE_PATH);
                                $this->PImageTest->resize(UPLOAD_FULL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_SERVICE_IMAGE_WIDTH, UPLOAD_SMALL_SERVICE_IMAGE_HEIGHT, 100);
                                $this->PImageTest->resize(UPLOAD_FULL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_SERVICE_IMAGE_WIDTH, UPLOAD_THUMB_SERVICE_IMAGE_HEIGHT, 100);

                                $this->ServiceImage->create();
                                $this->request->data['ServiceImage']['service_id'] = $serviceId;
                                $this->request->data['ServiceImage']['image'] = $returnedUploadImageArray[0];
                                $this->request->data['ServiceImage']['status'] = 1;
                                $this->request->data['ServiceImage']['slug'] = date('Ymdhis') . $serviceId . mt_rand(100, 1000);
                                $this->ServiceImage->save($this->data['ServiceImage']);
                            }
                        }
                    }
                    $this->Session->setFlash('Service Added Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'services', 'action' => 'index'));
                }
            }
        }
        $this->set('subCategoryList', $subCategoryList);
    }

    public function admin_edit($slug = null) {
        $this->layout = "admin";
        $this->set('serviceListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Edit Service');
        $userList = $this->User->getList();
        $this->set('userList', $userList);
        $categoryList = $this->Category->getList(1);
        $this->set('categoryList', $categoryList);
        $subCategoryList = array();
        $msgString = '';
        if ($this->data) {
            //pr($this->data); exit;
            if (empty($this->data["Service"]["user_id"])) {
                $msgString .="- Company is required field.<br>";
            }
            $this->request->data["Service"]["name"] = trim($this->data["Service"]["name"]);
            if (empty($this->data["Service"]["name"])) {
                $msgString .="- Service Name is required field.<br>";
            }
            if (empty($this->data["Service"]["category_id"])) {
                $msgString .="- Category is required field.<br>";
            }
            if (empty($this->data["Service"]["subcategory_id"])) {
                $msgString .="- Sub Category is required field.<br>";
            }
            if ($this->data["Service"]["price"] == "") {
                $msgString .="- Price is required field.<br>";
            }
            if ($this->data["Service"]["delivery_cost"] == "") {
                $msgString .="- Delivery Cost is required field.<br>";
            }
//            if (strip_tags($this->data["Service"]["description"]) == "") {
//                $msgString .="- Description is required field.<br>";
//            }

            if (isset($msgString) && $msgString != '') {
                $subCategoryList = $this->Category->getSubCategoryList($this->data['Service']['category_id']);
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $serviceId = $this->data["Service"]["id"];

                $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                $toReplace = "-";
                if (count($this->data["Service"]["images"]) > 0) {
                    foreach ($this->data["Service"]["images"] as $val) {
                        if ($val["name"]) {
                            $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                            $imageArray = $val;
                            $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_FULL_SERVICE_IMAGE_PATH);
                            $this->PImageTest->resize(UPLOAD_FULL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_SERVICE_IMAGE_WIDTH, UPLOAD_SMALL_SERVICE_IMAGE_HEIGHT, 100);
                            $this->PImageTest->resize(UPLOAD_FULL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_SERVICE_IMAGE_WIDTH, UPLOAD_THUMB_SERVICE_IMAGE_HEIGHT, 100);

                            $this->ServiceImage->create();
                            $this->request->data['ServiceImage']['service_id'] = $serviceId;
                            $this->request->data['ServiceImage']['image'] = $returnedUploadImageArray[0];
                            $this->request->data['ServiceImage']['status'] = 1;
                            $this->request->data['ServiceImage']['slug'] = date('Ymdhis') . $serviceId . mt_rand(100, 1000);
                            $this->ServiceImage->save($this->data['ServiceImage']);
                        }
                    }
                }
                
                if ($this->data["Service"]["unit_type"] == 0) {
                     $this->request->data['Service']['unit_value'] = '';
                     $this->request->data['Service']['unit_of_measure'] = '';
                }
                if ($this->Service->save($this->data)) {
                    $this->Session->setFlash('Service Updated Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'services', 'action' => 'index', 'page' => $this->passedArgs["page"]));
                }
            }
        } else {
            $this->data = $this->Service->findBySlug($slug);
            $this->request->data['Service']['old_name'] = $this->data['Service']['name'];
            $subCategoryList = $this->Category->getSubCategoryList($this->data['Service']['category_id']);
            $this->set('subCategoryList', $subCategoryList);
            $serviceImages = $this->ServiceImage->find("all", array("conditions" => array("ServiceImage.service_id" => $this->data['Service']['id'])));
            $this->set('serviceImages', $serviceImages);
            // pr($productImages); exit;
        }
    }

    public function admin_activateService($slug = NULL) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Service->field('id', array('Service.slug' => $slug));
            $cnd = array("Service.id = $id");
            $this->Service->updateAll(array('Service.status' => "'1'"), $cnd);
            $this->set('action', '/admin/services/deactivateService/' . $slug);
            $this->set('id', $id);
            $this->set('status', 1);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_deactivateService($slug = NULL) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Service->field('id', array('Service.slug' => $slug));
            $cnd = array("Service.id = $id");
            $this->Service->updateAll(array('Service.status' => "'0'"), $cnd);
            $this->set('action', '/admin/services/activateService/' . $slug);
            $this->set('id', $id);
            $this->set('status', 0);

            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_delete($slug = null) {
        $id = $this->Service->field('id', array('Service.slug' => $slug));
        if ($id) {
            $service_image_list = $this->ServiceImage->find('list', array('conditions' => array('ServiceImage.service_id' => $id), 'fields' => array('ServiceImage.id', 'ServiceImage.image')));
            if (!empty($service_image_list)) {
                foreach ($service_image_list as $key => $value) {
                    @unlink(UPLOAD_FULL_SERVICE_IMAGE_PATH . $value);
                    @unlink(UPLOAD_SMALL_SERVICE_IMAGE_PATH . $value);
                    @unlink(UPLOAD_THUMB_SERVICE_IMAGE_PATH . $value);

                    $this->ServiceImage->delete($key);
                }
            }

            $this->Service->delete($id);
            $this->Session->setFlash('Service deleted successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');
        }
        $this->redirect(array('controller' => 'services', 'action' => 'index', 'page' => $this->passedArgs["page"]));
    }

    public function admin_deleteImage($slug = null) {
        $imageData = $this->ServiceImage->findBySlug($slug);
        $id = $imageData['ServiceImage']['id'];
        if ($id) {
            $this->ServiceImage->delete($id);
            @unlink(UPLOAD_FULL_SERVICE_IMAGE_PATH . $imageData['ServiceImage']['image']);
            @unlink(UPLOAD_SMALL_SERVICE_IMAGE_PATH . $imageData['ServiceImage']['image']);
            @unlink(UPLOAD_THUMB_SERVICE_IMAGE_PATH . $imageData['ServiceImage']['image']);
            //$this->Session->setFlash('Service deleted successfully', 'success_msg');
        } else {
            //$this->Session->setFlash('No record deleted', 'error_msg');
        }

        $serviceImages = $this->ServiceImage->find("all", array("conditions" => array("ServiceImage.service_id" => $imageData['ServiceImage']['service_id'])));
        $this->set('serviceImages', $serviceImages);
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/services/';
            $this->render('service_image');
        }
    }

    /*     * ****** End Back End Functions ****** */



    /*     * ****** Start Front End Functions ****** */

    public function index() {
        $this->layout = "client";
        $this->set('serviceListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Manage Services');
        $this->userLoginCheck();
        $condition = array();
        $separator = array();
        $urlSeparator = array();
        $condition = array('Service.user_id' => $this->Session->read('user_id'));


        if (!empty($this->data)) {
            //echo "<pre>"; print_r($this->data); exit;
            if (isset($this->data['Service']['action'])) {
                $idList = $this->data['Service']['idList'];
                if ($idList) {
                    if ($this->data['Service']['action'] == "delete") {
                        $cnd = array("Service.id IN ($idList) ");
                        $this->Service->deleteAll($cnd);

                        $idListArray = explode(',', $idList);
                        foreach ($idListArray as $id) {
                            $product_image_list = $this->ServiceImage->find('list', array('conditions' => array('ServiceImage.service_id' => $id), 'fields' => array('ServiceImage.id', 'ServiceImage.image')));
                            if (!empty($product_image_list)) {
                                foreach ($product_image_list as $key => $value) {
                                    @unlink(UPLOAD_FULL_SERVICE_IMAGE_PATH . $value);
                                    @unlink(UPLOAD_SMALL_SERVICE_IMAGE_PATH . $value);
                                    @unlink(UPLOAD_THUMB_SERVICE_IMAGE_PATH . $value);

                                    $this->ServiceImage->delete($key);
                                }
                            }
                        }
                    }
                }
            }
        }


        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);


        $this->paginate['Service'] = array(
            'conditions' => $condition,
            'order' => array('Service.id' => 'DESC'),
            'limit' => '50'
        );

        //pr($this->paginate('Service', $condition)); exit;
        $this->set('services', $this->paginate('Service', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'services/';
            $this->render('index');
        }
    }

    public function add() {
        $this->layout = "client";
        $this->set('serviceListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Add Service');

        $this->userLoginCheck();
        $userList = $this->User->getList();
        $this->set('userList', $userList);
        $categoryList = $this->Category->getList(1);
        $this->set('categoryList', $categoryList);
        $subCategoryList = array();

        $msgString = '';
        if ($this->data) {
            //pr($this->data); exit;
            $this->request->data["Service"]["name"] = trim($this->data["Service"]["name"]);
            if (empty($this->data["Service"]["name"])) {
                $msgString .="- Service Name is required field.<br>";
            }
            if (empty($this->data["Service"]["category_id"])) {
                $msgString .="- Category is required field.<br>";
            }
            if (empty($this->data["Service"]["subcategory_id"])) {
                $msgString .="- Sub Category is required field.<br>";
            }
            if ($this->data["Service"]["price"] == "") {
                $msgString .="- Price is required field.<br>";
            }
            if ($this->data["Service"]["delivery_cost"] == "") {
                $msgString .="- Delivery Cost is required field.<br>";
            }
//            if (strip_tags($this->data["Service"]["description"]) == "") {
//                $msgString .="- Description is required field.<br>";
//            }

            if (isset($msgString) && $msgString != '') {
                $subCategoryList = $this->Category->getSubCategoryList($this->data['Service']['category_id']);
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data['Service']['slug'] = $this->stringToSlugUnique($this->data["Service"]["name"], 'Service');
                $this->request->data['Service']['status'] = '1';
                $this->request->data['Service']['user_id'] = $this->Session->read('user_id');
                
                if ($this->data["Service"]["unit_type"] == 0) {
                     $this->request->data['Service']['unit_value'] = '';
                     $this->request->data['Service']['unit_of_measure'] = '';
                }

                if ($this->Service->save($this->data)) {
                    $serviceId = $this->Service->id;

                    $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                    $toReplace = "-";
                    if (count($this->data["Service"]["images"]) > 0) {
                        foreach ($this->data["Service"]["images"] as $val) {
                            if ($val["name"]) {
                                $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                                $imageArray = $val;
                                $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_FULL_SERVICE_IMAGE_PATH);
                                $this->PImageTest->resize(UPLOAD_FULL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_SERVICE_IMAGE_WIDTH, UPLOAD_SMALL_SERVICE_IMAGE_HEIGHT, 100);
                                $this->PImageTest->resize(UPLOAD_FULL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_SERVICE_IMAGE_WIDTH, UPLOAD_THUMB_SERVICE_IMAGE_HEIGHT, 100);

                                $this->ServiceImage->create();
                                $this->request->data['ServiceImage']['service_id'] = $serviceId;
                                $this->request->data['ServiceImage']['image'] = $returnedUploadImageArray[0];
                                $this->request->data['ServiceImage']['status'] = 1;
                                $this->request->data['ServiceImage']['slug'] = date('Ymdhis') . $serviceId . mt_rand(100, 1000);
                                $this->ServiceImage->save($this->data['ServiceImage']);
                            }
                        }
                    }
                    $this->Session->setFlash('Service Added Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'services', 'action' => 'index/'));
                }
            }
        }
        $this->set('subCategoryList', $subCategoryList);
    }

    public function edit($slug = null) {
        $this->layout = "client";
        $this->set('serviceListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Edit Service');
        $this->userLoginCheck();

        $editInfo = $this->Service->findBySlug($slug);
        if (!$editInfo) {
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller' => 'services', 'action' => 'index'));
        } elseif ($editInfo['Service']['user_id'] != $this->Session->read('user_id')) {
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller' => 'services', 'action' => 'index'));
        }
        

        $userList = $this->User->getList();
        $this->set('userList', $userList);
        $categoryList = $this->Category->getList(1);
        $this->set('categoryList', $categoryList);
        $subCategoryList = array();
        $msgString = '';

        if ($this->data) {
            //pr($this->data); exit;
            $this->request->data["Service"]["name"] = trim($this->data["Service"]["name"]);
            if (empty($this->data["Service"]["name"])) {
                $msgString .="- Service Name is required field.<br>";
            }
            if (empty($this->data["Service"]["category_id"])) {
                $msgString .="- Category is required field.<br>";
            }
            if (empty($this->data["Service"]["subcategory_id"])) {
                $msgString .="- Sub Category is required field.<br>";
            }
            if ($this->data["Service"]["price"] == "") {
                $msgString .="- Price is required field.<br>";
            }
            if ($this->data["Service"]["delivery_cost"] == "") {
                $msgString .="- Delivery Cost is required field.<br>";
            }
//            if (strip_tags($this->data["Service"]["description"]) == "") {
//                $msgString .="- Description is required field.<br>";
//            }

            if (isset($msgString) && $msgString != '') {
                $subCategoryList = $this->Category->getSubCategoryList($this->data['Service']['category_id']);
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $serviceId = $this->data["Service"]["id"];
                if ($this->data["Service"]["unit_type"] == 0) {
                     $this->request->data['Service']['unit_value'] = '';
                     $this->request->data['Service']['unit_of_measure'] = '';
                }

                $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                $toReplace = "-";
                if (count($this->data["Service"]["images"]) > 0) {
                    foreach ($this->data["Service"]["images"] as $val) {
                        if ($val["name"]) {
                            $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                            $imageArray = $val;
                            $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_FULL_SERVICE_IMAGE_PATH);
                            $this->PImageTest->resize(UPLOAD_FULL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_SERVICE_IMAGE_WIDTH, UPLOAD_SMALL_SERVICE_IMAGE_HEIGHT, 100);
                            $this->PImageTest->resize(UPLOAD_FULL_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_SERVICE_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_SERVICE_IMAGE_WIDTH, UPLOAD_THUMB_SERVICE_IMAGE_HEIGHT, 100);

                            $this->ServiceImage->create();
                            $this->request->data['ServiceImage']['service_id'] = $serviceId;
                            $this->request->data['ServiceImage']['image'] = $returnedUploadImageArray[0];
                            $this->request->data['ServiceImage']['status'] = 1;
                            $this->request->data['ServiceImage']['slug'] = date('Ymdhis') . $serviceId . mt_rand(100, 1000);
                            $this->ServiceImage->save($this->data['ServiceImage']);
                        }
                    }
                }
                if ($this->Service->save($this->data)) {
                    $this->Session->setFlash('Service Updated Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'services', 'action' => 'index', 'page' => $this->passedArgs["page"]));
                }
            }
        } else {
            $this->data = $this->Service->findBySlug($slug);
            $this->request->data['Service']['old_name'] = $this->data['Service']['name'];
            $subCategoryList = $this->Category->getSubCategoryList($this->data['Service']['category_id']);
            $this->set('subCategoryList', $subCategoryList);
            $serviceImages = $this->ServiceImage->find("all", array("conditions" => array("ServiceImage.service_id" => $this->data['Service']['id'])));
            $this->set('serviceImages', $serviceImages);
            // pr($serviceImages); exit;
        }
    }

    public function delete($slug = null) {
        $id = $this->Service->field('id', array('Service.slug' => $slug));
        if ($id) {
            $service_image_list = $this->ServiceImage->find('list', array('conditions' => array('ServiceImage.service_id' => $id), 'fields' => array('ServiceImage.id', 'ServiceImage.image')));
            if (!empty($service_image_list)) {
                foreach ($service_image_list as $key => $value) {
                    @unlink(UPLOAD_FULL_SERVICE_IMAGE_PATH . $value);
                    @unlink(UPLOAD_SMALL_SERVICE_IMAGE_PATH . $value);
                    @unlink(UPLOAD_THUMB_SERVICE_IMAGE_PATH . $value);

                    $this->ServiceImage->delete($key);
                }
            }
            $this->Service->delete($id);
            $this->Session->setFlash('Service Deleted successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');
        }
        $this->redirect(array('controller' => 'services', 'action' => 'index/', 'page' => $this->passedArgs["page"]));
    }

    public function deleteImage($slug = null) {
        $imageData = $this->ServiceImage->findBySlug($slug);
        $id = $imageData['ServiceImage']['id'];
        if ($id) {
            $this->ServiceImage->delete($id);
            @unlink(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $imageData['ServiceImage']['image']);
            @unlink(UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $imageData['ServiceImage']['image']);
            @unlink(UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $imageData['ServiceImage']['image']);
        } else {
            //$this->Session->setFlash('No record deleted', 'error_msg');
        }

        $serviceImages = $this->ServiceImage->find("all", array("conditions" => array("ServiceImage.service_id" => $imageData['ServiceImage']['service_id'])));
        $this->set('serviceImages', $serviceImages);
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'services/';
            $this->render('service_image');
        }
    }

    /*     * ****** End Front End Functions ****** */
}

//End ServiceController Class
?>
