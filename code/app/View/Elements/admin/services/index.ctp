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


<?php if ($services) { ?>
    <?php echo $this->Form->create("Service", array("action" => "index", "method" => "Post")); ?>
    <div class="panel-body">
        <div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
        <div id="loaderID" style="display:none;width: 90%;position:absolute;text-align: center;margin-top:120px"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
        <?php
        $paginationParam = $this->Paginator->params();
        $page = $paginationParam['page'];
        $urlArray = array_merge(array('controller' => 'services', 'action' => 'index', $separator));
        $this->Paginator->_ajaxHelperClass = "Ajax";
        $this->Paginator->Ajax = $this->Ajax;
        $this->Paginator->options(array('update' => 'listID', 'url' => $urlArray, 'indicator' => 'loaderID'));
        ?>
        <section id="no-more-tables" class="lstng-section">
            <div class="topn">
                <div class="topn_left">Services List</div>
                <div class="topn_right" id="pagingLinks" align="right">
                    <div class="countrdm"><?php echo $this->Paginator->counter('No. of Records <span class="badge-gray">{:start}</span> - <span class="badge-gray">{:end}</span> of <span class="badge-gray">{:count}</span>'); ?></div>
                    <span class="custom_link pagination"> 
                        <?php echo $this->Paginator->first('First', array()); ?>&nbsp;
                        <?php if ($this->Paginator->hasPrev('Service')) {
                            echo $this->Paginator->prev('Prev', array());
                        } ?>&nbsp;
    <?php echo $this->Paginator->numbers(array('separator' => '  ')); ?>&nbsp;
    <?php if ($this->Paginator->hasNext('Service')) {
        echo $this->Paginator->next('Next', array());
    } ?>&nbsp;
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
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('Service.name', 'Service Name'); ?></th>
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('Service.price', 'Price'); ?></th>
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('Service.delivery_cost', 'Delivery Cost'); ?></th>
                            <th class="sorting_paging crtdicon"><i class="fa fa-calendar"></i> <?php echo $this->Paginator->sort('Service.created', 'Created'); ?></th>
                            <th class="action_dvv"><i class=" fa fa-gavel"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                                <?php foreach ($services as $service) { ?>
                                    <?php //pr($user); exit;?> 
                            <tr>
                                <td data-title=""><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $service['Service']['id']; ?>" /></td>
                                <td data-title="Company Name">
                                    <?php
                                    if ($service['User']['company_name']) {
                                        echo $service['User']['company_name'];
                                    } else {
                                        echo "N/A";
                                    }
                                    ?>
                                </td>
                                <td data-title="Service Name">
                                    <?php
                                    if ($service['Service']['name']) {
                                        echo $service['Service']['name'];
                                    } else {
                                        echo "N/A";
                                    }
                                    ?>
                                </td>
                                <td data-title="Product Price"><?php echo CURRENCY . $service['Service']['price']; ?></td>
                                <td data-title="Delivery Cost"><?php echo $service['Service']['delivery_cost'] ? CURRENCY . $service['Service']['delivery_cost'] : "N/A"; ?></td>
                                <td data-title="Created"><?php echo date('F d, Y', strtotime($service['Service']['created'])); ?></td>
                                <td data-title="Action">
                                    <div id="loaderIDAct<?php echo $service['Service']['id']; ?>" style="display:none;position:absolute;margin:0px 0 0 4px;z-index: 9999;"><?php echo $this->Html->image("loading.gif"); ?></div>
                                    <span id="status<?php echo $service['Service']['id']; ?>">
                                        <?php
                                        if ($service['Service']['status'] == '1') {
                                            echo $this->Ajax->link('<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>', array('controller' => 'services', 'action' => 'deactivateService', $service['Service']['slug']), array('update' => 'status' . $service['Service']['id'], 'indicator' => 'loaderIDAct' . $service['Service']['id'], 'confirm' => 'Are you sure you want to Deactivate ?', 'escape' => false, 'title' => 'Deactivate'));
                                        } else {
                                            echo $this->Ajax->link('<button class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button>', array('controller' => 'services', 'action' => 'activateService', $service['Service']['slug']), array('update' => 'status' . $service['Service']['id'], 'indicator' => 'loaderIDAct' . $service['Service']['id'], 'confirm' => 'Are you sure you want to Activate ?', 'escape' => false, 'title' => 'Activate'));
                                        }
                                        ?>
                                    </span>

                            <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array("controller" => "services", "action" => 'edit', $service['Service']['slug']), array('escape' => false, 'class' => "btn btn-warning btn-xs", 'title' => 'Edit')); ?>
                            <?php echo $this->Html->link('<i class="fa fa-trash-o "></i>', array('controller' => 'services', 'action' => 'delete', $service['Service']['slug']), array('update' => 'deleted' . $service['Service']['id'], 'indicator' => 'loaderID', 'class' => 'btn btn-primary btn-xs', 'confirm' => 'Are you sure you want to Delete ?', 'escape' => false, 'title' => 'Delete')); ?>
                                    <a href="#info<?php echo $service['Service']['id']; ?>" rel="facebox" title="View" class="btn btn-info btn-xs"><i class="fa fa-eye "></i></a>

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
    <?php echo $this->Form->text('Service.idList', array('type' => 'hidden', 'value' => '', 'id' => 'idList')); ?>
            <?php echo $this->Form->text('Service.action', array('type' => 'hidden', 'value' => 'activate', 'id' => 'action')); ?>
            <?php echo $this->Ajax->submit("Activate", array('div' => false, 'url' => array('controller' => 'services', 'action' => 'index'), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('activate');", 'confirm' => "Are you sure you want to Activate ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('activated');", 'class' => 'btn btn-success btn-cons')); ?> 
            <?php echo $this->Ajax->submit("Deactivate", array('div' => false, 'url' => array('controller' => 'services', 'action' => 'index'), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('deactivate');", 'confirm' => "Are you sure you want to Deactivate ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('deactivated');", 'class' => 'btn btn-success btn-cons')); ?> 
            <?php echo $this->Ajax->submit("Delete", array('div' => false, 'url' => array('controller' => 'services', 'action' => 'index'), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('delete');", 'confirm' => "Are you sure you want to Delete ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('deleted');", 'class' => 'btn btn-success btn-cons')); ?> 
                </div>
            </div>
            <?php
            if (isset($keyword) && $keyword != '') {
                echo $this->Form->hidden('Service.keyword', array('type' => 'hidden', 'value' => $keyword));
            }
            if (isset($searchByDateFrom) && $searchByDateFrom != '') {
                echo $this->Form->hidden('Service.searchByDateFrom', array('type' => 'hidden', 'value' => $searchByDateFrom));
            }
            if (isset($searchByDateTo) && $searchByDateTo != '') {
                echo $this->Form->hidden('Service.searchByDateTo', array('type' => 'hidden', 'value' => $searchByDateTo));
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



<?php foreach ($services as $service) { ?>
    <?php //pr($user);  ?>

    <div id="info<?php echo $service['Service']['id']; ?>"
         style="display: none;">

        <!-- Fieldset -->
        <div class="nzwh-wrapper">
            <fieldset class="nzwh">
                <legend class="nzwh">
    <?php echo $service['Service']['name']; ?>
                </legend>
                <div class="drt">
                    <span style="width:100%;float:left;height:30px;">&nbsp;</span>
                    <span>Company Name : </span>   <?php echo $service['User']['company_name']; ?><br/>
                    <span>Chairman Name : </span>   <?php echo $service['User']['chairman']; ?><br/>
                    <span>Email Address : </span>   <?php echo $service['User']['email_address']; ?><br/>
                    <span>Service Name : </span>   <?php echo $service['Service']['name']; ?><br/>
                    <span>Category : </span>   <?php echo $service['Category']['name'] ? $service['Category']['name'] : "N/A"; ?><br/>
                    <span>Sub Category : </span>  <?php echo $service['SubCategory']['name'] ? $service['SubCategory']['name'] : "N/A"; ?><br/>
                    <span>Service Price : </span>   <?php echo CURRENCY . $service['Service']['price']; ?><br/>
                    <span>Delivery Cost : </span>   <?php echo $service['Service']['delivery_cost'] ? CURRENCY . $service['Service']['delivery_cost'] : 'N/A'; ?><br/>
                    <span>Minimum Orders : </span>   <?php
                    if (!empty($service['Service']['minimum_orders'])) {
                        if ($service['Service']['unit_type'] == 0) {
                            echo $service['Service']['minimum_orders'] . " " . 'Piece';
                        } else {
                            echo $service['Service']['minimum_orders']; echo $service['Service']['unit_value'] == ""  ? " Piece" : " " . $service['Service']['unit_value'];
                        }
                    } else {
                        echo "N/A";
                    }
                    ?><br/>
                    <span>Description : </span>   <?php echo $service['Service']['description'] ? $service['Service']['description'] : "N/A"; ?><br/>

                </div>
            </fieldset>
        </div>

    </div>
<?php } ?>