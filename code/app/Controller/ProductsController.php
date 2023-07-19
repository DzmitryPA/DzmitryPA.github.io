<?php

class ProductsController extends AppController {

    public $name = 'Products';
    public $uses = array('Admin', 'User', 'Product', 'ProductImage', 'Category');
    public $helpers = array('Html', 'Form', 'Paginator', 'Javascript', 'Ajax', 'Js', 'Text', 'Number');
    public $paginate = array('limit' => '50', 'page' => '1', 'order' => array('Product.name' => 'asc'));
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

    /******** Start Back End Functions *******/
    
    public function admin_index() {
        $this->layout = "admin";
        $this->set('productListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Manage Products');
        $condition = array();
        $separator = array();
        $urlSeparator = array();

        if (!empty($this->data)) {
            //print_r($this->data);
            if (isset($this->data['Product']['keyword']) && $this->data['Product']['keyword'] != '') {
                $keyword = trim($this->data['Product']['keyword']);
            }
            if (isset($this->data['Product']['searchByDateFrom']) && $this->data['Product']['searchByDateFrom'] != '') {
                $searchByDateFrom = trim($this->data['Product']['searchByDateFrom']);
            }
            if (isset($this->data['Product']['searchByDateTo']) && $this->data['Product']['searchByDateTo'] != '') {
                $searchByDateTo = trim($this->data['Product']['searchByDateTo']);
            }

            if (isset($this->data['Product']['action'])) {
                $idList = $this->data['Product']['idList'];
                if ($idList) {
                    if ($this->data['Product']['action'] == "activate") {
                        $cnd = array("Product.id IN ($idList) ");
                        $this->Product->updateAll(array('Product.status' => "'1'"), $cnd);
                    } elseif ($this->data['Product']['action'] == "deactivate") {
                        $cnd = array("Product.id IN ($idList) ");
                        $this->Product->updateAll(array('Product.status' => "'0'"), $cnd);
                    } elseif ($this->data['Product']['action'] == "delete") {
                        $cnd = array("Product.id IN ($idList) ");
                        $this->Product->deleteAll($cnd);

                        $idListArray = explode(',', $idList);
                        foreach ($idListArray as $id) {
                            $product_image_list = $this->ProductImage->find('list', array('conditions' => array('ProductImage.product_id' => $id), 'fields' => array('ProductImage.id', 'ProductImage.image')));
                            if (!empty($product_image_list)) {
                                foreach ($product_image_list as $key => $value) {
                                    @unlink(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $value);
                                    @unlink(UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $value);
                                    @unlink(UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $value);

                                    $this->ProductImage->delete($key);
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
            $condition[] = " (Product.name like '%" . addslashes($keyword) . "%' or User.company_name like '%" . addslashes($keyword) . "%')  ";
            $this->set('keyword', $keyword);
        }
        if (isset($searchByDateFrom) && $searchByDateFrom != '') {
            $separator[] = 'searchByDateFrom:' . urlencode($searchByDateFrom);
            $searchByDateFrom = str_replace('_', '\_', $searchByDateFrom);
            $searchByDate_con1 = date('Y-m-d', strtotime($searchByDateFrom));
            $condition[] = " (Date(Product.created)>='$searchByDate_con1' ) ";
            $searchByDateFrom = str_replace('\_', '_', $searchByDateFrom);
        }

        if (isset($searchByDateTo) && $searchByDateTo != '') {
            $separator[] = 'searchByDateTo:' . urlencode($searchByDateTo);
            $searchByDateTo = str_replace('_', '\_', $searchByDateTo);
            $searchByDate_con2 = date('Y-m-d', strtotime($searchByDateTo));
            $condition[] = " (Date(Product.created)<='$searchByDate_con2' ) ";
            $searchByDateTo = str_replace('\_', '_', $searchByDateTo);
        }

        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);


        $this->paginate['Product'] = array(
            'conditions' => $condition,
            'order' => array('Product.id' => 'DESC'),
            'limit' => '50'
        );

        $this->set('products', $this->paginate('Product', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/products/';
            $this->render('index');
        }
    }

    public function admin_add() {
        $this->layout = "admin";
        $this->set('productAdd', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Add Product');

        $userList = $this->User->getList();
        $this->set('userList', $userList);
        $categoryList = $this->Category->getList();
        $this->set('categoryList', $categoryList);
        $subCategoryList = array();

        $msgString = '';
        if ($this->data) {
            //pr($this->data); exit;
            if (empty($this->data["Product"]["user_id"])) {
                $msgString .="- Company is required field.<br>";
            }
            $this->request->data["Product"]["name"] = trim($this->data["Product"]["name"]);
            if (empty($this->data["Product"]["name"])) {
                $msgString .="- Product Name is required field.<br>";
            }
            if (empty($this->data["Product"]["category_id"])) {
                $msgString .="- Category is required field.<br>";
            }
            if (empty($this->data["Product"]["subcategory_id"])) {
                $msgString .="- Sub Category is required field.<br>";
            }
            if ($this->data["Product"]["price"] == "") {
                $msgString .="- Price is required field.<br>";
            }
            if ($this->data["Product"]["delivery_cost"] == "") {
                $msgString .="- Delivery Cost is required field.<br>";
            }
            
//            if (strip_tags($this->data["Product"]["description"]) == "") {
//                $msgString .="- Description is required field.<br>";
//            }

            if (isset($msgString) && $msgString != '') {
                $subCategoryList = $this->Category->getSubCategoryList($this->data['Product']['category_id']);
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data['Product']['slug'] = $this->stringToSlugUnique($this->data["Product"]["name"], 'Product');
                $this->request->data['Product']['status'] = '1';
                if ($this->data["Product"]["unit_type"] == 0) {
                     $this->request->data['Product']['unit_value'] = '';
                     $this->request->data['Product']['unit_of_measure'] = '';
                }

                if ($this->Product->save($this->data)) {
                    $productId = $this->Product->id;

                    $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                    $toReplace = "-";
                    if (count($this->data["Product"]["images"]) > 0) {
                        foreach ($this->data["Product"]["images"] as $val) {
                            if ($val["name"]) {
                                $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                                $imageArray = $val;
                                $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_FULL_PRODUCT_IMAGE_PATH);
                                $this->PImageTest->resize(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_PRODUCT_IMAGE_WIDTH, UPLOAD_SMALL_PRODUCT_IMAGE_HEIGHT, 100);
                                $this->PImageTest->resize(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_PRODUCT_IMAGE_WIDTH, UPLOAD_THUMB_PRODUCT_IMAGE_HEIGHT, 100);

                                $this->ProductImage->create();
                                $this->request->data['ProductImage']['product_id'] = $productId;
                                $this->request->data['ProductImage']['image'] = $returnedUploadImageArray[0];
                                $this->request->data['ProductImage']['status'] = 1;
                                $this->request->data['ProductImage']['slug'] = date('Ymdhis') . $productId . mt_rand(100, 1000);
                                $this->ProductImage->save($this->data['ProductImage']);
                            }
                        }
                    }
                    $this->Session->setFlash('Product Added Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'products', 'action' => 'index'));
                }
            }
        }
        $this->set('subCategoryList', $subCategoryList);
    }

    public function admin_edit($slug = null) {
        $this->layout = "admin";
        $this->set('productListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Edit Product');
        
        $editInfo = $this->Product->findBySlug($slug);
        if(!$editInfo){
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller' => 'products', 'action' => 'index'));
        }
        
        $userList = $this->User->getList();
        $this->set('userList', $userList);
        $categoryList = $this->Category->getList();
        $this->set('categoryList', $categoryList);
        $subCategoryList = array();
        $msgString = '';
        if ($this->data) {
            //pr($this->data); exit;
            if (empty($this->data["Product"]["user_id"])) {
                $msgString .="- Company is required field.<br>";
            }
            $this->request->data["Product"]["name"] = trim($this->data["Product"]["name"]);
            if (empty($this->data["Product"]["name"])) {
                $msgString .="- Product Name is required field.<br>";
            }
            if (empty($this->data["Product"]["category_id"])) {
                $msgString .="- Category is required field.<br>";
            }
            if (empty($this->data["Product"]["subcategory_id"])) {
                $msgString .="- Sub Category is required field.<br>";
            }
            if ($this->data["Product"]["price"] == "") {
                $msgString .="- Price is required field.<br>";
            }
            if ($this->data["Product"]["delivery_cost"] == "") {
                $msgString .="- Delivery Cost is required field.<br>";
            }
//            if (strip_tags($this->data["Product"]["description"]) == "") {
//                $msgString .="- Description is required field.<br>";
//            }

            if (isset($msgString) && $msgString != '') {
                $subCategoryList = $this->Category->getSubCategoryList($this->data['Product']['category_id']);
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $productId = $this->data["Product"]["id"];

                $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                $toReplace = "-";
                if (count($this->data["Product"]["images"]) > 0) {
                    foreach ($this->data["Product"]["images"] as $val) {
                        if ($val["name"]) {
                            $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                            $imageArray = $val;
                            $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_FULL_PRODUCT_IMAGE_PATH);
                            $this->PImageTest->resize(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_PRODUCT_IMAGE_WIDTH, UPLOAD_SMALL_PRODUCT_IMAGE_HEIGHT, 100);
                            $this->PImageTest->resize(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_PRODUCT_IMAGE_WIDTH, UPLOAD_THUMB_PRODUCT_IMAGE_HEIGHT, 100);

                            $this->ProductImage->create();
                            $this->request->data['ProductImage']['product_id'] = $productId;
                            $this->request->data['ProductImage']['image'] = $returnedUploadImageArray[0];
                            $this->request->data['ProductImage']['status'] = 1;
                            $this->request->data['ProductImage']['slug'] = date('Ymdhis') . $productId . mt_rand(100, 1000);
                            $this->ProductImage->save($this->data['ProductImage']);
                        }
                    }
                }else{
                    $this->data["Product"]["images"] == "";
                }
                
                if ($this->data["Product"]["unit_type"] == 0) {
                     $this->request->data['Product']['unit_value'] = '';
                     $this->request->data['Product']['unit_of_measure'] = '';
                }
                if ($this->Product->save($this->data)) {
                    $this->Session->setFlash('Product Updated Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'products', 'action' => 'index', 'page' => $this->passedArgs["page"]));
                }
            }
        } else {
            $this->data = $this->Product->findBySlug($slug);
            $this->request->data['Product']['old_name'] = $this->data['Product']['name'];
            $subCategoryList = $this->Category->getSubCategoryList($this->data['Product']['category_id']);
            $this->set('subCategoryList', $subCategoryList);
            $productImages = $this->ProductImage->find("all", array("conditions" => array("ProductImage.product_id" => $this->data['Product']['id'])));
            $this->set('productImages', $productImages);
            // pr($productImages); exit;
        }
    }

    public function admin_activateProduct($slug = NULL) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Product->field('id', array('Product.slug' => $slug));
            $cnd = array("Product.id = $id");
            $this->Product->updateAll(array('Product.status' => "'1'"), $cnd);
            $this->set('action', '/admin/products/deactivateProduct/' . $slug);
            $this->set('id', $id);
            $this->set('status', 1);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_deactivateProduct($slug = NULL) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Product->field('id', array('Product.slug' => $slug));
            $cnd = array("Product.id = $id");
            $this->Product->updateAll(array('Product.status' => "'0'"), $cnd);
            $this->set('action', '/admin/products/activateProduct/' . $slug);
            $this->set('id', $id);
            $this->set('status', 0);

            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_delete($slug = null) {
        $id = $this->Product->field('id', array('Product.slug' => $slug));
        if ($id) {
            $product_image_list = $this->ProductImage->find('list', array('conditions' => array('ProductImage.product_id' => $id), 'fields' => array('ProductImage.id', 'ProductImage.image')));
            if (!empty($product_image_list)) {
                foreach ($product_image_list as $key => $value) {
                    @unlink(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $value);
                    @unlink(UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $value);
                    @unlink(UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $value);

                    $this->ProductImage->delete($key);
                }
            }

            $this->Product->delete($id);
            $this->Session->setFlash('Product deleted successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');
        }
        $this->redirect(array('controller' => 'products', 'action' => 'index', 'page' => $this->passedArgs["page"]));
    }

    public function admin_deleteImage($slug = null) {
        $imageData = $this->ProductImage->findBySlug($slug);
        $id = $imageData['ProductImage']['id'];
        if ($id) {
            $this->ProductImage->delete($id);
            @unlink(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $imageData['ProductImage']['image']);
            @unlink(UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $imageData['ProductImage']['image']);
            @unlink(UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $imageData['ProductImage']['image']);
            $this->Session->setFlash('Product deleted successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');
        }

        $productImages = $this->ProductImage->find("all", array("conditions" => array("ProductImage.product_id" => $imageData['ProductImage']['product_id'])));
        $this->set('productImages', $productImages);
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/products/';
            $this->render('product_image');
        }
    }
    
    /******** End Back End Functions *******/
    
    
    
    /******** Start Front End Functions *******/
    
    public function index() {
        $this->layout = "client";
        $this->set('productListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Manage Products');
        $this->userLoginCheck();
        $condition = array();
        $separator = array();
        $urlSeparator = array();
        $condition = array('Product.user_id' => $this->Session->read('user_id'));
        

        if (!empty($this->data)) {
           //echo "<pre>"; print_r($this->data); exit;
            if (isset($this->data['Product']['action'])) {
                $idList = $this->data['Product']['idList'];
                if ($idList) {
                    if ($this->data['Product']['action'] == "delete") {
                        $cnd = array("Product.id IN ($idList) ");
                        $this->Product->deleteAll($cnd);

                        $idListArray = explode(',', $idList);
                        foreach ($idListArray as $id) {
                            $product_image_list = $this->ProductImage->find('list', array('conditions' => array('ProductImage.product_id' => $id), 'fields' => array('ProductImage.id', 'ProductImage.image')));
                            if (!empty($product_image_list)) {
                                foreach ($product_image_list as $key => $value) {
                                    @unlink(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $value);
                                    @unlink(UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $value);
                                    @unlink(UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $value);

                                    $this->ProductImage->delete($key);
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


        $this->paginate['Product'] = array(
            'conditions' => $condition,
            'order' => array('Product.id' => 'DESC'),
            'limit' => '50'
        );

        $this->set('products', $this->paginate('Product', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'products/';
            $this->render('index');
        }
    }
    
    public function add() {
        $this->layout = "client";
        $this->set('productAdd', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Add Product');

        $this->userLoginCheck();
        $userList = $this->User->getList();
        $this->set('userList', $userList);
        $categoryList = $this->Category->getList();
        $this->set('categoryList', $categoryList);
        $subCategoryList = array();
        
        $msgString = '';
        if ($this->data) {
            //pr($this->data); exit;
            $this->request->data["Product"]["name"] = trim($this->data["Product"]["name"]);
            if (empty($this->data["Product"]["name"])) {
                $msgString .="- Product Name is required field.<br>";
            }
            if (empty($this->data["Product"]["category_id"])) {
                $msgString .="- Category is required field.<br>";
            }
            if (empty($this->data["Product"]["subcategory_id"])) {
                $msgString .="- Sub Category is required field.<br>";
            }
            if ($this->data["Product"]["price"] == "") {
                $msgString .="- Price is required field.<br>";
            }
            if ($this->data["Product"]["delivery_cost"] == "") {
                $msgString .="- Delivery Cost is required field.<br>";
            }
            
//            if ($this->data["Product"]["description"] == "") {
//                $msgString .="- Description is required field.<br>";
//            }

            if (isset($msgString) && $msgString != '') {
                $subCategoryList = $this->Category->getSubCategoryList($this->data['Product']['category_id']);
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data['Product']['slug'] = $this->stringToSlugUnique($this->data["Product"]["name"], 'Product');
                $this->request->data['Product']['status'] = '1';
                $this->request->data['Product']['user_id'] = $this->Session->read('user_id');
                
                if ($this->data["Product"]["unit_type"] == 0) {
                     $this->request->data['Product']['unit_value'] = '';
                     $this->request->data['Product']['unit_of_measure'] = '';
                }

                if ($this->Product->save($this->data)) {
                    $productId = $this->Product->id;

                    $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                    $toReplace = "-";
                    if (!empty($this->data["Product"]["images"]) && count($this->data["Product"]["images"]) > 0) {
                        foreach ($this->data["Product"]["images"] as $val) {
                            if ($val["name"]) {
                                $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                                $imageArray = $val;
                                $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_FULL_PRODUCT_IMAGE_PATH);
                                $this->PImageTest->resize(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_PRODUCT_IMAGE_WIDTH, UPLOAD_SMALL_PRODUCT_IMAGE_HEIGHT, 100);
                                $this->PImageTest->resize(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_PRODUCT_IMAGE_WIDTH, UPLOAD_THUMB_PRODUCT_IMAGE_HEIGHT, 100);

                                $this->ProductImage->create();
                                $this->request->data['ProductImage']['product_id'] = $productId;
                                $this->request->data['ProductImage']['image'] = $returnedUploadImageArray[0];
                                $this->request->data['ProductImage']['status'] = 1;
                                $this->request->data['ProductImage']['slug'] = date('Ymdhis') . $productId . mt_rand(100, 1000);
                                $this->ProductImage->save($this->data['ProductImage']);
                            }
                        }
                    }else{

                    }
                    $this->Session->setFlash('Product Added Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'products', 'action' => 'index/'));
                }
            }
        }
        $this->set('subCategoryList', $subCategoryList);
    }
    
    public function edit($slug = null) {
        $this->layout = "client";
        $this->set('productListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Edit Product');
        $this->userLoginCheck();
        
        $editInfo = $this->Product->findBySlug($slug);
        if(!$editInfo){
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller' => 'products', 'action' => 'index'));
        }elseif($editInfo['Product']['user_id'] != $this->Session->read('user_id')){
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller' => 'products', 'action' => 'index'));
        }
        
        $userList = $this->User->getList();
        $this->set('userList', $userList);
        $categoryList = $this->Category->getList();
        $this->set('categoryList', $categoryList);
        $subCategoryList = array();
        $msgString = '';
        
        if ($this->data) {
            //pr($this->data); exit;
            $this->request->data["Product"]["name"] = trim($this->data["Product"]["name"]);
            if (empty($this->data["Product"]["name"])) {
                $msgString .="- Product Name is required field.<br>";
            }
            if (empty($this->data["Product"]["category_id"])) {
                $msgString .="- Category is required field.<br>";
            }
            if (empty($this->data["Product"]["subcategory_id"])) {
                $msgString .="- Sub Category is required field.<br>";
            }
            if ($this->data["Product"]["price"] == "") {
                $msgString .="- Price is required field.<br>";
            }
            if ($this->data["Product"]["delivery_cost"] == "") {
                $msgString .="- Delivery Cost is required field.<br>";
            }
//            if (strip_tags($this->data["Product"]["description"]) == "") {
//                $msgString .="- Description is required field.<br>";
//            }

            if (isset($msgString) && $msgString != '') {
                $subCategoryList = $this->Category->getSubCategoryList($this->data['Product']['category_id']);
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $productId = $this->data["Product"]["id"];
                
                if ($this->data["Product"]["unit_type"] == 0) {
                     $this->request->data['Product']['unit_value'] = '';
                     $this->request->data['Product']['unit_of_measure'] = '';
                }

                $specialCharacters = array('#', '$', '%', '@', '+', '=', '\\', '/', '"', ' ', "'", ':', '~', '`', '!', '^', '*', '(', ')', '|', "'", "&");
                $toReplace = "-";
                if (count($this->data["Product"]["images"]) > 0) {
                    foreach ($this->data["Product"]["images"] as $val) {
                        if ($val["name"]) {
                            $val['name'] = str_replace($specialCharacters, $toReplace, $val['name']);
                            $imageArray = $val;
                            $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_FULL_PRODUCT_IMAGE_PATH);
                            $this->PImageTest->resize(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_SMALL_PRODUCT_IMAGE_WIDTH, UPLOAD_SMALL_PRODUCT_IMAGE_HEIGHT, 100);
                            $this->PImageTest->resize(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $returnedUploadImageArray[0], UPLOAD_THUMB_PRODUCT_IMAGE_WIDTH, UPLOAD_THUMB_PRODUCT_IMAGE_HEIGHT, 100);

                            $this->ProductImage->create();
                            $this->request->data['ProductImage']['product_id'] = $productId;
                            $this->request->data['ProductImage']['image'] = $returnedUploadImageArray[0];
                            $this->request->data['ProductImage']['status'] = 1;
                            $this->request->data['ProductImage']['slug'] = date('Ymdhis') . $productId . mt_rand(100, 1000);
                            $this->ProductImage->save($this->data['ProductImage']);
                        }
                    }
                }
                if ($this->Product->save($this->data)) {
                    $this->Session->setFlash('Product Updated Successfully', 'success_msg');
                    $this->redirect(array('controller' => 'products', 'action' => 'index', 'page' => $this->passedArgs["page"]));
                }
            }
        } else {
            $this->data = $this->Product->findBySlug($slug);
            $this->request->data['Product']['old_name'] = $this->data['Product']['name'];
            $subCategoryList = $this->Category->getSubCategoryList($this->data['Product']['category_id']);
            $this->set('subCategoryList', $subCategoryList);
            $productImages = $this->ProductImage->find("all", array("conditions" => array("ProductImage.product_id" => $this->data['Product']['id'])));
            $this->set('productImages', $productImages);
            // pr($productImages); exit;
        }
    }
    
    
    public function delete($slug = null) {
        $id = $this->Product->field('id', array('Product.slug' => $slug));
        if ($id) {
            $product_image_list = $this->ProductImage->find('list', array('conditions' => array('ProductImage.product_id' => $id), 'fields' => array('ProductImage.id', 'ProductImage.image')));
            if (!empty($product_image_list)) {
                foreach ($product_image_list as $key => $value) {
                    @unlink(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $value);
                    @unlink(UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $value);
                    @unlink(UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $value);

                    $this->ProductImage->delete($key);
                }
            }
            $this->Product->delete($id);
            $this->Session->setFlash('Product Deleted successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');
        }
        $this->redirect(array('controller' => 'products', 'action' => 'index/', 'page' => $this->passedArgs["page"]));
    }
    
    public function deleteImage($slug = null) {
        $imageData = $this->ProductImage->findBySlug($slug);
        $id = $imageData['ProductImage']['id'];
        if ($id) {
            $this->ProductImage->delete($id);
            @unlink(UPLOAD_FULL_PRODUCT_IMAGE_PATH . $imageData['ProductImage']['image']);
            @unlink(UPLOAD_SMALL_PRODUCT_IMAGE_PATH . $imageData['ProductImage']['image']);
            @unlink(UPLOAD_THUMB_PRODUCT_IMAGE_PATH . $imageData['ProductImage']['image']);
        } else {
            //$this->Session->setFlash('No record deleted', 'error_msg');
        }

        $productImages = $this->ProductImage->find("all", array("conditions" => array("ProductImage.product_id" => $imageData['ProductImage']['product_id'])));
        $this->set('productImages', $productImages);
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'products/';
            $this->render('product_image');
        }
    }
    
    public function view($slug = null) {
        $this->layout = "client";
        $this->set('productListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'View Product Detail');
        $this->userLoginCheck();
        
        $productInfo = $this->Product->findBySlug($slug);
        if(!$productInfo){
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller' => 'products', 'action' => 'index'));
        }
        
        
    }
    
    /******** End Front End Functions *******/

}

//End ProductController Class
?>
