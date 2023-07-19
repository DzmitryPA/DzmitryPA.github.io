<?php
if (!empty($productImages)) {
    foreach ($productImages as $productImage) {
        ?>
        <div class="imgEditSbmtt">
            <?php echo $this->Ajax->submit("X", array('div' => false, 'url' => array('controller' => 'products', 'action' => 'deleteImage', $productImage['ProductImage']['slug']), 'update' => 'ImageID', 'confirm' => 'Are you sure, you want to delete this image?', 'indicator' => 'loaderID')); ?>
            <div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">
                <?php
                $filePath = UPLOAD_FULL_PRODUCT_IMAGE_PATH . $productImage['ProductImage']['image'];
                if (file_exists($filePath) && $productImage) {
                    echo $this->Html->image(DISPLAY_FULL_PRODUCT_IMAGE_PATH . $productImage['ProductImage']['image'], array('alt' => ''));
                }
                ?>

            </div>
        </div>
    <?php
    }
}
?>