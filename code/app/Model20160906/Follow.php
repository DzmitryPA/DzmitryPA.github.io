<?php

class Follow extends AppModel {

    public $name = 'Follow';
    var $belongsTo = array(
        'Follower' => array(
            'className' => 'User',
            'conditions' => 'Follower.id = Follow.follower_id',
            'foreignKey' => '',
            'dependent' => true
        ),
        'Following' => array(
            'className' => 'User',
            'conditions' => 'Following.id = Follow.following_id',
            'foreignKey' => '',
            'dependent' => true
        )
   );
 
}