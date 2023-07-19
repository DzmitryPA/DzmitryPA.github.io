<?php

class Service extends AppModel {

    public $name = 'Service';
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id'
        ),
        'SubCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'subcategory_id'
        )
    );
    var $hasMany = array(
       'ServiceImage' => array(
            'className' => 'ServiceImage',
            'foreignKey' => 'service_id',
            'dependent' => true
        )
        
    );

    public function getList(){
        $list = $this->find('list', array('conditions'=>array('Service.status'=>1), 'fields'=>array('Service.id', 'Service.name'), 'order'=>array('Service.name ASC')));
        return $list;
    }
}

?>