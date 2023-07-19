<?php
if (!empty($serviceImages)) {
    foreach ($serviceImages as $serviceImage) {
        ?>
        <div class="imgEditSbmtt">
            <?php echo $this->Ajax->submit("X", array('div' => false, 'url' => array('controller' => 'services', 'action' => 'deleteImage', $serviceImage['ServiceImage']['slug']), 'update' => 'ImageID',  'confirm' => 'Are you sure, you want to delete this image?','indicator' => 'loaderID')); ?>
            <div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">
                <?php
                $filePath = UPLOAD_FULL_SERVICE_IMAGE_PATH . $serviceImage['ServiceImage']['image'];
                if (file_exists($filePath) && $serviceImage) {
                    echo $this->Html->image(DISPLAY_FULL_SERVICE_IMAGE_PATH . $serviceImage['ServiceImage']['image'], array('alt' => ''));
                }
                ?>

            </div>
        </div>
    <?php
    }
}
?>