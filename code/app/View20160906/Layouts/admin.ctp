<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
      Administration - <?php
        if (isset($title_for_layout)){
            echo $title_for_layout;
        }else{
            echo SITE_TITLE;
        }
        ?>
  </title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTTP_IMAGE;?>/favicon.ico" />
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTTP_IMAGE;?>/favicon.png" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <?php echo $this->Html->css('bootstrap.min.css'); ?>
  <?php echo $this->Html->css('AdminLTE.min.css'); ?>
  <?php echo $this->Html->css('style.css'); ?>
  <?php echo $this->Html->css('media.css'); ?>
  <?php echo $this->Html->css('all-skins.min.css'); ?>
  <?php echo $this->Html->css('table-responsive.css'); ?>
  <?php echo $this->Html->script('jquery-2.1.0.min.js'); ?>
  <?php echo $this->Html->script('jquery.validate.js'); ?>
  <?php echo $this->Html->script('app.min.js'); ?>
  <?php echo $this->Html->script('listing.js'); ?>
  


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php echo $this->element('admin/header'); ?>
    <?php echo $this->element('admin/left_menu'); ?>
    <?php echo $content_for_layout; ?>
</div>
</body>
</html>
