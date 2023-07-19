<header>
    <div class="header_left">
        <div class="menu_icon"></div>
        <div class="logo"><?php echo $this->Html->link($this->Html->image('front/logo.png', array('alt'=>SITE_TITLE)), '/', array('escape' => false)); ?></div>
    </div>

    <div class="header_right">
        <div class="notification_section_top">
            <ul>
                <li><div class="icn_noti"><i class="nav-icon fa fa-bullhorn"></i><span class="bg_colrred">5</span></div></li>
                <li><div class="icn_noti"><i class="nav-icon fa fa-envelope"></i><span class="bg_colrred green">10</span></div></li>
                <li><div class="icn_noti"><i class="nav-icon fa fa-gavel"></i><span class="bg_colrred green">10</span></div></li>
                <li><div class="icn_noti"><i class="fa fa-credit-card" aria-hidden="true"></i><span class="bg_colrred green">10</span></div></li>
                <li><div class="icn_noti"><?php echo $this->Html->link('<i class="nav-icon fa fa-power-off"></i>', array('controller'=>'users', 'action'=>'logout'), array('escape' => false)); ?></div></li>
            </ul>
        </div>
    </div>
</header>
