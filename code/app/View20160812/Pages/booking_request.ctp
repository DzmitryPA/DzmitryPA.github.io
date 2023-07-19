<?php echo $this->element('account_menu'); 

if($this->Session->read('user_type') == 'Driver'){
    $controller = 'drivers';
}elseif($this->Session->read('user_type') == 'Company'){
    $controller = 'companies';
}else{
    $controller = 'users';
}
?>

<div class="container">    
    <div class="clear"></div>
    <?php echo $this->element('side_menu'); ?>
    <div class="sec_right_bbbox">
        <?php echo $this->element('top_menu'); ?>
        <?php echo $this->Session->flash(); ?>
        <div class="clear"></div>
        <div class="change_div_box my_pro_ffl">
            <div class="pro_user_title_name">Booking Request</div>
            <div class="clear"></div>

		
			<div class="profile_box_fff_fill">
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Job ID <span>:</span></div>
                    <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Customer Name <span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Package Details <span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Number of Item <span>:</span></div>
                    <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Collection Address <span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                
                
                
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Collection Date <span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Collection Time<span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Delivery Address <span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                
                
                
                
                
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Delivery Date <span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Delivery Time<span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Special Request <span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                
                
                
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Tips <span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Price<span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Driver name <span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                
                
                
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Taxi number<span>:</span></div>
                     <div class="use_input">
                            <?php echo $this->Form->text('User.last_name', array('maxlength' => '255','label' => '', 'div' => false, 'class' => "data_right_sec_name input_bot_border required", 'placeholder' => 'Last Name')) ?>  
                        </div>
                </div>
                <div class="row_fill_prod">
                    <div class="data_left_sec_name">Status by of the booking <span>:</span></div>
                     <div class="use_input">
                     	<div class="data_right_sec_name data_hhhin">
                            <label><input type="radio" name="accept" />Accepted by the driver</label>
                            <label><input type="radio" name="accept" />Canceled by the customer</label>
                        </div>
                        </div>
                </div>
                
                
                
                
                <div class="use_input use_inputde pad_box data_center">
                        <input class="submit_bt_log no_left" value="Submit" type="submit">
                
            </div>

            </div>
        </div>
    </div>
</div>
	  