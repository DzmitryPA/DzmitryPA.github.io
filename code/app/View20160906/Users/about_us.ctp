<div class=" <?php echo ($this->Session->read('user_id') == '') ? 'right_part_fulls right_part_fulls_none' : 'right_part'  ?>">
<div class="ee"><?php echo $this->Session->flash(); ?></div>
    <?php echo $this->element("users/profile_header"); ?>
    
    <!--<div class="section_about_banner">
    <?php //echo $this->Html->image('front/about_anner.png', array('alt'=>'Banner Image')); ?></div>-->
            <div class="clear"></div>
            
            <div class="aside_contaner_full about_contenteditor">
                <?php
                    if($userInfo['User']['about_us'] != ""){
                        echo $userInfo['User']['about_us'];
                    }else{
                        echo "<div class='no_detail_about_us'> Oops! It seems, this company haven't filled their About Us Section. </div>";
                    }
                
                ?>

            </div>


</div>