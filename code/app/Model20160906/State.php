<?php
class State extends AppModel {

    public $name = 'State';
    
    function isRecordUniqueState($state_name = null) {
        $resultUser = $this->find('count', array('conditions' =>"State.state_name = '" . addslashes($state_name) . "'"));
        if ($resultUser) {
            return false;
        } else {
            return true;
        }
    }

    public function getList(){
        $list = $this->find('list', array('conditions'=>array('State.status'=>1), 'fields'=>array('State.id', 'State.state_name'), 'order'=>array('State.state_name ASC')));
        return $list;
    }
   
}

?>