<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>
            <?php
            if (isset($title_for_layout)) {
                echo $title_for_layout;
            } else {
                echo SITE_TITLE;
            }
            ?>
        </title>
        <?php echo $this->Html->css('front/bootstrap.css'); ?>
        <?php echo $this->Html->css('front/style.css'); ?>
        <?php echo $this->Html->css('front/responsive.css'); ?>
        <?php echo $this->Html->css('front/font-awesome.css'); ?>
        <?php echo $this->Html->css('front/animate.css'); ?>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTTP_IMAGE; ?>/favicon.ico" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTTP_IMAGE; ?>/favicon.png" />
        <?php echo $this->Html->script('front/jquery.min.js'); ?>
        <?php /*<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script> */?>
        <script type="text/javascript">
            window.jQuery || document.write('<script src="js/jquery.min.js">' + "<" + "/script>");
        </script>
        <?php echo $this->Html->script('front/jquery.min.js'); ?>
        <?php echo $this->Html->script('front/bootstrap.js'); ?>
        <?php echo $this->Html->script('front/script.js'); ?>
        <?php echo $this->Html->script('front/retina.min.js'); ?>
        <?php echo $this->Html->script('jquery.validate.js'); ?>
        <script>
            $(document).ready(function(){
                $(".menu_icon").click(function(){
                    $(".navigation").toggleClass("left_icon");
                    $(".menu_icon").toggleClass("active");
                    $(".left_part").toggleClass("half");
                    $(".right_part").toggleClass("half");
                    $("body").toggleClass("web_rightside");
                });  
            });
        </script>
        <script type="text/javascript">
            $(window).load(function() {
                $(".web_page_loader").fadeOut("slow");
            })
        </script>
    </head>

    <body>
        <div class="web_page_loader"></div>
        
        <div class="page">
            <?php echo $this->element('header_inner'); ?>
            <?php echo $this->element('company_left_menu'); ?>
            <?php echo $content_for_layout; ?>
        </div>             
    </body>
</html>



