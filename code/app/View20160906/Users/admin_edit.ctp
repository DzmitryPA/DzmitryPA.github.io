<script type="text/javascript">
    $(document).ready(function () {

        $.validator.addMethod("passold", function (value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20})/.test(value));
        }, "Please enter correct password");

        $("#registerForm").validate({
            submitHandler: function (form) {
                var step = $('#stepcnt').val();
                if (step) {
                    if (step == 1) {
                        /*if ($('#companyname').val() == 0) {
                         alert('Company name already exist, please enter other name!');
                         } else if ($('#emailaddress').val() == 0) {
                         alert('Email address aready exist, please enter other email address!');
                         } else if ($('#uniqueid').val() == 0) {
                         alert('Unique ID aready exist, please enter other Unique ID!');
                         } else {*/
                        $('#stepcnt').val('2');
                        $('#step1').hide();
                        $('#step2').show();
                        //}
                    } else if (step == 2) {
                        $('#stepcnt').val('3');
                        $('#step2').hide();
                        $('#step3').show();
                    } else if (step == 3) {
                        $('#stepcnt').val('4');
                        $('#step3').hide();
                        $('#step4').show();
                    } else if (step == 4) {
                        $('#sub_btn_dive').hide();
                        $('#sub_btn_dive_loader').show();
                        $('#registerForm').submit();
                    }
                }
            }
        });


        $('#UserCompanyName').click(function () {
            $("#cname_result").html('');
        });
        $('#UserEmailAddress').click(function () {
            $("#email_result").html('');
        });


        $('#UserNewPassword').keyup(function () {

            var pswd = $(this).val();

            //validate the length
            if (pswd.length < 8) {
                $('#length').removeClass('validpass').addClass('invalidpass');
            } else {
                $('#length').removeClass('invalidpass').addClass('validpass');
            }

            //validate letter
            if (pswd.match(/[A-z]/)) {
                $('#letter').removeClass('invalidpass').addClass('validpass');
            } else {
                $('#letter').removeClass('validpass').addClass('invalidpass');
            }

            //validate uppercase letter
            if (pswd.match(/[A-Z]/)) {
                $('#capital').removeClass('invalidpass').addClass('validpass');
            } else {
                $('stepcnt').val();
                $('#capital').removeClass('validpass').addClass('invalidpass');
            }

            //validate number
            if (pswd.match(/\d/)) {
                $('#number').removeClass('invalidpass').addClass('validpass');
            } else {
                $('#number').removeClass('validpass').addClass('invalidpass');
            }

        }).focus(function () {
            $('#pswd_info').show();
        }).blur(function () {
            $('#pswd_info').hide();
        });

        $("#terms_constions").click(function () {
            $("#term_popup_box").slideToggle("");
        });
        $("#term_popup_box_close").click(function () {
            $("#term_popup_box").slideToggle();
        });


        $("#privacy_policy").click(function () {
            $("#privacy_popup_box").slideToggle("");
        });
        $("#privacy_popup_box_close").click(function () {
            $("#privacy_popup_box").slideToggle();
        });


    });

    function checkCompanyName(cname) {
        if (cname != '') {
            $.ajax({
                type: 'POST',
                url: "<?php echo HTTP_PATH; ?>/users/checkCompanyName/" + cname,
                cache: false,
                beforeSend: function () {
                    $("#cname_loader").show();
                },
                success: function (result) {
                    alert(result);
                    $("#cname_loader").hide();
                    if (result == 0) {
                        $('#companyname').val('0');
                        $("#cname_result").html('<span class="rest_error">Company name already exist</span>');
                    } else if (result == 1) {
                        $('#companyname').val('1');
                        $("#cname_result").html('<span class="cname_result">Company name available</span>');
                    }
                }
            });
            return false;
        }
    }

    function checkEmail(cname) {

        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(cname)) {

        } else {
            return false;
        }


        if (cname != '') {
            $.ajax({
                type: 'POST',
                url: "<?php echo HTTP_PATH; ?>/users/checkEmail/" + cname,
                cache: false,
                beforeSend: function () {
                    $("#email_loader").show();
                },
                success: function (result) {
                    $("#email_loader").hide();
                    if (result == 0) {
                        $('#emailaddress').val('0');
                        $("#email_result").html('<span class="rest_error">Email address already exist</span>');
                    } else if (result == 1) {
                        $('#emailaddress').val('1');
                        $("#email_result").html('<span class="cname_result">Email address available</span>');
                    }
                }
            });
            return false;
        }
    }

    function checkUnique(cname) {
        if (cname != '') {
            $.ajax({
                type: 'POST',
                url: "<?php echo HTTP_PATH; ?>/users/checkUnique/" + cname,
                cache: false,
                beforeSend: function () {
                    $("#unique_loader").show();
                },
                success: function (result) {
                    $("#unique_loader").hide();
                    if (result == 0) {
                        $('#uniqueid').val('0');
                        $("#unique_result").html('<span class="rest_error">Unique ID already exist</span>');
                    } else if (result == 1) {
                        $('#uniqueid').val('1');
                        $("#unique_result").html('<span class="cname_result">Unique ID available</span>');
                    }
                }
            });
            return false;
        }
    }

    function backTo(st) {
        var cstep = st * 1 + 1;
        $('#step' + cstep).hide();
        $('#step' + st).show();
        $('#stepcnt').val(st);
    }


</script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Edit Company 
        </h1>
        <ol class="breadcrumb">
            <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller' => 'admins', 'action' => 'dashboard'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link('<i class="fa fa-building"></i> Companies', array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?></li>
            <li class="active">Edit Company</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">&nbsp;</h3>
            </div>
            <div class="ersu_message"> <?php echo $this->Session->flash(); ?> </div>
            <?php echo $this->Form->create(Null, array('id' => 'registerForm', 'enctype' => 'multipart/form-data')); ?>
            <div class="form-horizontal">
                <div class="steps_sections">
                    <input type="hidden" value="1" name="stepcnt" id="stepcnt" />
                    <input type="hidden" value="0" name="companyname" id="companyname" />
                    <input type="hidden" value="0" name="emailaddress" id="emailaddress" />
                    <input type="hidden" value="0" name="uniqueid" id="uniqueid" />
                    <div class="box-body">
                        <div class="steps_sections_row stp" id="step1" style="display: none1;">
                            <div class="step_counts">Step 1:</div>
                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Company Name <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.company_name', array('class' => "form-control required", 'placeholder' => 'Company Name', 'autocomplete' => 'off', 'readonly' => "readonly")); ?>
                                    <div class="cname_loader" id="cname_loader"><?php echo $this->Html->image('loading_bl.svg'); ?></div>
                                    <div class="cname_result" id="cname_result"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Email Address <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.email_address', array('class' => "form-control required email", 'placeholder' => 'Email address', 'autocomplete' => 'off', 'readonly' => "readonly")); ?>
                                    <div class="cname_loader" id="email_loader"><?php echo $this->Html->image('loading_bl.svg'); ?></div>
                                    <div class="cname_result" id="email_result"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Unique Id <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.unique_id', array('class' => "form-control required", 'placeholder' => 'Unique Id', 'autocomplete' => 'off', 'readonly' => "readonly")); ?>
                                    <div class="cname_loader" id="unique_loader"><?php echo $this->Html->image('loading_bl.svg'); ?></div>
                                    <div class="cname_result" id="unique_result"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Password <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->password('User.new_password', array('minlength' => 8, 'class' => "form-control passold", 'placeholder' => 'Password', 'autocomplete' => 'off')); ?>
                                    <em class="bugdm">* Note: If You want to change User's password, only then fill password below otherwise leave it blank.</em>
                                    <div id="pswd_info" class="bounceInUp animated">
                                        <h4>Password must meet the following requirements:</h4>
                                        <ul>
                                            <li id="letter" class="invalidpass">At least <strong>one letter</strong></li>
                                            <li id="capital" class="invalidpass">At least <strong>one capital letter</strong></li>
                                            <li id="number" class="invalidpass">At least <strong>one number</strong></li>
                                            <li id="length" class="invalidpass">Be at least <strong>8 characters</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Confirm Password <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->password('User.confirm_password', array('class' => "form-control", 'placeholder' => 'Retype password', 'equalTo' => '#UserNewPassword')); ?>
                                </div>
                            </div>


                            <div class="clear"></div>
                            <div class="box-footer">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label" for="inputPassword3">&nbsp;</label>
                                <input type="submit" name="submit" value="Confirm" class="btn btn-info log_btn_sjaerk marfi"/>
                            </div>
                        </div>




                        <div class="steps_sections_row stp" id="step2" style="display: none;">
                            <div class="step_counts">Step 2:</div>
                            <div class="step_counts">Address Info:</div>
                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Select State <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->select('User.state_id', $stateList, array('empty' => 'Select State (In USA)', 'class' => "form-control required", 'id' => 'state_id')); ?>
                                    <?php echo $this->Ajax->observeField('state_id', array('url' => '/admin/states/getCityList/User', 'update' => 'city_list', 'indicator' => 'state_loader')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Select City <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8" id="city_list">
                                    <?php echo $this->Form->select('User.city_id', $cityList, array('empty' => 'Select City', 'class' => "form-control required")); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Street <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.street', array('class' => "form-control required", 'placeholder' => 'Street', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Building number/office <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.building_number', array('class' => "form-control required", 'placeholder' => 'Building Number/Office', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Postcode/ZIP <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.zipcode', array('class' => "form-control required", 'placeholder' => 'Postcode/ZIP', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>
                            
                            
                            <div class="step_counts">Social Info:</div>
                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Twitter URL <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.twitter', array('class' => "form-control url", 'placeholder' => 'Twitter URL', 'autocomplete' => 'off')); ?>
                                    <div class="help_text">Example URL: https://twitter.com/xyz</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Facebook URL <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.facebook', array('class' => "form-control url", 'placeholder' => 'Facebook URL', 'autocomplete' => 'off')); ?>
                                    <div class="help_text">Example URL: https://facebook.com/xyz</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Linkedin URL <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.linkedin', array('class' => "form-control url", 'placeholder' => 'Linkedin URL', 'autocomplete' => 'off')); ?>
                                    <div class="help_text">Example URL: https://linkedin.com/xyz</div>
                                </div>
                            </div>


                            <div class="clear"></div>
                            <div class="box-footer">
                                <div class="clear"></div>
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label" for="inputPassword3">&nbsp;</label>
                                <input type="button" name="submit" value="Previus" class="btn btn-info log_btn_sjaerk marfi" onclick="backTo(1)"/>
                                <input type="submit" name="submit" value="Next" class="btn btn-info log_btn_sjaerk marfi"/>
                            </div>
                        </div>

                        <div class="steps_sections_row stp" id="step3" style="display: none;">
                            <div class="step_counts">Step 3 (Company info):</div>
                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Chairman <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.chairman', array('class' => "form-control required", 'placeholder' => 'Chairman', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label"> EIN <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.ein', array('class' => "form-control required", 'placeholder' => 'Employer Identification Number (EIN)', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Select Industry <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->select('User.industry_id', $industryList, array('empty' => 'Industry (choice from list of Industry)', 'class' => "form-control required")); ?>
                                    <?php echo $this->Ajax->observeField('UserIndustryId', array('url' => '/admin/industries/getSubIndustryList/User', 'update' => 'subind_list', 'indicator' => 'industry_loader')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Subcategory of Industry <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8" id="subind_list">
                                    <?php echo $this->Form->select('User.subindustry_id', $subIndustryList, array('empty' => 'Subcategory of Industry', 'class' => "form-control required")); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Year Establishment <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php
                                    global $year;
                                    echo $this->Form->select('User.est_year', $year, array('empty' => 'Year Establishment', 'class' => "form-control required"));
                                    ?>  </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Number of Employees <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.employers', array('class' => "form-control required digits", 'placeholder' => 'Number of Employees', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Certificate Number <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.certificate_number', array('class' => "form-control", 'placeholder' => 'Certificate Number', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label">Upload Certificate <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->file('User.certificates', array('class' => 'form-control', 'label' => false, 'id' => 'add_picture', 'onchange' => 'uploadCertificates()')) ?>
                                    <div class="help_text">Supported File Types: jpg, jpeg, png (Max. 2MB).</div>

                                    <em class="bugdm">* Note: Upload a new certificate if you want to replace to previously uploaded document.</em>

                                    <?php if (!empty($this->data['User']['certificates'])) { ?>
                                        <div class="download_link"><p class="estimate_document_download">
                                                <?php echo $this->Html->link('<i class="fa fa-download"></i> Download Previous Uploaded Certificate', array('controller' => 'users', 'action' => 'download', 'User', 'certificates', md5($this->data['User']['id']), $this->data['User']['id']), array('title' => 'Download Attachment', 'class' => 'dnld_detail', 'escape' => false)); ?>
                                            </p></div> 
                                    <?php } ?>
                                </div>
                            </div>


                            <div class="clear"></div>
                            <div class="box-footer">
                                <div class="clear"></div>
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label" for="inputPassword3">&nbsp;</label>
                                <input type="button" name="submit" value="Previus" class="btn btn-info log_btn_sjaerk marfi" onclick="backTo(2)"/>
                                <input type="submit" name="submit" value="Next" class="btn btn-info log_btn_sjaerk marfi"/>
                            </div>
                        </div>

                        <div class="steps_sections_row stp" id="step4" style="display: none;">
                            <div class="step_counts">Step 4 (Payments):</div>
                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Bank Account Number <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.bank_account_number', array('class' => "form-control required digits", 'placeholder' => 'Bank Account Number', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Bank Branch Name <span class="require">*</span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.branch_name', array('class' => "form-control required", 'placeholder' => 'Bank Branch Name', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Paypal Email <span class="require"></span></label>
                                <div class="col-lg-10 col-sm-7 col-md-8">
                                    <?php echo $this->Form->text('User.paypal_email', array('class' => "form-control email", 'placeholder' => 'Paypal Email', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>

                            <div class="step_ladtaj stkiip" id="skip_hide"><span><a href="javascript:void(0)" onclick="skipStep5Up()">Skip Step 5</a></span></div>
                            <div class="step_ladtaj stkiip showww" id="skip_show" style="display: none;" ><span><a href="javascript:void(0)" onclick="skipStep5Down()">Show Step 5</a></span></div>


                            <div class="step_ladtaj" id="st5">
                                <div class="step_counts">Step 5 (customize Profile):</div>     

                                <div class="form-group">
                                    <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Add Logo <span class="require"></span></label>
                                    <div class="col-lg-10 col-sm-7 col-md-8">
                                        <?php if (!empty($this->data['User']['old_company_logo'])) { ?>
                                            <div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">
                                                <?php
                                                $filePath = UPLOAD_LOGO_PATH . $this->data['User']['old_company_logo'];
                                                if (file_exists($filePath) && $this->data['User']['old_company_logo']) {
                                                    echo $this->Html->image(DISPLAY_LOGO_PATH . $this->data['User']['old_company_logo'], array('alt' => ''));
                                                } else {
                                                    echo $this->Html->image('no_image.gif');
                                                }
                                                ?>
                                            </div>
                                        <?php } ?>

                                        <?php echo $this->Form->file('User.company_logo', array('class' => 'form-control', 'label' => false, 'id' => 'add_logo', 'onchange' => 'uploadLogo()')) ?>
                                        <div class="help_text">Supported File Types: jpg, jpeg, png (Max. 2MB).</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Background Image <span class="require"></span></label>
                                    <div class="col-lg-10 col-sm-7 col-md-8">
                                        <?php if (!empty($this->data['User']['old_background_img'])) { ?>
                                            <div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">
                                                <?php
                                                $filePath = UPLOAD_BACKGROUND_PATH . $this->data['User']['old_background_img'];
                                                if (file_exists($filePath) && $this->data['User']['old_background_img']) {
                                                    echo $this->Html->image(DISPLAY_BACKGROUND_PATH . $this->data['User']['old_background_img'], array('alt' => ''));
                                                } else {
                                                    echo $this->Html->image('no_image.gif');
                                                }
                                                ?>
                                            </div>

                                        <?php } ?>

                                        <?php echo $this->Form->file('User.background_img', array('class' => 'form-control', 'label' => false, 'id' => 'add_bg_image', 'onchange' => 'uploadBackground()')); ?>
                                        <div class="help_text">Supported File Types: jpg, jpeg, png (Max. 2MB).</div>
                                    </div>
                                </div>

                                <?php /* ?>
                                <div class="form-group">
                                    <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Slider Pictures (max 5) <span class="require">*</span></label>
                                    <div class="col-lg-10 col-sm-7 col-md-8">
                                        <?php
                                        if (!empty($this->data['User']['old_slider_img'])) {
                                            $sliderImgs = explode(',', $this->data['User']['old_slider_img']);
                                            foreach ($sliderImgs as $sliderImg){
                                            ?>
                                            
                                            <div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">
                                                <?php
                                                $filePath = UPLOAD_SLIDER_PATH . $sliderImg;
                                                if (file_exists($filePath) && $sliderImg) {
                                                    echo $this->Html->image(DISPLAY_SLIDER_PATH . $sliderImg, array('alt' => ''));
                                                } else {
                                                    echo $this->Html->image('no_image.gif');
                                                }
                                                ?>
                                            </div>

                                            <?php }
                                            
                                                } ?>

                                        <?php echo $this->Form->file('User.slider_img', array('multiple' => 'multiple', 'name' => 'data[User][slider_img][]', 'class' => 'form-control', 'label' => false, 'id' => 'add_slider_bg', 'onchange' => 'uploadSlider()')) ?>
                                        <div class="help_text">Select multiple file with Ctrl press, File Types: jpg, jpeg, png (Max. 2MB for each).</div>
                                    </div>
                                </div>
                             <?php */ ?>

                            </div>

                            <?php
                            echo $this->Form->hidden('User.id');
                            echo $this->Form->hidden('User.slug');
                            echo $this->Form->hidden('User.status');
                            echo $this->Form->hidden('User.old_certificates');
                            echo $this->Form->hidden('User.old_company_logo');
                            echo $this->Form->hidden('User.old_background_img');
                            echo $this->Form->hidden('User.old_slider_img');
                            echo $this->Form->hidden('User.old_password');
                            ?>

                            <div class="clear"></div>
                            <div class="box-footer">
                                <div class="clear"></div>
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label" for="inputPassword3">&nbsp;</label>
                                <input type="button" name="submit" value="Previus" class="btn btn-info  log_btn_sjaerk marfi" onclick="backTo(3)"/>
                                <input type="submit" name="submit" value="Submit" class="btn btn-info  log_btn_sjaerk marfi"/>
                                <span class="step_abbouts">*You can skip the Step 5</span>
                            </div>
                            <div class="btn_form_end_row" id="sub_btn_dive_loader" style="display: none;">
                                <label class="col-sm-5 col-md-4 col-lg-2 control-label" for="inputPassword3">&nbsp;</label>
                                <div class="btm_loader"> <?php echo $this->Html->image('loading_bl.svg'); ?> Please wait...</div>
                            </div>
                            <label class="col-sm-5 col-md-4 col-lg-2 control-label" for="inputPassword3">&nbsp;</label>
                        </div>



                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>

        </div>
    </section>
</div>




<script>
    function skipStep5Up() {
        $('#skip_hide').hide();
        $('#skip_show').show();
        $('#st5').slideToggle('slow');
    }
    function skipStep5Down() {
        $('#skip_hide').show();
        $('#skip_show').hide();
        $('#st5').slideToggle('slow');
    }

    function in_array(needle, haystack) {
        for (var i = 0, j = haystack.length; i < j; i++) {
            if (needle == haystack[i])
                return true;
        }
        return false;
    }

    function getExt(filename) {
        var dot_pos = filename.lastIndexOf(".");
        if (dot_pos == -1)
            return;
        return filename.substr(dot_pos + 1).toLowerCase();
    }

    function uploadCertificates() {
        var filename = document.getElementById("add_picture").value;
        var filetype = ['jpeg', 'png', 'jpg'];
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " file not allowed for Certificates.");
                return false;
            } else {
                var fi = document.getElementById('add_picture');
                var filesize = fi.files[0].size;//check uploaded file size
                if (filesize > 2097152) {
                    alert('Maximum 2MB file size allowed for Certificates.');
                    return false;
                }
            }
        }
        $('#certificates_id').html($('#add_picture')[0].files[0].name);
        return true;
    }

    function uploadLogo() {
        var filename = document.getElementById("add_logo").value;
        var filetype = ['jpeg', 'png', 'jpg'];
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " file not allowed for logo.");
                return false;
            } else {
                var fi = document.getElementById('add_logo');
                var filesize = fi.files[0].size;//check uploaded file size
                if (filesize > 2097152) {
                    alert('Maximum 2MB file size allowed for logo.');
                    return false;
                }
            }
        }
        $('#logo_id').html($('#add_logo')[0].files[0].name);
        return true;
    }

    function uploadBackground() {
        var filename = document.getElementById("add_bg_image").value;
        var filetype = ['jpeg', 'png', 'jpg'];
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " file not allowed for background image.");
                return false;
            } else {
                var fi = document.getElementById('add_bg_image');
                var filesize = fi.files[0].size;//check uploaded file size
                if (filesize > 2097152) {
                    alert('Maximum 2MB file size allowed for background image.');
                    return false;
                }
            }
        }
        $('#background_img_id').html($('#add_bg_image')[0].files[0].name);
        return true;
    }


    function uploadSlider() {

        var files = $('#add_slider_bg')[0].files;
        if (files.length > 5) {
            alert('You can upload max 6 slider picture.');
            $('#add_slider_bg').val('');
            return;
        }

        var allImages = '';
        var filetype = ['jpeg', 'png', 'jpg'];
        var slidercnt = 0;
        for (var i = 0; i < files.length; i++) {
            var ext = getExt(files[i].name);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(files[i].name + " is invalid file.");
                continue;
            } else {
                var fi = document.getElementById('add_bg_image');
                var filesize = files[i].size;//check uploaded file size
                if (filesize > 2097152) {
                    alert(files[i].name + 'is more than 2MB');
                    continue;
                }
            }
            if (slidercnt != 0) {
                allImages = allImages + ', '
            }
            allImages = allImages + files[i].name;

            slidercnt++;
        }

        $('#slider_img_id').html(allImages);
        return true;

    }
</script>