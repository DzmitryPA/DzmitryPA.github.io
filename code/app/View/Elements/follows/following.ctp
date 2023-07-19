
<?php echo $this->Form->create("Follow", array("action" => "myFollowing", "method" => "Post")); ?>

<?php
$paginationParam = $this->Paginator->params();
$page = $paginationParam['page'];
$urlArray = array_merge(array('controller' => 'follows', 'action' => 'myFollowing', $separator));
$this->Paginator->_ajaxHelperClass = "Ajax";
$this->Paginator->Ajax = $this->Ajax;
$this->Paginator->options(array('update' => 'listID', 'url' => $urlArray, 'indicator' => 'loaderID'));
?>

<div class="full_box_of_staf_ne">
    <div class="full_box_of_staf_left"><h2>My Followings</h2></div>  
    <div class="show_pagination_ec">
        <span class="custom_link pagination"> 
            <?php echo $this->Paginator->first('First', array()); ?>&nbsp;
            <?php if ($this->Paginator->hasPrev('User')) echo $this->Paginator->prev('Prev', array()); ?>
            <?php echo $this->Paginator->numbers(array('separator' => '  ')); ?>
            <?php
            if ($this->Paginator->hasNext('User')) {
                echo $this->Paginator->next('Next', array());
            }
            ?>
            <?php echo $this->Paginator->last('Last', array()); ?>                    
        </span>
    </div>
</div>

<?php if ($users) { ?>

    <div class="tab_fomate_overlay tab_fomate_overlay_minsk">
        <div class="tab_fomate_table">
            <div class="tab_fomate_table_row tab_fomate_table_row_th">
                <div class="tab_fomate_table_cell ">Logo</div>
                <div class="tab_fomate_table_cell"><?php echo $this->Paginator->sort('Following.company_name', 'Company Name'); ?></div>
                <div class="tab_fomate_table_cell"><?php echo $this->Paginator->sort('Following.unique_id', 'Unique Id'); ?></div>
                <div class="tab_fomate_table_cell">Action</div>
            </div>




            <?php foreach ($users as $userInfo) { ?>

                <div class="tab_fomate_table_row">
                    <div class="tab_fomate_table_cell left_align_text">
                        <div class="bose_dash_full_contentsmale_fill_cellsed">
                            <?php
                            $filePath = UPLOAD_LOGO_PATH . $userInfo['Following']['company_logo'];
                            if (file_exists($filePath) && $userInfo['Following']['company_logo']) {
                                echo $this->Html->link($this->Html->image(DISPLAY_LOGO_PATH . $userInfo['Following']['company_logo'], array('alt' => 'Img')), array('controller' => 'users', 'action' => 'profile', $userInfo['Following']['slug']), array('escape' => false, 'class' => ''));
                            } else {
                                echo $this->Html->link($this->Html->image('no_image.gif'), array('controller' => 'users', 'action' => 'profile', $userInfo['Following']['slug']), array('escape' => false, 'class' => ''));
                            }
                            ?>
                        </div>
                    </div>
                    <div class="tab_fomate_table_cell"><?php echo $userInfo['Following']['company_name']; ?></div>
                    <div class="tab_fomate_table_cell"><?php echo $userInfo['Following']['unique_id']; ?></div>
                    <div class="tab_fomate_table_cell"><div class="view_detail"><?php echo $this->Html->link('View Details', array('controller' => 'users', 'action' => 'profile', $userInfo['Following']['slug']), array('escape' => false, 'class' => '')); ?></div></div>
                </div>

            <?php } ?>
        </div> </div>

    <div class="show_pagination_ec show_pagination_ec_bottom show_pagination_ec_nrk">
        <span class="custom_link pagination"> 
            <?php echo $this->Paginator->first('First', array()); ?>&nbsp;
            <?php if ($this->Paginator->hasPrev('User')) echo $this->Paginator->prev('Prev', array()); ?>
            <?php echo $this->Paginator->numbers(array('separator' => '  ')); ?>
            <?php
            if ($this->Paginator->hasNext('User')) {
                echo $this->Paginator->next('Next', array());
            }
            ?>
            <?php echo $this->Paginator->last('Last', array()); ?>                    
        </span>
    </div>


    <?php echo $this->Form->end(); ?>
    <?php
} else {
    echo "<div class='no-rec-fnd-front'>  No Record Found </div>";
}
?>