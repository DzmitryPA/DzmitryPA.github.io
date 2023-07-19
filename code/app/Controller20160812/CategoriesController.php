<?php
class CategoriesController extends AppController {

    public $name = 'Categories';
    public $uses = array('Admin', 'User','Category');
    public $helpers = array('Html', 'Form', 'Paginator','Javascript', 'Ajax', 'Js','Text','Number');
    public $paginate = array('limit' => '50', 'page' => '1', 'order' => array('Category.name' => 'asc'));
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
        $this->set('catListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Manage Categories');
        
        $condition = array('Category.parent_id'=>0);
        $separator = array();
        $urlSeparator = array();
       
        if (!empty($this->data)) {
            if (isset($this->data['Category']['keyword']) && $this->data['Category']['keyword'] != '') {
                $keyword = trim($this->data['Category']['keyword']);
            }
        
            if (isset($this->data['Category']['action'])) {
                $idList = $this->data['Category']['idList'];
                if ($idList) {
                    if ($this->data['Category']['action'] == "activate") {
                        $cnd = array("Category.id IN ($idList) ");
                        $this->Category->updateAll(array('Category.status' => "'1'"), $cnd);
                    } elseif ($this->data['Category']['action'] == "deactivate") {
                        $cnd = array("Category.id IN ($idList) ");
                        $this->Category->updateAll(array('Category.status' => "'0'"), $cnd);
                    } elseif ($this->data['Category']['action'] == "delete") {
                        $cnd = array("Category.id IN ($idList) ");
                        $cnd1 = array("Category.parent_id IN ($idList) ");
                        $this->Category->deleteAll($cnd);
                        $this->Category->deleteAll($cnd1);
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
            $condition[] = " (Category.name like '%" . addslashes($keyword) . "%')  ";
            $this->set('keyword', $keyword);
        }
        
        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);
    
        $this->paginate['Category'] = array(
            'conditions' => $condition,
            'order' => array('Category.id' => 'DESC'),
            'limit' => '50'
        );
        
        $this->set('categories', $this->paginate('Category', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/categories/';
            $this->render('index');
        }
    }

    public function admin_add() {
        $this->layout = "admin";
        $this->set('catAdd', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Add Category');
        $msgString = '';
        if ($this->data) {
            $this->request->data["Category"]["name"] = trim($this->data["Category"]["name"]);
            if (empty($this->data["Category"]["name"])) {
                $msgString .="- Category Name is required field.<br>";
            }elseif ($this->Category->isRecordUniqueCategory($this->data["Category"]["name"],0) == false) {
                $msgString .="- Category Name already exists.<br>";
            }
            
            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data['Category']['slug'] = $this->stringToSlugUnique($this->data["Category"]["name"],'Category');
                $this->request->data['Category']['status'] = '1';
                if ($this->Category->save($this->data)) {
                    $this->Session->setFlash('Category Added Successfully', 'success_msg');
                    $this->redirect(array('controller'=>'categories', 'action'=>'index'));
                }
            }
        }
    }

    public function admin_edit($slug = null) {
        $this->layout = "admin";
        $this->set('catListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Edit Category');
        $msgString = '';
        if ($this->data) {
            $this->request->data["Category"]["name"] = trim($this->data["Category"]["name"]);
            if (empty($this->data["Category"]["name"])) {
                $msgString .="- Category Name is required field.<br>";
            }elseif(strtolower($this->data["Category"]["old_name"]) != strtolower($this->data["Category"]["name"])){
                if ($this->Category->isRecordUniqueCategory($this->data["Category"]["name"],0) == false) {
                    $msgString .="- Category Name already exists.<br>";
                }
                $this->request->data['Category']['slug'] = $this->stringToSlugUnique($this->data["Category"]["name"],'Category');
            }
            
            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                
                if ($this->Category->save($this->data)) {
                    $this->Session->setFlash('Category Updated Successfully', 'success_msg');
                    $this->redirect(array('controller'=>'categories', 'action'=>'index', 'page'=>$this->passedArgs["page"]));
                }
            }
        }else{
            $this->data = $this->Category->findBySlug($slug);
            $this->request->data['Category']['old_name'] = $this->data['Category']['name'];
        }
    }

    public function admin_activateCategory($slug = NULL, $parentSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Category->field('id', array('Category.slug' => $slug));
            $cnd = array("Category.id = $id");
            $this->Category->updateAll(array('Category.status' => "'1'"), $cnd);
            $this->set('action', '/admin/categories/deactivateCategory/' . $slug);
            $this->set('id', $id);
            $this->set('status', 1);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_deactivateCategory($slug = NULL, $parentSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Category->field('id', array('Category.slug' => $slug));
            $cnd = array("Category.id = $id");
            $this->Category->updateAll(array('Category.status' => "'0'"), $cnd);
            $this->set('action', '/admin/categories/activateCategory/' . $slug);
            $this->set('id', $id);
            $this->set('status', 0);


            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_delete($slug = null) {
        $id = $this->Category->field('id', array('Category.slug' => $slug));
        if ($id) {
            $this->Category->deleteAll(array('Category.parent_id'=>$id));
            $this->Category->delete($id);
            $this->Session->setFlash('Category deleted successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');                
        }
        $this->redirect(array('controller'=>'categories','action'=>'index', 'page'=>$this->passedArgs["page"]));
    }


   public function admin_subcategory($cslug=null) {
        $this->layout = "admin";
        $this->set('catListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Manage Sub Categories");

        $catInfo = $this->Category->findBySlug($cslug);
        $this->set('cslug',$cslug);
        if($catInfo){
            $catId = $catInfo['Category']['id'];
            $this->set('catInfo',$catInfo);
        }else{
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller'=>'industries','action'=>'index'));
        }

        $condition = array('Category.parent_id'=>$catId);
        $separator = array();
        $urlSeparator = array();
        $name = '';

        if (!empty($this->data)) {
            if (isset($this->data['Category']['name']) && $this->data['Category']['name'] != '') {
                $name = trim($this->data['Category']['name']);
            }

            if (isset($this->data['Category']['action'])) {
                $idList = $this->data['Category']['idList'];
                if ($idList) {
                    if ($this->data['Category']['action'] == "activate") {
                        $cnd = array("Category.id IN ($idList) ");
                        $this->Category->updateAll(array('Category.status' => "'1'"), $cnd);
                    } elseif ($this->data['Category']['action'] == "deactivate") {
                        $cnd = array("Category.id IN ($idList) ");
                        $this->Category->updateAll(array('Category.status' => "'0'"), $cnd);
                    } elseif ($this->data['Category']['action'] == "delete") {
                        $cnd = array("Category.id IN ($idList) ");
                        $cnd1 = array("Category.parent_id IN ($idList) ");
                      
                        $this->Category->deleteAll($cnd);
                        $this->Category->deleteAll($cnd1);
                      
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
            $condition[] = " (Category.name like '%" . addslashes($name) . "%') ";
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

        $this->paginate['Category'] = array(
            'conditions' => $condition,
            'order' => array('Category.id' => 'DESC'),
            'limit' => '50'
        );

        $this->set('subcategories', $this->paginate('Category', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/categories/';
            $this->render('subcategory');
        }
    }

     public function admin_addsubcategory($cslug=null) {
        $this->set('catListAct', 1);
        $msgString = "";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Add Sub Category");

        $catInfo = $this->Category->findBySlug($cslug);
        $this->set('cslug',$cslug);
        if($catInfo){
            $catId = $catInfo['Category']['id'];
            $this->set('catInfo',$catInfo);
        }else{
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller'=>'categories','action'=>'index'));
        }

        if ($this->data) {
            
            $this->request->data["Category"]["name"] = trim($this->data["Category"]["name"]);
            if (empty($this->data["Category"]["name"])) {
                $msgString .="-Sub Category Name is required field.<br>";
            }elseif ($this->Category->isRecordUniqueCategory($this->data["Category"]["name"],$catId) == false) {
                $msgString .="-Sub Category Name already exists.<br>";
            }

            

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
            	$this->request->data['Category']['slug'] = $this->stringToSlugUnique($this->data["Category"]["name"],'Category');
                $this->request->data['Category']['status'] = '1';
                $this->request->data['Category']['parent_id'] = $catId;
                if ($this->Category->save($this->data)) {
                    $this->Session->setFlash('Sub Category added successfully', 'success_msg');
                    $this->redirect('/admin/categories/subcategory/'.$cslug);
                }
            }
        }
    }


     public function admin_editsubcategory($slug = null,$cslug=null) {

        $this->set('catListAct', 1);
        $msgString = "";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Edit Sub Category");

        $catInfo = $this->Category->findBySlug($cslug);
        $this->set('cslug',$cslug);
        if($catInfo){
            $catId = $catInfo['Category']['id'];
            $this->set('catInfo',$catInfo);
        }else{
            $this->Session->setFlash('Invalide URL', 'error_msg');
            $this->redirect(array('controller'=>'categories','action'=>'index'));
        }

        if ($this->data) {
            
            $this->request->data["Category"]["name"] = trim($this->data["Category"]["name"]);
            if (empty($this->data["Category"]["name"])) {
                $msgString .="- Sub Category Name  is required field.<br>";
            }elseif(strtolower($this->data["Category"]["old_name"]) != strtolower($this->data["Category"]["name"])){
                $this->request->data['Category']['slug'] = $this->stringToSlugUnique($this->data["Category"]["name"],'Category');
                if ($this->Category->isRecordUniqueCategory($this->data["Category"]["name"],0) == false) {
                    $msgString .="- Sub Category Name already exists.<br>";
                }
            }

            

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                if ($this->Category->save($this->data)) {
                    $this->Session->setFlash('Sub Category Updated Successfully', 'success_msg');
                    $this->redirect('/admin/categories/subcategory/'.$cslug);
                }
            }
        }else{
            $id = $this->Category->field('id', array('Category.slug' => $slug));
            $this->Category->id = $id;
            $this->data = $this->Category->read();
            $this->request->data['Category']['old_name'] = $this->data['Category']['name'];
        }
    }
    
    public function admin_deletesubcategory($slug = NULL, $main_category_slug = null) {
        if ($slug != '') {
            if (!empty($main_category_slug)) {
                $mainCategoryDetail = $this->Category->findBySlug($main_category_slug);
                if (empty($mainCategoryDetail) || $mainCategoryDetail['Category']['parent_id'] != 0) {
                    $this->Session->setFlash('Wrong URL access.', 'error_msg');
                    $this->redirect(array('controller' => 'categories', 'action' => 'index', ''));
                }
            }
            $id = $this->Category->field('id', array('Category.slug' => $slug));
            $this->Category->delete($id);
            $this->Session->setFlash('Sub Category deleted successfully.', 'success_msg');
            $this->redirect(array('controller' => 'categories', 'action' => 'subcategory', $main_category_slug));
        }
    }
    
    public function admin_getsubcategory(){
        $this->layout = '';
        $categoryId = $this->data['Product']['category_id'];
        $subcatlist = $this->Category->find('list', array('conditions' => array('status' => 1, 'parent_id' => $categoryId), 'fields' => array('id', 'name'), 'order' => array('name' => 'ASC')));
        $this->set('subcatlist', $subcatlist);
    }
    
    
    public function index() {
        $this->layout = "client";
        $this->set('category_list', 1);
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
    
}?>
