<?php
if ($this->Session->read('user_id')) {
    $company_id = $this->Session->read('user_id');
} else {
    $company_id = 0;
}
?>


<div class="banner_top_section"
     <?php if($userInfo['User']['background_img'] != "") { ?>
     style="background: url(../files/background/<?php echo $userInfo['User']['background_img']; ?>)"
     <?php } ?>>
    
    <div class="text-center">
        <div class="logo_of_img">
<?php
$filePath = UPLOAD_LOGO_PATH . $userInfo['User']['company_logo'];
if (file_exists($filePath) && $userInfo['User']['company_logo']) {
    echo $this->Html->image(DISPLAY_LOGO_PATH . $userInfo['User']['company_logo'], array('alt' => 'Img'));
} else {
    echo $this->Html->image('no_image.gif');
}
?>
        </div>
        <div class="logo_of_title"><?php echo $userInfo['User']['company_name'] ?></div>
        <div class="logo_of_titlesub">@<?php echo $userInfo['User']['unique_id'] ?></div>
    </div>

    <div class="clear"></div>
    <div class="aside_contaner">
        <div class="bar_of_overtratring">
            <div class="section_of_bar section_of_bar_full">
                <div class="section_of_bar_title">Overall Rating <span>(265 opinions)</span></div>
                <div id="rate-result" class="clear_bar_sec">

                    <span id="main1" class="rank rank1"></span><span id="main2" class="rank rank1"></span><span id="main3" class="rank rank1"></span><span id="main4" class="rank rank05"></span><span id="main5" class="rank rank0"></span>

                </div>

            </div>

            <div class="section_of_bar_halff">
                <div class="section_of_bar">                        
                    <div class="clear_bar_sec_progress"><span class="sparkline-transactions">167,137,107,77,97,127,157</span></div>
                </div>

                <div class="section_of_bar">
                    <div class="section_of_bar_title">Transactions</div>
                    <div class="clear_bar_sec">3,593</div>
                </div>
            </div>
            <div class="section_of_bar_halff">
                <div class="section_of_bar">                        
                    <div class="clear_bar_sec_progress"><span class="sparkline-sales">167,137,107,77,97,127,157</span></div>
                </div>

                <div class="section_of_bar">
                    <div class="section_of_bar_title">Sales</div>
                    <div class="clear_bar_sec">$ 1,423</div>
                </div> 
            </div>
            <div class="section_of_bar_halff">

<?php
$followers = ClassRegistry::init('Follow')->field('COUNT(Follow.id)', array('Follow.following_id' => $userInfo['User']['id']));
?>
                <div class="section_of_bar">
                    <div class="section_of_bar_title">Followers</div>
                    <div class="clear_bar_sec">+ <span id="counttFollow"><?php echo $followers ?></span></div>
                </div>

                <div class="section_of_bar">
                    <div class="folow_btn">
                        <div id="udtFollow">
<?php
if ($company_id == $userInfo['User']['id']) {
    echo $this->Html->link('Follow', 'javascript:void(0)', array('class' => '', 'escape' => false));
} else {
    $ifExist = ClassRegistry::init('Follow')->field('id', array('Follow.following_id' => $userInfo['User']['id'], 'Follow.follower_id' => $company_id));
    if ($ifExist) {
        echo $this->Html->link('Unfollow', 'javascript:void(0)', array('class' => '', 'escape' => false, 'onclick' => 'unfollow(' . $userInfo['User']['id'] . ',' . $company_id . ')'));
    } else {
        echo $this->Html->link('Follow', 'javascript:void(0)', array('class' => '', 'escape' => false, 'onclick' => 'follow(' . $userInfo['User']['id'] . ',' . $company_id . ')'));
    }
}
?> 
                        </div>

                        <div class="btn_loader_followw" id="sub_btn_dive_loader" style="display: none;">
                            <div class="btm_loader_followw"> <?php echo $this->Html->image('loading.svg'); ?></div>
                        </div>

                    </div>

                </div>

            </div>


        </div>
    </div>
</div>

<div class="menu_links">
    <ul>
        <li><?php echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'profile', $slug), array('escape' => false, 'class' => (isset($profilHeaderAct)) ? "active" : "")); ?></li>
        <li><?php echo $this->Html->link('About Us', array('controller' => 'users', 'action' => 'aboutUs', $slug), array('escape' => false, 'class' => (isset($aboutusHeaderAct)) ? "active" : "")); ?></li>
        <li><?php echo $this->Html->link('Showcase', 'javascript:void(0)', array('escape' => false, 'class' => (isset($showcaseHeaderAct)) ? "active" : "")); ?></li>
        <li><?php echo $this->Html->link('Information', 'javascript:void(0)', array('escape' => false, 'class' => (isset($infoHeaderAct)) ? "active" : "")); ?></li>
        <li><?php echo $this->Html->link('Contact', array('controller' => 'users', 'action' => 'contactUs', $slug), array('escape' => false, 'class' => (isset($contactHeaderAct)) ? "active" : "")); ?></li>
    </ul>
</div>


<?php 
if($company_id != $userInfo['User']['id'] && $userInfo['User']['watch_status'] == 1){
$logged_in_comp_watch_status =ClassRegistry::init('User')->field('watch_status', array('User.id' => $company_id));
if($logged_in_comp_watch_status == 1){    
?>

<script>
    $(function () {
        watchProfile();
    });
    
    function watchProfile(){
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>/users/watchProfile/<?php echo $userInfo['User']['id']; ?>',
            beforeSend: function() {},
            success: function(result) {
            }

        });
    }

</script>

<?php
}
}
?>


<?php echo $this->Html->script('front/pixel-admin.min.js'); ?>

<script type="text/javascript">
//begin js
    $('.sparkline-transactions').sparkline('html', {
        type: 'bar',
        height: '37',
        barWidth: 7,
        barSpacing: 5,
        zeroAxis: false,
        tooltipPrefix: '$',
        barColor: '#148ed1',
        tooltipFormat: $.spformat('${{value}}', 'sparkline-tooltip')
    });
    $('.sparkline-sales').sparkline('html', {
        type: 'bar',
        height: '37',
        barWidth: 7,
        barSpacing: 5,
        zeroAxis: false,
        barColor: '#148ed1',
        tooltipFormat: $.spformat('${{value}}', 'sparkline-tooltip')
    });




    $('.rank').hover(function () {

        var $start = (parseInt($(this).attr('id').substr(4, 1)));



        $('.rank').addClass('rank-notactive');

        for (i = 1; i < $start + 1; i++) {

            $('#main' + i).addClass('rank-active').removeClass('rank-notactive');

            console.log($('#main' + i));

        }

    }, function () {

        $('.rank').removeClass('rank-active');

        $('.rank').removeClass('rank-notactive');

    });



    $('.rank').click(function () {

        var $start = (parseInt($(this).attr('id').substr(4, 1)));

        $('#inputRate').val($start);

        $('#submit_rate').submit();

    });



    $('#profile-slider').carousel();



    var bgperc = ($('#main-navbar').outerHeight() + $('#parallax').outerHeight()) / 100;

    $(window).scroll(function () {

        if (($('#main-navbar').outerHeight() + $('#parallax').outerHeight()) > $(document).scrollTop()) {

            var bgposy = ($(document).scrollTop() / bgperc).toFixed(2);

            $('#parallax').css('background-position', '50% ' + bgposy + '%');

        }

    });



    $('.followed').hover(
            function () {

                var $this = $(this); // caching $(this)

                $this.data('initialText', $this.text());

                $this.text("Unfollow");

            },
            function () {

                var $this = $(this); // caching $(this)

                $this.text($this.data('initialText'));

            }

    );


    //$( '.cbp-fwslider' ).cbpFWSlider();




    //window.PixelAdmin.start(init);


//end
</script>

<script>
    function follow(following_id, follower_id) {
        if (follower_id > 0) {
            $.ajax({
                type: 'POST',
                url: "<?php echo HTTP_PATH; ?>/follows/followCompany",
                cache: false,
                data: {following_id: following_id, follower_id: follower_id},
                beforeSend: function () {
                    $("#sub_btn_dive_loader").show();
                },
                complete: function () {
                    $("#sub_btn_dive_loader").hide();
                },
                success: function (result) {
                    $("#sub_btn_dive_loader").hide();
                    if (result) {
                        $("#udtFollow").html(result);
                        updateFollowers(following_id);
                    }
                }
            });
        } else {
            $(location).attr('href', "<?php echo HTTP_PATH ?>/users/login");
        }

    }


    function unfollow(following_id, follower_id) {

        if (follower_id > 0) {
            $.ajax({
                type: 'POST',
                url: "<?php echo HTTP_PATH; ?>/follows/unfollowCompany",
                cache: false,
                data: {following_id: following_id, follower_id: follower_id},
                beforeSend: function () {
                    $("#sub_btn_dive_loader").show();
                },
                complete: function () {
                    $("#sub_btn_dive_loader").hide();
                },
                success: function (result) {
                    $("#sub_btn_dive_loader").hide();
                    if (result) {
                        $("#udtFollow").html(result);
                        updateFollowers(following_id);
                    }

                }
            });

        } else {
            $(location).attr('href', "<?php echo HTTP_PATH ?>/users/login");

        }

    }


    function updateFollowers(following_id) {
        $.ajax({
            type: 'POST',
            url: "<?php echo HTTP_PATH; ?>/follows/updateFollowers",
            cache: false,
            data: {following_id: following_id},
            beforeSend: function () {

            },
            complete: function () {

            },
            success: function (result) {
                //alert(result);
                if (result) {
                    $("#counttFollow").html(result);
                }
            }
        });
    }

</script>