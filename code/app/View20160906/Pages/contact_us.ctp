<script src="https://maps.googleapis.com/maps/api/js" type="text/javascript"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<?php echo $this->Html->script('jquery.validate.js'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#contactUs").validate();
    });

</script>
<script>
    var map;
    function Init() {
        var geocoder = new google.maps.Geocoder();    // instantiate a geocoder object
        var address = '<?php echo $contact_details['Admin']['address']; ?>';

        geocoder.geocode({'address': address}, function (results, status) {
            var addr_type = results[0].types[0];	// type of address inputted that was geocoded

            if (status == google.maps.GeocoderStatus.OK) {
                ShowLocation(results[0].geometry.location, address, addr_type);
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });

        map = new google.maps.Map(document.getElementById('map-canvas'));
    }

    function ShowLocation(latlng, address, addr_type) {
        map.setCenter(latlng);
        var zoom = 15;
        map.setZoom(zoom);

        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: 'address'
                    //icon : "<?php //echo bloginfo('template_url');  ?>/images/map_icon.png",
        });

        var contentString = '<div class="info_box">' +
                '<div class="inflfour">Details from google maps</div>' +
                '<div class="inflfive"><?php echo $contact_details['Admin']['address']; ?></div>' +
                //'<div class="inflsix"><a href="<?php //echo bloginfo('url');  ?>">www.faircomny.com</a></div>'+
                '<div class="inflseven"><?php echo $contact_details['Admin']['phone']; ?></div>' +
                //'<div class="infleight"><a href="<?php //echo $googleplus_link[0];  ?>">Google+ page</a></div>'+
                +'</div>' + '</div>'; 	// HTML text to display in the InfoWindow
        var infowindow = new google.maps.InfoWindow({content: contentString});
        google.maps.event.addListener(marker, 'mouseover', function () {
            infowindow.open(map, marker);
        });
    }

    google.maps.event.addDomListener(window, 'load', Init);

</script>

<div class="inner_pages_aside">
    <div class="container">
        <div class="maids">
            <div class="loginp">
                <h1>Contact Us</h1>
            </div>
           
            <div class="clr"></div>
            <article class="no_apid new_soidf">
                <div class="middel_con">


                    <div class="con_tu">

                        <div class="cont_ac">
                            <div class="con_left">
                                <h3 class="fancy-title">
                                    <span>Office Info</span>
                                </h3>
                                <?php
                                if (empty($contact_details['Admin']['company_name']) && empty($contact_details['Admin']['phone']) && empty($contact_details['Admin']['contact_email']) && empty($contact_details['Admin']['address'])) {
                                    
                                } else {
                                    ?>
                                    <div class="inputs"> 
                                        <div class="copmanys"> 
                                            <small><i class="fa fa-institution blubx"></i></small>
                                            <div class="metios"> 
                                                <em>Company Name</em>
                                                <b>
                                                    <?php
                                                    if ($contact_details['Admin']['company_name']) {
                                                        echo $contact_details['Admin']['company_name'];
                                                    }
                                                    ?>
                                                </b>
                                            </div>
                                        </div>
                                            <?php if ($contact_details['Admin']['address']) { ?>
                                            <div class="copmanys">
                                                <small><i class="fa fa-home blubx"></i></small>
                                                <div class="metios">
                                                    <em>Address</em>
                                                    <b>
                                                        <?php echo $contact_details['Admin']['address']; ?>
                                                    </b>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($contact_details['Admin']['phone']) { ?>
                                            <div class="copmanys">
                                                <small><i class="fa fa-phone-square blubx"></i></small>
                                                <div class="metios">
                                                    <em>Contact</em>
                                                    <b>
                                            <?php echo $contact_details['Admin']['phone']; ?>
                                                    </b>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($contact_details['Admin']['contact_email']) { ?>
                                            <div class="copmanys">
                                                <small><i class="fa fa-envelope-o blubx"></i></small>
                                                <div class="metios">
                                                    <em>Email</em>
                                                    <b>
                                            <?php echo $contact_details['Admin']['contact_email']; ?>
                                                    </b>
                                                </div>
                                            </div>
                                            <?php }
                                        }
                                        ?>
                                    <span class="cont"> <?php //echo $this->Html->image('front/cont.png',array('alt'=>'')); ?></span>

                                </div>
                                <?php
                                if ($contact_details['Admin']['address'] ) {
                                    $stylecss = '';
                                } else {
                                    $stylecss = 'width:100%;';
                                }
                                ?>

                            </div>
                            <div class="rig_con">

                                <h3 class="fancy-title">
                                    <span>Contact Form</span>
                                </h3>
                                <div class="cgtr">
                                    <?php echo $this->Form->create(null, array('method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'contactUs', 'id' => 'contactUs')); ?>
                                    <?php echo $this->Session->flash(); ?>

                                    <div class="oned">

                                        <div class="input_box_register">
                                            <?php echo $this->Form->text('User.name', array('placeholder' => 'Name*', 'size' => '20', 'label' => '', 'div' => false, 'class' => "required con_inpt")) ?>
                                        </div>
                                    </div>
                                    <div class="oned">

                                        <div class="input_box_register">
                                            <?php echo $this->Form->text('User.subject', array('placeholder' => 'Subject*', 'size' => '20', 'label' => '', 'div' => false, 'class' => "required con_inpt")) ?>
                                        </div>

                                    </div>

                                    <div class="oned">                                

                                        <div class="input_box_register">
                                            <?php echo $this->Form->text('User.email', array('placeholder' => 'Email Address*', 'size' => '20', 'label' => '', 'div' => false, 'class' => "required email con_inpt")) ?>
                                        </div>
                                    </div>
                                    <div class="oned">  
                                        <div class="captn">                                   
                                            <?php echo $this->Html->image($this->Html->url(array('controller' => 'users', 'action' => 'captcha'), true), array('style' => '', 'vspace' => 2, 'id' => 'captcha')); ?>                      
                                            <a href="javascript:void(0);" onclick="document.getElementById('captcha').src = '<?php echo $this->Html->url('/users/captcha'); ?>?' + Math.round(Math.random(0) * 1000) + 1"> <img src="<?php echo HTTP_IMAGE . "/captcha_refresh.gif"; ?>" width="35"></a>

                                        </div>
                                        <div class="in_boxes_inpu_left01 capin">                                    
                                            <div class="input_box_register">
                                                <?php echo $this->Form->text('User.captcha', array('placeholder' => 'Security Code*', 'size' => '20', 'label' => '', 'div' => false, 'id' => 'captcha', 'class' => "required con_inpt")) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="oned texyarro">                                    
                                        <div class="input_box_register reg_textare">
                                            <?php echo $this->Form->textarea('User.message', array('placeholder' => 'Message*', 'class' => 'required con_inpt_textarea', 'size' => '50', 'rows' => 5, 'cols' => 5, 'label' => '', 'div' => false, 'no-resize' => true)); ?>
                                        </div>
                                    </div>
                                    <div class="oned onedde login_boxes2 loing_dv">
                                        <div class="login_boxes0">
                                            <label>&nbsp;</label>
                                            <div class="input_box"> 
                                            <?php echo $this->Form->submit('Submit', array('title' => 'Submit', 'class' => 'login_bt btu_ri btn', 'size' => '30', 'label' => '', 'div' => false)) ?> 
                                                <label>&nbsp;</label>
                                                <?php echo $this->Form->reset('Reset', array('class' => 'login_bt btu_ri bgysd', 'maxlength' => '50', 'size' => '30', 'label' => '', 'div' => false, 'value' => 'Reset')) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo $this->Form->end(); ?>	

                            </div>
                            <div class="clr"></div>
                                <?php if ($contact_details['Admin']['address']) { ?>
                                <div class="con_le"> 
                                    <h3 class="fancy-title">
                                        <span>Office Map</span>
                                    </h3>                                       
                                    <div class="img_bdr_new_neww">
                                        <div class="img_org_new">
                                            <div id="map" style="width:100%; height: 300px;">
                                                <div id='map-canvas' style="width: 100%; height: 100%;" >                                                
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            <?php } ?>
                        </div>




                    </div>

                </div>

            </article>
            <div class="clr"></div>

        </div>
    </div>
</div>     