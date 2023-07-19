<div class=" <?php echo ($this->Session->read('user_id') == '') ? 'right_part_fulls right_part_fulls_none' : 'right_part' ?>">

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
                            <li data-target="#myCarousel" data-slide-to="<?php echo $i ?>" class="<?php echo $i == 0 ? 'active' : '' ?>"></li>
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
                        } else {
                            echo "N/A";
                        }
                        ?>
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

            <div id="updateID">
                <?php if ($timelines) { ?>
                    <?php echo $this->element('timelines/index'); ?>
                <?php } else { ?>
                    <div class="timeline_sections_box loadinfg" >
                        <div class="timeline_sections_right loading_content_ful">
                            <div class="loading_content">No Posts Found</div>                               
                        </div>
                    </div>
                <?php } ?>
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
        </div>
    </div>
</div>

<script type="text/javascript">
    var page = 1;
    var end = 0;

    $(".right_part").scroll(function () {

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight && end == 0) {
            page++;
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>/users/profile/page:' + page,
                beforeSend: function () {
                    $("#loaderPartMore").show();
                },
                success: function (result) {
                    $("#loaderPartMore").hide();
                    $("#updateID").append(result);
                    if (result.length == 0) {
                        //$("#updateID").append($("#noMoreResult").html());
                        $("#noMoreResult").show();
                        end++;
                    }
                }

            });
        }
    });

    function showCommentFormMain(id) {
        $("#comment_formdiv" + id).toggle("");
    }

    function saveData(id) {
        if ($.trim($('#txtara_comm' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("You can't post a blank comment");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>/timelines/postComment/',
                data: $('#postcomment' + id).serialize(),
                beforeSend: function () {
                    $("#comment_loader" + id).show();
                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    $("#comment_loader" + id).hide();
                    $("#postcomm" + id).show();
                    $('#txtara_comm' + id).val('');
                    //$('.precommsect' + id).append(result).fadeIn(5000);
                    $(result).hide().appendTo('.precommsect' + id).fadeIn(1000);
                }
            });
        }
    }


    function deleteComment(id, slug) {
        if (id == '' || slug == "") {
            alert("Invalid Access")
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>/timelines/deleteComment/' + id + '/' + slug,
                beforeSend: function () {

                },
                success: function (result) {
                    $(".comment_mndv" + slug).fadeOut(1000);
                }
            });
        }
    }

    function showMakeOffer(id) {
        $("#makeoffer_popup_box" + id).slideToggle("");
    }

    function hideMakeOffer(id) {
        $("#makeoffer_popup_box" + id).fadeOut(500);
    }
    
    function showMore(id) {
        $("#timeline_desc_full" + id).show();
        $("#timeline_desc_less" + id).hide();
    }


</script>