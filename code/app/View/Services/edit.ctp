<?php echo $this->Html->css('front/editor/bootstrap-combined.no-icons.min.css'); ?>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">

<?php echo $this->Html->script('front/editor/jquery.hotkeys.js'); ?>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<?php echo $this->Html->css('front/editor/index.css'); ?>
<?php echo $this->Html->script('front/editor/bootstrap-wysiwyg.js'); ?>

<script type="text/javascript">
    $(document).ready(function () {

        $.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9\s`~!@#$%^&*()+={}|;:'",.\/?\\-]+$/.test(value);
        }, "Please do not enter  special character like < or >");
        $.validator.addMethod('positiveNumber',
                function (value) {
                    return Number(value) >= 0;
                }, 'Enter a valid value.');
        $("#addService").validate();

        $("#descbgbx").on('keyup', function () {
            var data = $("#editor").html();
            $("#ServiceDescription").val(data);
        });

        $("#descbgbx").on('click', function () {
            var data = $("#editor").html();
            $("#ServiceDescription").val(data);
        });
        
        $("#ServiceUnitType1").click(function () {
            $("#units_measur").show("");
        });

        $("#ServiceUnitType0").click(function () {
            $("#units_measur").hide("");
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

    });
</script>


<script>
    $(function () {
        function initToolbarBootstrapBindings() {
            var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                'Times New Roman', 'Verdana'],
                    fontTarget = $('[title=Font]').siblings('.dropdown-menu');
            $.each(fonts, function (idx, fontName) {
                fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
            });
            $('a[title]').tooltip({container: 'body'});
            $('.dropdown-menu input').click(function () {
                return false;
            })
                    .change(function () {
                        $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                    })
                    .keydown('esc', function () {
                        this.value = '';
                        $(this).change();
                    });

            $('[data-role=magic-overlay]').each(function () {
                var overlay = $(this), target = $(overlay.data('target'));
                overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
            });
            if ("onwebkitspeechchange"  in document.createElement("input")) {
                var editorOffset = $('#editor').offset();
                $('#voiceBtn').css('position', 'absolute').offset({top: editorOffset.top, left: editorOffset.left + $('#editor').innerWidth() - 35});
            } else {
                $('#voiceBtn').hide();
            }
        }
        ;
        function showErrorAlert(reason, detail) {
            var msg = '';
            if (reason === 'unsupported-file-type') {
                msg = "Unsupported format " + detail;
            }
            else {
                console.log("error uploading file", reason, detail);
            }
            $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }
        ;
        initToolbarBootstrapBindings();
        $('#editor').wysiwyg({fileUploadError: showErrorAlert});
        window.prettyPrint && prettyPrint();
    });
</script>

<div class="right_part">
    <div class="aside_contaner_full about_contenteditor about_contenteditor_enewk  radiual_sections">

        <div class="full_box_of_staf_full">                    
            <div class="left_aprt_of_gst">
                <div class="title_of_page_riweoname revtitle_of_page_riweoname no_bordere">Edit Service</div>
            </div>
        </div>
        <?php echo $this->Form->create('Service', array('method' => 'POST', 'name' => 'addService', 'id' => 'addService', 'enctype' => 'multipart/form-data')); ?>
        <div class="bocx_of_sull" style="border: 0;">               
            <div class="form_edit_full_sboc_xsec" style="border:0; padding: 0;">
                <div class="form_row_fhr">
                    <div class="form_row_fhr_cols">
                        <div class="ch_select_sje">
                            <?php echo $this->Form->select('Service.category_id', $categoryList, array('empty' => 'Select Category', 'class' => "select_input_box required", 'id' => 'category_id')); ?>
                            <?php echo $this->Ajax->observeField('category_id', array('url' => '/categories/getSubCategoryList/Service/select_input_box', 'update' => 'category_list', 'indicator' => 'cat_loader')); ?>
                        </div>
                    </div>
                    <div class="form_row_fhr_cols">
                        <div class="ch_select_sje" id="category_list">
                            <?php echo $this->Form->select('Service.subcategory_id', $subCategoryList, array('empty' => 'Select Sub Category', 'class' => "select_input_box required")); ?>
                        </div>
                    </div>
                    <div class="form_row_fhr_cols">
                        <?php echo $this->Form->text('Service.price', array('maxlength' => '10', 'class' => "select_input_box required positiveNumber", 'placeholder' => 'Price ('.CURRENCY.')', 'min' => '0')); ?>
                    </div>

                    <div class="form_row_fhr_cols">
                        <div class="form_row_fhr_cols_radi">
                                    <?php
                                    $options = array('0' => '<label for="ServiceUnitType0"><span><span></span></span><em>Piece(s)</em></label>', '1' => '<label for="ServiceUnitType1"><span><span></span></span><em>Unit of Measure</em></label>');
                                    echo $this->Form->radio('Service.unit_type', $options, array('label' => '', 'legend' => false, 'class' => "radio_more_select", 'div' => false, 'separator' => '</div><div class="form_row_fhr_cols_radi">'));
                                    ?>
                    </div>
                    </div>
                    
                    
                    <div class="popup_fomr_rosdfs popup_fomr_rosdfs_left popup_fomr_rosdfs_left_full" id="units_measur" style="display: <?php echo $this->data['Service']['unit_type'] == 0 ? 'none' : 'block' ?>;">
                        <div class="cols_two_sksss">
                            <div class="popup_fomr_rosdfs_col">
                                <label class="popup_title" for="Length">Length</label>
                                <input type="radio" <?php echo $this->data['Service']['unit_of_measure'] == 'Length' ? 'checked' : '' ?> class="" id="Length" name="data[Service][unit_of_measure]" value="Length">
                                <div class="input_sor_boc">
                                    <?php
                                    global $length;
                                    echo $this->Form->select('Service.unit_value', $length, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'LengthSelect', $this->data['Service']['unit_of_measure'] == 'Length' ? '' : 'disabled'));
                                    ?>
                                </div>
                            </div>

                            <div class="popup_fomr_rosdfs_col rightasdas">
                                <label class="popup_title" for="Surface">Surface</label>
                                <input type="radio" class="" <?php echo $this->data['Service']['unit_of_measure'] == 'Surface' ? 'checked' : '' ?> id="Surface" name="data[Service][unit_of_measure]" value="Surface">
                                <div class="input_sor_boc">
                                    <?php
                                    global $surface;
                                    echo $this->Form->select('Service.unit_value', $surface, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'SurfaceSelect', $this->data['Service']['unit_of_measure'] == 'Surface' ? '' : 'disabled'));
                                    ?>
                                </div>
                            </div>

                        </div>
                        <div class="cols_two_sksss">
                            <div class="popup_fomr_rosdfs_col">
                                <label class="popup_title" for="Weight">Weight</label>
                                <input type="radio"  class="" <?php echo $this->data['Service']['unit_of_measure'] == 'Weight' ? 'checked' : '' ?> id="Weight" name="data[Service][unit_of_measure]" value="Weight">
                                <div class="input_sor_boc">
                                    <?php
                                    global $weight;
                                    echo $this->Form->select('Service.unit_value', $weight, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'WeightSelect', $this->data['Service']['unit_of_measure'] == 'Weight' ? '' : 'disabled'));
                                    ?>
                                </div>
                            </div>

                            <div class="popup_fomr_rosdfs_col rightasdas">
                                <label class="popup_title" for="Capacity">Capacity</label>
                                <input type="radio" class="" <?php echo $this->data['Service']['unit_of_measure'] == 'Capacity' ? 'checked' : '' ?> id="Capacity" name="data[Service][unit_of_measure]" value="Capacity">
                                <div class="input_sor_boc">
                                    <?php
                                    global $capacity;
                                    echo $this->Form->select('Service.unit_value', $capacity, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'CapacitySelect', $this->data['Service']['unit_of_measure'] == 'Capacity' ? '' : 'disabled'));
                                    ?>
                                </div>
                            </div>
                            </div>
                        </div>

                    <div class="form_row_fhr_cols">
                        <?php echo $this->Form->text('Service.name', array('class' => "select_input_box required", 'placeholder' => 'Name Of Service')); ?>
                    </div>
                    <div class="form_row_fhr_cols">
                        <?php echo $this->Form->text('Service.delivery_cost', array('maxlength' => '10', 'class' => "select_input_box required positiveNumber", 'placeholder' => 'Delivery Cost ('.CURRENCY.')', 'min' => '0')); ?>
                    </div>

                    <div class="form_row_fhr_cols">
                        <?php echo $this->Form->text('Service.minimum_orders', array('maxlength' => '25', 'class' => "select_input_box positiveNumber", 'placeholder' => 'Minimum Order')); ?>
                    </div>


                    <div class="form_row_fhr_cols">
                        
                        
                        <div id="ImageID">
                            <?php echo $this->element("services/service_image"); ?>
                        </div>

                        <!--<div id="ImageAboveDiv">
                        <div class="shoe_imagrd_rgijt_img">
                            <div class="shoe_imagrd_rgijt_img_minimg">
                                <?php //echo $this->Html->image('no_image.gif', array('id' => 'umg_ahe_dsdf', 'alt' => 'img')); ?>
                            </div>
                        </div>
                        </div>-->
                        
                        <div class="shoe_imagrd_rgijt">
                            <span class="inline-gsj">
                                <label class="btn_add_picture" for="add_picture">Add Picture</label>
                                <?php echo $this->Form->file('Service.images', array('multiple' => 'multiple', 'name' => 'data[Service][images][]', 'class' => 'hidden_filss', 'label' => false, 'id' => 'add_picture')) ?>
                            </span>
                            <div class="image_detail_show" id="fp"></div>
                            <div class="help_text">Select multiple file with Ctrl press, File Types: jpg, jpeg, png (Max. 2MB for each).</div>
                            <div id="showimg" class="image_detail_show showimages_mul"></div>
                        </div>
                    </div> 

                    <div class="form_row_fhr_cols_thiscs editro_stebda"  id="descbgbx">
                        <div id="alerts"></div>
                        <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                            <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                </ul>
                            </div>
                            <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                                    <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                                    <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                                <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                                <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                                <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                            </div>
                            <div class="btn-group">
                                <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
                                <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
                                <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                                <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                            </div>
                            <div class="btn-group">
                                <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                                <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                                <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
                                <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
                            </div>
                            <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
                                <div class="dropdown-menu input-append">
                                    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
                                    <button class="btn" type="button">Add</button>
                                </div>
                                <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

                            </div>

                            <div class="btn-group">
                                <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
                                <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                            </div>
                            <div class="btn-group">
                                <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                                <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                            </div>
                            <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
                        </div>

                        <div id="editor">
                            <?php echo $this->data['Service']['description']; ?>
                        </div>
                    </div>
                    <div class="clear"></div>

                    <?php echo $this->Form->hidden('Service.description'); ?>
                    <?php echo $this->Form->hidden('Service.id'); ?>

                    <div class="form_row_fhr_cols_full form_row_fhr_cols">
                        <?php echo $this->Html->link('Cancel', array('controller' => 'services', 'action' => 'index'), array('escape' => false, 'class' => 'button_form_suber')); ?>
                        <?php echo $this->Form->submit('Update', array('class' => 'button_form_suber', 'div' => false)); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>    




<script>
//    function in_array(needle, haystack) {
//        for (var i = 0, j = haystack.length; i < j; i++) {
//            if (needle == haystack[i])
//                return true;
//        }
//        return false;
//    }
//
//    function getExt(filename) {
//        var dot_pos = filename.lastIndexOf(".");
//        if (dot_pos == -1)
//            return;
//        return filename.substr(dot_pos + 1).toLowerCase();
//    }
//    
//    
//    function uploadMultipleImages() {
//        var files = $('#add_picture')[0].files;
//        if (files.length > 5) {
//            alert('You can upload max 5 Service Images.');
//            $('#add_images').val('');
//            return;
//        }
//        
//        var allImages = '';
//        var filetype = ['jpeg', 'png', 'jpg'];
//        var slidercnt = 0;
//        $('#fp').html('');
//        for (var i = 0; i < files.length; i++) {
//            var ext = getExt(files[i].name);
//            ext = ext.toLowerCase();
//            var checktype = in_array(ext, filetype);
//            if (!checktype) {
//                alert(files[i].name + " is invalid file.");
//                continue;
//            } else {
//                var fi = document.getElementById('add_bg_image');
//                var filesize = files[i].size;//check uploaded file size
//                if (filesize > 2097152) {
//                    alert(files[i].name + 'is more than 2MB');
//                    continue;
//                }
//            }
//            if (slidercnt != 0) {
//                allImages = allImages + ', '
//            }
//            allImages = allImages + files[i].name;
//            $('#fp').html($('#fp').html() + '<div class="full_image_detail">' +
//                            '<span class="name_of_image">' + files[i].name + '</span>' + '<span class="size_of_image">' + Math.round((files[i].size / 1024)) + 'KB </span></div>&nbsp;');
//
//            slidercnt++;
//        }
//            return true;
//   }


</script>




<script>
    $("#add_picture").on('change', function () {

     //Get count of selected files
     var countFiles = $(this)[0].files.length;
     
     var imgPath = $(this)[0].value;
     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
     var image_holder = $("#showimg");
     image_holder.empty();

     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
         if (typeof (FileReader) != "undefined") {

             //loop for each file selected for uploaded.
             for (var i = 0; i < countFiles; i++) {

                if($(this)[0].files[i].size > 2097152){
                    alert($(this)[0].files[i].name + " is more than 2MB.");
                    continue;
                }else{
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                                "class": "thumb-image"
                        }).appendTo(image_holder);
                    }

                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }    
             }

         } else {
             alert("This browser does not support FileReader.");
         }
     } else {
         alert("Please select only images");
     }
 });
   
</script>