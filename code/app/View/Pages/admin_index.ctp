<div class="content-wrapper">
    <section class="content-header">
      <h1>
         Manage Text Pages
      </h1>
      <ol class="breadcrumb">
          <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span> Dashboard</span> ', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false));?></li>
          <li><?php echo $this->Html->link('<i class="fa fa-file-text-o"></i> <span> Content</span> ', 'javascript:void(0)', array('escape'=>false));?></li>
          <li class="active"> Pages List </li>
      </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="locater_img" id="loaderID"><?php echo $this->Html->image('loader_large_blue.gif');?></div>
            <div class="m_content" id="listID">
                <div class="ersu_message"> <?php echo $this->Session->flash(); ?> </div>
                <?php echo $this->element("admin/page/index"); ?>
            </div>
            
        </div>
    </section>
</div>