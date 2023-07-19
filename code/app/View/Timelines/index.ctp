<script>
    $(document).ready(function () {
        $("#locationForm").validate();
        $("#industryForm").validate();
        $("#tradeOfferForm").validate();
        $("#newsForm").validate();
        $("#buyingLeadForm").validate();
    });


    $(document).ready(function () {
        $("#add_industory_popup, #add_industory_popup_lead").click(function () {
            $("#add_industory_popup_box").slideToggle("");
        });
        $("#add_industory_popup_box_close").click(function () {
            $("#add_industory_popup_box").hide();
        });
        $("#add_industory_popup, #add_industory_popup_lead").click(function () {
            $("#add_industory_popup, #add_industory_popup_lead").slideShow();
        });

// add place

        $("#add_place_popup, #add_place_popup_lead").click(function () {
            $("#add_place_popup_box").slideToggle("");
        });
        $("#add_place_popup_box_close").click(function () {
            $("#add_place_popup_box").hide();
        });
        $("#add_place_popup, #add_place_popup_lead").click(function () {
            $("#add_place_popup, #add_place_popup_lead").slideShow();
        });


        $("#TimelineUnitType1").click(function () {
            $("#units_measur").show("");
        });

        $("#TimelineUnitType0").click(function () {
            $("#units_measur").hide("");
        });


    });
</script>


<script type="text/javascript">

    $(document).ready(function () {

        $(".element_boxx").hide();
        $(".element_boxx:first").show();

        $(".edd_linksss ul li a").click(function () {
            $(".edd_linksss ul li a").removeClass("active");
            $(this).addClass("active");
            $(".element_boxx").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).fadeIn();
        });

    });

</script>

<script type="text/javascript">

    $(document).ready(function () {
        $(".timeline_sections").hide();
        $(".timeline_sections:first").show();

        $(".filtring_type_post_ing ul li .nww").click(function () {
            $(".filtring_type_post_ing ul li .nww").removeClass("active");
            $(this).addClass("active");
            $(".timeline_sections").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).fadeIn();
        });

    });

    function checkIndustryType() {
        if (!$('#timelineindustry_id').length) {
            alert('Industry type is required.');
            return false;
        }

        if (!$('#timelineState_id').length) {
            if (confirm("If you don't add location, this Trade Offer will show in whole Country") == true) {
                return true;
            } else {
                return false;
            }
        }
    }

    function checkIndustryBuyingLead() {
        if (!$('#timelineindustry_idbuying').length) {
            alert('Industry type is required.');
            return false;
        }

        if (!$('#timelineState_idbuying').length) {
            if (confirm("If you don't add location, this Trade Offer will show in whole Country") == true) {
                return true;
            } else {
                return false;
            }
        }
    }

    function ownposts(type) {
        if(type == 0){
            var msg = 'Are you sure you want to show your own posts?';
        }else{
            var msg = 'Are you sure you want to hide your own posts?';
        }
        
        if (confirm(msg) == true) {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>/timelines/setownposts/' + type,
                beforeSend: function () {
                    $("#loaderId").show();
                },
                success: function (result) {
                    $("#loaderId").hide();
                    if (result == 1) {
                        window.location.reload();
                    }
                }
            });

        } else {
            return false;
        }

    }

</script>

<div class="right_part">
    <div class="aside_for_box">
        <div class="aside_contaner">
            <div class="ee"><?php echo $this->Session->flash(); ?></div>

            <div class="add_new_element_box">
                <div class="edd_linksss">
                    <ul>
                        <li class="addks">Add New Element:</li>
                        <li><a class="trade_isnn active" rel="trade_offer_box">Trade Offer</a></li>
                        <li><a class="news_isnn" rel="news_box">News</a></li>
                        <li><a class="buying_isnn" rel="buying_lead_box">Buying Lead</a></li>
                    </ul>
                </div>
                <div class="element_boxx" id="trade_offer_box">
                    <?php echo $this->Form->create(Null, array('id' => 'tradeOfferForm', 'enctype' => 'multipart/form-data')); ?>
                    <div class="effect_box">
                        <?php echo $this->Form->textarea('Timeline.description', array('class' => "effectab_forma required", 'rows' => '15', 'placeholder' => 'Type here...')); ?>
                    </div>
                    <div class="effect_box_bottom">
                        <div class="menu_addks">
                            <ul>
                                <li id="add_place_popup"><a><i class="fa fa-map-marker_icn" aria-hidden="true"></i> Add Location</a>
                                    <p id="trade_offer_box_location_data" class="showpopupd"></p>
                                </li>
                                <li id="add_industory_popup"><a><i class="fa fa-building-o" aria-hidden="true"></i> Add Industry Type</a>
                                    <p id="trade_offer_box_industry_data" class="showpopupd"></p>
                                </li>
                            </ul>
                        </div>

                        <div class="menu_addks_right">
                            <div class="image_detail_show" id="fp"></div>
                            <span class="inline-gsj">
                                <label class="btn_add_picture" for="add_picture">Add Picture</label>
                                <?php echo $this->Form->file('Timeline.image', array('class' => 'hidden_filss', 'label' => false, 'id' => 'add_picture', 'onchange' => 'uploadTradeImage()')) ?>
                            </span>
                            <?php echo $this->Form->submit('Add Post', array('name' => 'tradeOffer', 'class' => 'btn_add_sjskd', 'div' => false, 'onclick' => 'return checkIndustryType();')); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>

                <div class="element_boxx" id="news_box">
                    <?php echo $this->Form->create(Null, array('id' => 'newsForm', 'enctype' => 'multipart/form-data')); ?>
                    <div class="effect_box">
                        <?php echo $this->Form->textarea('Timeline.description', array('class' => "effectab_forma required", 'rows' => '15', 'placeholder' => 'Type news...')); ?>
                    </div>
                    <div class="effect_box_bottom">                                

                        <div class="menu_addks_right">
                            <div class="image_detail_show" id="fp_1"></div>
                            <span class="inline-gsj">
                                <label class="btn_add_picture" for="add_picture_1">Add Picture</label>
                                <?php echo $this->Form->file('Timeline.image', array('class' => 'hidden_filss', 'label' => false, 'id' => 'add_picture_1', 'onchange' => 'uploadNewsImage()')) ?>
                            </span>
                            <?php echo $this->Form->submit('Add Post', array('name' => 'newsPost', 'class' => 'btn_add_sjskd', 'div' => false)); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>


                <div class="element_boxx" id="buying_lead_box">
                    <?php echo $this->Form->create(Null, array('id' => 'buyingLeadForm', 'enctype' => 'multipart/form-data')); ?>
                    <div class="effect_box">
                        <div class="add_pic_ope">
                            <?php echo $this->Form->textarea('Timeline.description', array('class' => "effectab_forma required", 'rows' => '15', 'placeholder' => 'Product or service discription')); ?>
                        </div>
                        <div class="popup_fomr_roneht">
                            <label class="popup_title">Product Name</label>
                            <div class="input_sor_boc">
                                <?php echo $this->Form->text('Timeline.product_name', array('class' => "popup_formtce required", 'placeholder' => '', 'autocomplete' => 'off')); ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="popup_fomr_roneht">
                            <label class="popup_title">Add Quantity</label>
                            <div class="input_sor_boc">
                                <?php echo $this->Form->text('Timeline.quantity', array('class' => "popup_formtce required digits", 'placeholder' => '', 'autocomplete' => 'off')); ?>
                            </div>
                        </div>
                        <div class="popup_fomr_rosdfs">
                            <div class="radio_select_option">

                                <div class="radio_select_option_cols">
                                    <?php
                                    $options = array('0' => '<label for="TimelineUnitType0">Piece(s)</label>', '1' => '<label for="TimelineUnitType1">Units Of Measure</label>');
                                    echo $this->Form->radio('Timeline.unit_type', $options, array('label' => '', 'legend' => false, 'value' => 0, 'class' => "radio_more_select", 'div' => false, 'separator' => '</div><div class="radio_select_option_cols">'));
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="popup_fomr_rosdfs popup_fomr_rosdfs_left" id="units_measur" style="display: none;">
                            <div class="popup_fomr_rosdfs_col">
                                <label class="popup_title">Length</label>
                                <input type="radio" checked="checked" class="" id="Length" name="data[Timeline][unit_of_measure]" value="Length">
                                <div class="input_sor_boc">
                                    <?php
                                    global $length;
                                    echo $this->Form->select('Timeline.unit_value', $length, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'LengthSelect'));
                                    ?>
                                </div>
                            </div>

                            <div class="popup_fomr_rosdfs_col rightasdas">
                                <label class="popup_title">Surface</label>
                                <input type="radio" class="" id="Surface" name="data[Timeline][unit_of_measure]" value="Surface">
                                <div class="input_sor_boc">
                                    <?php
                                    global $surface;
                                    echo $this->Form->select('Timeline.unit_value', $surface, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'SurfaceSelect', 'disabled'));
                                    ?>
                                </div>
                            </div>



                            <div class="popup_fomr_rosdfs_col">
                                <label class="popup_title">Weight</label>
                                <input type="radio"  class="" id="Weight" name="data[Timeline][unit_of_measure]" value="Weight">
                                <div class="input_sor_boc">
                                    <?php
                                    global $weight;
                                    echo $this->Form->select('Timeline.unit_value', $weight, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'WeightSelect', 'disabled'));
                                    ?>
                                </div>
                            </div>

                            <div class="popup_fomr_rosdfs_col rightasdas">
                                <label class="popup_title">Capacity</label>
                                <input type="radio" class="" id="Capacity" name="data[Timeline][unit_of_measure]" value="Capacity">
                                <div class="input_sor_boc">
                                    <?php
                                    global $capacity;
                                    echo $this->Form->select('Timeline.unit_value', $capacity, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'CapacitySelect', 'disabled'));
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>
                        <div class="popup_fomr_roneht">
                            <label class="popup_title">Asking price</label>
                            <div class="input_sor_boc">
                                <?php echo $this->Form->text('Timeline.asking_price', array('class' => "popup_formtce required number", 'placeholder' => '', 'autocomplete' => 'off', 'min' => 0)); ?>
                            </div>
                        </div>


                    </div>
                    <div class="effect_box_bottom">                                
                        <div class="menu_addks">
                            <ul>
                                <li id="add_place_popup_lead"><a><i class="fa fa-map-marker_icn" aria-hidden="true"></i> Add Location</a>
                                    <p id="buying_lead_box_location_data" class="showpopupd"></p>
                                </li>
                                <li id="add_industory_popup_lead"><a><i class="fa fa-building-o" aria-hidden="true"></i> Add Industry Type</a>
                                    <p id="buying_lead_box_industry_data" class="showpopupd"></p>
                                </li>
                            </ul>
                        </div>
                        <div class="menu_addks_right">  
                            <div class="image_detail_show" id="fp_buying"></div>
                            <span class="inline-gsj">
                                <label class="btn_add_picture" for="add_picture_buying">Add Picture</label>
                                <?php echo $this->Form->file('Timeline.image', array('class' => 'hidden_filss', 'label' => false, 'id' => 'add_picture_buying', 'onchange' => 'uploadLeadImage()')) ?>
                            </span>

                            <?php echo $this->Form->submit('Add Post', array('name' => 'buyingLeadPost', 'class' => 'btn_add_sjskd', 'div' => false, 'onclick' => 'return checkIndustryBuyingLead()')); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>

            <div class="filtring_type_post">
                <div class="filtring_type_post_ing">
                    <ul id="filter_ul_idd">
                        <li class="active nww" id="flt_0" rel="all_filter"><a>All</a></li>
                        <li class="trade_offer_lk nww" id="flt_1" rel="trade_offer_filter"><a></a></li>
                        <li class="news_lk nww" id="flt_2" rel="news_lk_filter"><a></a></li>
                        <li class="buyingleads_lk nww" id="flt_3" rel="buyinglead_filter"><a></a></li>

                        <?php if ($userInfo['User']['show_own_post'] == 0) { ?>
                            <li class="logout_lk"> <?php echo $this->Html->link('<i class="nav-icon fa fa-power-off"></i>', 'javascript:void(0);', array('escape' => false, 'class' => '', 'title' => 'Turn Off Own Posts', 'onclick' => 'ownposts(1)')); ?> </li>
                        <?php } else { ?>
                            <li class="logout_lk active_red"> <?php echo $this->Html->link('<i class="nav-icon fa fa-power-off"></i>', 'javascript:void(0);', array('escape' => false, 'class' => '', 'title' => 'Turn On  Own Posts', 'onclick' => 'ownposts(0)')); ?> </li>
                        <?php } ?>
                    </ul>
                </div>
                <span class="after_by_divss"></span>
            </div>


            <div class="timeline_sections" id="all_filter">
                <div id="updateID">
                    <?php if ($timelines) { ?>
                        <?php echo $this->element('timelines/index'); ?>
                    <?php } else { ?>
                        <div style="display: block" id="noInitialResult">
                            <div class="no-rec-fnd-front">No Posts Found</div>
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

            <div class="timeline_sections" id="trade_offer_filter">
                <div id="updateID1">
                    <div style="display: none" id="noInitialResult1">
                        <div class="no-rec-fnd-front">No Posts Found</div>    
                    </div>
                </div>
                <div style="display: none" id="noMoreResult1">
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
            <div class="timeline_sections" id="news_lk_filter">
                <div id="updateID2">
                    <div style="display: none" id="noInitialResult2">
                        <div class="no-rec-fnd-front">No Posts Found</div>    
                    </div>
                </div>
                <div style="display: none" id="noMoreResult2">
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
            <div class="timeline_sections" id="buyinglead_filter">
                <div id="updateID3">
                    <div style="display: none" id="noInitialResult3">
                        <div class="no-rec-fnd-front">No Posts Found</div>                               
                    </div>
                </div>
                <div style="display: none" id="noMoreResult3">
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

        function uploadTradeImage() {
            var filename = document.getElementById("add_picture").value;
            var filetype = ['jpeg', 'png', 'jpg'];
            if (filename != '') {
                var ext = getExt(filename);
                ext = ext.toLowerCase();
                var checktype = in_array(ext, filetype);
                if (!checktype) {
                    alert(ext + " file not allowed for Image.");
                    return false;
                } else {
                    var fi = document.getElementById('add_picture');
                    var filesize = fi.files[0].size;//check uploaded file size
                    if (filesize > 2097152) {
                        alert('Maximum 2MB file size allowed for Image.');
                        return false;
                    }
                }
            }
            //$('#fp').html($('#add_picture')[0].files[0].name);
            $('#fp').html('<div class="full_image_detail">' + '<span class="name_of_image">' + $('#add_picture')[0].files[0].name + '</span>' + '<span class="size_of_image">' + Math.round(($('#add_picture')[0].files[0].size / 1024)) + 'KB </span>');
            return true;
        }

        function uploadNewsImage() {
            var filename = document.getElementById("add_picture_1").value;
            var filetype = ['jpeg', 'png', 'jpg'];
            if (filename != '') {
                var ext = getExt(filename);
                ext = ext.toLowerCase();
                var checktype = in_array(ext, filetype);
                if (!checktype) {
                    alert(ext + " file not allowed for Image.");
                    return false;
                } else {
                    var fi = document.getElementById('add_picture_1');
                    var filesize = fi.files[0].size;//check uploaded file size
                    if (filesize > 2097152) {
                        alert('Maximum 2MB file size allowed for Image.');
                        return false;
                    }
                }
            }
            //$('#fp').html($('#add_picture_1')[0].files[0].name);
            $('#fp_1').html('<div class="full_image_detail">' + '<span class="name_of_image">' + $('#add_picture_1')[0].files[0].name + '</span>' + '<span class="size_of_image">' + Math.round(($('#add_picture_1')[0].files[0].size / 1024)) + 'KB </span>');
            return true;
        }

        function uploadLeadImage() {
            var filename = document.getElementById("add_picture_buying").value;
            var filetype = ['jpeg', 'png', 'jpg'];
            if (filename != '') {
                var ext = getExt(filename);
                ext = ext.toLowerCase();
                var checktype = in_array(ext, filetype);
                if (!checktype) {
                    alert(ext + " file not allowed for Image.");
                    return false;
                } else {
                    var fi = document.getElementById('add_picture_buying');
                    var filesize = fi.files[0].size;//check uploaded file size
                    if (filesize > 2097152) {
                        alert('Maximum 2MB file size allowed for Image.');
                        return false;
                    }
                }
            }
            //$('#fp').html($('#add_picture_buying')[0].files[0].name);
            $('#fp_buying').html('<div class="full_image_detail">' + '<span class="name_of_image">' + $('#add_picture_buying')[0].files[0].name + '</span>' + '<span class="size_of_image">' + Math.round(($('#add_picture_buying')[0].files[0].size / 1024)) + 'KB </span>');
            return true;
        }

    </script>
</div>
</div>   





<!-- Add Industory type -->

<div class="popup_full_sectiuons" id="add_industory_popup_box">
    <div class="popup_insude_box">
        <?php echo $this->Form->create(Null, array('id' => 'industryForm')); ?>
        <div class="popup_close_btn" id="add_industory_popup_box_close"></div>
        <h3 class="title_of_popup">Add Industry Type</h3>
        <div class="popup_insude_box_ins">
            <div class="popup_insude_box_ins_nofull">
                <div class="popup_fomr_row">
                    <label class="popup_title">Industry</label>
                    <div class="input_sor_boc">
                        <?php echo $this->Form->select('Timeline.industry_id', $industryList, array('empty' => 'Select Industry', 'class' => "popup_formtce required")); ?>
                        <div class="cname_loader" id="industry_loader"><?php echo $this->Html->image('loading.svg'); ?></div>
                        <?php echo $this->Ajax->observeField('TimelineIndustryId', array('url' => '/industries/getSubIndustryList/Timeline/popup_formtce', 'update' => 'subind_list', 'indicator' => 'industry_loader')); ?>
                    </div>
                </div>


                <div class="popup_fomr_row">
                    <label class="popup_title">Category</label>
                    <div class="input_sor_boc" id="subind_list">
                        <?php echo $this->Form->select('Timeline.subindustry_id', $subIndustryList, array('empty' => 'Subcategory Of Industry', 'class' => "popup_formtce required")); ?>
                    </div>
                </div>

                <div class="popup_fomr_row">
                    <?php echo $this->Form->submit('Add', array('class' => 'btn_add_sjskd', 'id' => 'addIndustry_ppup', 'div' => false)); ?>
                </div> 
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>



<!-- Add Location -->
<div class="popup_full_sectiuons" id="add_place_popup_box">
    <div class="popup_insude_box">
        <?php echo $this->Form->create(Null, array('id' => 'locationForm')); ?>
        <div class="popup_close_btn" id="add_place_popup_box_close"></div>
        <h3 class="title_of_popup">Add Location</h3>
        <div class="popup_insude_box_ins">
            <div class="popup_insude_box_ins_nofull">
                <div class="popup_fomr_row">
                    <label class="popup_title">State</label>
                    <div class="input_sor_boc">
                        <?php echo $this->Form->select('Timeline.state_id', $stateList, array('empty' => 'Select State', 'class' => "popup_formtce required", 'id' => 'state_id')); ?>
                        <div class="cname_loader" id="state_loader"><?php echo $this->Html->image('loading.svg'); ?></div>
                        <?php echo $this->Ajax->observeField('state_id', array('url' => '/states/getCityList/Timeline/popup_formtce', 'update' => 'city_list', 'indicator' => 'state_loader')); ?>
                    </div>
                </div>
                <div class="popup_fomr_row">
                    <label class="popup_title">City/Place</label>
                    <div class="input_sor_boc" id="city_list">
                        <?php echo $this->Form->select('Timeline.city_id', $cityList, array('empty' => 'Select City', 'class' => "popup_formtce required")); ?>
                    </div>
                </div>
                <div class="popup_fomr_row">
                    <?php echo $this->Form->submit('Add Location', array('class' => 'btn_add_sjskd', 'id' => 'addState_ppup', 'div' => false)); ?>
                </div> 
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<!-- Make Offer -->




<script>
    
    $('#locationForm').on('submit', function (e) {
        e.preventDefault();
        var StateId = $.trim($("#state_id").children("option:selected").val());
        var StateName = $.trim($("#state_id").children("option:selected").text());
        var CityId = $.trim($("#TimelineCityId").children("option:selected").val());
        var CityName = $.trim($("#TimelineCityId").children("option:selected").text());


        if (StateId != "" && CityId != "") {
            var n = $(".element_boxx").css("display");
            //if n = block, City and State will be added to Trade Post and if n = none, City and State will be added to Buying Lead. This is not for NEWS 
            if (n == 'block') {
                $('#trade_offer_box_location_data').html("-" + CityName + ", " + StateName + "<br><input  id='timelineState_id' type='hidden' name='data[Timeline][state_id]' value=" + StateId + "><input type='hidden' name='data[Timeline][city_id]' value=" + CityId + ">")
                $('#trade_offer_box_location_data').addClass('active');
            } else {
                $('#buying_lead_box_location_data').html("-" + CityName + ", " + StateName + "<br><input  id='timelineState_idbuying' type='hidden' name='data[Timeline][state_id]' value=" + StateId + "><input type='hidden' name='data[Timeline][city_id]' value=" + CityId + ">")
                $('#buying_lead_box_location_data').addClass('active');
            }
            $("#trade_offer_box_location_data").addClass("error_active").delay(3000).queue(function(){
        $(this).removeClass("error_active").dequeue();
        });
            //2
        $("#buying_lead_box_location_data").addClass("error_active_1").delay(3000).queue(function(){
            $(this).removeClass("error_active_1").dequeue();
        });
            $("#add_place_popup_box").hide();
        }
        
        

    });

    $('#industryForm').on('submit', function (e) {
        e.preventDefault();
        var IndustryId = $.trim($("#TimelineIndustryId").children("option:selected").val());
        var IndustryName = $.trim($("#TimelineIndustryId").children("option:selected").text());
        var SubIndustryId = $.trim($("#TimelineSubindustryId").children("option:selected").val());
        var SubIndustryName = $.trim($("#TimelineSubindustryId").children("option:selected").text());

        if (IndustryId != "" && SubIndustryId != "") {
            var n = $(".element_boxx").css("display");
            //if n = block, Industry and SubIndustry will be added to Trade Post and if n = none, City and State will be added to Buying Lead. This is not for NEWS
            if (n == 'block') {
                $('#trade_offer_box_industry_data').html("-" + SubIndustryName + ", " + IndustryName + "<br><input id='timelineindustry_id' type='hidden' name='data[Timeline][industry_id]' value=" + IndustryId + "><input type='hidden' name='data[Timeline][subindustry_id]' value=" + SubIndustryId + ">")
                $('#trade_offer_box_industry_data').addClass('active');
            } else {
                $('#buying_lead_box_industry_data').html("-" + SubIndustryName + ", " + IndustryName + "<br><input id='timelineindustry_idbuying' type='hidden' name='data[Timeline][industry_id]' value=" + IndustryId + "><input type='hidden' name='data[Timeline][subindustry_id]' value=" + SubIndustryId + ">")
                $('#buying_lead_box_industry_data').addClass('active');
            }
            //3
        $("#trade_offer_box_industry_data").addClass("error_active_2").delay(3000).queue(function(){
            $(this).removeClass("error_active_2").dequeue();
        });
        
        //4
        $("#buying_lead_box_industry_data").addClass("error_active_3").delay(3000).queue(function(){
            $(this).removeClass("error_active_3").dequeue();
        });
            $("#add_industory_popup_box").hide();
        }

    });

    $('#Length').on('click', function () {
        $("#LengthSelect").prop("disabled", false);
        $("#SurfaceSelect").prop("disabled", true);
        $("#WeightSelect").prop("disabled", true);
        $("#CapacitySelect").prop("disabled", true);

    });
    $('#Surface').on('click', function () {
        $("#LengthSelect").prop("disabled", true);
        $("#SurfaceSelect").prop("disabled", false);
        $("#WeightSelect").prop("disabled", true);
        $("#CapacitySelect").prop("disabled", true);
    });
    $('#Weight').on('click', function () {
        $("#LengthSelect").prop("disabled", true);
        $("#SurfaceSelect").prop("disabled", true);
        $("#WeightSelect").prop("disabled", false);
        $("#CapacitySelect").prop("disabled", true);
    });
    $('#Capacity').on('click', function () {
        $("#LengthSelect").prop("disabled", true);
        $("#SurfaceSelect").prop("disabled", true);
        $("#WeightSelect").prop("disabled", true);
        $("#CapacitySelect").prop("disabled", false);
    });

</script>


<script>
    //Update Filter Option Onload  
    $(function () {
        updateAllTypeFilters(1);    //For Trade Offer
        updateAllTypeFilters(2);    //For News
        updateAllTypeFilters(3);    //For Buying Lead
    });

    function updateAllTypeFilters(type) {
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>/timelines/updateFilter/' + type,
            beforeSend: function () {
            },
            success: function (result) {
                if (result.length == 0) {
                    $("#noInitialResult" + type).css('display', 'block');
                } else {
                    $("#updateID" + type).html(result);
                }
            }
        });
    }

</script>

<script type="text/javascript">
    var page = 1;
    var pageA = 1;
    var pageB = 1;
    var pageC = 1;
    var end = 0;
    var endA = 0;
    var endB = 0;
    var endC = 0;

    $(".right_part").scroll(function () {
        var dt = $("#filter_ul_idd li.active").attr('id');
        if (dt == 'flt_0') {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight && end == 0) {
                page++;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>/timelines/index/page:' + page,
                    beforeSend: function () {
                        $("#loaderPartMore").show();
                    },
                    success: function (result) {
                        $("#loaderPartMore").hide();
                        $("#updateID").append(result);
                        if (result.length == 0) {
                            //$("#updateID").append($("#noMoreResult").html());
                            if ($('#noInitialResult').css('display') != 'block') {
                                $("#noMoreResult").show();
                            }
                            end++;
                        }
                    }

                });
            }
        } else {
            var res = dt.split("_");
            var count = res[1];
            if (count == 1) {
                endNew = endA;
            } else if (count == 2) {
                endNew = endB;
            } else {
                endNew = endC;
            }
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight && endNew == 0) {
                if (count == 1) {
                    pageA++;
                    pageNew = pageA;
                } else if (count == 2) {
                    pageB++;
                    pageNew = pageB;
                } else {
                    pageC++;
                    pageNew = pageC;
                }

                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>/timelines/updateFilter/' + count + '/page:' + pageNew,
                    beforeSend: function () {
                        $("#loaderPartMore").show();
                    },
                    success: function (result) {
                        $("#loaderPartMore").hide();
                        if (result.length == 0) {
                            if ($('#noInitialResult' + count).css('display') != 'block') {
                                $("#noMoreResult" + count).show();
                            }
                            if (count == 1) {
                                endA++;
                            } else if (count == 2) {
                                endB++;
                            } else {
                                endC++;
                            }
                        } else {
                            $("#updateID" + count).append(result);
                        }
                    }

                });
            }
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


    function showCommentFormOther(id) {
        $("#comment_formdivother" + id).toggle("");
    }

    function saveDataOther(id) {
        if ($.trim($('#txtara_comm_other' + id).val()) == '') {
            $('#txtara_comm_other' + id).addClass('required');
            alert("You can't post a blank comment")
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>/timelines/postComment/',
                data: $('#postcommentOther' + id).serialize(),
                beforeSend: function () {
                    $("#comment_loader_other" + id).show();
                    $("#postcomm_other" + id).hide();
                },
                success: function (result) {
                    $("#comment_loader_other" + id).hide();
                    $("#postcomm_other" + id).show();
                    $('#txtara_comm_other' + id).val('');
                    //$('.precommsect' + id).append(result);
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

    function showMakeOfferOther(id) {
        $("#makeoffer_popup_box_other" + id).slideToggle("");
    }

    function hideMakeOfferOther(id) {
        $("#makeoffer_popup_box_other" + id).fadeOut(500);
    }

    function showMore(id) {
        $("#timeline_desc_full" + id).show();
        $("#timeline_desc_less" + id).hide();
    }

    function showMoreOther(id) {
        $("#timeline_other_desc_full" + id).show();
        $("#timeline_other_desc_less" + id).hide();
    }


</script>

