<script type="text/javascript">
    $(document).ready(function() {
        $("#adminForm").validate();
    });

</script>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Edit State 
      </h1>
      <ol class="breadcrumb">
          <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false));?></li>
          <li><?php echo $this->Html->link('<i class="fa fa-table"></i> States', array('controller'=>'states', 'action'=>'index'), array('escape'=>false));?></li>
          <li class="active">Edit State</li>
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
                      <label class="col-sm-2 control-label">State <span class="require">*</span></label>
                      <div class="col-sm-10">
                          <?php echo $this->Form->text('State.state_name', array('class' => "form-control required" )); ?>
                      </div>
                    </div>
                    <div class="box-footer">
                        <label class="col-sm-2 control-label" for="inputPassword3">&nbsp;</label>
                        <?php echo $this->Form->hidden('State.id'); ?>
                        <?php echo $this->Form->hidden('State.old_name'); ?>
                        <?php echo $this->Form->submit('Update', array('class' => 'btn btn-info', 'div'=>false)); ?>
                        <?php echo $this->Html->link('Cancel', array('controller'=>'states', 'action'=>'index','page'=>$this->passedArgs["page"]), array('escape'=>false, 'class'=>'btn btn-default canlcel_le'));?>
                    </div>
                  </div>
                </div>
            <?php echo $this->Form->end(); ?>
          </div>
    </section>
  </div>
