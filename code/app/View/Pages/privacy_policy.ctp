<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="" />

        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="shortcut icon" href="<?php echo HTTP_PATH; ?>/app/webroot/img/front/favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="<?php echo HTTP_PATH; ?>/app/webroot/img/front/favicon.ico" type="image/x-icon"/>
        <title>
            <?php
            if (isset($title_for_layout))
                echo $title_for_layout;
            else
                echo SITE_TITLE;
            ?>
        </title>
        <?php echo $this->Html->css('front/style.css'); ?>
        <?php echo $this->Html->css('front/responsive.css'); ?>
        <?php echo $this->Html->css('front/font-awesome.css'); ?>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
        <?php echo $this->Html->script('front/jquery.min.js'); ?>
        <?php echo $this->Html->script('front/html5.js'); ?>        
        <script type="text/javascript">
            $(document).ready(function(){
                $(".dev_menu").click(function(){
                    $(".menu_open").toggle();
                });    
            });
            </script>

            <script type="text/javascript">
            $(document).ready(function(){
                    $("#test_2, #test_3").hide();
                $("#dote_2").click(function(){
                    $("#test_2").show();
                            $("#test_1, #test_3").hide();

                            $("#dote_2").addClass("active");
                            $("#dote_1, #dote_3").removeClass("active");




                });   



                    $("#test_1, #test_2").hide();
                    $("#test_3").show();
                $("#dote_3").click(function(){
                    $("#test_3").show();
                            $("#test_2, #test_1").hide();
                            $("#dote_3").addClass("active");
                            $("#dote_2, #dote_1").removeClass("active");

                });  

                    $("#test_3, #test_2").hide();
                    $("#test_1").show();
                $("#dote_1").click(function(){
                    $("#test_1").show();
                            $("#test_2, #test_3").hide();
                            $("#dote_1").addClass("active");
                            $("#dote_2, #dote_3").removeClass("active");
                });    
            });
            </script>
    </head>


    <body style="background:#fff;">
        <div class="wrapper">
           
            <div class="maids">
                <div class="loginp">
                    <h1><?php echo $pageContent['Page']['static_page_title']; ?></h1>
                </div>
                <div class="inpfil">
                    <?php echo $pageContent['Page']['static_page_description']; ?>
                    <div class="clr"></div>
                </div>
            </div>
        </div>
        <!-- end of #container -->
    </body>
</html>
