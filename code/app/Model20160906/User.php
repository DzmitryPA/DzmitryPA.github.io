<?php

class User extends AppModel {

    public $name = 'User';
    var $belongsTo = array(
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id'
        ),
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id'
        ),
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id'
        ),
        'Industry' => array(
            'className' => 'Industry',
            'foreignKey' => 'industry_id'
        ),
        'IndustrySubCategory' => array(
            'className' => 'Industry',
            'foreignKey' => 'subindustry_id'
        ),
    );

    function checkEmail($email_address = null) {
        if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

    function isRecordUniqueemail($email_address = null) {
        $resultUser = $this->find('count', array('conditions' => "User.email_address = '" . addslashes($email_address) . "'"));
        if ($resultUser) {
            return false;
        } else {
            return true;
        }
    }

    function isRecordCompany($companyName = null) {
        $resultUser = $this->find('count', array('conditions' => "User.company_name = '" . addslashes($companyName) . "'"));
        if ($resultUser) {
            return false;
        } else {
            return true;
        }
    }

    function isRecordUniqueID($unique_id = null) {
        $resultUser = $this->find('count', array('conditions' => "User.unique_id = '" . addslashes($unique_id) . "'"));
        if ($resultUser) {
            return false;
        } else {
            return true;
        }
    }


}

?>