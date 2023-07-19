<?php
class City extends AppModel {

    public $name = 'City';
    
    function isRecordUniqueCity($city_name = null,$state_id = null) {
        $resultUser = $this->find('count', array('conditions' =>"City.city_name = '" . addslashes($city_name) . "' AND City.state_id = '".$state_id."'"));
        if ($resultUser) {
            return false;
        } else {
            return true;
        }
    }

    public function getList($stateId =null){
        $list = $this->find('list', array('conditions'=>array('City.status'=>1, 'City.state_id'=>$stateId), 'fields'=>array('City.id', 'City.city_name'), 'order'=>array('City.city_name ASC')));
        return $list;
    }
   
}

?>