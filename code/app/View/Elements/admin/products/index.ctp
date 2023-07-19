<style>
    <!--
    .colr1{background-color: LavenderBlush !important;}
    -->
</style>
<?php echo $this->Html->script('facebox.js'); ?>
<?php echo $this->Html->css('facebox.css'); ?>
<script type="text/javascript">
    $(document).ready(function ($) {
        $('.close_image').hide();
        $('a[rel*=facebox]').facebox({
            loadingImage: '<?php echo HTTP_IMAGE ?>/loading.gif',
            closeImage: '<?php echo HTTP_IMAGE ?>/close.png'
        })
    })
</script>
<style>
    /* NZ Web Hosting - www.nzwhost.com 
     * Fieldset Alternative Demo
    */
    .fieldset {
        border: solid 2px #ff0000;
        background: #3ca4ee;
        margin-top: 20px;
        position: relative;
    }

    .legend {
        border: solid 2px #ff0000;
        left: 0.5em;
        top: -0.6em;
        position: absolute;
        background: #A7BB5C;
        font-weight: bold;
        padding: 0 0.25em 0 0.25em;
    }

    .nzwh-wrapper .content {
        margin: 1em 0.5em 0.5em 0.5em;
    }

    legend.nzwh {
        background: none repeat scroll 0 0 #fff !important;
        border: 1px solid #a7a7a7 !important;
        border-radius: 5px !important;
        color: #a0a0a0;
        font-weight: normal;
        left: 0.5em;
        padding: 5px;
        position: absolute;
        top: -0.99em;
        width: auto !important;
    }

    fieldset.nzwh {
        background: none repeat scroll 0 0 #eee;
        border: 1px solid #a7a7a7;
        margin-top: 10px;
        padding: 0 10px;
        position: relative;
    }
</style>


<?php if ($products) { ?>
<?php echo $this->Form->create("Product", array("action" => "index", "method" => "Post")); ?>
    <div class="panel-body">
        <div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
        <div id="loaderID" style="display:none;width: 90%;position:absolute;text-align: center;margin-top:120px"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
        <?php
        $paginationParam = $this->Paginator->params(); $page = $paginationParam['page'];
        $urlArray = array_merge(array('controller' => 'products', 'action' => 'index',$separator));
        $this->Paginator->_ajaxHelperClass = "Ajax";
        $this->Paginator->Ajax = $this->Ajax;
        $this->Paginator->options(array('update' => 'listID', 'url' => $urlArray, 'indicator' => 'loaderID'));
        ?>
        <section id="no-more-tables" class="lstng-section">
            <div class="topn">
                <div class="topn_left">Products List</div>
                <div class="topn_right" id="pagingLinks" align="right">
                    <div class="countrdm"><?php echo $this->Paginator->counter('No. of Records <span class="badge-gray">{:start}</span> - <span class="badge-gray">{:end}</span> of <span class="badge-gray">{:count}</span>'); ?></div>
                    <span class="custom_link pagination"> 
                        <?php echo $this->Paginator->first('First', array()); ?>&nbsp;
                        <?php if ($this->Paginator->hasPrev('Product')) { echo $this->Paginator->prev('Prev', array()); } ?>&nbsp;
                        <?php echo $this->Paginator->numbers(array('separator' => '  ')); ?>&nbsp;
                        <?php if ($this->Paginator->hasNext('Product')) { echo $this->Paginator->next('Next', array()); } ?>&nbsp;
                        <?php echo $this->Paginator->last('Last', array()); ?>&nbsp;                    
                    </span>
                </div>
            </div>   
            
            <div class="tbl-resp-listing">
                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf ajshort">
                                <tr>
                                    <th style="width:5%"><input name="chkRecordId" value="0" onClick="checkAll(this.form)" type='checkbox' class="checkall" /></th>
                                    <th class="sorting_paging"><?php echo $this->Paginator->sort('User.company_name', 'Company Name'); ?></th>
                                    <th class="sorting_paging"><?php echo $this->Paginator->sort('Product.name', 'Product Name'); ?></th>
                                    <th class="sorting_paging"><?php echo $this->Paginator->sort('Product.price', 'Price'); ?></th>
                                    <th class="sorting_paging"><?php echo $this->Paginator->sort('Product.delivery_cost', 'Delivery Cost'); ?></th>
                                    <th class="sorting_paging crtdicon"><i class="fa fa-calendar"></i> <?php echo $this->Paginator->sort('Product.created', 'Created'); ?></th>
                                    <th class="action_dvv"><i class=" fa fa-gavel"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product) { ?>
                                <?php //pr($user); exit;?> 
                                    <tr>
                                        <td data-title=""><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $product['Product']['id']; ?>" /></td>
                                        <td data-title="Company Name">
                                            <?php
                                            if($product['User']['company_name']){
                                               echo $product['User']['company_name'];                                            
                                            }else{
                                                echo "N/A" ;
                                            } 
                                            ?>
                                        </td>
                                        <td data-title="Product Name">
                                            <?php
                                            if($product['Product']['name']){
                                               echo $product['Product']['name'];                                            
                                            }else{
                                                echo "N/A" ;
                                            } 
                                            ?>
                                        </td>
                                        <td data-title="Product Price"><?php echo CURRENCY . $product['Product']['price']; ?></td>
                                        <td data-title="Delivery Price"><?php echo $product['Product']['delivery_cost'] ? CURRENCY . $product['Product']['delivery_cost'] : 'N/A'; ?></td>
                                        <td data-title="Created"><?php echo date('F d, Y', strtotime($product['Product']['created'])); ?></td>
                                        <td data-title="Action">
                                            <div id="loaderIDAct<?php echo $product['Product']['id']; ?>" style="display:none;position:absolute;margin:0px 0 0 4px;z-index: 9999;"><?php echo $this->Html->image("loading.gif"); ?></div>
                                            <span id="status<?php echo $product['Product']['id']; ?>">
                                                <?php
                                                if ($product['Product']['status'] == '1') {
                                                    echo $this->Ajax->link('<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>', array('controller' => 'products', 'action' => 'deactivateProduct', $product['Product']['slug']), array('update' => 'status' . $product['Product']['id'], 'indicator' => 'loaderIDAct' . $product['Product']['id'], 'confirm' => 'Are you sure you want to Deactivate ?', 'escape' => false, 'title' => 'Deactivate'));
                                                } else {
                                                    echo $this->Ajax->link('<button class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button>', array('controller' => 'products', 'action' => 'activateProduct', $product['Product']['slug']), array('update' => 'status' . $product['Product']['id'], 'indicator' => 'loaderIDAct' . $product['Product']['id'], 'confirm' => 'Are you sure you want to Activate ?', 'escape' => false, 'title' => 'Activate'));
                                                }
                                                ?>
                                            </span>

                                            <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array("controller" => "products", "action" => 'edit', $product['Product']['slug']), array('escape' => false, 'class' => "btn btn-warning btn-xs", 'title' => 'Edit')); ?>
                                            <?php echo $this->Html->link('<i class="fa fa-trash-o "></i>', array('controller' => 'products', 'action' => 'delete', $product['Product']['slug']), array('update' => 'deleted' . $product['Product']['id'], 'indicator' => 'loaderID', 'class' => 'btn btn-primary btn-xs', 'confirm' => 'Are you sure you want to Delete ?', 'escape' => false, 'title' => 'Delete')); ?>
                                            <a href="#info<?php echo $product['Product']['id']; ?>" rel="facebox" title="View" class="btn btn-info btn-xs"><i class="fa fa-eye "></i></a>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
        </section>
        
          <div class="search_frm">
            <div id="actdiv" class="outside">
                <div class="block-footer mogi">
                    <?php echo $this->Form->text('Product.idList', array('type' => 'hidden', 'value' => '', 'id' => 'idList')); ?>
                    <?php echo $this->Form->text('Product.action', array('type' => 'hidden', 'value' => 'activate', 'id' => 'action')); ?>
                    <?php echo $this->Ajax->submit("Activate", array('div' => false, 'url' => array('controller' => 'products', 'action' => 'index'), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('activate');", 'confirm' => "Are you sure you want to Activate ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('activated');", 'class' => 'btn btn-success btn-cons')); ?> 
                    <?php echo $this->Ajax->submit("Deactivate", array('div' => false, 'url' => array('controller' => 'products', 'action' => 'index'), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('deactivate');", 'confirm' => "Are you sure you want to Deactivate ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('deactivated');", 'class' => 'btn btn-success btn-cons')); ?> 
                    <?php echo $this->Ajax->submit("Delete", array('div' => false, 'url' => array('controller' => 'products', 'action' => 'index'), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('delete');", 'confirm' => "Are you sure you want to Delete ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('deleted');", 'class' => 'btn btn-success btn-cons')); ?> 
                </div>
            </div>
            <?php
            if (isset($keyword) && $keyword != '') {
                echo $this->Form->hidden('Product.keyword', array('type' => 'hidden', 'value' => $keyword));
            }
            if (isset($searchByDateFrom) && $searchByDateFrom != '') {
                echo $this->Form->hidden('Product.searchByDateFrom', array('type' => 'hidden', 'value' => $searchByDateFrom));
            }
            if (isset($searchByDateTo) && $searchByDateTo != '') {
                echo $this->Form->hidden('Product.searchByDateTo', array('type' => 'hidden', 'value' => $searchByDateTo));
            }
            
            ?>
         </div>
        <div class="dataTables_paginate paging_simple_numbers ad_page">
            
        </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
<?php } else { ?>
    <div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
    <div class="admin_no_record">No record found.</div>
<?php }
?>



<?php foreach ($products as $product) { ?>
<?php //pr($user); ?>

<div id="info<?php echo $product['Product']['id']; ?>"
         style="display: none;">
        
        <!-- Fieldset -->
        <div class="nzwh-wrapper">
            <fieldset class="nzwh">
                <legend class="nzwh">
                    <?php echo $product['Product']['name']; ?>
                </legend>
                <div class="drt">
                    <span style="width:100%;float:left;height:30px;">&nbsp;</span>
                    <span>Company Name : </span>   <?php echo $product['User']['company_name']; ?><br/>
                    <span>Chairman Name : </span>   <?php echo $product['User']['chairman']; ?><br/>
                    <span>Email Address : </span>   <?php echo $product['User']['email_address']; ?><br/>
                    <span>Product Name : </span>   <?php echo $product['Product']['name']; ?><br/>
                    <span>Category : </span>   <?php echo $product['Category']['name'] ? $product['Category']['name'] : "N/A"; ?><br/>
                    <span>Sub Category : </span>  <?php echo $product['SubCategory']['name'] ? $product['SubCategory']['name'] : "N/A"; ?><br/>
                    <span>Product Price : </span>   <?php echo CURRENCY . $product['Product']['price']; ?><br/>
                    <span>Delivery Cost : </span>   <?php echo $product['Product']['delivery_cost'] ? CURRENCY . $product['Product']['delivery_cost'] : "N/A"; ?><br/>
                    <span>Minimum Orders : </span>   <?php
                    if (!empty($product['Product']['minimum_orders'])) {
                        if ($product['Product']['unit_type'] == 0) {
                            echo $product['Product']['minimum_orders'] . " " . 'Piece';
                        } else {
                            echo $product['Product']['minimum_orders']; echo $product['Product']['unit_value'] == "" ? ' Piece' : ' ' . $product['Product']['unit_value'] ;
                        }
                    } else {
                        echo "N/A";
                    }
                    ?><br/>
                    <span>Description : </span>   <?php echo $product['Product']['description'] ? $product['Product']['description'] : "N/A"; ?><br/>
                </div>
            </fieldset>
        </div>

    </div>
<?php } ?>