<?php
if (!empty($serviceImages)) {
    foreach ($serviceImages as $serviceImage) {
        ?>
        <div class="imgEditSbmttFrnt">
            <?php echo $this->Ajax->submit("X", array('div' => false, 'class' => 'clsefrntbt', 'url' => array('controller' => 'services', 'action' => 'deleteImage', $serviceImage['ServiceImage']['slug']), 'update' => 'ImageID', 'confirm' => 'Are you sure, you want to delete this image?', 'indicator' => 'loaderID')); ?>
            <div class="shoe_imagrd_rgijt_img">
                            <div class="shoe_imagrd_rgijt_img_minimg">
                <?php
                $filePath = UPLOAD_FULL_SERVICE_IMAGE_PATH . $serviceImage['ServiceImage']['image'];
                if (file_exists($filePath) && $serviceImage) {
                    echo $this->Html->image(DISPLAY_FULL_SERVICE_IMAGE_PATH . $serviceImage['ServiceImage']['image'], array('alt' => ''));
                }
                ?>

            </div>
            </div>
        </div>
    <?php
    }
}
?>