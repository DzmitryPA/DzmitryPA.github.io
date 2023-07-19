<?php 
$reurnUrl = '/users/dashboard';
if($this->Session->read('returnUrl') !=''){
    $reurnUrl = '/'.$this->Session->read('returnUrl');
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#userlogin").validate({
            submitHandler: function(form) {
                $(".ee").html('');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>/users/login',
                    data: $("#userlogin").serialize(),
                    beforeSend: function() { $("#sub_btn_dive").hide(); $("#sub_btn_dive_loader").show();},
                    success: function(result) {
                        if (result == 1) {
                            $('#errormessage').html('<div class="alert alert-success fade in">Login sucessfully...</div>');
                            window.location.href = '<?php echo HTTP_PATH.$reurnUrl; ?>';
                        } else {
                            $("#sub_btn_dive").show(); $("#sub_btn_dive_loader").hide();
                            $('#errormessage').html('<div class="alert alert-block alert-danger fade in">' + result + '</div>');
                        }
                    }
                });
            }
        });
        
        $("#userForgot").validate({
            submitHandler: function(form) {
                $(".ee").html('');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>/users/forgotPassword',
                    data: $("#userForgot").serialize(),
                    dataType: "text",
                    beforeSend: function() { $("#sub_btn_dive_fr").hide(); $("#sub_btn_dive_loader_fr").show();},
                    success: function(result) {
                        if (result == 1) {
                            $("#sub_btn_dive_fr").show(); $("#sub_btn_dive_loader_fr").hide();
                            $('#errormessagefr').html('<div class="alert alert-success fade in">A link to reset your password has been sent to your email address.</div>');
                        } else {
                            $("#sub_btn_dive_fr").show(); $("#sub_btn_dive_loader_fr").hide();
                            $('#errormessagefr').html('<div class="alert alert-block alert-danger fade in">' + result + '</div>');
                        }
                    }
                });
            }
        });
    });

 function showForgotPassword(){
   $('#loginf').hide();
   $('#forgotpass').show();
  }
 function showLogin(){
   $('#forgotpass').hide();
   $('#loginf').show();
 }
</script>  
<div class="right_part_fulls">
    <div class="login_section_full_box">
        <div class="login_section_full" id="loginf">
            <div class="title_of_sjsda">Login</div>
            <div class="ee" id="errormessage"></div>
            <div class="ee"><?php echo $this->Session->flash(); ?></div>
            <div class="clear"></div>
            
            <?php echo $this->Form->create(Null, array('id' => 'userlogin')); ?>
                <div class="col_row_sjde">
                    <?php echo $this->Form->text('User.email_address', array('class' => "form_secinpurs required email", 'placeholder'=>'Email address', 'autocomplete'=>'off')); ?>
                </div>
                <div class="col_row_sjde">
                    <?php echo $this->Form->password('User.password', array('class' => "form_secinpurs required", 'placeholder'=>'Password', 'autocomplete'=>'off')); ?>
                </div>
                <div class="col_row_sjde col_row_sjde_rev">                    
                    <div class="col_tow_logns remember_secsd">
                        <?php echo $this->Form->checkbox('User.rememberme', array('value' => '1', 'id'=>'remember_sec', 'class'=>'check_rem')); ?>
                        <label for="remember_sec"><span><span></span></span><em>Remember Me</em></label>
                    </div>
                    <div class="col_tow_logns forgot_pass_sec">
                        <?php echo $this->Html->link('Forgot your Password?', 'javascript:void(0);', array('escape' => false, 'onclick'=>'showForgotPassword()')); ?>
                    </div>
                </div>
                <div class="clear"></div>

                <div class="btn_form_end_row" id="sub_btn_dive">
                    <input type="submit" name="submit" value="Login" class="log_btn_sjaerk"/>
                </div>
                <div class="btn_form_end_row" id="sub_btn_dive_loader" style="display: none;">
                    <div class="btm_loader"> <?php echo $this->Html->image('loading.svg');?> Please wait...</div>
                </div>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <div class="login_section_full" id="forgotpass" style="display: none;">
            <div class="title_of_sjsda">Forgot Password</div>
            <div class="ee" id="errormessagefr"></div>
            <div class="ee"><?php echo $this->Session->flash(); ?></div>
            <div class="clear"></div>
            
            <?php echo $this->Form->create(Null, array('id' => 'userForgot')); ?>
                <div class="col_row_sjde">
                    <?php echo $this->Form->text('User.email_address', array('class' => "form_secinpurs required email", 'placeholder'=>'Email address', 'autocomplete'=>'off')); ?>
                </div>
                <div class="clear"></div>
                <div class="btn_form_end_row" id="sub_btn_dive_fr">
                    <input type="submit" name="submit" value="Submit" class="log_btn_sjaerk"/>
                </div>
                <div class="btn_form_end_row" id="sub_btn_dive_loader_fr" style="display: none;">
                    <div class="btm_loader"> <?php echo $this->Html->image('loading.svg');?> Please wait...</div>
                </div>
                <div class="col_tow_logns frlogin">
                    <?php echo $this->Html->link('I got my password login now', 'javascript:void(0);', array('escape' => false, 'onclick'=>'showLogin();')); ?>
                </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>