<?php
if ($statuss == 1) {
    echo $this->Html->link('Unfollow', 'javascript:void(0)', array('class' => '', 'escape' => false, 'onclick' => 'unfollow(' . $following_id . ',' . $follower_id . ')'));
} else {
    echo $this->Html->link('Follow', 'javascript:void(0)', array('class' => '', 'escape' => false, 'onclick' => 'follow(' . $following_id . ',' . $follower_id . ')'));
}
?>