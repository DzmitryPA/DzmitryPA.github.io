<script type="text/javascript">
    $(document).ready(function () {
        $("#contactUs").validate();
    });

</script>
<?php
$companyAddress = $userInfo['User']['building_number'] . ", " .
        $userInfo['User']['street'] . ", " .
        $userInfo['City']['city_name'] . ", " .
        $userInfo['State']['state_name'] . ", " .
        $userInfo['User']['zipcode'] . ", " .
        $userInfo['Country']['name']
?>
<script src="https://maps.googleapis.com/maps/api/js" type="text/javascript"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<script>
    var map;
    function Init() {
        var geocoder = new google.maps.Geocoder();    // instantiate a geocoder object
        var address = '<?php echo $companyAddress; ?>';

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
                    //icon : "<?php //echo bloginfo('template_url');     ?>/images/map_icon.png",
        });

        var contentString = '<div class="info_box">' +
                '<div class="inflfour">Details from google maps</div>' +
                '<div class="inflseven"><?php echo $companyAddress; ?></div>' +
                '</div>'; 	// HTML text to display in the InfoWindow
        var infowindow = new google.maps.InfoWindow({content: contentString});
        google.maps.event.addListener(marker, 'mouseover', function () {
            infowindow.open(map, marker);
        });
    }

    google.maps.event.addDomListener(window, 'load', Init);

</script>

<div class=" <?php echo ($this->Session->read('user_id') == '') ? 'right_part_fulls right_part_fulls_none' : 'right_part' ?>">
    <div class="ee"><?php echo $this->Session->flash(); ?></div>    
    <?php echo $this->element("users/profile_header"); ?>


    <div class="contat_map_box">
        <?php  if ($companyAddress != "") { ?>
            <div class="rig_con"> 
                <h3 class="fancy-title">
                    <span>&nbsp</span>
                </h3>                                       
                <div class="img_bdr_new_neww">
                    <div class="img_org_new">
                        <div id="map" style="width:100%; height: 430px;">
                            <div id='map-canvas' style="width: 100%; height: 100%;" >                                                
                            </div>                                                
                        </div>
                    </div>
                </div>
            </div> 
        <?php } ?>
    </div>
    <div class="clear"></div>

    <div class="aside_for_box">
        <div class="aside_contaner">
            <div class="contact_left">
                <div class="contact_title">Contact us</div>
                <!--<div class="cont_row desct"><strong>About:</strong> 
                    <?php /* if ($userInfo['User']['about_us'] != "") { ?>
                        <?php
                            $string = strip_tags($userInfo['User']['about_us']);
                            if (strlen($string) > 112) {
                                $stringCut = substr($string, 0, 112);
                                $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...' . $this->Html->link('view more', array('controller' => 'users', 'action' => 'aboutUs', $slug), array('escape' => false, 'class' => (isset($aboutusHeaderAct)) ? "active" : ""));
                            }
                            echo $string;
                        ?>
                        <?php
                    } else {
                        echo 'N/A';
                    } */
                    ?>
                </div>-->
                <div class="cont_row"><strong>Company: </strong><?php echo $userInfo['User']['company_name'] ?></div>
                <div class="cont_row"><strong>Address: </strong><?php
                    echo $userInfo['User']['building_number'] . ", " .
                    $userInfo['User']['street'] . ", " .
                    $userInfo['City']['city_name'] . ", " .
                    $userInfo['State']['state_name'] . ", " .
                    $userInfo['User']['zipcode'] . ", " .
                    $userInfo['Country']['name']
                    ?></div>
                <div class="cont_row"><strong>Phone: </strong><?php echo $userInfo['User']['phone'] != "" ? $userInfo['User']['phone'] : "N/A";  ?></div>
                <div class="cont_row"><strong>Fax: </strong><?php echo $userInfo['User']['fax'] != "" ? $userInfo['User']['fax'] : "N/A";  ?></div>
                <div class="cont_row "><strong>Website: </strong><?php if ($userInfo['User']['website'] != "") { ?><a href="<?php echo $userInfo['User']['website'] ?>" target="_blank"><?php echo $userInfo['User']['website'] ?></a> <?php }else{ echo "N/A"; } ?></div>
                
                <div class="cont_row"><strong>Connect with us:</strong></div>
                <div class="social_icons">
                    <ul>
                        <?php if ($userInfo['User']['facebook'] != "") { ?>
                            <li><a href="<?php echo $userInfo['User']['facebook'] ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <?php }if ($userInfo['User']['twitter'] != "") { ?>
                            <li><a href="<?php echo $userInfo['User']['twitter'] ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <?php }if ($userInfo['User']['linkedin'] != "") { ?>
                            <li><a href="<?php echo $userInfo['User']['linkedin'] ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="contact_right">
                <div class="contact_title">Send your Comments</div>
                <?php echo $this->Form->create(null, array('method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'contactUs', 'id' => 'contactUs')); ?>
                
                <!--<div class="form_row">
                    <div class="form_row_label">Name:</div>
                    <div class="form_row_inputs">
                        <?php //echo $this->Form->text('User.name', array('placeholder' => '', 'size' => '20', 'label' => '', 'div' => false, 'class' => "required subject_sub")) ?>
                    </div>
                </div>

                <div class="form_row">
                    <div class="form_row_label">Email:</div>
                    <div class="form_row_inputs">
                        <?php //echo $this->Form->text('User.email', array('placeholder' => '', 'size' => '20', 'label' => '', 'div' => false, 'class' => "required email subject_sub")) ?>
                    </div>
                </div>-->
                
                <?php
                echo $this->Form->hidden('User.name');
                echo $this->Form->hidden('User.email');
                ?>


                <div class="form_row">
                    <div class="form_row_label">Subject:</div>
                    <div class="form_row_inputs">
                        <?php echo $this->Form->text('User.subject', array('placeholder' => '', 'size' => '20', 'label' => '', 'div' => false, 'class' => "required subject_sub")) ?>
                    </div>
                </div>
                <div class="form_row">
                    <div class="form_row_label">Message:</div>
                    <div class="form_row_inputs">
                        <?php echo $this->Form->textarea('User.message', array('placeholder' => '', 'class' => 'required textarea_uinpur', 'size' => '50', 'rows' => 5, 'cols' => 5, 'label' => '', 'div' => false, 'no-resize' => true)); ?>
                    </div>
                </div>
                <div class="form_row desct_btn_sub">
                    <?php echo $this->Form->reset('Reset', array('class' => 'btn_submit', 'maxlength' => '50', 'size' => '30', 'label' => '', 'div' => false, 'value' => 'Reset')) ?>
                    <?php echo $this->Form->submit('Submit', array('title' => 'Submit', 'class' => 'btn_submit', 'size' => '30', 'label' => '', 'div' => false)) ?> 
                </div>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>