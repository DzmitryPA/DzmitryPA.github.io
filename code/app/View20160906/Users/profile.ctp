<script>
    $(document).ready(function () {

// Make offer

        $("#makeoffer_popup").click(function () {
            $("#makeoffer_popup_box").slideToggle("");
        });
        $("#makeoffer_popup_box_close").click(function () {
            $("#makeoffer_popup_box").hide();
        });
        $("#makeoffer_popup").click(function () {
            $("#makeoffer_popup").slideShow();
        });


// Trade Comment

        $("#comment_trade").click(function () {
            $("#comment_trade_box").toggle("");
        });

        // news Comment

        $("#comment_news").click(function () {
            $("#comment_news_box").toggle("");
        });

        // lead Comment

        $("#comment_lead").click(function () {
            $("#comment_lead_box").toggle("");
        });

    });
</script>


<div class=" <?php echo ($this->Session->read('user_id') == '') ? 'right_part_fulls right_part_fulls_none' : 'right_part'  ?>">

    <div class="ee"><?php echo $this->Session->flash(); ?></div>
    <?php echo $this->element("users/profile_header"); ?>

    <div class="content_of_parts">
        <?php
        if (!empty($userInfo['User']['slider_img'])) {
            ?>
            <div class="slider_banner">
                <div id="myCarousel" class="carousel slide" data-ride="carousel"> 
                    <div class="carousel-inner">
                        <?php
                        $sliderImgs = explode(',', $userInfo['User']['slider_img']);
                        $i = 0;
                        foreach ($sliderImgs as $sliderImg) {
                            ++$i;
                            ?>
                            <div class="item <?php echo ($i == 1 ? "active" : "") ?>">
                                <?php echo $this->Html->image(DISPLAY_SLIDER_PATH . $sliderImg, array('alt' => 'Slider Image')); ?>
                            </div>
                        <?php } ?>



                    </div>
                    <!--<a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span></a> 
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span></a> -->

                    <ol class="carousel-indicators">
                        <?php
                        $i = 0;
                            foreach ($sliderImgs as $sliderImg) {
                        ?>
                            <li data-target="#myCarousel" data-slide-to="<?php echo $i ?>" class="<?php echo $i==0 ?'active':'' ?>"></li>
                        <?php
                            ++$i;
                        }
                        ?>
                    </ol>

                </div>
            </div>
<?php } ?>
    </div>

    <div class="aside_for_box aside_company">
        <div class="aside_contaner">
            <div class="text-center">
                <div class="title_of_aside">Company information</div>
            </div>
            <div class="clear"></div>

            <div class="trade_box">
                <div class="trade_box_cols">
                    <div class="trade_box_cols_title">Industry</div>
                    <div class="trade_box_cols_title_value"><?php echo ($userInfo['Industry']['name'] != "") ? $userInfo['Industry']['name'] : "N/A" ?></div>
                </div> 
                <div class="trade_box_cols">
                    <div class="trade_box_cols_title">Category</div>
                    <div class="trade_box_cols_title_value"><?php echo ($userInfo['IndustrySubCategory']['name'] != "") ? $userInfo['IndustrySubCategory']['name'] : "N/A" ?></div>
                </div> 
                <div class="trade_box_cols">
                    <div class="trade_box_cols_title">Employer Identification Number</div>
                    <div class="trade_box_cols_title_value"><?php echo ($userInfo['User']['ein'] != "") ? $userInfo['User']['ein'] : "N/A" ?></div>
                </div> 
            </div>

            <div class="trade_box">
                <div class="trade_box_cols">
                    <div class="trade_box_cols_title">Chairman</div>
                    <div class="trade_box_cols_title_value"><?php echo ($userInfo['User']['chairman'] != "") ? $userInfo['User']['chairman'] : "N/A" ?></div>
                </div> 
                <div class="trade_box_cols">
                    <div class="trade_box_cols_title">Year establishment</div>
                    <div class="trade_box_cols_title_value"><?php echo ($userInfo['User']['est_year'] != "") ? $userInfo['User']['est_year'] : "N/A" ?></div>
                </div> 
                <div class="trade_box_cols">
                    <div class="trade_box_cols_title">Employees</div>
                    <div class="trade_box_cols_title_value"><?php echo ($userInfo['User']['employers'] != "") ? $userInfo['User']['employers'] : "N/A" ?></div>
                </div> 
            </div>

            <div class="trade_box trade_box_last">
                <div class="trade_box_cols">
                    <div class="trade_box_cols_title">Certificate</div>
                    <div class="trade_box_cols_title_value"><?php echo $userInfo['User']['certificate_number'] ?>
                    </div>
                </div> 
                <div class="trade_box_cols">
                    <div class="certificate_img">
                                <?php /* if (!empty($userInfo['User']['certificates'])) { ?>
                            <div class="download_link"><p class="estimate_document_download">
                            <?php echo $this->Html->link('<i class="fa fa-download"></i> Download', array('controller' => 'users', 'action' => 'download', 'User', 'certificates', md5($userInfo['User']['id']), $userInfo['User']['id']), array('title' => 'Download Attachment', 'class' => 'dnld_detail', 'escape' => false)); ?>
                                </p></div> 
                            <?php
                        } else {
                            echo "Not Uploaded";
                        } */
                        ?>
            <?php 
                if (!empty($userInfo['User']['certificates'])) {
                    echo $this->Html->image(DISPLAY_CRTIFICATE_PATH . $userInfo['User']['certificates'], array('alt' => 'Certificate Image')); 
                }else{
                    echo "N/A";
                } ?>
            </div>
                </div> 
            </div>
        </div>
    </div>


    <div class="aside_for_box">
        <div class="aside_contaner">
            <div class="text-center">
                <div class="title_of_aside">News</div>
            </div>
            <div class="clear"></div>

            <div class="timeline_sections">
                <div class="timeline_sections_box pad_botossd">
                    <div class="timeline_sections_left">
                        <div class="timeline_sections_left_date">
                            today
                            <span>04:20</span>
                        </div>
                        <div class="timeline_sections_left_icon"><span class="handshake_icon"></span></div>
                    </div>
                    <div class="timeline_sections_right">
                        <div class="timeline_sections_right_top">
                            <div class="timeline_sections_right_top_header">
                                <div class="this_project_tag">
                                    <div class="this_project_tag_img"><?php echo $this->Html->image('front/apple_icn_small.png', array('alt'=>'Img')); ?></div>
                                    <div class="this_project_tag_name"><a href="#">Apple</a></div>
                                </div>
                                <div class="total_views">18 Views</div>
                                <span class="title-cmal_top"><a href="javascript:void(0)">@my_company</a></span>
                            </div>
                            <div class="timeline_sections_right_top_content">
                                <p>Location: Cupertino, California, United States</p>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled... <a href="#">Show More</a></p>
                            </div>
                        </div>
                        <div class="timeline_sections_right_footer">
                            <div class="comment_liks"><a id="comment_trade"><i class="fa fa-comments" aria-hidden="true"></i> Comment</a></div>
                        </div>                                
                    </div>
                    <div class="comment_today_section" id="comment_trade_box">
                        <form action="">
                            <textarea class="com_textareasexcr" placeholder="Write your comment here"></textarea>
                            <input type="button" class="post_com_btnn" name="comment" value="Post Comment"/>
                        </form>
                    </div>
                </div>




                <div class="timeline_sections_box">
                    <div class="timeline_sections_left">
                        <div class="timeline_sections_left_date">
                            Yesterday
                            <span>04:20</span>
                        </div>
                        <div class="timeline_sections_left_icon"><span class="news_ocnjkdj"></span></div>
                    </div>
                    <div class="timeline_sections_right">
                        <div class="timeline_sections_right_top">
                            <div class="timeline_sections_right_top_header">
                                <div class="this_project_tag">
                                    <div class="this_project_tag_img"><?php echo $this->Html->image('front/apple_icn_small.png', array('alt'=>'Img')); ?></div>
                                    <div class="this_project_tag_name"><a href="#">Apple</a></div>
                                </div>
                                <div class="total_views">1,021,282 Views</div>
                                <span class="title-cmal_top"><a href="javascript:void(0)">@my_company</a></span>
                            </div>
                            <div class="timeline_sections_right_top_content">

                                <p>In hac habitasse platea dictumst. Pellentesque bibendum id sem nec faucibus. Maecenas molestie, augue vel accumsan rutrum, massa mi rutrum odio, id luctus mauris nibh ut leo.</p>
                                <div class="image_sss"><?php echo $this->Html->image('front/aplephone_ig.png', array('alt'=>'Img')); ?></div>
                            </div>
                        </div>
                        <div class="timeline_sections_right_footer">
                            <div class="comment_liks"><a id="comment_news"><i class="fa fa-comments" aria-hidden="true"></i> Comment</a></div>
                        </div>                                
                    </div>
                    <div class="comment_today_section" id="comment_news_box">
                        <form action="">
                            <textarea class="com_textareasexcr" placeholder="Write your comment here"></textarea>
                            <input type="button" class="post_com_btnn" name="comment" value="Post Comment"/>
                        </form>
                    </div>
                </div>





                <div class="timeline_sections_box">
                    <div class="timeline_sections_left">
                        <div class="timeline_sections_left_date">
                            10 January 2014
                            <span>04:20</span>
                        </div>
                        <div class="timeline_sections_left_icon"><span class="rwing"></span></div>
                    </div>
                    <div class="timeline_sections_right">
                        <div class="timeline_sections_right_top">
                            <div class="timeline_sections_right_top_header">
                                <div class="this_project_tag">
                                    <div class="this_project_tag_img"><?php echo $this->Html->image('front/apple_icn_small.png', array('alt'=>'Img')); ?></div>
                                    <div class="this_project_tag_name"><a href="#">Apple</a></div>
                                </div>
                                <div class="total_views">1,021,282 Views</div>
                                <span class="title-cmal_top"><a href="javascript:void(0)">@my_company</a></span>
                            </div>
                            <div class="timeline_sections_right_top_content">
                                <div class="titlke_of_buying_eled">Product Name</div>
                                <p>Hi, Im looking for complete furniture to my small office.</p>
                                <div class="image_sss"><?php echo $this->Html->image('front/bamnch_idf.png', array('alt'=>'Img')); ?></div>
                            </div>
                            <div class="timeline_sections_right_top_contentaba">
                                <span class="let_bas">Quantity: 2 pieces</span>
                                <span class="right_bas">Asking Price:$ 1,400</span>
                            </div>

                        </div>
                        <div class="timeline_sections_right_footer">
                            <div class="comment_liks"><a id="comment_lead"><i class="fa fa-comments" aria-hidden="true"></i> Comment</a></div>
                            <div class="make_offer_btn"><a id="makeoffer_popup">Make Offer</a></div>
                        </div> 
                    </div>
                    <div class="comment_today_section" id="comment_lead_box">
                        <form action="">
                            <textarea class="com_textareasexcr" placeholder="Write your comment here"></textarea>
                            <input type="button" class="post_com_btnn" name="comment" value="Post Comment"/>
                        </form>
                    </div>
                </div>




                <div class="timeline_sections_box loadinfg">
                    <div class="timeline_sections_left">
                        <div class="timeline_sections_left_icon"><i class="fa fa-spinner" aria-hidden="true"></i></div>
                    </div>
                    <div class="timeline_sections_right loading_content_ful">
                        <div class="loading_content">Loading...</div>                               
                    </div>
                </div>






            </div>
        </div>
    </div>
</div>



<div class="popup_full_sectiuons" id="makeoffer_popup_box">
    <div class="popup_insude_box">
        <div class="popup_close_btn" id="makeoffer_popup_box_close"></div>
        <h3 class="title_of_popup">Make Offer</h3>
        <div class="popup_insude_box_ins">
            <div class="popup_insude_box_ins_nofull">
                <div class="popup_fomr_row">
                    <label class="popup_title">Write Your Offer</label>
                    <div class="input_sor_boc">
                        <input type="text" name="write your offer"  class="popup_formtce"/>
                    </div>
                </div>

                <div class="popup_fomr_row">
                    <label class="popup_title">Price</label>
                    <div class="input_sor_boc">
                        <input type="text" name="Price"  class="popup_formtce"/>
                    </div>
                </div>


                <div class="popup_fomr_row">
                    <label class="popup_title">Quantity</label>
                    <div class="input_sor_boc">
                        <input type="text" name="Price"  class="popup_formtce"/>
                    </div>
                </div>


                <div class="popup_fomr_row">
                    <input type="button" name="skip" value="Submit" class="btn_add_sjskd"/>
                </div> 
            </div>
        </div>
    </div>
</div>

