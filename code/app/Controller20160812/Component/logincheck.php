<?php
class LogincheckComponent extends Object{

          function userLoginCheck(){
           $userid   = $this->Session->read('user_id');
            if(empty($userid)){
                $msgString  =   "Please Login";
                $this->Session->write("message",$msgString);
                $this->redirect("/");
              }
           }




}
?>