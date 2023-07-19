<?php if ($timelines) { ?>
    <?php
    foreach ($timelines as $timeline) {
        ?>
        <div class="timeline_sections_box pad_botossd">
            <div class="timeline_sections_left">
                <div class="timeline_sections_left_date">
                    <?php
                    if (date('Y-m-d') == date('Y-m-d', strtotime($timeline['Timeline']['created']))) {
                        echo "today";
                    } elseif (date('Y-m-d', strtotime("-1 days")) == date('Y-m-d', strtotime($timeline['Timeline']['created']))) {
                        echo "yesterday";
                    } else {
                        echo date('j F Y', strtotime($timeline['Timeline']['created']));
                    }
                    ?>

                    <span><?php echo date('H:i', strtotime($timeline['Timeline']['created']));
                    ?></span>
                </div>
                <div class="timeline_sections_left_icon"><span class="
                    <?php
                    if ($timeline['Timeline']['post_type'] == 0) {
                        echo 'handshake_icon';
                    } elseif ($timeline['Timeline']['post_type'] == 1) {
                        echo 'news_ocnjkdj';
                    } elseif ($timeline['Timeline']['post_type'] == 2) {
                        echo 'rwing';
                    }
                    ?>"></span></div>
            </div>
            <div class="timeline_sections_right">
                <div class="timeline_sections_right_top">
                    <div class="timeline_sections_right_top_header">
                        <div class="this_project_tag">
                            <div class="this_project_tag_img">
                                <?php
                                $filePath = UPLOAD_LOGO_PATH . $timeline['User']['company_logo'];
                                if (file_exists($filePath) && $timeline['User']['company_logo']) {
                                    echo $this->Html->link($this->Html->image(DISPLAY_LOGO_PATH . $timeline['User']['company_logo'], array('alt' => 'Img')), array('controller' => 'users', 'action' => 'profile', $timeline['User']['slug']), array('escape' => false, 'class' => ''));
                                } else {
                                    echo $this->Html->link($this->Html->image('no_image.gif'), array('controller' => 'users', 'action' => 'profile', $timeline['User']['slug']), array('escape' => false, 'class' => ''));
                                }
                                ?>
                            </div>
                            <div class="this_project_tag_name"><?php echo $this->Html->link($timeline['User']['company_name'], array('controller' => 'users', 'action' => 'profile', $timeline['User']['slug']), array('escape' => false, 'class' => '')); ?></div>
                        </div>
                        <div class="total_views">18 Views</div>
                        <span class="title-cmal_top"><a href="javascript:void(0)">@<?php echo $timeline['User']['unique_id'] ?></a></span>
                    </div>

                    <div class="timeline_sections_right_top_content">
                        <?php if ($timeline['Timeline']['post_type'] == 2) { ?>
                            <div class="titlke_of_buying_eled"><?php echo ($timeline['Timeline']['product_name'] != "") ? $timeline['Timeline']['product_name'] : "N/A"; ?></div>
                        <?php } ?>
                        <p><?php echo $timeline['Timeline']['description'] ?> <a href="#">Show More</a></p>
                        <?php if ($timeline['Timeline']['image'] != "") { ?>
                            <div class="image_sss">
                                <?php
                                $filePath = UPLOAD_TIMELINE_POST_PATH . $timeline['Timeline']['image'];
                                if (file_exists($filePath) && $timeline['Timeline']['image']) {
                                    echo $this->Html->image(DISPLAY_TIMELINE_POST_PATH . $timeline['Timeline']['image'], array('alt' => 'Img'));
                                } else {
                                    echo $this->Html->image('no_image.gif');
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($timeline['Timeline']['post_type'] == 2) { ?>
                        <div class="timeline_sections_right_top_contentaba">
                            <span class="let_bas">Quantity: <?php echo $timeline['Timeline']['quantity']; ?> <?php echo ($timeline['Timeline']['unit_type'] == 1) ? $timeline['Timeline']['unit_value'] : 'pieces' ?></span>
                            <span class="right_bas">Asking Price: <?php echo CURRENCY . " " . $timeline['Timeline']['asking_price']; ?></span>
                        </div>
                    <?php } ?>
                </div>
                <div class="timeline_sections_right_footer">
                    <div class="comment_liks"><a onclick="showCommentFormMain(<?php echo $timeline['Timeline']['id'] ?>)" id="comment_shwbutton<?php echo $timeline['Timeline']['id'] ?>"><i class="fa fa-comments" aria-hidden="true"></i> Comment</a></div>
                    <?php if ($timeline['Timeline']['post_type'] == 2) { ?>
                    <?php if ($timeline['Timeline']['user_id'] != $this->Session->read('user_id')) { ?>
                        <div class="make_offer_btn"><a id="makeoffer_popup<?php echo $timeline['Timeline']['id'] ?>" onclick="showMakeOffer(<?php echo $timeline['Timeline']['id'] ?>)">Make Offer</a></div>
                    <?php } } ?>
                </div>                                
            </div>
            <div class="comment_today_section" id="comment_formdiv<?php echo $timeline['Timeline']['id'] ?>">
                <div class="prev_comment_section precommsect<?php echo $timeline['Timeline']['id'] ?>">
                    <?php
                    $allTimelineComm = ClassRegistry::init('Comment')->find('all', array('conditions' => array('Comment.timeline_id' => $timeline['Timeline']['id'], 'Comment.status' => 1), 'order' => 'Comment.id ASC'));
                    if ($allTimelineComm) {
                        foreach ($allTimelineComm as $comment) {
                            ?>
                            <div class="comment_container comment_mndv<?php echo $comment['Comment']['slug'] ?>">
                                <div class="comment_upper">
                                    <div class="this_project_tag_img img_comment">
                                        <?php
                                        $filePath = UPLOAD_LOGO_PATH . $comment['User']['company_logo'];
                                        if (file_exists($filePath) && $comment['User']['company_logo']) {
                                            echo $this->Html->link($this->Html->image(DISPLAY_LOGO_PATH . $comment['User']['company_logo'], array('alt' => 'Img')), array('controller' => 'users', 'action' => 'profile', $comment['User']['slug']), array('escape' => false, 'class' => ''));
                                        } else {
                                            echo $this->Html->link($this->Html->image('no_image.gif'), array('controller' => 'users', 'action' => 'profile', $comment['User']['slug']), array('escape' => false, 'class' => ''));
                                        }
                                        ?>
                                    </div>
                                    <div class="this_project_tag_name name_comment"><?php echo $this->Html->link($comment['User']['company_name'], array('controller' => 'users', 'action' => 'profile', $comment['User']['slug']), array('escape' => false, 'class' => '')); ?></div>
                                    <div class="datetime_comment">
                                        <?php
                                        if (date('Y-m-d') == date('Y-m-d', strtotime($comment['Comment']['created']))) {
                                            echo "today";
                                        } elseif (date('Y-m-d', strtotime("-1 days")) == date('Y-m-d', strtotime($comment['Comment']['created']))) {
                                            echo "yesterday";
                                        } else {
                                            echo date('j F Y', strtotime($comment['Comment']['created']));
                                        }
                                        ?>

                                        <span><?php echo date('H:i', strtotime($comment['Comment']['created']));
                                        ?></span>
                                    </div>
                                </div>
                                <div class="comment_lower">
                                    <span> <?php echo $comment['Comment']['comment'] ?> </span>
                                    <?php
                                    if ($comment['Comment']['from_user_id'] == $userInfo['User']['id']) {
                                        echo $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', 'javascript:void(0);', array('escape' => false, 'class' => '', 'onclick' => "deleteComment(" . $comment['Comment']['from_user_id'] . ",'" . $comment['Comment']['slug'] . "')"));
                                    }
                                    ?>
                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="btm_loader1" id="comment_loader<?php echo $timeline['Timeline']['id'] ?>"> <?php echo $this->Html->image('loading_bl.svg'); ?></div>
                <script>
                    $(document).ready(function () {
                        $("#postcomment<?php echo $timeline['Timeline']['id'] ?>").validate({
                        });
                    });
                </script>
                <?php echo $this->Form->create(Null, array('id' => 'postcomment' . $timeline['Timeline']['id'])); ?>
                <?php echo $this->Form->textarea('Comment.comment', array('class' => 'com_textareasexcr required', 'id' => 'txtara_comm' . $timeline['Timeline']['id'], 'placeholder' => 'Write your comment here')); ?>
                <input type="hidden" id="" name="data[Comment][timeline_id]" value="<?php echo $timeline['Timeline']['id'] ?>" >
                <input type="button" class="post_com_btnn" name="comment" id="postcomm<?php echo $timeline['Timeline']['id'] ?>" value="Post Comment" onclick="saveData(<?php echo $timeline['Timeline']['id'] ?>);"/>
                <?php echo $this->Form->end(); ?>

            </div>
        </div>

        <?php if ($timeline['Timeline']['post_type'] == 2) { ?>
            <div class="popup_full_sectiuons" id="makeoffer_popup_box<?php echo $timeline['Timeline']['id'] ?>">
                <div class="popup_insude_box">
                    <div class="popup_close_btn" id="makeoffer_popup_box_close<?php echo $timeline['Timeline']['id'] ?>" onclick="hideMakeOffer(<?php echo $timeline['Timeline']['id'] ?>)"></div>
                    <h3 class="title_of_popup">Make Offer</h3>
                    <script>
                        $(document).ready(function () {
                            $("#postoffer<?php echo $timeline['Timeline']['id'] ?>").validate({
                                submitHandler: function (form) {
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo HTTP_PATH; ?>/timelines/saveOfferData/',
                                        data: $('#postoffer<?php echo $timeline['Timeline']['id'] ?>').serialize(),
                                        beforeSend: function () {
                                            $("#loaderId").show();
                                        },
                                        success: function (result) {
                                            $("#loaderId").hide();
                                            if (result == 1) {
                                                $('#successmsg_<?php echo $timeline['Timeline']['id'] ?>').show();
                                                setTimeout(function() { hideMakeOffer(<?php echo $timeline['Timeline']['id'] ?>); }, 3000);
                                            } else {
                                                $('#errormsg_<?php echo $timeline['Timeline']['id'] ?>').show();
                                                setTimeout(function() { hideMakeOffer(<?php echo $timeline['Timeline']['id'] ?>); }, 3000);
                                            }
                                        }
                                    });
                                }
                            });
                        });
                    </script>
                    <div class="popup_insude_box_ins">
                        <?php echo $this->Form->create(Null, array('id' => 'postoffer' . $timeline['Timeline']['id'])); ?>
                        <div class="ee">
                            <div style="width:100%; display: none; float: left;" id="successmsg_<?php echo $timeline['Timeline']['id'] ?>" class="alert alert-success successErrorMsg">
                                Your offer has been posted succesfully.
                            </div>
                            <div style="width:100%; display: none; float: left;" id="errormsg_<?php echo $timeline['Timeline']['id'] ?>" class="alert alert-danger successErrorMsg">
                                An Error Occured while posting your offer, Please try again.
                            </div>
                        </div>
                        <div class="popup_insude_box_ins_nofull">
                            <div class="popup_fomr_row">
                                <label class="popup_title">Write Your Offer</label>
                                <div class="input_sor_boc">
                                    <?php echo $this->Form->text('Offer.offer', array('class' => 'popup_formtce required', 'id' => 'offer_lead' . $timeline['Timeline']['id'], 'placeholder' => '')); ?>
                                </div>
                            </div>

                            <div class="popup_fomr_row">
                                <label class="popup_title">Price</label>
                                <div class="input_sor_boc">
                                    <?php echo $this->Form->text('Offer.price', array('class' => 'popup_formtce required number', 'id' => 'offer_price' . $timeline['Timeline']['id'], 'placeholder' => '', 'min' => '0')); ?>
                                </div>
                            </div>


                            <div class="popup_fomr_row">
                                <label class="popup_title">Quantity</label>
                                <div class="input_sor_boc">
                                    <?php echo $this->Form->text('Offer.quantity', array('class' => 'popup_formtce required digit', 'id' => 'offer_quantity' . $timeline['Timeline']['id'], 'placeholder' => '', 'min' => '1')); ?>
                                </div>
                            </div>


                            <div class="popup_fomr_row">
                                <input type="hidden"  name="data[Offer][timeline_id]" value="<?php echo $timeline['Timeline']['id'] ?>" >
                                <?php echo $this->Form->submit('Submit', array('class' => 'btn_add_sjskd', 'id' => '', 'div' => false)); ?>
                            </div> 
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
    }
    ?>

    <div class="timeline_sections_box loadinfg" id="loaderPartMore" style="display: none">
        <div class="timeline_sections_left">
            <div class="timeline_sections_left_icon"><i class="fa fa-spinner" aria-hidden="true"></i></div>
        </div>
        <div class="timeline_sections_right loading_content_ful">
            <div class="loading_content">Loading...</div>                               
        </div>
    </div>

    <div style="display: none" id="noMoreResult">
        <div class="timeline_sections_box loadinfg" >
            <div class="timeline_sections_left">
                <div class="timeline_sections_left_icon"><i class="fa fa-power-off" aria-hidden="true"></i></div>
            </div>
            <div class="timeline_sections_right loading_content_ful">
                <div class="loading_content">No More Posts Found</div>                               
            </div>
        </div>
    </div>
    <?php
}?>