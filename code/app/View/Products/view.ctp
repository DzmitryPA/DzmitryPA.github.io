
<!--  Image Gallery -->


  <?php echo $this->Html->css('image_gallery/jquery.simpleLens.css'); ?>
  <?php echo $this->Html->css('image_gallery/jquery.simpleGallery.css'); ?>
  <?php echo $this->Html->script('image_gallery/jquery.simpleGallery.js'); ?>
  <?php echo $this->Html->script('image_gallery/jquery.simpleLens.js'); ?>

<script>
    $(document).ready(function(){
        $('#demo-1 .simpleLens-thumbnails-container img').simpleGallery({
            loading_image: 'demo/images/loading.gif'
        });

        $('#demo-1 .simpleLens-big-image').simpleLens({
            loading_image: 'demo/images/loading.gif'
        });
    });
</script>

  <div class="right_part">
<div class="aside_contaner_full">
                <div class="bread_cremsks bread_cremsks_mare">
                    <ul>

                        <li><a href="search_product.html">Product</a></li>
                        <li><a href="search_product.html">Categories</a></li>
                        <li><a href="search_product_subcategories.html">Agriculture</a></li>
                        <li>Agricultural Growing Media</li>
                    </ul>
                </div>
                <div class="clear"></div>
                <div class="left_aprt_of_gst">
                    <div class="title_of_page_riweoname revtitle_of_page_riweoname no_bordere mar_leftsk">Agricultural Growing Media</div>
                </div>
                <div class="bocx_of_sull pad_notficationbehts_mosre" style="border-radius:3px;">
                    <div class="pad_notficationbehts ">
                        <div class="slider_part_detail">
                            <div class="simpleLens-gallery-container" id="demo-1">
                                <div class="simpleLens-container">
                                    <div class="simpleLens-big-image-container">
                                        <a class="simpleLens-lens-image" data-lens-image="<?php echo HTTP_PATH ?>/img/front/product/large/pr_1.png">
                                            <?php echo $this->Html->image('product/front/thumb/pr_1.png', array('class' => 'simpleLens-big-image')); ?>
                                        </a>
                                    </div>
                                </div>

                                <div class="simpleLens-thumbnails-container">
                                    <a href="#" class="simpleLens-thumbnail-wrapper"
                                       data-lens-image="<?php echo HTTP_PATH ?>/img/front/product/large/pr_1.png"
                                       data-big-image="<?php echo HTTP_PATH ?>/img/front/product/medium/product/pr_1.png">
                                        <?php echo $this->Html->image('front/product/thumb/pr_1.png'); ?>
                                    </a>
                                    <a href="#" class="simpleLens-thumbnail-wrapper"
                                       data-lens-image="<?php echo HTTP_PATH ?>/img/front/product/large/pr_1.png"
                                       data-big-image="<?php echo HTTP_PATH ?>/img/front/product/pr_1.png">
                                        <?php echo $this->Html->image('product/front/thumb/pr_1.png'); ?>
                                    </a>
                                    <a href="#" class="simpleLens-thumbnail-wrapper"
                                       data-lens-image="<?php echo HTTP_PATH ?>/img/front/product/large/pr_1.png"
                                       data-big-image="<?php echo HTTP_PATH ?>/img/front/product/pr_1.png">
                                        <?php echo $this->Html->image('front/product/thumb/pr_1.png'); ?>
                                    </a>
                                    <a href="#" class="simpleLens-thumbnail-wrapper"
                                       data-lens-image="<?php echo HTTP_PATH ?>/img/front/product/large/pr_1.png"
                                       data-big-image="<?php echo HTTP_PATH ?>/img/front/product/pr_1.png">
                                        <?php echo $this->Html->image('front/product/thumb/pr_1.png'); ?>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="right_part_detail">
                            <div class="left_part_fr_dhfnsrsa">
                                
                                <div class="devide_parts_cols">
                                    <div class="devide_parts_row">
                                        <label>Name:</label><span>Agricultural Growing Media</span>
                                    </div>
                                    <div class="devide_parts_row">
                                    <label>Category:</label><span>Consumer Electronic</span>
                                    </div>
                                    <div class="devide_parts_row">
                                    <label>Sub-Category:</label><span>Mobile Phones</span>
                                    </div>
                                    <div class="devide_parts_row">
                                    <label>Price:</label><span>$500</span>
                                    </div>
                                    <div class="devide_parts_row">
                                    <label>Delivery Cost:</label><span>Negotiated</span>
                                    </div>
                                </div>
                                <div class="devide_parts_cols">
                                  
                                    
                                    <div class="devide_parts_row">
                                    <label>Minimum Order:</label><span>100 pieces</span>
                                    </div>
                                    
                                    <div class="devide_parts_row">
                                    <label>Completed orders:</label><span>210</span>
                                    </div>
                                    
                                </div>

                            </div>
                            <div class="product_rating_sections">
                                <div class="this_project_tag">
                                    <div class="this_project_tag_img"><img src="img/apple_icn_small.png" alt="img"></div>
                                    <div class="this_project_tag_name"><a href="#">Apple INC</a></div>
                                </div>
                                <div class="clear"></div>
                                <div class="rating_oevral">
                                    <div class="box_of_rating_full_row_title">Overall Rating</div>
                                    <div class="box_of_rating_full_row_rating"><img src="img/rating_of_img.png" alt="img"></div>
                                </div>
                                <div class="clear"></div>
                                <div class="rating_oevral">
                                    <div class="half_sectoos">
                                        <div class="box_of_rating_full_row_title">Overall Rating</div>
                                        <div class="box_of_rating_full_row_rating"><img src="img/rating_of_img_smll.png" alt="img"></div>
                                    </div>
                                     <div class="half_sectoos">
                                        <div class="box_of_rating_full_row_title">Delivery time</div>
                                        <div class="box_of_rating_full_row_rating"><img src="img/rating_of_img_smll.png" alt="img"></div>
                                    </div>
                                </div>
                                
                                <div class="rating_oevral">
                                    <div class="half_sectoos">
                                        <div class="box_of_rating_full_row_title">Contact</div>
                                        <div class="box_of_rating_full_row_rating"><img src="img/rating_of_img_smll.png" alt="img"></div>
                                    </div>
                                     <div class="half_sectoos">
                                        <div class="box_of_rating_full_row_title">Professionalism</div>
                                        <div class="box_of_rating_full_row_rating"><img src="img/rating_of_img_smll.png" alt="img"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="clear"></div>
                            
                            <div class="wemotilonal_tak">
                                
                                    <div class="button_expemnzne">
                                        <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i> <span> Ask about Product</span></a>
                                    </div>
                               
                                    <div class="button_expemnzne secoms_shfaj">
                                        <a href="#"><img src="img/chart_icon_white.png" class="fa" alt="img"/> <span>Send Buying Lead</span></a>
                                    </div>                               
                                
                                    <div class="button_expemnzne secomsfor_shfaj">
                                        <a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Order</span></a>
                                    </div>
                               
                            </div>
                            
                        </div>
                        
                        
                        <div class="clear"></div>   
                        <div class="line_seprate_secs"></div>
                        <div class="sdksf_bikul">
                            <div class="data_dfetail_left">
                                <p><span>Apple iPhone 5S:</span> Apple iPhone 5s smartphone was launched in September 2013. The phone comes with a 4.00-inch touchscreen display with a resolution of 640 pixels by 1136 pixels at a PPI of 326 pixels per inch. </p>

                                <p>The Apple iPhone 5s is powered by 1.3GHz dual-core Apple A7 (64-bit ARMv8) processor and it comes with 1GB of RAM. The phone packs 16GB of internal storage cannot be expanded. As far as the cameras are concerned, the Apple iPhone 5s packs a 8-megapixel primary camera on the rear and a 1.2-megapixel front shooter for selfies.</p> 

                                <p>The Apple iPhone 5s runs iOS 7 and is powered by a 1570mAh non removable battery. It measures 123.80 x 58.60 x 7.60 (height x width x thickness) and weighs 112.00 grams. </p>

<P>The Apple iPhone 5s is a single SIM (GSM) smartphone that accepts a Nano-SIM. Connectivity options include Wi-Fi, GPS, Bluetooth, 4G (with support for Band 40 used by some LTE networks in India). Sensors on the phone include Proximity sensor, Ambient light sensor, Accelerometer, and Gyroscope. 
</p>
                            </div>

                            <div class="data_dfetail_right">
                                <div class="vs_data_dfetail_right">
                                    <img src="img/mob_img_sbfjs.png" alt="img"/>                                                          
                                </div>
                            </div>
                        </div>
                    </div>                    
                    
                    
                </div>
                </div>
                </div>