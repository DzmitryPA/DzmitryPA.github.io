<?php

/**
 * @abstract This model class is written for Category Model for this project
 * @Package MOdel
 * @category Model
 * @author Logicspice(info@logicspice.com)
 * @since 1.0.0 15-Mar-12
 * @copyright Copyright & Copy ; 2012, Logicspice Consultancy Pvt. Ltd., Jaipur
 *
 */
class Industry extends AppModel {

    public $name = 'Industry';
    var $belongsTo = array(
        'Parent' => array(
            'className' => 'Industry',
            'foreignKey' => 'parent_id'
        )
    );
    
    
    public function getList(){
        $list = $this->find('list', array('conditions'=>array('Industry.status'=>1, 'parent_id'=>0), 'fields'=>array('Industry.id', 'Industry.name'), 'order'=>array('Industry.name ASC')));
        return $list;
    }
    
    public function getSubIndustryList($indId){
        $list = $this->find('list', array('conditions'=>array('Industry.status'=>1, 'Industry.parent_id'=>$indId), 'fields'=>array('Industry.id', 'Industry.name'), 'order'=>array('Industry.name ASC')));
        return $list;
    }
    
    
     function isRecordUniqueCategory($category_name = null,$parent_id = '0') {
        $resultUser = $this->find('count', array('conditions' =>"Industry.name = '" . addslashes($category_name) . "' AND Industry.parent_id = '".$parent_id."'"));
        if ($resultUser) {
            return false;
        } else {
            return true;
        }
    }

}

?>