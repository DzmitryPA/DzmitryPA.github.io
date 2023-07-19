<?php

class Watch extends AppModel {

    public $name = 'Watch';
    var $belongsTo = array(
        'FromWatch' => array(
            'className' => 'User',
            'conditions' => 'FromWatch.id = Watch.from_watch_id',
            'foreignKey' => '',
            'fields' => 'FromWatch.company_name, FromWatch.unique_id',
            'dependent' => true
        ),
        'Industry' => array(
            'className' => 'Industry',
            'conditions' => 'Industry.id = FromWatch.industry_id',
            'foreignKey' => '',
            'dependent' => true
        ),
   );
 
}