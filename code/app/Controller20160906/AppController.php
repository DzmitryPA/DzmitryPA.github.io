<?php

class AppController extends Controller {

    var $uses = array("User");
    function beforeRender() {
        $this->_setErrorLayout();
    }

    function _setErrorLayout() {
      
        if ($this->name == 'CakeError') {
            $this->layout = '';
            $this->redirect("/homes/error");
        }
    }

    
  
    function userLoginCheck() {
        $returnUrl = $this->params->url;
        $userid = $this->Session->read("user_id");
        $isExists = $this->User->field('User.id', array('User.id' => $userid, 'User.activation_status' => 1, 'User.status' => 1));
        if (empty($isExists)) {
            $msgString = "Please Login";
            $this->Session->delete('user_id');
            $this->Session->delete('user_name');
            $this->Session->delete('email_address');
            $this->Session->delete('company_name');
            $this->Session->setFlash($msgString, 'error_msg');
            $this->Session->write("returnUrl", $returnUrl);
            $this->redirect(array('controller'=>'users', 'action'=>'login'));
        }
    }
    
    function userLoggedinCheck() {
        $userid = $this->Session->read("user_id");
        $isExists = $this->User->field('User.id', array('User.id' => $userid, 'User.activation_status' => 1, 'User.status' => 1));
        if (!empty($isExists)) {
            $this->redirect("/users/dashboard");
        } else {
            $this->Session->delete('user_id');
            $this->Session->delete('user_name');
            $this->Session->delete('email_address');
            $this->Session->delete('company_name');
            
        }
    }

    function emailExistCheck($email = null) {
        if (isset($email)) {
            $emailExist = $this->User->find("first", array("conditions" => array("User.email_address = '" . $email . "'", "User.status = 0")));
            if (!empty($emailExist)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function stringToSlugUnique($str, $modelName, $fieldName = 'slug') {
        $str = substr(strtolower($str), 0, 150);
        $str = Inflector::slug($str, '-');

        $check = $this->$modelName->find('first', array('fields' => array($modelName . '.slug'), 'conditions' => array($modelName . '.' . $fieldName . ' like' => $str . '%'), 'order' => array($modelName . '.id' => 'DESC')));
        if ($check) {
            $split = explode("-", $check[$modelName]['slug']);
            return $str . '-' . (end($split) + 1);
        } else {
            return $str;
        }
    }

    function stringToSlug($str, $modelName, $fieldName = 'slug') {
        if(!$modelName){
            $modelName = 'User';
        }
        $str = substr(strtolower($str), 0, 35);
        $str = Inflector::slug($str, '-');

        $check = $this->$modelName->find('first', array('fields' => array($modelName . '.slug'), 'conditions' => array($modelName . '.' . $fieldName . ' like' => $str . '%'), 'order' => array($modelName . '.id' => 'DESC')));
        if ($check) {
            $split = explode("-", $check[$modelName]['slug']);
            return $str . '-' . (end($split) + 1);
        } else {
            return $str;
        }
    }

    
    public function getExtension($str) {

        $i = strrpos($str, ".");

        if (!$i) {
            return "";
        }

        $l = strlen($str) - $i;

        $ext = substr($str, $i + 1, $l);

        return $ext;
    }
    
    public  function rand_string($length) {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }

    
}

?>
