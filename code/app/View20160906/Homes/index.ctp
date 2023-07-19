<script type="text/javascript"> window.jQuery || document.write('<script src="js/jquery.min.js">'+"<"+"/script>"); </script><script src="js/jquery.min.js"></script><script src="js/jquery.min.js"></script>
<?php echo $this->Html->script('jquery.scroll-reveal.js'); ?>
<script>
$(document).ready(function(){
    $.fn.scrollReveal();  
});
</script>
<script>
$(document).ready(function(){
    $("#show_features").click(function(){
        $(".col_three_row_hidden").slideToggle();     
        $("#show_features").slideToggle("hidden");     
    });  
});
</script>



<div class="right_part_fulls right_part_fulls_none">
    <div class="post_rela">
    <div class="home_page_bg">
        <div class="container">
            <h2>Business is our passion!</h2>
            <div class="clear"></div>
            <div class="image_of_bud"><img src="img/front/b2b_part.png" alt="img"/></div>
        </div>
    </div>
    <div class="home_how_work_section">
        <div class="container">
            <div class="text-center">
                <div class="title_of_aside">How It Works</div>
            </div>
            <div class="clear"></div>
            
            <div class="work_how_timeline">
                <ul>
                    <li class="right_align js-reveal">
                        <span class="time_line_count">1</span>
                        <div class="work_how_timeline_data">
                            <h2>Create Company Profile</h2>
                            <p>Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>
                    </li>
                    <li class="left_align js-reveal">
                        <span class="time_line_count">2</span>
                        <div class="work_how_timeline_data">
                            <h2>Add your Products or Services</h2>
                            <p>Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>
                    </li>
                    
                    <li class="right_align js-reveal">
                        <span class="time_line_count">3</span>
                        <div class="work_how_timeline_data">
                            <h2>Invite your Customers / Suppliers</h2>
                            <p>Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>
                    </li>
                    <li class="left_align js-reveal">
                        <span class="time_line_count">4</span>
                        <div class="work_how_timeline_data">
                            <h2>Offer Sales / Buying Leads</h2>
                            <p>Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>
                    </li>
                    
                    
                    <li class="right_align js-reveal">
                        <span class="time_line_count">5</span>
                        <div class="work_how_timeline_data">
                            <h2>Make Transactions</h2>
                            <p>Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>
                    </li>
                    <li class="left_align js-reveal">
                        <span class="time_line_count">6</span>
                        <div class="work_how_timeline_data">
                            <h2>Generate Invoices</h2>
                            <p>Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>
                    </li>
                    <li class="right_align js-reveal">
                        <span class="time_line_count">7</span>
                        <div class="work_how_timeline_data">
                            <h2>Make Payment</h2>
                            <p>Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>
                    </li>
                    
                    
                </ul>
            </div>
        </div>
    </div>
    
    <div class="home_about_section">
        <div class="container">
            <div class="text-center">
                <div class="title_of_aside title_of_aside_white">About Stafir</div>                
            </div>
            <div class="clear"></div>
            <p class="about_sec_psl">
                The business to business networking website to offer trading between companies like trading, manufacturing, wholesalers, retailers, contractors except government organizations. Companies can exchange between wide range of products & offered services.
            </p>
            <div class="about_anckir"><?php echo $this->Html->link('About Us', array('controller' => 'pages', 'action' => 'staticpage', 'slug' => 'about-us'), array('escape' => false, 'class' => '')); ?></div>
        </div>
    </div>
    
    <div class="home_how_work_section">
        <div class="container">
            <div class="text-center">
                <div class="title_of_aside">Features We Offer</div>
            </div>
            <div class="clear"></div>
            
            <div class="col_three_row">
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/icn_fet_1.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Dashboard</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/icn_fet_2.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Messaging</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/icn_fet_3.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Transactions / Leads</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
            </div>
            
            <div class="col_three_row">
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/icn_fet_4.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Responsive Design</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/icn_fet_5.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Invoicing</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/icn_fet_6.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Company Rating</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
            </div>
            
            
            
            <div class="col_three_row col_three_row_hidden">
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/piblication.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Publications</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/customer.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Customers/Suppliers Managment</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/product.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Products / Services Showcase</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
            </div>
            
            
            <div class="col_three_row col_three_row_hidden">
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/profile.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Profile customization</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>
                <div class="col_row_of js-reveal">
                    <div class="feature_box_plus">
                        <div class="feature_box_plus_img"><img src="img/front/social.png" alt="img"/></div>
                        <div class="feature_box_plus_title">Social Network</div>
                        <div class="feature_box_plus_p">Lorem Ipsum is the dummy text of the printing and typesetting industry. It has survived not only five centuries.</div>
                    </div>
                </div>                
            </div>
            
            <div class="clear"></div>                
            <div class="about_anckir about_anckir_nt" id="show_features"><a>View More</a></div>
            
        </div>
    </div>
    
    <div class="app_shoew_secion">
        <div class="container">
            <div class="app_shoew_secion_left js-reveal">
                <div class="text-center">
                    <div class="title_of_aside">android and iOS app</div>
                    <div class="sta_tils_se">Stafir App for Android and iOS.<br/>Its Under Construction and will be Coming Soon.</div>
                    <div class="fata_of_app">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
                    
                    <div class="clear"></div>
                    <div class="btn_of_apps">
                        <a class="android_app_store"></a>
                        <a class="apple_app_store"></a>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="app_shoew_secion_right js-reveal">
                <img src="img/front/img_of_app_phone.png" alt="img"/>
            </div>
        </div>
    </div>
    
    <div class="contact_info_section_home">
        <div class="container">
            <div class="text-center">
                <div class="title_of_aside title_of_aside_white">Contact Information</div>                
            </div>
            
            <div class="contact_info_cols js-reveal">
                <div class="contact_info_cols_iucn"><img src="img/front/location_ins.png" alt="img"/></div>
                <div class="contact_info_cols_cont"><h2>Address:</h2><p><?php echo $adminInfo['Admin']['address'] ?></p></div>
            </div>
            <div class="contact_info_cols js-reveal">
                <div class="contact_info_cols_iucn"><img src="img/front/cont_email_se.png" alt="img"/></div>
                <div class="contact_info_cols_cont"><h2>Email:</h2><p><?php echo $adminInfo['Admin']['contact_email'] ?></p></div>
            </div>
        </div>
    </div>
    
    
<script src="https://maps.googleapis.com/maps/api/js" type="text/javascript"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<script>
    var map;
    function Init() {
        var geocoder = new google.maps.Geocoder();    // instantiate a geocoder object
        var address = '<?php echo $adminInfo['Admin']['address']; ?>';

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
                '<div class="inflseven"><?php echo $adminInfo['Admin']['address']; ?></div>' +
               '</div>'; 	// HTML text to display in the InfoWindow
        var infowindow = new google.maps.InfoWindow({content: contentString});
        google.maps.event.addListener(marker, 'mouseover', function () {
            infowindow.open(map, marker);
        });
    }

    google.maps.event.addDomListener(window, 'load', Init);

</script>
    
    
    <div class="map_home_bg">
        <!--<img src="img/front/map_home.png" alt="img"/>-->
        <!--<iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d7096045.389753992!2d76.93205260895272!3d29.723643088897383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x396c4adf4c57e281%3A0xce1c63a0cf22e09!2sJaipur%2C+Rajasthan!3m2!1d26.9124336!2d75.7872709!5e0!3m2!1sen!2sin!4v1464955579070" width="100%" height="450" style="border:0" allowfullscreen></iframe>-->
    
        <?php  if ($adminInfo['Admin']['address']) { ?>
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
                            <?php }  ?>
    </div>
    

    </div>