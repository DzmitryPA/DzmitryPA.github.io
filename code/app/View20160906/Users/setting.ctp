<script type="text/javascript">
    $(document).ready(function () {
        $.validator.addMethod("contact", function (value, element) {
            return  this.optional(element) || (/^[0-9+]+$/.test(value));
        }, "Phone Number is not valid for above field.");
        $.validator.addMethod("fax", function (value, element) {
            return  this.optional(element) || (/^[0-9+-]+$/.test(value));
        }, "Fax Number is not valid for above field.");
        $.validator.addMethod("passold", function (value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20})/.test(value));
        }, "Please enter correct password");
        $("#userInfoForm").validate();
        $("#userAddressForm").validate();
        $("#aboutUsForm").validate();
        $("#changePassword").validate();


        $('#new_password').keyup(function () {
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

    });
</script>

<div class="right_part">
    <div class="aside_contaner_full">
        <div class="ee"><?php echo $this->Session->flash(); ?></div>
        <div class="tilte_of_setctins">Edit Slider Picture</div>
        <?php echo $this->Form->create(Null, array('id' => 'userSliderImageForm', 'enctype' => 'multipart/form-data')); ?>
        <div class="btn_right_sizea">
            <input type="submit" name="editSliderImage" value="Save" class="btn_of_she"/>
        </div>

        <div class="clear"></div>

        <div class="section_setting_full">
            <div class="slider_section_image_attach_row">
                <?php
                $i = 0;
                if (!empty($this->data['User']['slider_img'])) {
                    $sliderImgs = explode(',', $this->data['User']['slider_img']);
                    foreach ($sliderImgs as $sliderImg) {
                        ++$i;
                        ?>
                        <div class="slider_section_image_attach">
                            <div class="slider_section_image_attach_box">
                                <div class="slider_section_image_attach_box_imn">
                                    <div class="attach_file_of_slider">
                                        <div class="edit_sec_duywsa">
                                            <div class="image_povelroals"><span class="slide_closed" onclick="deleteSliderImage(<?php echo "'" . $sliderImg . "'" ?>)"></span></div>
                                            <?php echo $this->Html->image(DISPLAY_SLIDER_PATH . $sliderImg, array('alt' => 'Slider Image')); ?>
                                        </div>                      
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>


                <?php
                $j = 0;
                while ($i < 5) {
                    ++$i;
                    ++$j;
                    ?>
                    <div class="slider_section_image_attach">
                        <div class="slider_section_image_attach_box">
                            <div class="slider_section_image_attach_box_imn">
                                <div class="attach_file_of_slider">
                                    <?php echo $this->Form->file('User.slider' . $j, array('class' => 'hidden_file_od', 'label' => false, 'id' => 'add_logo' . $j, 'onchange' => 'uploadSlider(' . $j . ')')) ?>
                                    <label for="add_logo<?php echo $j ?>" id="logo_id<?php echo $j ?>">
                                        <?php echo $this->Html->image('front/add_imghs.png', array('id' => 'showimg' . $j)); ?> </label>                                        
                                </div>                                    
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
        <?php
        echo $this->Form->hidden('User.id');
        echo $this->Form->hidden('User.slug');
        echo $this->Form->hidden('User.status');
        echo $this->Form->hidden('User.old_slider_img');
        ?>
        <input type="hidden" value="<?php echo $j ?>" name="counter"/>

        <?php echo $this->Form->end(); ?>
        <div class="clear"></div>

        <div class="line_break_agads"></div>

        <div class="tilte_of_setctins">Edit Company Profile</div>
        <?php echo $this->Form->create(Null, array('id' => 'userInfoForm', 'enctype' => 'multipart/form-data')); ?>
        <div class="btn_right_sizea">
            <!--<input type="reset" name="submit" value="Reset" class="btn_of_she"/>-->
            <input type="submit" name="editinfo" value="Save" class="btn_of_she"/>
        </div>

        <div class="clear"></div>

        <div class="two_section_edit_compahit">
            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>INDUSTRY</label>
                        <div class="select_bahf_baheva">
                            <?php echo $this->Form->select('User.industry_id', $industryList, array('empty' => 'Industry (choice from list of Industry)', 'class' => "edit_prof_slad required")); ?>
                            <div class="cname_loader" id="industry_loader"><?php echo $this->Html->image('loading.svg'); ?></div>
                            <?php echo $this->Ajax->observeField('UserIndustryId', array('url' => '/industries/getSubIndustryList/User/edit_prof_slad', 'update' => 'subind_list', 'indicator' => 'industry_loader')); ?>
                        </div> 
                    </div>
                </div>
            </div>

            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>CATEGORY</label>
                        <div class="select_bahf_baheva" id="subind_list">
                            <?php echo $this->Form->select('User.subindustry_id', $subIndustryList, array('empty' => 'Subcategory of Industry', 'class' => "edit_prof_slad required")); ?>
                        </div>                                
                    </div>
                </div>
            </div>


            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>YEAR ESTABLISHMENT</label>
                        <div class="select_bahf_baheva">
                            <?php
                            global $year;
                            echo $this->Form->select('User.est_year', $year, array('empty' => 'Year Establishment', 'class' => "edit_prof_slad required"));
                            ?>
                        </div>                           
                    </div>  
                </div>
            </div>

            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>EMPLOYEES</label>
                        <?php echo $this->Form->text('User.employers', array('class' => "edit_prof_slad required digits", 'placeholder' => 'Number of Employees', 'autocomplete' => 'off')); ?>
                    </div>
                </div>
            </div>
            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>EMPLOYER IDENTIFICATION NUMBER</label>
                        <?php echo $this->Form->text('User.ein', array('maxlength' => '9', 'class' => "edit_prof_slad required", 'placeholder' => 'Employer Identification Number (EIN)', 'autocomplete' => 'off')); ?>

                    </div>
                </div>
            </div>



            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>CERTIFICATE IMAGE</label>
                        <?php echo $this->Form->file('User.certificates', array('class' => 'form_secinpursfile', 'label' => false, 'id' => 'certificate_file', 'onchange' => 'uploadCertificates()')) ?>
                        <label for="certificate_file" class="edit_prof_slad" id="certificates_id"><?php echo $this->data['User']['certificates']; ?></label>
                    </div>
                </div>
            </div>

            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>CERTIFICATE NUMBER</label>
                        <?php echo $this->Form->text('User.certificate_number', array('class' => "edit_prof_slad required", 'placeholder' => 'CERTIFICATE NUMBER', 'autocomplete' => 'off')); ?>

                    </div>
                </div>
            </div>
            <div class="two_section_edit_company ">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>CHAIRMAN</label>
                        <?php echo $this->Form->text('User.chairman', array('class' => "edit_prof_slad required", 'placeholder' => 'Chairman', 'autocomplete' => 'off')); ?>                                
                    </div>
                </div>
            </div>
            
            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>COMPANY LOGO</label>
                        <?php echo $this->Form->file('User.company_logo', array('class' => 'form_secinpursfile', 'label'=>false, 'id'=>'add_logo', 'onchange' => 'uploadLogo()')) ?>
                        <label for="add_logo" class="edit_prof_slad" id="logo_id"><?php echo $this->data['User']['company_logo']; ?></label>
                    </div>
                </div>
            </div>
            
            
            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>BACKGROUND IMAGE</label>
                        <?php echo $this->Form->file('User.background_img', array('class' => 'form_secinpursfile', 'label'=>false, 'id'=>'add_bg_image', 'onchange' => 'uploadBackground()')); ?>
                        <label for="add_bg_image" class="edit_prof_slad" id="background_img_id"><?php echo $this->data['User']['background_img']; ?></label>
                    </div>
                </div>
            </div>
            
            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Phone</label>
                        <?php echo $this->Form->text('User.phone', array('maxlength' => '16', 'class' => "edit_prof_slad contact", 'placeholder' => 'Phone Number', 'autocomplete' => 'off')); ?>
                    </div>
                </div>
            </div>
            <div class="two_section_edit_company ">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Fax</label>
                        <?php echo $this->Form->text('User.fax', array('maxlength' => '16', 'class' => "edit_prof_slad fax", 'placeholder' => 'Fax Number', 'autocomplete' => 'off')); ?>
                    </div>
                </div>
            </div>
            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Website URL</label>
                        <?php echo $this->Form->text('User.website', array('class' => "edit_prof_slad url", 'placeholder' => 'Website URL', 'autocomplete' => 'off')); ?>
                        <span class="help_text ">Example: http://www.example.com</span>
                    </div>
                </div>
            </div>
            <div class="two_section_edit_company ">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Profile Privacy Setting</label>
                        <div class="cols_three"><div class="itend_ewr_check">
                                <?php
                                $options2 = array('1' => '<span class="new_label">On</span>', '0' => '<span class="new_label">Off</span>');
                                echo $this->Form->radio('User.watch_status', $options2, array('label' => '', 'legend' => false, 'class' => "", 'div' => false, 'separator' => '</div></div><div class="cols_three"><div class="itend_ewr_check">'));
                                ?>
                            </div>
                        </div>

                        <span class="help_text">If set to <b>'On'</b>, then while you watch profile of another company those company will be able to know
                            that you watch them as well as you'll see who watches your company's profile.
                        </span>
                        <span class="help_text">If set to <b>'Off'</b>, then while you watch profile of another company those company won't know
                            that you watch them but also you won't see who watches your company's profile.
                        </span>
                    </div>
                </div>
            </div>




        </div>
        <?php
        echo $this->Form->hidden('User.id');
        echo $this->Form->hidden('User.slug');
        echo $this->Form->hidden('User.status');
        echo $this->Form->hidden('User.old_certificates');
        echo $this->Form->hidden('User.old_company_logo');
        echo $this->Form->hidden('User.old_background_img');
        ?>
        <?php echo $this->Form->end(); ?>


        <div class="clear"></div>
        <div class="line_break_agads"></div>
        <div class="clear"></div>


        <div class="tilte_of_setctins">Edit Company Address & Social Info</div>
        <?php echo $this->Form->create(Null, array('id' => 'userAddressForm', 'enctype' => 'multipart/form-data')); ?>
        <div class="btn_right_sizea">
            <!--<input type="reset" name="submit" value="Reset" class="btn_of_she"/>-->
            <input type="submit" name="editAddress" value="Save" class="btn_of_she"/>
        </div>

        <div class="clear"></div>

        <div class="two_section_edit_compahit">
            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>State</label>
                        <div class="select_bahf_baheva">
                            <?php echo $this->Form->select('User.state_id', $stateList, array('empty' => 'Select State', 'class' => "edit_prof_slad required")); ?>
                            <div class="cname_loader" id="state_loader"><?php echo $this->Html->image('loading.svg'); ?></div>
                            <?php echo $this->Ajax->observeField('UserStateId', array('url' => '/states/getCityList/User/edit_prof_slad', 'update' => 'city_list', 'indicator' => 'state_loader')); ?>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>City</label>
                        <div class="select_bahf_baheva" id="city_list">
                            <?php echo $this->Form->select('User.city_id', $cityList, array('empty' => 'Select City', 'class' => "edit_prof_slad required")); ?>
                        </div>                                
                    </div>
                </div>
            </div>
            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Street</label>
                        <?php echo $this->Form->text('User.street', array('class' => "edit_prof_slad required", 'placeholder' => 'Street', 'autocomplete' => 'off')); ?>
                    </div>
                </div>
            </div>

            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Building Number</label>
                        <?php echo $this->Form->text('User.building_number', array('class' => "edit_prof_slad required", 'placeholder' => 'Building Number', 'autocomplete' => 'off')); ?>                                
                    </div>
                </div>
            </div>
            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Zipcode</label>
                        <?php echo $this->Form->text('User.zipcode', array('maxlength' => '16', 'class' => "edit_prof_slad contact", 'placeholder' => 'Zipcode', 'autocomplete' => 'off')); ?>
                    </div>
                </div>
            </div>
            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Twitter</label>
                        <?php echo $this->Form->text('User.twitter', array('class' => "edit_prof_slad url", 'placeholder' => 'Twitter URL', 'autocomplete' => 'off')); ?>
                        <div class="help_text webhelpurl_frnt">Example URL: https://twitter.com/xyz</div>
                    </div>
                </div>
            </div>
            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Facebook</label>
                        <?php echo $this->Form->text('User.facebook', array('class' => "edit_prof_slad url", 'placeholder' => 'Facebook URL', 'autocomplete' => 'off')); ?>
                        <div class="help_text webhelpurl_frnt">Example URL: https://facebook.com/xyz</div>
                    </div>               
                </div>
            </div>
            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Linkedin</label>
                        <?php echo $this->Form->text('User.linkedin', array('class' => "edit_prof_slad url", 'placeholder' => 'Linkedin URL', 'autocomplete' => 'off')); ?>
                        <div class="help_text webhelpurl_frnt">Example URL: https://linkedin.com/xyz</div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo $this->Form->hidden('User.id');
        echo $this->Form->hidden('User.slug');
        echo $this->Form->hidden('User.status');
        ?>
        <?php echo $this->Form->end(); ?>



        <div class="clear"></div>
        <div class="line_break_agads"></div>
        <div class="clear"></div>

        <div class="tilte_of_setctins">Change Password</div>
        <?php echo $this->Form->create(Null, array('id' => 'changePassword', 'enctype' => 'multipart/form-data')); ?>
        <div class="btn_right_sizea">
            <!--<input type="reset" name="submit" value="Reset" class="btn_of_she"/>-->
            <input type="submit" name="changePassword" value="Save" class="btn_of_she"/>
        </div>

        <div class="clear"></div>

        <div class="two_section_edit_compahit">
            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Old Password</label>
                        <?php echo $this->Form->password('User.old_password', array('label' => '', 'div' => false, 'class' => "edit_prof_slad required", 'placeholder' => 'Old password', 'autocomplete' => 'off')) ?>  
                    </div>
                </div>
            </div>

            <div class="two_section_edit_company">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>New Password</label>
                        <?php echo $this->Form->password('User.new_password', array('minlength' => '8', 'maxlength' => '40', 'label' => '', 'div' => false, 'id' => 'new_password', 'class' => "edit_prof_slad passold required", 'placeholder' => 'New Password')) ?>   
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
            </div>
            <div class="two_section_edit_company clear">
                <div class="two_section_edit_company_box">
                    <div class="two_section_edit_company_box_row">
                        <label>Confirm Password</label>
                        <?php echo $this->Form->password('User.conf_password', array('label' => '', 'div' => false, 'equalTo' => '#new_password', 'class' => "edit_prof_slad required", 'placeholder' => 'Confirm Password')) ?>  
                    </div>
                </div>
            </div>



        </div>
        <?php
        echo $this->Form->hidden('User.id');
        echo $this->Form->hidden('User.slug');
        echo $this->Form->hidden('User.status');
        echo $this->Form->hidden('User.oldPassword');
        ?>
        <?php echo $this->Form->end(); ?>






        <div class="clear"></div>
        <div class="line_break_agads"></div>
        <div class="clear"></div>


        <div class="tilte_of_setctins">Edit About Us</div>
        <?php echo $this->Form->create(Null, array('id' => 'aboutUsForm', 'enctype' => 'multipart/form-data')); ?>
        <div class="btn_right_sizea">
            <!--<input type="reset" name="submit" value="Reset" class="btn_of_she"/>-->
            <input type="submit" name="editAboutUs" value="Save" class="btn_of_she"/>
        </div>

        <div class="clear"></div>
        <div class="editor_sie_jare3">
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>tinymce.init({selector: 'textarea.editor_meshage'});</script>
            <?php echo $this->Form->textarea('User.about_us', array('class' => "editor_meshage required", 'rows' => '15', 'placeholder' => 'About Us')); ?>
        </div>
        <?php
        echo $this->Form->hidden('User.id');
        echo $this->Form->hidden('User.slug');
        echo $this->Form->hidden('User.status');
        ?>
        <?php echo $this->Form->end(); ?>







    </div>     

</div>

<script>

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
        var filename = document.getElementById("certificate_file").value;
        var filetype = ['jpeg', 'png', 'jpg'];
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " file not allowed for Certificate.");
                return false;
            } else {
                var fi = document.getElementById('certificate_file');
                var filesize = fi.files[0].size;//check uploaded file size
                if (filesize > 2097152) {
                    alert('Maximum 2MB file size allowed for Certificates.');
                    return false;
                }
            }
        }
        $('#certificates_id').html($('#certificate_file')[0].files[0].name);
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

    function deleteSliderImage(image) {
        if (image != "") {
            var r = confirm("Are you sure, you want to delete Slider Image?");
            if (r == true) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo HTTP_PATH; ?>/users/deleteSliderImage/" + image,
                    cache: false,
                    beforeSend: function () {
                        $(".web_page_loader").show();
                    },
                    success: function (result) {
                        $(".web_page_loader").hide();
                        //alert(result);
                        window.location.reload();
                    }
                });
                return false;
            } else {
                return false;
            }
        }
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

    function uploadSlider(j) {
        var filename = document.getElementById("add_logo" + j).value;
        var filetype = ['jpeg', 'png', 'jpg'];
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " file not allowed for logo.");
                return false;
            } else {
                var fi = document.getElementById('add_logo' + j);
                var filesize = fi.files[0].size;//check uploaded file size
                if (filesize > 2097152) {
                    alert('Maximum 2MB file size allowed for logo.');
                    return false;
                }
            }
        }


        var reader = new FileReader();
        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("showimg" + j).src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL($('#add_logo' + j)[0].files[0]);
        //$('#logo_id' + j).html($('#add_logo' + j)[0].files[0].name);
        return true;
    }
</script>

