<?php echo $this->Html->css('front/editor/bootstrap-combined.no-icons.min.css'); ?>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">

<?php echo $this->Html->script('front/editor/jquery.hotkeys.js'); ?>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<?php echo $this->Html->css('front/editor/index.css'); ?>
<?php echo $this->Html->script('front/editor/bootstrap-wysiwyg.js'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9\s`~!@#$%^&*()+={}|;:'",.\/?\\-]+$/.test(value);
            }, "Please do not enter  special character like < or >");
            $("#addPage").validate();
         
         $("#descbgbx").on('keyup', function(){
            var data = $("#editor").html();
            $("#PageStaticPageDescription").val(data);
         });
         
         $("#descbgbx").on('click', function(){
            var data = $("#editor").html();
            $("#PageStaticPageDescription").val(data);
         });
            
        });
</script>


<script>
  $(function(){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
  });
</script>

<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Edit Page Detail 
      </h1>
      <ol class="breadcrumb">
          <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false));?></li>
          <li><?php echo $this->Html->link('<i class="fa fa-file-text-o"></i> Content', array('controller'=>'pages', 'action'=>'index'), array('escape'=>false));?></li>
          <li class="active">Edit Page</li>
      </ol>
    </section>

    <section class="content">
     <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">&nbsp;</h3>
            </div>
            <div class="ersu_message"> <?php echo $this->Session->flash(); ?> </div>
            <?php echo $this->Form->create('Page', array('method' => 'POST', 'name' => 'addPage', 'id' => 'addPage', 'enctype' => 'multipart/form-data')); ?>
                <div class="form-horizontal">
                    <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Page Title <span class="require">*</span></label>
                      <div class="col-sm-10">
                          <?php echo $this->Form->text('Page.static_page_title', array('maxlength' => '255', 'size' => '25', 'label' => '', 'div' => false, 'class' => "form-control alphanumeric required")) ?>    
                      </div>
                    </div>
                        
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Page Description <span class="require">*</span></label>
                      <div class="col-sm-10">
                           <?php //echo $this->Fck->fckeditor(array('Page', 'static_page_description'), $this->Html->base, $this->data['Page']['static_page_description']); ?>
                          <div class="form_row_fhr_cols_thiscs editro_stebda" id="descbgbx">
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
                                  <?php //echo $this->Form->text('Page.static_page_description', array('label' => '', 'data-edit' => 'inserttext', 'id' => 'voiceBtn', 'x-webkit-speech' => '', 'div' => false, 'class' => "")) ?>    
                                </div>

                                <div id="editor">
                                    <?php echo $this->data['Page']['static_page_description']; ?>
                                    <?php //echo $this->Form->text('Page.static_page_description', array('label' => '', 'data-edit' => '', 'id' => 'editor', 'div' => false, 'class' => "")) ?>    
                                </div>
                            </div>
                      
                      </div>
                    </div>    
                    <div class="box-footer">
                        <label class="col-sm-2 control-label" for="inputPassword3">&nbsp;</label>
                        <?php echo $this->Form->hidden('Page.pageOldName');?>
                        <?php echo $this->Form->hidden('Page.id');?>
                        <?php echo $this->Form->hidden('Page.static_page_description');?>
                        
                        <?php echo $this->Form->submit('Update', array('class' => 'btn btn-info', 'div'=>false, 'id' => 'finalsbmt')); ?>
                        <?php echo $this->Html->link('Cancel', array('controller'=>'pages', 'action'=>'index'), array('escape'=>false, 'class'=>'btn btn-default canlcel_le'));?>
                    </div>
                  </div>
                </div>
            <?php echo $this->Form->end(); ?>
          </div>
    </section>
  </div>
