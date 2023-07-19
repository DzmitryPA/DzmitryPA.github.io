<header class="main-header">
     <a href="<?php echo HTTP_PATH;?>/admin/admins/dashboard" class="logo">
         <span class="logo-mini"><b><?php echo $this->Html->image('short_logo.png');?></b></span>
      <span class="logo-lg"><?php echo $this->Html->image('email_logo.png');?></span>
    </a>
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                        <?php echo $this->Html->image('user2-160x160.jpg', ['alt' => SITE_TITLE, "class" => "user-image"]); ?>
                        <span class="hidden-xs"><?php echo $this->Session->read('admin_username') ?></span>
                    </a>
                </li>
                <li><?php echo $this->Html->link('<i class="fa fa-sign-out fa-lg"></i> Logout', array('controller'=>'admins', 'action'=>'logout'), array('escape'=>false));?>  </li>
            </ul>
        </div>
    </nav>
</header>