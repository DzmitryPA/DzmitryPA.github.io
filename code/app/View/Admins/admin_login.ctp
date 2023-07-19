<?php 
$reurnUrl = '/admin/admins/dashboard';
if($this->Session->read('returnUrlAdmin') !=''){
    $reurnUrl = '/'.$this->Session->read('returnUrlAdmin');
}
?>
        

<script type="text/javascript">
    $(document).ready(function() {
        $("#adminlogin").validate({
            submitHandler: function(form) {
                $(".ee").html('');
                $("#msgID").hide();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>/admin/admins/login',
                    data: $("#adminlogin").serialize(),
                    dataType: "text",
                    beforeSend: function() {
                        $("#submitBtn").val('Processing..');
                    },
                    success: function(result) {
                        if (result == 1) {
                            window.location.href = '<?php echo HTTP_PATH.$reurnUrl; ?>';
                        } else {
                            $("#submitBtn").val('Login');
                            $('#errormessage').html('<div class="alert alert-block alert-danger fade in">' + result + '</div>');
                        }
                    }
                });
            }
        });
        
        $("#adminForgot").validate({
            submitHandler: function(form) {
                $("#msgID").hide();
                $(".ee").html('');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>/admin/admins/forgotPassword',
                    data: $("#adminForgot").serialize(),
                    dataType: "text",
                    beforeSend: function() {
                        $("#submitBtnFr").val('Processing..');
                    },
                    success: function(result) {
                        if (result == 1) {
                            $("#submitBtnFr").val('Submit');
                            $('#errormessagefr').html('<div class="alert alert-success fade in">Your password has been sent on your email id.</div>');
                        } else {
                            $("#submitBtnFr").val('Submit');
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
<div class="" id="loginf">
    <div class="login-logo">
        <b>Administrator Login</b>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <div class="ee" id="errormessage"></div>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Form->create(Null, array('id' => 'adminlogin')); ?>
            <div class="form-group has-feedback">
                <?php echo $this->Form->text('Admin.username', array('div' => false, 'class' => "form-control required", 'placeholder' => 'Username', 'autofocus')); ?>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php echo $this->Form->password('Admin.password', array('class' => "form-control required", 'placeholder' => 'Password')); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label><?php echo $this->Form->input('Admin.remember', ['type' => 'checkbox', 'label' => false, 'div' => false]); ?> Remember Me
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
        <?php echo $this->Form->submit('Login', array('class' => 'btn btn-primary btn-block btn-flat', 'id' => 'submitBtn')); ?>
            </div>
        </div>
<?php echo $this->Form->end(); ?>
<?php echo $this->Html->link('Forgot Password?', 'javascript:void(0)', array('onclick'=>'showForgotPassword()')); ?>
    </div>
</div>
<div class="" id="forgotpass" style="display: none;">
    <div class="login-logo">
        <b>Forgot Password</b>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Enter your e-mail address below to reset your password.</p>
        <div class="ee" id="errormessagefr"></div>
           <?php echo $this->Form->create(Null, array('id' => 'adminForgot')); ?>
        <div class="form-group has-feedback">
            <?php echo $this->Form->text('Admin.email', array('div' => false, 'class' => "form-control required email", 'placeholder' => 'Emaill Address', 'autofocus')); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <?php echo $this->Html->link('I got my password', 'javascript:void(0);', array('onclick'=>'showLogin();')); ?>
            </div>
            <div class="col-xs-4">
        <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-primary btn-block btn-flat', 'id' => 'submitBtnFr')); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
