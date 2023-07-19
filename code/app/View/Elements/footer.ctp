<footer>
        <div class="container">
            <div class="about_stafir_footer">
                <?php echo $this->Html->image('front/footer_logo.png', array('alt' => 'Logo')) ?>
                <div class="clear"></div>
                
                <div class="abut_fotr_text">The business to business networking website to offer trading between companies like trading, manufacturing, wholesalers, retailers, contractors except government organizations. Companies can exchange between wide range of products & offered services.</div>
            </div>
            <div class="fooyter_menu_secks">
                <div class="footer_menus">
                    <ul>
                        <li><?php echo $this->Html->link('Home', '/', array('escape' => false, 'class' => '')); ?></li>
                    <li><?php echo $this->Html->link('Features', array('controller' => 'pages', 'action' => 'features'), array('escape' => false, 'class' => '')); ?></li>
                    <li><?php echo $this->Html->link('Pricing', array('controller' => 'pages', 'action' => 'staticpage', 'slug' => 'pricing'), array('escape' => false, 'class' => '')); ?></li>
                    <li><?php echo $this->Html->link('FAQ', array('controller' => 'pages', 'action' => 'faq'), array('escape' => false, 'class' => '')); ?></li>
                    <li><?php echo $this->Html->link('How It Works', array('controller' => 'pages', 'action' => 'staticpage', 'slug' => 'how-it-works'), array('escape' => false, 'class' => '')); ?></li>
                    <li><?php echo $this->Html->link('Privacy Policy', array('controller' => 'pages', 'action' => 'staticpage', 'slug' => 'privacy-policy'), array('escape' => false, 'class' => '')); ?></li>
                    </ul>
                </div>
            </div>
            <div class="fooyter_copy_right">
                <div class="footer_menus_textd">
                    &copy; 2016 stafir.com<br/>
                    All Rights Reserved<br/>
                    <?php echo $this->Html->link('Terms and Conditions', array('controller' => 'pages', 'action' => 'staticpage', 'slug' => 'terms-and-condition'), array('escape' => false, 'class' => '')); ?><br/>
                    <a href="http://logicspice.com" target="_blank">Web Solution Provider Company</a> LogicSpice
                </div>
            </div>
            <div class="fooyter_app_icn">
                <div class="app_icn_foot">
                    <a class="android_app_store"></a>
                    <a class="apple_app_store"></a>
                </div>
            </div>
        </div>
    </footer>
</div>