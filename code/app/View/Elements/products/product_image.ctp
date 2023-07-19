<?php
if (!empty($productImages)) {
    foreach ($productImages as $productImage) {
        ?>
        <div class="imgEditSbmttFrnt">
            <?php echo $this->Ajax->submit("X", array('div' => false, 'class' => 'clsefrntbt', 'url' => array('controller' => 'products', 'action' => 'deleteImage', $productImage['ProductImage']['slug']), 'update' => 'ImageID', 'confirm' => 'Are you sure, you want to delete this image?', 'indicator' => 'loaderID')); ?>
            <div class="shoe_imagrd_rgijt_img">
                            <div class="shoe_imagrd_rgijt_img_minimg">
                <?php
                $filePath = UPLOAD_FULL_PRODUCT_IMAGE_PATH . $productImage['ProductImage']['image'];
                if (file_exists($filePath) && $productImage) {
                    echo $this->Html->image(DISPLAY_FULL_PRODUCT_IMAGE_PATH . $productImage['ProductImage']['image'], array('alt' => ''));
                }
                ?>

            </div>
            </div>
        </div>
    <?php
    }
}
?>