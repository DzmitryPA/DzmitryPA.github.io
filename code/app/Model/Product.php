<?php

class Product extends AppModel {

    public $name = 'Product';
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
       'ProductImage' => array(
            'className' => 'ProductImage',
            'foreignKey' => 'product_id',
            'dependent' => true
        )
        
    );

    public function getList(){
        $list = $this->find('list', array('conditions'=>array('Product.status'=>1), 'fields'=>array('Product.id', 'Product.name'), 'order'=>array('Product.name ASC')));
        return $list;
    }
}

?>