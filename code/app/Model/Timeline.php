<?php

class Timeline extends AppModel {

    public $name = 'Timeline';
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'fields' => 'User.id, User.company_name, User.unique_id, User.company_logo, User.slug'
        ),
        'Industry' => array(
            'className' => 'Industry',
            'foreignKey' => 'industry_id',
            'fields' => 'Industry.id, Industry.name'
        ),
        'IndustrySubCategory' => array(
            'className' => 'Industry',
            'foreignKey' => 'subindustry_id',
            'fields' => 'IndustrySubCategory.id, IndustrySubCategory.name'
        ),
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
            'fields' => 'State.id, State.state_name'
        ),
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'fields' => 'City.id, City.city_name'
        ),
    );
    
//    var $hasMany = array(
//       'Comment' => array(
//            'className' => 'Comment',
//            'foreignKey' => 'timeline_id',
//            'dependent' => true
//        )
//    );
}
?>