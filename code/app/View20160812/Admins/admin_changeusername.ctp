<script type="text/javascript">
    $(document).ready(function() {
        $("#adminForm").validate();
    });

</script>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
         Change Username 
      </h1>
      <ol class="breadcrumb">
          <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false));?></li>
          <li><a href="javascript:void(0);"><i class="fa fa-cogs"></i> Configuration</a></li>
          <li class="active">Change Username</li>
      </ol>
    </section>

    <section class="content">
     <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">&nbsp;</h3>
            </div>
            <div class="ersu_message"> <?php echo $this->Session->flash(); ?> </div>
            <?php echo $this->Form->create(Null, array('id' => 'adminForm')); ?>
                <div class="form-horizontal">
                    <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Current Username <span class="require"></span></label>
                      <div class="col-sm-10">
                          <?php echo $this->Form->text('Admin.old_username', array('class' => "form-control required", 'value'=>$adminInfo['Admin']['username'],'readonly'=>true )); ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">New Username <span class="require">*</span></label>
                      <div class="col-sm-10">
                          <?php echo $this->Form->text('Admin.new_username', array('class' => "form-control required", 'placeholder' => 'New Username')); ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Confirm Username <span class="require">*</span></label>
                      <div class="col-sm-10">
                          <?php echo $this->Form->text('Admin.conf_username', array('class' => "form-control required",'placeholder' => 'Confirm Username', 'equalTo'=>'#AdminNewUsername')); ?>
                      </div>
                    </div>

                    <div class="box-footer">
                        <label class="col-sm-2 control-label" for="inputPassword3">&nbsp;</label>
                        <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-info', 'div'=>false)); ?>
                        <?php echo $this->Html->link('Cancel', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false, 'class'=>'btn btn-default canlcel_le'));?>
                    </div>
                  </div>
                </div>
            <?php echo $this->Form->end(); ?>
          </div>
    </section>
  </div>
