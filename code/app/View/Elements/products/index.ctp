<?php echo $this->Form->create("Product", array("action" => "index", "method" => "Post")); ?>
<div class="full_box_of_staf_full spacing_right_sisde">
    <div class="full_box_of_staf_right">                        
        <div class="invite_cusomer_link_brns">
            <?php if ($products) { ?>
            <?php echo $this->Ajax->submit('Delete', array('div' => false, 'url' => array('controller' => 'products', 'action' => 'index/'), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('delete');", 'confirm' => "Are you sure you want to Delete ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('deleted');", 'class' => 'btn_del_frntlstng')); ?> 
            <?php } ?>
            <?php echo $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> <span>Add Product</span>', array('controller' => 'products', 'action' => 'add'), array('escape' => false)); ?>
        </div>
    </div>
    <div class="left_aprt_of_gst">
        <div class="title_of_page_riweoname no_bordere">Manage Products</div>
    </div>
</div>

<?php
$paginationParam = $this->Paginator->params();
$page = $paginationParam['page'];
$urlArray = array_merge(array('controller' => 'products', 'action' => 'index', $separator));
$this->Paginator->_ajaxHelperClass = "Ajax";
$this->Paginator->Ajax = $this->Ajax;
$this->Paginator->options(array('update' => 'listID', 'url' => $urlArray, 'indicator' => 'loaderID'));
?>
<div class="clear"></div>
<div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
<div class="clear"></div>
<div class="show_pagination_ec frnt_pgntt">
    <span class="custom_link pagination"> 
        <?php echo $this->Paginator->first('First', array()); ?>&nbsp;
        <?php if ($this->Paginator->hasPrev('Product')) echo $this->Paginator->prev('Prev', array()); ?>
        <?php echo $this->Paginator->numbers(array('separator' => '  ')); ?>
        <?php
        if ($this->Paginator->hasNext('Product')) {
            echo $this->Paginator->next('Next', array());
        }
        ?>
        <?php echo $this->Paginator->last('Last', array()); ?>                    
    </span>
</div>

<div class="tab_fomate_overlay tab_fomate_overlay_yabs">

    <?php if ($products) { ?>
        <div class="tab_fomate_table">
            <div class="tab_fomate_table_row tab_fomate_table_row_th">     
                <div class="tab_fomate_table_cell"><div class="check_labl_value"><input name="chkRecordId" value="0" onClick="checkAll(this.form)" type='checkbox' class="checkall"/><label for="pro_all"><span><span></span></span></label></div></div>
                <div class="tab_fomate_table_cell">Image</div>
                <div class="tab_fomate_table_cell"><?php echo $this->Paginator->sort('Product.name', 'Product Name'); ?></div>
                <div class="tab_fomate_table_cell"><?php echo $this->Paginator->sort('Product.price', 'Price'); ?></div>
                <div class="tab_fomate_table_cell"><?php echo $this->Paginator->sort('Category.name', 'Category'); ?></div>
                <div class="tab_fomate_table_cell">&nbsp;</div>
                <div class="tab_fomate_table_cell">&nbsp;</div>
                <div class="tab_fomate_table_cell">&nbsp;</div>
            </div>

            <?php foreach ($products as $product) { ?>

                <div class="tab_fomate_table_row">
                    <div class="tab_fomate_table_cell"><div class="check_labl_value"><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $product['Product']['id']; ?>" /><label for="pro_1"><span><span></span></span></label></div></div>
                    <div class="tab_fomate_table_cell"><div class="image_of_product_iae">
                            <?php
                            if (!empty($product['ProductImage'])) {
                                $filePath = UPLOAD_FULL_PRODUCT_IMAGE_PATH . $product['ProductImage'][0]['image'];
                                if (file_exists($filePath) && $product['ProductImage'][0]['image']) {
                                    echo $this->Html->image(DISPLAY_THUMB_PRODUCT_IMAGE_PATH . $product['ProductImage'][0]['image'], array('alt' => 'Img'));
                                } else {
                                    echo $this->Html->image('no_image.gif');
                                }
                            } else {
                                echo $this->Html->image('no_image.gif');
                            }
                            ?>

                        </div></div>
                    <div class="tab_fomate_table_cell"><?php echo $product['Product']['name'] ? $product['Product']['name'] : "N/A"; ?></div>
                    <div class="tab_fomate_table_cell"><?php echo $product['Product']['price'] ? CURRENCY . $product['Product']['price'] : "N/A"; ?></div>
                    <div class="tab_fomate_table_cell"><?php echo $product['Category']['name'] ? $product['Category']['name'] : "N/A"; ?></div>
                    <div class="tab_fomate_table_cell"><div class="invoive_btn_sema">
                        <?php echo $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i> <span>View</span>', 'javascript:void(0)', array('escape' => false)); ?>
                        </div></div>
                    <div class="tab_fomate_table_cell"><div class="invoive_btn_sema">
                            <?php echo $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Edit</span>', array('controller' => 'products', 'action' => 'edit', $product['Product']['slug']), array('escape' => false)); ?>
                        </div></div>
                    <div class="tab_fomate_table_cell"><div class="invoive_btn_sema">
                            <?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller' => 'products', 'action' => 'delete', $product['Product']['slug']), array('update' => 'deleted' . $product['Product']['id'], 'indicator' => 'loaderID', 'class' => 'btn btn-primary btn-xs', 'confirm' => 'Are you sure you want to Delete ?', 'escape' => false, 'title' => 'Delete')); ?>
                        </div></div>
                </div> 
            <?php } ?>
        </div>
        <?php echo $this->Form->text('Product.idList', array('type' => 'hidden', 'value' => '', 'id' => 'idList')); ?>
        <?php echo $this->Form->text('Product.action', array('type' => 'hidden', 'value' => 'activate', 'id' => 'action')); ?>



        <?php
    } else {
        echo "<div class='no-rec-fnd-front'>  No Record Found </div>";
    }
    ?>
</div>
<?php echo $this->Form->end(); ?>

