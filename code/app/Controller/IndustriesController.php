<?php
class IndustriesController extends AppController {

    public $name = 'Industries';
    public $uses = array('Admin', 'User','Industry');
    public $helpers = array('Html', 'Form', 'Paginator','Javascript', 'Ajax', 'Js','Text','Number');
    public $paginate = array('limit' => '50', 'page' => '1', 'order' => array('Industry.name' => 'asc'));
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
        $this->set('industryListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Manage Industries');
        
        $condition = array('Industry.parent_id'=>0);
        $separator = array();
        $urlSeparator = array();
       
        if (!empty($this->data)) {
            if (isset($this->data['Industry']['keyword']) && $this->data['Industry']['keyword'] != '') {
                $keyword = trim($this->data['Industry']['keyword']);
            }
        
            if (isset($this->data['Industry']['action'])) {
                $idList = $this->data['Industry']['idList'];
                if ($idList) {
                    if ($this->data['Industry']['action'] == "activate") {
                        $cnd = array("Industry.id IN ($idList) ");
                        $this->Industry->updateAll(array('Industry.status' => "'1'"), $cnd);
                    } elseif ($this->data['Industry']['action'] == "deactivate") {
                        $cnd = array("Industry.id IN ($idList) ");
                        $this->Industry->updateAll(array('Industry.status' => "'0'"), $cnd);
                    } elseif ($this->data['Industry']['action'] == "delete") {
                        $cnd = array("Industry.id IN ($idList) ");
                        $cnd1 = array("Industry.parent_id IN ($idList) ");
                        $this->Industry->deleteAll($cnd);
                        $this->Industry->deleteAll($cnd1);
                    }
                }
            }
        } elseif (!empty($this->params)) {
            if (isset($this->params['named']['keyword']) && $this->params['named']['keyword'] != '') {
                $keyword = urldecode(trim($this->params['named']['keyword']));
            }
        }

        if (isset($keyword) && $keyword != '') {
            $separator[] = 'keyword:' . urlencode($keyword);
            $condition[] = " (Industry.name like '%" . addslashes($keyword) . "%')  ";
            $this->set('keyword', $keyword);
        }
        
        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);
    
        $this->paginate['Industry'] = array(
            'conditions' => $condition,
            'order' => array('Industry.name' => 'ASC'),
            'limit' => '50'
        );
        
        $this->set('categories', $this->paginate('Industry', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/industries/';
            $this->render('index');
        }
    }

    public function admin_add() {
        $this->layout = "admin";
        $this->set('indusAdd', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Add Industry');
        $msgString = '';
        if ($this->data) {
            $this->request->data["Industry"]["name"] = trim($this->data["Industry"]["name"]);
            if (empty($this->data["Industry"]["name"])) {
                $msgString .="- Industry Name is required field.<br>";
            }elseif ($this->Industry->isRecordUniqueCategory($this->data["Industry"]["name"],0) == false) {
                $msgString .="- Industry Name already exists.<br>";
            }
            
            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data['Industry']['slug'] = $this->stringToSlugUnique($this->data["Industry"]["name"],'Industry');
                $this->request->data['Industry']['status'] = '1';
                if ($this->Industry->save($this->data)) {
                    $this->Session->setFlash('Industry Added Successfully', 'success_msg');
                    $this->redirect(array('controller'=>'industries', 'action'=>'index'));
                }
            }
        }
    }

    public function admin_edit($slug = null) {
        $this->layout = "admin";
        $this->set('industryListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Edit Industry');
        $msgString = '';
        if ($this->data) {
            $this->request->data["Industry"]["name"] = trim($this->data["Industry"]["name"]);
            if (empty($this->data["Industry"]["name"])) {
                $msgString .="- Industry Name is required field.<br>";
            }elseif(strtolower(trim($this->data["Industry"]["old_name"])) != strtolower(trim($this->data["Industry"]["name"]))){
                if ($this->Industry->isRecordUniqueCategory($this->data["Industry"]["name"],0) == false) {
                    $msgString .="- Industry Name already exists.<br>";
                }
                $this->request->data['Industry']['slug'] = $this->stringToSlugUnique($this->data["Industry"]["name"],'Industry');
            }
            
            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                
                if ($this->Industry->save($this->data)) {
                    $this->Session->setFlash('Industry updated successfully', 'success_msg');
                    $this->redirect(array('controller'=>'industries', 'action'=>'index', 'page'=>$this->passedArgs["page"]));
                }
            }
        }else{
            $this->data = $this->Industry->findBySlug($slug);
            $this->request->data['Industry']['old_name'] = $this->data['Industry']['name'];
        }
    }

    public function admin_activateCategory($slug = NULL, $parentSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Industry->field('id', array('Industry.slug' => $slug));
            $cnd = array("Industry.id = $id");
            $this->Industry->updateAll(array('Industry.status' => "'1'"), $cnd);
            $this->set('action', '/admin/industries/deactivateCategory/' . $slug);
            $this->set('id', $id);
            $this->set('status', 1);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_deactivateCategory($slug = NULL, $parentSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Industry->field('id', array('Industry.slug' => $slug));
            $cnd = array("Industry.id = $id");
            $this->Industry->updateAll(array('Industry.status' => "'0'"), $cnd);
            $this->set('action', '/admin/industries/activateCategory/' . $slug);
            $this->set('id', $id);
            $this->set('status', 0);


            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_delete($slug = null) {
        $id = $this->Industry->field('id', array('Industry.slug' => $slug));
        if ($id) {
            $this->Industry->deleteAll(array('Industry.parent_id'=>$id));
            $this->Industry->delete($id);
            $this->Session->setFlash('Industry deleted successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');                
        }
        $this->redirect(array('controller'=>'industries','action'=>'index', 'page'=>$this->passedArgs["page"]));
    }


   public function admin_subcategory($cslug=null) {
        $this->layout = "admin";
        $this->set('industryListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Manage Industry Sub Categories");

        $catInfo = $this->Industry->findBySlug($cslug);
        $this->set('cslug',$cslug);
        if($catInfo){
            $catId = $catInfo['Industry']['id'];
            $this->set('catInfo',$catInfo);
        }else{
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller'=>'industries','action'=>'index'));
        }

        $condition = array('Industry.parent_id'=>$catId);
        $separator = array();
        $urlSeparator = array();
        $name = '';

        if (!empty($this->data)) {
            if (isset($this->data['Industry']['name']) && $this->data['Industry']['name'] != '') {
                $name = trim($this->data['Industry']['name']);
            }

            if (isset($this->data['Industry']['action'])) {
                $idList = $this->data['Industry']['idList'];
                if ($idList) {
                    if ($this->data['Industry']['action'] == "activate") {
                        $cnd = array("Industry.id IN ($idList) ");
                        $this->Industry->updateAll(array('Industry.status' => "'1'"), $cnd);
                    } elseif ($this->data['Industry']['action'] == "deactivate") {
                        $cnd = array("Industry.id IN ($idList) ");
                        $this->Industry->updateAll(array('Industry.status' => "'0'"), $cnd);
                    } elseif ($this->data['Industry']['action'] == "delete") {
                        $cnd = array("Industry.id IN ($idList) ");
                        $this->Industry->deleteAll($cnd);
                    }
                }
            }
        } elseif (!empty($this->params)) {
            if (isset($this->params['named']['name']) && $this->params['named']['name'] != '') {
                $name = urldecode(trim($this->params['named']['name']));
            }
        }

        if (isset($name) && $name != '') {
            $separator[] = 'name:' . urlencode($name);
            $condition[] = " (Industry.name like '%" . addslashes($name) . "%') ";
        }

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

        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);
        $this->set('name', $name);
        $this->set('searchKey', $name);

        $this->paginate['Industry'] = array(
            'conditions' => $condition,
            'order' => array('Industry.name' => 'ASC'),
            'limit' => '50'
        );

        $this->set('subcategories', $this->paginate('Industry', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/industries/';
            $this->render('subcategory');
        }
    }

     public function admin_addsubcategory($cslug=null) {
        $this->set('industryListAct', 1);
        $msgString = "";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Add Industry Sub Category");

        $catInfo = $this->Industry->findBySlug($cslug);
        $this->set('cslug',$cslug);
        if($catInfo){
            $catId = $catInfo['Industry']['id'];
            $this->set('catInfo',$catInfo);
        }else{
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller'=>'industries','action'=>'index'));
        }

        if ($this->data) {
            
            $this->request->data["Industry"]["name"] = trim($this->data["Industry"]["name"]);
            if (empty($this->data["Industry"]["name"])) {
                $msgString .="-Industry Sub Category Name is required field.<br>";
            }elseif ($this->Industry->isRecordUniqueCategory($this->data["Industry"]["name"],$catId) == false) {
                $msgString .="-Industry Sub Category Name already exists.<br>";
            }

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data['Industry']['slug'] = $this->stringToSlugUnique($this->data["Industry"]["name"],'Industry');
                $this->request->data['Industry']['status'] = '1';
                $this->request->data['Industry']['parent_id'] = $catId;
                if ($this->Industry->save($this->data)) {
                    $this->Session->setFlash('Sub category added successfully', 'success_msg');
                    $this->redirect('/admin/industries/subcategory/'.$cslug);
                }
            }
        }
    }


     public function admin_editsubcategory($slug = null,$cslug=null) {

        $this->set('industryListAct', 1);
        $msgString = "";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Edit Industry Sub Category");

        $catInfo = $this->Industry->findBySlug($cslug);
        $this->set('cslug',$cslug);
        if($catInfo){
            $catId = $catInfo['Industry']['id'];
            $this->set('catInfo',$catInfo);
        }else{
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller'=>'industries','action'=>'index'));
        }

        if ($this->data) {
            
            $this->request->data["Industry"]["name"] = trim($this->data["Industry"]["name"]);
            if (empty($this->data["Industry"]["name"])) {
                $msgString .="- Industry Sub Category Name is required field.<br>";
            }elseif(strtolower(trim($this->data["Industry"]["old_name"])) != strtolower(trim($this->data["Industry"]["name"]))){
                $this->request->data['Industry']['slug'] = $this->stringToSlugUnique($this->data["Industry"]["name"],'Industry');
                if ($this->Industry->isRecordUniqueCategory($this->data["Industry"]["name"],0) == false) {
                    $msgString .="- Industry Sub Category Name already exists.<br>";
                }
            }

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                if ($this->Industry->save($this->data)) {
                    $this->Session->setFlash('Industry Sub Category Name Updated Successfully', 'success_msg');
                    $this->redirect('/admin/industries/subcategory/'.$cslug);
                }
            }
        }else{
            $id = $this->Industry->field('id', array('Industry.slug' => $slug));
            $this->Industry->id = $id;
            $this->data = $this->Industry->read();
            $this->request->data['Industry']['old_name'] = $this->data['Industry']['name'];
        }
    }
    
    public function admin_deletesubcategory($slug = NULL, $main_category_slug = null) {
        if ($slug != '') {
            if (!empty($main_category_slug)) {
                $mainCategoryDetail = $this->Industry->findBySlug($main_category_slug);
                if (empty($mainCategoryDetail) || $mainCategoryDetail['Industry']['parent_id'] != 0) {
                    $this->Session->setFlash('Wrong URL access.', 'error_msg');
                    $this->redirect(array('controller' => 'industries', 'action' => 'index', ''));
                }
            }
            $id = $this->Industry->field('id', array('Industry.slug' => $slug));
            $this->Industry->delete($id);
            $this->Session->setFlash('Industry Sub Category deleted successfully.', 'success_msg');
            $this->redirect(array('controller' => 'industries', 'action' => 'subcategory', $main_category_slug));
        }
    }
    
    public function index() {
        $this->layout = "client";
        $this->set('category_list', 'active');
        $this->set('title_for_layout', TITLE_FOR_PAGES . "List Categories");
        
        $categoryBars = $this->Category->find('all',array('conditions'=>array('Category.parent_id' => '0','Category.status'=>1),'order'=>array('Category.name' => 'ASC')));
        $this->set('categoryBars',$categoryBars);
        
        $categoryCount = $this->Category->find('count',array('conditions'=>array('Category.parent_id' => '0','Category.status'=>1)));
        $this->set('categoryCount',$categoryCount);
        
    }
    
    public function listing() {
        $this->layout = "client";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "List Categories");
        $categoryList = $this->Category->find('all',array('conditions'=>array('Category.status'=>'1','Category.parent_id'=>0),'fields'=>array('Category.slug','Category.name','Category.image')));
        $this->set('categoryList',$categoryList);
        
    }
    
    public function sublisting($slug = null) {
        $this->layout = "client";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "List Sub Categories");
        $main_cat_id = $this->Category->field("Category.id",array('Category.slug'=>$slug));
        $main_cat_name = $this->Category->field("Category.name",array('Category.slug'=>$slug));
        $this->set('slug',$slug);
        $this->set('main_cat_id',$main_cat_id);
        $this->set('main_cat_name',$main_cat_name);
        $categoryList = $this->Category->find('all',array('conditions'=>array('Category.status'=>'1','Category.parent_id'=>$main_cat_id),'fields'=>array('Category.slug','Category.name','Category.image')));
        $this->set('categoryList',$categoryList);
        if(!$categoryList){
            $this->redirect("/users/getlist/".$slug);
        }
        
    }
    
    // new function
    public function getSubIndustryList($model = 'User', $class = null){
        $this->layout = '';
        $indId = $this->data[$model]['industry_id'];
        $subIndustryList = $this->Industry->getSubIndustryList($indId);
        $this->set('subIndustryList', $subIndustryList);
        $this->set('class', $class);
        $this->set('model', $model);
    }
    
    public function admin_getSubIndustryList($model = 'User'){
        $this->layout = '';
        $indId = $this->data[$model]['industry_id'];
        $subIndustryList = $this->Industry->getSubIndustryList($indId);
        $this->set('subIndustryList', $subIndustryList);
    }
    
}?>
