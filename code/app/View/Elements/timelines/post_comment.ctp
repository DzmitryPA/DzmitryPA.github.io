<?php
if ($comment) {
    ?>
    <div class="comment_container comment_mndv<?php echo $comment['Comment']['slug'] ?>">
        <div class="comment_upper">
            <div class="this_project_tag_img img_comment">
                <?php
                $filePath = UPLOAD_LOGO_PATH . $comment['User']['company_logo'];
                if (file_exists($filePath) && $comment['User']['company_logo']) {
                    echo $this->Html->link($this->Html->image(DISPLAY_LOGO_PATH . $comment['User']['company_logo'], array('alt' => 'Img')), array('controller' => 'users', 'action' => 'profile', $comment['User']['slug']), array('escape' => false, 'class' => ''));
                } else {
                    echo $this->Html->link($this->Html->image('no_image.gif'), array('controller' => 'users', 'action' => 'profile', $comment['User']['slug']), array('escape' => false, 'class' => ''));
                }
                ?>
            </div>
            <div class="this_project_tag_name name_comment"><?php echo $this->Html->link($comment['User']['company_name'], array('controller' => 'users', 'action' => 'profile', $comment['User']['slug']), array('escape' => false, 'class' => '')); ?></div>
            <div class="datetime_comment">
                <?php
                if (date('Y-m-d') == date('Y-m-d', strtotime($comment['Comment']['created']))) {
                    echo "today";
                } elseif (date('Y-m-d', strtotime("-1 days")) == date('Y-m-d', strtotime($comment['Comment']['created']))) {
                    echo "yesterday";
                } else {
                    echo date('j F Y', strtotime($comment['Comment']['created']));
                }
                ?>

                <span><?php echo date('H:i', strtotime($comment['Comment']['created']));
                ?></span>
            </div>
        </div>
        <div class="comment_lower">
            <span> <?php echo $comment['Comment']['comment'] ?> </span>
            
            <?php
            if ($comment['Comment']['from_user_id'] == $this->Session->read('user_id')) {
                echo $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', 'javascript:void(0);', array('escape' => false, 'class' => '', 'onclick' => "deleteComment(" . $comment['Comment']['from_user_id'] . ",'" . $comment['Comment']['slug'] . "')"));
            }
            ?>
        </div>

    </div>
    <?php
}
?>