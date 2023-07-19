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
  <?php echo $this->Html->css('bootstrap.min.css'); ?>
  <?php echo $this->Html->css('AdminLTE.min.css'); ?>
  <?php echo $this->Html->script('jquery-2.1.0.min.js'); ?>
  <?php echo $this->Html->script('jquery.validate.js'); ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <?php echo $content_for_layout; ?>
</div>
</body>
</html>