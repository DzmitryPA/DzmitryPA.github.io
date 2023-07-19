<?php
class StatesController extends AppController {

    public $name = 'States';
    public $uses = array('Admin', 'User','State', 'City');
    public $helpers = array('Html', 'Form', 'Paginator','Javascript', 'Ajax', 'Js','Text','Number');
    public $paginate = array('limit' => '50', 'page' => '1', 'order' => array('State.state_name' => 'asc'));
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
        $this->set('stateListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Manage States');
        $condition = array();
        //$condition = array('State.country_id'=>2);
        $separator = array();
        $urlSeparator = array();
       
        if (!empty($this->data)) {
            //print_r($this->data);
            if (isset($this->data['State']['keyword']) && $this->data['State']['keyword'] != '') {
                $keyword = trim($this->data['State']['keyword']);
            }
        
            if (isset($this->data['State']['action'])) {
                $idList = $this->data['State']['idList'];
                if ($idList) {
                    if ($this->data['State']['action'] == "activate") {
                        $cnd = array("State.id IN ($idList) ");
                        $this->State->updateAll(array('State.status' => "'1'"), $cnd);
                    } elseif ($this->data['State']['action'] == "deactivate") {
                        $cnd = array("State.id IN ($idList) ");
                        $this->State->updateAll(array('State.status' => "'0'"), $cnd);
                    } elseif ($this->data['State']['action'] == "delete") {
                        $cnd = array("State.id IN ($idList) ");
                        $cnd1 = array("City.state_id IN ($idList) ");
                        $this->State->deleteAll($cnd);
                        $this->City->deleteAll($cnd1);
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
            $condition[] = " (State.state_name like '%" . addslashes($keyword) . "%')  ";
            $this->set('keyword', $keyword);
        }
        
        $separator = implode("/", $separator);
        $urlSeparator = implode("/", $urlSeparator);

        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);
    
        
        $this->paginate['State'] = array(
            'conditions' => $condition,
            'order' => array('State.state_name' => 'ASC'),
            'limit' => '50'
        );
        
        $this->set('states', $this->paginate('State', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/states/';
            $this->render('index');
        }
    }

    public function admin_add() {
        $this->layout = "admin";
        $this->set('stateAdd', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Add State');
        $msgString = '';
        if ($this->data) {
            $this->request->data["State"]["state_name"] = trim($this->data["State"]["state_name"]);
            if (empty($this->data["State"]["state_name"])) {
                $msgString .="- State is required field.<br>";
            }elseif ($this->State->isRecordUniqueState($this->data["State"]["state_name"]) == false) {
                $msgString .="- State already exists.<br>";
            }
            
            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                $this->request->data['State']['slug'] = $this->stringToSlugUnique($this->data["State"]["state_name"],'State');
                $this->request->data['State']['status'] = '1';
                
                /*For Country US => 2, to be changed if Multiple Country*/
                $this->request->data['State']['country_id'] = '2';
                
                if ($this->State->save($this->data)) {
                    $this->Session->setFlash('State Added Successfully', 'success_msg');
                    $this->redirect(array('controller'=>'states', 'action'=>'index'));
                }
            }
        }
    }

    public function admin_edit($slug = null) {
        $this->layout = "admin";
        $this->set('stateListAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Edit State');
        $msgString = '';
        if ($this->data) {
            $this->request->data["State"]["state_name"] = trim($this->data["State"]["state_name"]);
            if (empty($this->data["State"]["state_name"])) {
                $msgString .="- State is required field.<br>";
            }elseif(strtolower($this->data["State"]["old_name"]) != strtolower($this->data["State"]["state_name"])){
                if ($this->State->isRecordUniqueState($this->data["State"]["state_name"]) == false) {
                    $msgString .="- State already exists.<br>";
                }
                $this->request->data['State']['slug'] = $this->stringToSlugUnique($this->data["State"]["state_name"],'State');
            }
            
            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
                
                if ($this->State->save($this->data)) {
                    $this->Session->setFlash('State Updated Successfully', 'success_msg');
                    $this->redirect(array('controller'=>'states', 'action'=>'index', 'page'=>$this->passedArgs["page"]));
                }
            }
        }else{
            $this->data = $this->State->findBySlug($slug);
            $this->request->data['State']['old_name'] = $this->data['State']['state_name'];
        }
    }

    public function admin_activateState($slug = NULL, $parentSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->State->field('id', array('State.slug' => $slug));
            $cnd = array("State.id = $id");
            $this->State->updateAll(array('State.status' => "'1'"), $cnd);
            $this->set('action', '/admin/states/deactivateState/' . $slug);
            $this->set('id', $id);
            $this->set('status', 1);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_deactivateState($slug = NULL, $parentSlug = null) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->State->field('id', array('State.slug' => $slug));
            $cnd = array("State.id = $id");
            $this->State->updateAll(array('State.status' => "'0'"), $cnd);
            $this->set('action', '/admin/states/activateState/' . $slug);
            $this->set('id', $id);
            $this->set('status', 0);


            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_delete($slug = null) {
        $id = $this->State->field('id', array('State.slug' => $slug));
        if ($id) {
            $this->City->deleteAll(array('City.state_id'=>$id));
            $this->State->delete($id);
            $this->Session->setFlash('State deleted successfully', 'success_msg');
        } else {
            $this->Session->setFlash('No record deleted', 'error_msg');                
        }
        $this->redirect(array('controller'=>'states','action'=>'index', 'page'=>$this->passedArgs["page"]));
    }


     
    public function getCityList($model = 'User', $class = null){
        $this->layout = '';
        $stateId = $this->data[$model]['state_id'];
        $cityList = $this->City->getList($stateId);
        $this->set('cityList', $cityList);
        $this->set('class', $class);
    }
    
    public function admin_getCityList($model = 'User'){
        $this->layout = '';
        $stateId = $this->data[$model]['state_id'];
        $cityList = $this->City->getList($stateId);
        $this->set('cityList', $cityList);
    }
    
        
}?>
