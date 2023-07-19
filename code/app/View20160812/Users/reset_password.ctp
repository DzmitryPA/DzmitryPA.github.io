<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod("passold", function (value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20})/.test(value));
        }, "Please enter correct password");
        
        $("#userlogin").validate({
            submitHandler: function(form) {
                $('#sub_btn_dive').hide();
                $('#sub_btn_dive_loader').show();
                $('#userlogin').submit();
            }
        });
        
        $('#UserPassword').keyup(function() { 
		
        var pswd = $(this).val();

        //validate the length
        if ( pswd.length < 8 ) {
                $('#length').removeClass('validpass').addClass('invalidpass');
        } else {
                $('#length').removeClass('invalidpass').addClass('validpass');
        }

        //validate letter
        if ( pswd.match(/[A-z]/) ) {
                $('#letter').removeClass('invalidpass').addClass('validpass');
        } else {
                $('#letter').removeClass('validpass').addClass('invalidpass');
        }

        //validate uppercase letter
        if ( pswd.match(/[A-Z]/) ) {
                $('#capital').removeClass('invalidpass').addClass('validpass');
        } else {$('stepcnt').val();
                $('#capital').removeClass('validpass').addClass('invalidpass');
        }

        //validate number
        if ( pswd.match(/\d/) ) {
                $('#number').removeClass('invalidpass').addClass('validpass');
        } else {
                $('#number').removeClass('validpass').addClass('invalidpass');
        }
		
	}).focus(function() {
		$('#pswd_info').show();
	}).blur(function() {
		$('#pswd_info').hide();
	});
    });
</script>  
<div class="right_part_fulls">
    <div class="login_section_full_box">
        <div class="login_section_full" id="loginf">
            <div class="title_of_sjsda">Reset Password</div>
            <div class="ee" id="errormessage"></div>
            <div class="ee"><?php echo $this->Session->flash(); ?></div>
            <div class="clear"></div>
            <?php echo $this->Form->create(Null, array('id' => 'userlogin')); ?>
                <div class="col_row_sjde">
                    <?php echo $this->Form->password('User.password', array('class' => "form_secinpurs required passold", 'placeholder'=>'Password', 'autocomplete'=>'off')); ?>
                    <div id="pswd_info">
                            <h4>Password must meet the following requirements:</h4>
                            <ul>
                                <li id="letter" class="invalidpass">At least <strong>one letter</strong></li>
                                <li id="capital" class="invalidpass">At least <strong>one capital letter</strong></li>
                                <li id="number" class="invalidpass">At least <strong>one number</strong></li>
                                <li id="length" class="invalidpass">Be at least <strong>8 characters</strong></li>
                            </ul>
                    </div>
                </div>
                <div class="col_row_sjde">
                    <?php echo $this->Form->password('User.confirm_password', array('class' => "form_secinpurs required", 'placeholder'=>'Confirm Password', 'autocomplete'=>'off', 'equalTo'=>'#UserPassword')); ?>
                </div>
                
                <div class="clear"></div>

                <div class="btn_form_end_row" id="sub_btn_dive">
                    <input type="submit" name="submit" value="Submit" class="log_btn_sjaerk"/>
                </div>
                <div class="btn_form_end_row" id="sub_btn_dive_loader" style="display: none;">
                    <div class="btm_loader"> <?php echo $this->Html->image('loading.svg');?> Please wait...</div>
                </div>
                <?php echo $this->Form->hidden('User.id', array('value' => $userId)) ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>