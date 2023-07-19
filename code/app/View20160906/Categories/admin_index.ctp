<div class="content-wrapper">
    <section class="content-header">
      <h1>
         Manage Categories 
      </h1>
      <ol class="breadcrumb">
          <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false));?></li>
          <li class="active"> Categories List </li>
      </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="ersu_message"> <?php echo $this->Session->flash(); ?> </div>
            <div class="admin_search">
                <?php echo $this->Form->create(Null, array('id' => 'adminForm')); ?>
                    <div class="form-group align_box">
                       <span class="hints">Search by Category</span>
                       <span class="hint"><?php echo $this->Form->text('Category.keyword', array('class' => "form-control required email", 'placeholder'=>"Search by Category", 'autocomplete' => "off" )); ?></span>
                       <div class="admin_asearch">
                            <div class="ad_s ajshort"> <?php echo $this->Ajax->submit("Search", array('div' => false, 'url' => array('controller' => 'categories', 'action' => 'index'), 'update' => 'listID', 'indicator' => 'loaderID', 'class' => 'btn btn-info')); ?></div>
                            <div class="ad_cancel"> <?php echo $this->Html->link('Clear Search', array('controller'=>'categories', 'action'=>'index'), array('escape'=>false, 'class'=>'btn btn-default canlcel_le'));?></div>
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
                <div class="add_new_record"><?php echo $this->Html->link('<i class="fa fa-plus"></i> Add Category', array('controller'=>'categories', 'action'=>'add'), array('escape'=>false, 'class'=>'btn btn-default'));?></div>
            </div>
            <div class="locater_img" id="loaderID"><?php echo $this->Html->image('loader_large_blue.gif');?></div>
            <div class="m_content" id="listID">
                <?php echo $this->element("admin/categories/index"); ?>
            </div>
            
        </div>
    </section>
</div>