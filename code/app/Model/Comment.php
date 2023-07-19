<?php

class Comment extends AppModel {

    public $name = 'Comment';
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'from_user_id',
            'fields' => 'User.id, User.company_name, User.unique_id, User.company_logo, User.slug'
        )
    ); 
}
?>