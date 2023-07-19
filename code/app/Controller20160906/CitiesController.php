<?php
class CitiesController extends AppController {

    public $name = 'Cities';
    public $uses = array('Admin', 'User','State', 'City');
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

    public function admin_index($stateslug=null) {
        $this->layout = "admin";
        $this->set('stateListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Manage Cities");

        $stateInfo = $this->State->findBySlug($stateslug);
        $this->set('stateslug',$stateslug);
        if($stateInfo){
            $stateId = $stateInfo['State']['id'];
            $this->set('stateInfo',$stateInfo);
        }else{
            $this->Session->write('error_msg', 'Invalide URL');
            $this->redirect(array('controller'=>'states','action'=>'index'));
        }

        $condition = array('City.state_id'=>$stateId);
        $separator = array();
        $urlSeparator = array();
        $name = '';

        if (!empty($this->data)) {
            if (isset($this->data['City']['city_name']) && $this->data['City']['city_name'] != '') {
                $name = trim($this->data['City']['city_name']);
            }

            if (isset($this->data['City']['action'])) {
                $idList = $this->data['City']['idList'];
                if ($idList) {
                    if ($this->data['City']['action'] == "activate") {
                        $cnd = array("City.id IN ($idList) ");
                        $this->City->updateAll(array('City.status' => "'1'"), $cnd);
                    } elseif ($this->data['City']['action'] == "deactivate") {
                        $cnd = array("City.id IN ($idList) ");
                        $this->City->updateAll(array('City.status' => "'0'"), $cnd);
                    } elseif ($this->data['City']['action'] == "delete") {
                        $cnd = array("City.id IN ($idList) ");
                        $this->City->deleteAll($cnd);
                    }
                }
            }
        } elseif (!empty($this->params)) {
            if (isset($this->params['named']['city_name']) && $this->params['named']['city_name'] != '') {
                $name = urldecode(trim($this->params['named']['city_name']));
            }
        }

        if (isset($name) && $name != '') {
            $separator[] = 'city_name:' . urlencode($name);
            $condition[] = " (City.city_name like '%" . addslashes($name) . "%') ";
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

        $this->paginate['City'] = array(
            'conditions' => $condition,
            'order' => array('City.city_name' => 'ASC'),
            'limit' => '50'
        );

        $this->set('cities', $this->paginate('City', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/cities/';
            $this->render('index');
        }
    }

     public function admin_add($stateslug=null) {
        $this->set('stateListAct', 1);
        $msgString = "";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Add City");

        $stateInfo = $this->State->findBySlug($stateslug);
        $this->set('stateslug',$stateslug);
        if($stateInfo){
            $stateId = $stateInfo['State']['id'];
            $this->set('stateInfo',$stateInfo);
        }else{
            $this->Session->write('error_msg', 'Invalide URL');
            $this->redirect(array('controller'=>'states','action'=>'index'));
        }

        if ($this->data) {
            $this->request->data["City"]["city_name"] = trim($this->data["City"]["city_name"]);
            if (empty($this->data["City"]["city_name"])) {
                $msgString .="-City is required field.<br>";
            }elseif ($this->City->isRecordUniqueCity($this->data["City"]["city_name"],$stateId) == false) {
                $msgString .="-City already exists.<br>";
            }

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
            	$this->request->data['City']['slug'] = $this->stringToSlugUnique($this->data["City"]["city_name"],'City');
                $this->request->data['City']['status'] = '1';
                $this->request->data['City']['state_id'] = $stateId;
                if ($this->City->save($this->data)) {
                    $this->Session->setFlash('City added successfully', 'success_msg');
                    $this->redirect('/admin/cities/index/'.$stateslug);
                }
            }
        }
    }


     public function admin_edit($slug = null,$stateslug=null) {

        $this->set('stateListAct', 1);
        $msgString = "";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Edit City");

        $stateInfo = $this->State->findBySlug($stateslug);
        $this->set('stateslug',$stateslug);
        if($stateInfo){
            $stateId = $stateInfo['State']['id'];
            $this->set('stateInfo',$stateInfo);
        }else{
            $this->Session->write('error_msg', 'Invalide URL');
            $this->redirect(array('controller'=>'states','action'=>'index'));
        }

        if ($this->data) {
            $this->request->data["City"]["city_name"] = trim($this->data["City"]["city_name"]);
            if (empty($this->data["City"]["city_name"])) {
                $msgString .="- City is required field.<br>";
            }elseif(strtolower($this->data["City"]["old_name"]) != strtolower($this->data["City"]["city_name"])){
                $this->request->data['City']['slug'] = $this->stringToSlugUnique($this->data["City"]["city_name"],'City');
                if ($this->City->isRecordUniqueCity($this->data["City"]["city_name"],$stateId) == false) {
                    $msgString .="- City already exists.<br>";
                }
            }

            

            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                if ($this->City->save($this->data)) {
                    $this->Session->setFlash('City updated successfully', 'success_msg');
                    $this->redirect('/admin/cities/index/'.$stateslug);
                }
            }
        }else{
            $id = $this->City->field('id', array('City.slug' => $slug));
            $this->City->id = $id;
            $this->data = $this->City->read();
            $this->request->data['City']['old_name'] = $this->data['City']['city_name'];
        }
    }
    
    public function admin_activateCity($slug = NULL, $stateSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->City->field('id', array('City.slug' => $slug));
            $cnd = array("City.id = $id");
            $this->City->updateAll(array('City.status' => "'1'"), $cnd);
            $this->set('action', '/admin/cities/deactivateCity/' . $slug);
            $this->set('id', $id);
            $this->set('status', 1);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_deactivateCity($slug = NULL, $parentSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->City->field('id', array('City.slug' => $slug));
            $cnd = array("City.id = $id");
            $this->City->updateAll(array('City.status' => "'0'"), $cnd);
            $this->set('action', '/admin/cities/activateCity/' . $slug);
            $this->set('id', $id);
            $this->set('status', 0);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }
    
    public function admin_delete($slug = null, $stateslug = null) {
        $id = $this->City->field('id', array('City.slug' => $slug));
        if ($id) {
            $this->City->delete($id);
            $this->Session->setFlash('City deleted successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');                
        }
        $this->redirect(array('controller'=>'cities','action'=>'index', $stateslug, 'page'=>$this->passedArgs["page"]));
    }
 
        
}?>
