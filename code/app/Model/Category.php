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
class Category extends AppModel {

    public $name = 'Category';
    var $belongsTo = array(
        'Parent' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id'
        )
    );
    
     function isRecordUniqueCategory($category_name = null,$parent_id = '0', $type = '0') {
        $resultUser = $this->find('count', array('conditions' =>"Category.name = '" . addslashes($category_name) . "' AND Category.parent_id = '".$parent_id."' AND Category.type = '".$type."'"));
        if ($resultUser) {
            return false;
        } else {
            return true;
        }
    }
    
    public function getList($type = 0){
        $list = $this->find('list', array('conditions'=>array('Category.status'=>1, 'Category.parent_id'=>0, 'Category.type'=>$type), 'fields'=>array('Category.id', 'Category.name'), 'order'=>array('Category.name ASC')));
        return $list;
    }
    
    public function getSubCategoryList($catId){
        $list = $this->find('list', array('conditions'=>array('Category.status'=>1, 'Category.parent_id'=>$catId), 'fields'=>array('Category.id', 'Category.name'), 'order'=>array('Category.name ASC')));
        return $list;
    }


}

?>