<div class="right_part">
    <div class="aside_contaner_full">
    
 <div class="bread_cremsks flwbrd_crmb">
        <ul>                    
            <li><?php echo $this->Html->link('Dashboard', array('controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'class' => '')); ?></li>
            <li>Followers</li>
        </ul>
        </div>
        
    <div class="m_content" id="listID">
        <?php echo $this->element("follows/follower"); ?>
    </div>

</div>
</div>