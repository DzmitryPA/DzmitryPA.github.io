<?php
class Admin extends AppModel{
	var $name	= 'Admin';
        function checkEmail($email_address = null){
                if(preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/", $email_address) === 0)
                {
                    return false;
                }
                else
                {
                    return true;
                }
        }


        function isEmailExist($conditions = null){
		$result=$this->find('count',array('conditions'=>$conditions));
		if($result){
			return false;
		}else{
			return true;
		}
	}
	
	
        function isPasswordExist($oldpassword,$admin_id){
            $adminDetail = $this->find('first', array('conditions' => array("(Admin.id = '" . $admin_id . "')")));
            return (is_array($adminDetail) && !empty($adminDetail) && crypt($oldpassword, $adminDetail['Admin']['password']) == $adminDetail['Admin']['password']);
        }      
       
	    
	    
        function chkAdminname($conditions = null){
           
		$result=$this->find('count',array('conditions'=>$conditions));

                if($result){                   
			return false;
		}else{
			return true;
		}
	}   
        
        
        function isRecordUniqueemail($email_address = null) {
    
            $resultUser = $this->find('count', array('conditions' => "Admin.email = '" . $email_address . "'"));
    
            if ($resultUser) {
                return false;
            } else {
                return true;
            }
        }
    
    
        function isRecordUniqueUsername($username = null) {
    
            $resultUser = $this->find('count', array('conditions' => "Admin.username = '" . $username . "'"));
    
            if ($resultUser) {
                return false;
            } else {
                return true;
            }
        }

	

}
?>