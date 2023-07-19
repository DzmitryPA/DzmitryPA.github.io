
<script>
    $(document).ready(function () {
        $(".device_emenu").click(function () {
            $(".menu_of_home").slideToggle();
        });
    });
</script>
<header>
    <div class="container">
        <div class="header_left">                
            <div class="logo"><?php echo $this->Html->link($this->Html->image('front/logo.png'), '/', array('escape' => false)); ?></div>
        </div>
        <div class="header_right relative_ecks">
            <div class="device_emenu"></div>
            <div class="menu_of_home">
                <ul>
                    <li class="<?php if(isset($homeAct)) { echo 'active'; } ?>"><?php echo $this->Html->link('Home', '/', array('escape' => false, 'class' => '')); ?></li>
                    <li class="<?php if(isset($featureAct)) { echo 'active'; } ?>"> <?php echo $this->Html->link('Features', array('controller' => 'pages', 'action' => 'features'), array('escape' => false, 'class' => '')); ?></li>
                    <li class="<?php if(isset($pricingAct)) { echo 'active'; } ?>"><?php echo $this->Html->link('Pricing', array('controller' => 'pages', 'action' => 'staticpage', 'slug' => 'pricing'), array('escape' => false, 'class' => '')); ?></li>
                    <li class="<?php if(isset($faqAct)) { echo 'active'; } ?>"><?php echo $this->Html->link('FAQ', array('controller' => 'pages', 'action' => 'faq'), array('escape' => false, 'class' => '')); ?></li>
                    <li class="<?php if(isset($howitworksAct)) { echo 'active'; } ?>"><?php echo $this->Html->link('How It Works', array('controller' => 'pages', 'action' => 'staticpage', 'slug' => 'how-it-works'), array('escape' => false, 'class' => '')); ?></li>
                </ul>
            </div>
            <div class="log_menuss">
                <ul>
                    <?php if (!$this->Session->read('user_id')) { ?>
                        <li class="signIn <?php
                        if (isset($loginAct)) {
                            echo 'active';
                        }
                        ?>"><?php echo $this->Html->link('Sign In', array('controller' => 'users', 'action' => 'login'), array('escape' => false)); ?></li>
                        <li class="signUp <?php
                        if (isset($regAct)) {
                            echo 'active';
                        }
                        ?>"><?php echo $this->Html->link('Sign Up', array('controller' => 'users', 'action' => 'register'), array('escape' => false)); ?></li>
                        <?php } else { ?>
                        <li class="dashbrdHome <?php
                        ?>"><?php echo $this->Html->link('Dashboard', array('controller' => 'users', 'action' => 'dashboard'), array('escape' => false)); ?></li>
                        <li class="logoutHome <?php
                            ?>"><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('escape' => false)); ?></li>

                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</header>