<div class="content-wrapper">
    <section class="content-header">
      <h1>
         Manage Industries 
      </h1>
      <ol class="breadcrumb">
          <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false));?></li>
          <li class="active"> Industries List </li>
      </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="ersu_message"> <?php echo $this->Session->flash(); ?> </div>
            <div class="admin_search">
                <?php echo $this->Form->create(Null, array('id' => 'adminForm')); ?>
                    <div class="form-group align_box">
                       <span class="hints">Search by Industry</span>
                       <span class="hint"><?php echo $this->Form->text('Industry.keyword', array('class' => "form-control required email", 'placeholder'=>"Search by Industry", 'autocomplete' => "off" )); ?></span>
                       <div class="admin_asearch">
                            <div class="ad_s ajshort"> <?php echo $this->Ajax->submit("Search", array('div' => false, 'url' => array('controller' => 'industries', 'action' => 'index'), 'update' => 'listID', 'indicator' => 'loaderID', 'class' => 'btn btn-info')); ?></div>
                            <div class="ad_cancel"> <?php echo $this->Html->link('Clear Search', array('controller'=>'industries', 'action'=>'index'), array('escape'=>false, 'class'=>'btn btn-default canlcel_le'));?></div>
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
                <div class="add_new_record"><?php echo $this->Html->link('<i class="fa fa-plus"></i> Add Industry', array('controller'=>'industries', 'action'=>'add'), array('escape'=>false, 'class'=>'btn btn-default'));?></div>
            </div>
            <div class="locater_img" id="loaderID"><?php echo $this->Html->image('loader_large_blue.gif');?></div>
            <div class="m_content" id="listID">
                <?php echo $this->element("admin/industries/index"); ?>
            </div>
            
        </div>
    </section>
</div>