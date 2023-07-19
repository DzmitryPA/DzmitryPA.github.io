<!DOCTYPE html>

<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="images/mobile-logo.png" rel="icon" type="image/x-icon" />
        <link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/mystyle.css">
        <script>
            $(document).ready(function() {
                var id = '#dialog';
//Get the screen height and width
                var maskHeight = $(document).height();
                var maskWidth = $(window).width();
//Set heigth and width to mask to fill up the whole screen
                $('#mask').css({'width': maskWidth, 'height': maskHeight});
//transition effect
                $('#mask').fadeIn(500);
                $('#mask').fadeTo("slow", 0.9);
//Get the window height and width
                var winH = $(window).height();
                var winW = $(window).width();
//Set the popup window to center
                $(id).css('top', winH / 2 - $(id).height() / 2);
                $(id).css('left', winW / 2 - $(id).width() / 2);
//transition effect
                $(id).fadeIn(2000);
//if mask is clicked
                $('#butt').click(function() {
                    $('.window').hide();
                    window.location.href = 'registers.php'; // full http path where yuo want to redirect redirect after click on yes like http://localhost/test/registers.php
                });
                $('#butt2').click(function() { 
                    $('.window').hide();
                    window.location.href = 'index.php'; // full http path where yuo want to redirect redirect after click on no http://localhost/test/index.php
                });
            });
            
             
            
        </script>


        <style>
            /*POP UP CONTENT*/
            @media only screen and (min-width: 720px) {
                #mask {
                    position: fixed;
                    margin-left: auto;
                    margin-right:auto;
                    top: 0;
                    z-index:999;
                    background-color: #000;
                    width: 100%;
                    height:100%;
                    display: none;

                }
                #boxes .window {
                    position: fixed;
                    left: 0;
                    top: 0;
                    width: 440px;
                    height: 200px;
                    display: block;
                    z-index: 9999;
                    padding: 20px;

                    text-align: center;
                }
                #boxes #dialog {
                    width: 730px;
                    height: 290px;
                    padding: 0px;
                    background-color: #ffffff;
                    font-family: 'Segoe UI Light', sans-serif;
                    font-size: 15pt;

                }

                #but
                {
                    position:relative;
                    top:2%;
                    bottom:30%;
                }
            }

        </style>

    </head>
    <body><br><br><br>
        <div class="row">
            <div id="fix">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="boxes">
                        <div id="dialog" class="window">
                            <img  src="images/popup.jpg" class="img-responsive" width="100" height="auto"></img><br>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <button type="button" class="btn btn-danger" id="butt">YES</button>
                                <button type="button" class="btn btn-danger" id="butt2">NO</button>
                            </div>                       
                        </div>
                        <div id="mask"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>