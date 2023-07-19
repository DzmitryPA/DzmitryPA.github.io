<?php 

/**
 * @abstract This controller Created for Default controller of the site.
 * @Package Controller
 * @category Controller
 * @author Logicspice(info@logicspice.com)
 * @since 1.0.0 2014-10-17
 * @copyright Copyright & Copy ; 2014, Logicspice Consultancy Pvt. Ltd., Jaipur
 *
 */
class HomesController extends AppController {
    
    public $uses = array('Admin', 'Page', 'Emailtemplate', 'User', 'Setting');
    public $helpers = array('Html', 'Form', 'Fck', 'Javascript', 'Ajax', 'Text', 'Number', 'Js');
    public $paginate = array('limit' => '20', 'page' => '1', 'order' => array('User.id' => 'DESC'));
    public $components = array('RequestHandler', 'Email', 'Upload', 'PImageTest', 'PImage', 'Captcha', 'Common');
    
    public function admin_index() {
        $this->layout = "admin";
        $this->set('title_for_layout', TITLE_FOR_PAGES . "Projects List");
        $this->set('project_list', 'active');
        
        $condition = array();
        $separator = array();
        $urlSeparator = array();
        ;
        $status = '';
        $userName = '';
        $searchByDateFrom = '';
        $searchByDateTo = '';

        if (!empty($this->data)) {
            //pr($this->data); exit;
            if (isset($this->data["User"]['userName']) && $this->data["User"]['userName'] != '') {
                $userName = trim($this->data["User"]['userName']);
            }

            if (isset($this->data["User"]['searchByDateFrom']) && $this->data["User"]['searchByDateFrom'] != '') {
                $searchByDateFrom = trim($this->data["User"]['searchByDateFrom']);
            }

            if (isset($this->data["User"]['searchByDateTo']) && $this->data["User"]['searchByDateTo'] != '') {
                $searchByDateTo = trim($this->data["User"]['searchByDateTo']);
            }

            if (isset($this->data["User"]['action'])) {
                $idList = $this->data["User"]['idList'];
                if ($idList) {
                    if ($this->data["User"]['action'] == "activate") {
                        $cnd = array("User.id IN ($idList) ");
                        $this->User->updateAll(array('User.status' => "'1'"), $cnd);
                    } elseif ($this->data["User"]['action'] == "deactivate") {
                        $cnd = array("User.id IN ($idList) ");
                        $this->User->updateAll(array('User.status' => "'0'"), $cnd);
                    } elseif ($this->data["User"]['action'] == "delete") {
                        $cnd = array("User.id IN ($idList) ");
                        $this->User->deleteAll($cnd);
                    }
                }
            }
        } elseif (!empty($this->params)) {
            if (isset($this->params['named']['userName']) && $this->params['named']['userName'] != '') {
                $userName = urldecode(trim($this->params['named']['userName']));
            }
            if (isset($this->params['named']['searchByDateFrom']) && $this->params['named']['searchByDateFrom'] != '') {
                $searchByDateFrom = urldecode(trim($this->params['named']['searchByDateFrom']));
            }
            if (isset($this->params['named']['status']) && $this->params['named']['status'] != '') {
                $status = urldecode(trim($this->params['named']['status']));
            }
            if (isset($this->params['named']['searchByDateTo']) && $this->params['named']['searchByDateTo'] != '') {
                $searchByDateTo = urldecode(trim($this->params['named']['searchByDateTo']));
            }
        }

        if (isset($userName) && $userName != '') {
            $separator[] = 'userName:' . urlencode($userName);
            $userName = str_replace('_', '\_', $userName);
            //$condition[] = " (`User`.`first_name` LIKE '%" . addslashes($userName) . "%' or concat(`User.first_name`,' ',`User.last_name`) LIKE '%" . addslashes($userName) . "%' or `User`.`email_address` LIKE '%" . addslashes($userName) . "%' or `User`.`last_name` LIKE '%" . addslashes($userName) . "%') ";
            $condition[] = " (`User`.`name` LIKE '%" . addslashes($userName) . "%' OR `User`.`email_address` LIKE '%" . addslashes($userName) . "%') ";
            $userName = str_replace('\_', '_', $userName);
            $this->set('searchKey', $userName);
        }
        if (isset($status) && $status != '') {
            $separator[] = 'status:' . urlencode($status);
            $status = str_replace('_', '\_', $status);
            $condition[] = " (`User`.`status` =  '" . addslashes($status) . "') ";
            $status = str_replace('\_', '_', $status);
            $this->set('searchKey', $status);
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

        $order = 'User.id Desc';

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
        $this->set('searchByDateFrom', $searchByDateFrom);
        $this->set('searchByDateTo', $searchByDateTo);
        $_SESSION['searchByDateFrom'] = $searchByDateFrom;
        $_SESSION['searchByDateTo'] = $searchByDateTo;
        $_SESSION['userName'] = $userName;

        $urlSeparator = implode("/", $urlSeparator);
        $this->set('userName', $userName);
        $this->set('separator', $separator);
        $this->set('urlSeparator', $urlSeparator);
        $this->paginate['User'] = array('conditions' => $condition, 'limit' => '20', 'page' => '1', 'order' => $order);
        $this->set('users', $this->paginate('User'));


        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/projects';
            $this->render('index');
        }
    }
    
}