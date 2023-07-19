<?php if ($users) { ?>
    <?php echo $this->Form->create("User", array("action" => "index", "method" => "Post")); ?>
    <div class="bread_cremsks">
        <ul>                    
            <li><?php echo $this->Html->link('Dashboard', array('controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'class' => '')); ?></li>
            <?php
            if (isset($industry)) {
                $value = array_search($industry, array_flip($industryList));
                ?>
                <li><?php echo $value ?></li>
            <?php } ?>
        </ul>
    </div>

    <?php
    $paginationParam = $this->Paginator->params();
    $page = $paginationParam['page'];
    $urlArray = array_merge(array('controller' => 'users', 'action' => 'searchCompanies', $separator));
    $this->Paginator->_ajaxHelperClass = "Ajax";
    $this->Paginator->Ajax = $this->Ajax;
    $this->Paginator->options(array('update' => 'listID', 'url' => $urlArray, 'indicator' => 'loaderID'));
    ?>

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


    <div class="aside_contaner_full">

        <div class="listing_section listing_section_sk listing_section_sk_dsnas listing_of_induasrtires">
            <div class="tab_content" id="roducts_data">
                <?php foreach ($users as $userInfo) { ?>
                    <div class="listing_section_row">
                        <div class="listing_section_row_img">
                            <?php
                            $filePath = UPLOAD_LOGO_PATH . $userInfo['User']['company_logo'];
                            if (file_exists($filePath) && $userInfo['User']['company_logo']) {
                                echo $this->Html->link($this->Html->image(DISPLAY_LOGO_PATH . $userInfo['User']['company_logo'], array('alt' => 'Img')), array('controller' => 'users', 'action' => 'profile', $userInfo['User']['slug']), array('escape' => false, 'class' => ''));
                            } else {
                                echo $this->Html->link($this->Html->image('no_image.gif'), array('controller' => 'users', 'action' => 'profile', $userInfo['User']['slug']), array('escape' => false, 'class' => ''));
                            }
                            ?>
                        </div>
                        <div class="listing_section_row_content">
                            <div class="listing_section_row_content_left">
                                <div class="lising_title_both"><?php echo $this->Html->link(ucfirst($userInfo['User']['company_name']), array('controller' => 'users', 'action' => 'profile', $userInfo['User']['slug']), array('escape' => false, 'class' => '')); ?></div>  
                                <div class="titl_of_ksd"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $userInfo['User']['building_number'] . ", " . $userInfo['User']['street'] . ", " . $userInfo['City']['city_name'] . ", " . $userInfo['User']['zipcode'] . ", " . $userInfo['State']['state_name'] . ", " . $userInfo['Country']['name'] ?> </div>
                                <span class="small_datae_conenr desct">
                                    <?php if ($userInfo['User']['about_us'] != "") { ?>
                                        <?php
                                    $string = strip_tags($userInfo['User']['about_us']);
                                    if (strlen($string) > 400) {
                                        $stringCut = substr($string, 0, 400);
                                        $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...' . $this->Html->link('view more', array('controller' => 'users', 'action' => 'aboutUs', $userInfo['User']['slug']), array('escape' => false, 'class' => (isset($aboutusHeaderAct)) ? "active" : ""));
                                    }
                                    echo $string;
                                    ?>
                                    <?php }
                                    ?>
                                </span>
                                <div class="alisingcatego alisingcategocos">
                                    <span>Industry Type:</span> <?php echo $userInfo['Industry']['name'] ?>
                                </div>                                   
                            </div>
                            <div class="listing_section_row_content_right">                                    
                                <div class="view_detail"><?php echo $this->Html->link('View Details', array('controller' => 'users', 'action' => 'profile', $userInfo['User']['slug']), array('escape' => false, 'class' => '')); ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>                        

        </div>
        <div class="show_pagination_ec show_pagination_ec_bottom">
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

    <?php
    if (isset($keyword) && $keyword != '') {
        echo $this->Form->hidden('User.keyword', array('type' => 'hidden', 'value' => $keyword));
    }
    if (isset($location) && $location != '') {
        echo $this->Form->hidden('User.location', array('type' => 'hidden', 'value' => $location));
    }
    if (isset($industry) && $industry != '') {
        echo $this->Form->hidden('User.industry', array('type' => 'hidden', 'value' => $industry));
    }
    ?>
    <?php echo $this->Form->end(); ?>
    <?php
} else {
    echo "<div class='no-rec-fnd-front'>  No Record Found </div>";
}
?>