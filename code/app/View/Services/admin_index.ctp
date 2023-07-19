<?php echo $this->Html->script('jquery/ui/jquery.ui.core.js'); ?>
<?php echo $this->Html->script('jquery/ui/jquery.ui.widget.js'); ?>
<?php echo $this->Html->script('jquery/ui/jquery.ui.position.js'); ?>
<?php echo $this->Html->script('jquery/ui/jquery.ui.datepicker.js'); ?>
<?php echo $this->Html->css('front/themes/ui-lightness/jquery.ui.all.css'); ?>
<script>
    $(function() {
        $("#searchByDateFrom").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            //minDate: 'mm-dd-yyyy',
            maxDate:'mm-dd-yyyy',
            changeYear: true,
            onClose: function(selectedDate) {
                if(selectedDate){$("#searchByDateTo").datepicker("option", "minDate", selectedDate);}
            }
        });
        $("#searchByDateTo").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            maxDate:'mm-dd-yyyy',
            changeYear: true,
            onClose: function(selectedDate) {
                if(selectedDate){$("#searchByDateFrom").datepicker("option", "maxDate", selectedDate);}
            }
        });

    });
</script>


<div class="content-wrapper">
    <section class="content-header">
      <h1>
         Manage Services 
      </h1>
      <ol class="breadcrumb">
          <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false));?></li>
          <li class="active"> Services List </li>
      </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="ersu_message"> <?php echo $this->Session->flash(); ?> </div>
            <div class="admin_search">
                <?php echo $this->Form->create(Null, array('id' => 'adminForm')); ?>
                    <div class="form-group align_box dtpickr_inputs">
                       <span class="hints">Search by Service Name or Company Name</span>
                       <span class="hint"><?php echo $this->Form->text('Service.keyword', array('class' => "form-control required email", 'placeholder'=>"Search by Service Name or Company Name", 'autocomplete' => "off" )); ?></span>
                       <span class="hint dtpickr_dv"><?php echo $this->Form->input('Service.searchByDateFrom', array('type' => 'text', 'id' => 'searchByDateFrom', 'label' => false , 'div' => false, 'class' => "form-control fix_widh fix_widh_custome", 'value' => isset($_SESSION['searchByDateFrom']) ? $_SESSION['searchByDateFrom'] : "" , 'placeholder' => 'From','readonly')); ?></span>
                       <span class="hint dtpickr_dv"><?php echo $this->Form->input('Service.searchByDateTo', array('type' => 'text', 'id' => 'searchByDateTo', 'label' => false , 'div' => false, 'class' => "form-control fix_widh fix_widh_custome", 'value' => isset($_SESSION['searchByDateTo']) ? $_SESSION['searchByDateTo'] : "", 'placeholder' => 'To','readonly')); ?></span>
                       <div class="admin_asearch">
                            <div class="ad_s ajshort"> <?php echo $this->Ajax->submit("Search", array('div' => false, 'url' => array('controller' => 'services', 'action' => 'index'), 'update' => 'listID', 'indicator' => 'loaderID', 'class' => 'btn btn-info')); ?></div>
                            <div class="ad_cancel"> <?php echo $this->Html->link('Clear Search', array('controller'=>'services', 'action'=>'index'), array('escape'=>false, 'class'=>'btn btn-default canlcel_le'));?></div>
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
                <div class="add_new_record"><?php echo $this->Html->link('<i class="fa fa-plus"></i> Add Service', array('controller'=>'services', 'action'=>'add'), array('escape'=>false, 'class'=>'btn btn-default'));?></div>
            </div>
            <div class="locater_img" id="loaderID"><?php echo $this->Html->image('loader_large_blue.gif');?></div>
            <div class="m_content" id="listID">
                <?php echo $this->element("admin/services/index"); ?>
            </div>
            
        </div>
    </section>
</div>