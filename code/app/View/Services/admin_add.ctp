<script type="text/javascript">
    $(document).ready(function () {
        $.validator.addMethod('positiveNumber',
                function (value) {
                    return Number(value) >= 0;
                }, 'Enter a valid value.');
        $("#adminForm").validate();
        
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
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Service 
        </h1>
        <ol class="breadcrumb">
            <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller' => 'admins', 'action' => 'dashboard'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link('<i class="fa fa-list"></i> Services', array('controller' => 'services', 'action' => 'index'), array('escape' => false)); ?></li>
            <li class="active">Add Service</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">&nbsp;</h3>
            </div>
            <div class="ersu_message"> <?php echo $this->Session->flash(); ?> </div>
            <?php echo $this->Form->create(Null, array('id' => 'adminForm', 'enctype' => 'multipart/form-data')); ?>
            <div class="form-horizontal">
                <div class="box-body">


                    <div class="form-group">
                        <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Select Company <span class="require">*</span></label>
                        <div class="col-lg-10 col-sm-7 col-md-8">
                            <?php echo $this->Form->select('Service.user_id', $userList, array('empty' => 'Select Company', 'class' => "form-control required", 'id' => 'state_id')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Service Name <span class="require">*</span></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('Service.name', array('class' => "form-control required", 'placeholder' => 'Service Name')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Select Category <span class="require">*</span></label>
                        <div class="col-lg-10 col-sm-7 col-md-8">
                            <?php echo $this->Form->select('Service.category_id', $categoryList, array('empty' => 'Select Category', 'class' => "form-control required", 'id' => 'category_id')); ?>
                            <?php echo $this->Ajax->observeField('category_id', array('url' => '/categories/getSubCategoryList/Service/form-control', 'update' => 'category_list', 'indicator' => 'cat_loader')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 col-md-4 col-lg-2 control-label">Select Sub Category <span class="require">*</span></label>
                        <div class="col-lg-10 col-sm-7 col-md-8" id="category_list">
                            <?php echo $this->Form->select('Service.subcategory_id', $subCategoryList, array('empty' => 'Select Sub Category', 'class' => "form-control required")); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Price Per <span class="require">*</span></label>
                        <div class="col-sm-10 unitp">
                            <div class="unit_price">
                            <?php
                                $options = array('0' => '<label for="ServiceUnitType0"><span><span></span></span><em>Piece(s)</em></label>', '1' => '<label for="ServiceUnitType1"><span><span></span></span><em>Unit of Measure</em></label>');
                                echo $this->Form->radio('Service.unit_type', $options, array('label' => '', 'legend' => false, 'value' => 0, 'class' => "radio_more_select", 'div' => false, 'separator' => '</div><div class="form_row_fhr_cols_radi">'));
                            ?>
                            </div>
                            
                             <div class="popup_fomr_rosdfs popup_fomr_rosdfs_left popup_fomr_rosdfs_left_full" id="units_measur" style="display: none;">
                                <div class="cols_two_sksss">
                                    <div class="popup_fomr_rosdfs_col">
                                        <label class="popup_title" for="Length">Length</label>
                                        <input type="radio" checked="checked" class="" id="Length" name="data[Service][unit_of_measure]" value="Length">
                                        <div class="input_sor_boc">
                                            <?php
                                            global $length;
                                            echo $this->Form->select('Service.unit_value', $length, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'LengthSelect'));
                                            ?>
                                        </div>
                                    </div>

                                    <div class="popup_fomr_rosdfs_col rightasdas">
                                        <label class="popup_title" for="Surface">Surface</label>
                                        <input type="radio" class="" id="Surface" name="data[Service][unit_of_measure]" value="Surface">
                                        <div class="input_sor_boc">
                                            <?php
                                            global $surface;
                                            echo $this->Form->select('Service.unit_value', $surface, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'SurfaceSelect', 'disabled'));
                                            ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="cols_two_sksss">
                                    <div class="popup_fomr_rosdfs_col">
                                        <label class="popup_title" for="Weight">Weight</label>
                                        <input type="radio"  class="" id="Weight" name="data[Service][unit_of_measure]" value="Weight">
                                        <div class="input_sor_boc">
                                            <?php
                                            global $weight;
                                            echo $this->Form->select('Service.unit_value', $weight, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'WeightSelect', 'disabled'));
                                            ?>
                                        </div>
                                    </div>

                                    <div class="popup_fomr_rosdfs_col rightasdas">
                                        <label class="popup_title" for="Capacity">Capacity</label>
                                        <input type="radio" class="" id="Capacity" name="data[Service][unit_of_measure]" value="Capacity">
                                        <div class="input_sor_boc">
                                            <?php
                                            global $capacity;
                                            echo $this->Form->select('Service.unit_value', $capacity, array('empty' => false, 'class' => "popup_formtce slct_ppup required", 'id' => 'CapacitySelect', 'disabled'));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Price (<?php echo CURRENCY;?>) <span class="require">*</span></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('Service.price', array('maxlength' => '10', 'class' => "form-control required positiveNumber ", 'placeholder' => 'Price ('.CURRENCY.')', 'min' => '0')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Delivery Cost (<?php echo CURRENCY;?>) <span class="require">*</span></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('Service.delivery_cost', array('maxlength' => '10', 'class' => "form-control required positiveNumber", 'placeholder' => 'Delivery Cost ('.CURRENCY.')', 'min' => '0')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Minimum Orders <span class="require"></span></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('Service.minimum_orders', array('maxlength' => '25', 'class' => "form-control positiveNumber", 'placeholder' => 'Minimum Orders')); ?>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description <span class="require">*</span></label>
                        <div class="col-sm-10">
                            <style>
                                #mceu_14-body{display: none}
                            </style>
                            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
                            <script>tinymce.init({selector: 'textarea.editor_meshage'});</script>
                            <?php echo $this->Form->textarea('Service.description', array('class' => "form-control editor_meshage required", 'rows' => '8', 'placeholder' => 'Description')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 col-md-4 col-lg-2 control-label"> Service Images <span class="require"></span></label>
                        <div class="col-lg-10 col-sm-7 col-md-8">
                            <?php echo $this->Form->file('Service.images', array('multiple' => 'multiple', 'name' => 'data[Service][images][]', 'class' => 'form-control', 'label' => false, 'id' => 'add_images', 'onchange' => 'uploadMultipleImages()')) ?>
                            <div class="help_text">Select multiple file with Ctrl press, File Types: jpg, jpeg, png (Max. 2MB for each).</div>
                            <div id="showimg" class="showimages_mul"></div>
                        </div>
                    </div>


                    <div class="box-footer">
                        <label class="col-sm-2 control-label" for="inputPassword3">&nbsp;</label>
                        <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-info', 'div' => false)); ?>
                        <?php echo $this->Html->link('Cancel', array('controller' => 'services', 'action' => 'index'), array('escape' => false, 'class' => 'btn btn-default canlcel_le')); ?>
                    </div>

                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </section>
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

    function uploadMultipleImages() {

//        var files = $('#add_images')[0].files;
//        if (files.length > 5) {
//            alert('You can upload max 5 Service Images.');
//            $('#add_images').val('');
//            return;
//        }
//
//        var allImages = '';
//        var filetype = ['jpeg', 'png', 'jpg'];
//        var slidercnt = 0;
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
//
//            slidercnt++;
//        }
//
//        //$('#add_images').html(allImages);
//        return true;

    }
    
    
    $("#add_images").on('change', function () {

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