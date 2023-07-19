<?php if ($categories) { ?>
    <?php echo $this->Form->create("Category", array("action" => "index", "method" => "Post")); ?>
    <div class="panel-body">
        <div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
        <div id="loaderID" style="display:none;width: 90%;position:absolute;text-align: center;margin-top:120px"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
        <?php
        $paginationParam = $this->Paginator->params(); $page = $paginationParam['page'];
        $urlArray = array_merge(array('controller' => 'categories', 'action' => 'index',$separator));
        $this->Paginator->_ajaxHelperClass = "Ajax";
        $this->Paginator->Ajax = $this->Ajax;
        $this->Paginator->options(array('update' => 'listID', 'url' => $urlArray, 'indicator' => 'loaderID'));
        ?>
        <section id="no-more-tables" class="lstng-section">
            <div class="topn">
                <div class="topn_left">Categories List</div>
                <div class="topn_right" id="pagingLinks" align="right">
                    <div class="countrdm"><?php echo $this->Paginator->counter('No. of Records <span class="badge-gray">{:start}</span> - <span class="badge-gray">{:end}</span> of <span class="badge-gray">{:count}</span>'); ?></div>
                    <span class="custom_link pagination"> 
                        <?php echo $this->Paginator->first('First', array()); ?>&nbsp;
                        <?php if ($this->Paginator->hasPrev('Category')) echo $this->Paginator->prev('Prev', array()); ?>&nbsp;
                        <?php echo $this->Paginator->numbers(array('separator' => '  ')); ?>&nbsp;
                        <?php if ($this->Paginator->hasNext('Category')) echo $this->Paginator->next('Next', array()); ?>&nbsp;
                        <?php echo $this->Paginator->last('Last', array()); ?>&nbsp;                    
                    </span>
                </div>
            </div>   
            
            <div class="tbl-resp-listing">
            <table class="table table-bordered table-striped table-condensed cf">
                <thead class="cf ajshort">
                    <tr>
                        <th style="width:5%"><input name="chkRecordId" value="0" onClick="checkAll(this.form)" type='checkbox' class="checkall" /></th>
                        <th class="sorting_paging"><?php echo $this->Paginator->sort('Category.name', 'Category Name'); ?></th>
                        <th class="sorting_paging crtdicon"><i class="fa fa-calendar"></i>   <?php echo $this->Paginator->sort('Category.created', ' Created'); ?></th>
                        <th class="action_dvv"><i class="fa fa-gavel"></i> Action</th>
                    </tr>
                </thead>
                
               <tbody>
                    <?php
                    $i = 1;
                    foreach ($categories as $category) {
                        if ($i % 2 == 0) {
                            $class = 'colr1';
                        } else {
                            $class = '';
                        }
                        ?>
                        <tr>
                            <td data-title="Select">
                                <input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $category['Category']['id']; ?>" />
                            </td>
                            <td data-title="Name"><?php echo $category['Category']['name']; ?></td>
                            <td data-title="Created"><?php echo date('F d,Y', strtotime($category['Category']['created'])); ?></td>
                            <td data-title="Action">
                                <div id="loaderIDAct<?php echo $category['Category']['id']; ?>" style="display:none;position:absolute;margin:0px 0 0 4px;z-index: 9999;"><?php echo $this->Html->image("loading.gif"); ?></div>
                                <span id="status<?php echo $category['Category']['id']; ?>">
                                    <?php
                                    if ($category['Category']['status'] == '1') {
                                        echo $this->Ajax->link('<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>', array('controller' => 'categories', 'action' => 'deactivateCategory', $category['Category']['slug']), array('update' => 'status' . $category['Category']['id'], 'indicator' => 'loaderIDAct' . $category['Category']['id'], 'confirm' => 'Are you sure you want to Deactivate ?', 'escape' => false, 'title' => 'Deactivate'));
                                    } else {
                                        echo $this->Ajax->link('<button class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button>', array('controller' => 'categories', 'action' => 'activateCategory', $category['Category']['slug']), array('update' => 'status' . $category['Category']['id'], 'indicator' => 'loaderIDAct' . $category['Category']['id'], 'confirm' => 'Are you sure you want to Activate ?', 'escape' => false, 'title' => 'Activate'));
                                    }
                                    ?>
                                </span>     
                                <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array("controller" => "categories", "action" => 'edit', $category['Category']['slug'], 'page'=>$page), array('escape' => false, 'class' => "btn btn-warning btn-xs", 'title' => 'Edit')); ?>
                                <?php echo $this->Html->link('<i class="fa fa-trash-o "></i>', array('controller' => 'categories', 'action' => 'delete', $category['Category']['slug'], 'page'=>$page), array('update' => 'deleted' . $category['Category']['id'], 'indicator' => 'loaderID', 'class' => 'btn btn-primary btn-xs', 'confirm' => 'Are you sure you want to Delete ?', 'escape' => false, 'title' => 'Delete')); ?>
                                <?php echo $this->Html->link('<i class="fa fa-sitemap"></i>', array("controller" => "categories", "action" => 'subcategory', $category['Category']['slug']), array('escape' => false, 'class' => "btn btn-warning btn-xs", 'title' => 'Manage Sub Categories')); ?>
                               
                            </td>	
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </section>

        <div class="search_frm">
           <div id="actdiv" class="outside">
                <div class="block-footer mogi">
                    <?php echo $this->Form->text('Category.idList', array('type' => 'hidden', 'value' => '', 'id' => 'idList')); ?>
                    <?php echo $this->Form->text('Category.action', array('type' => 'hidden', 'value' => 'activate', 'id' => 'action')); ?>
                    <?php echo $this->Ajax->submit("Activate", array('div' => false, 'url' => array('controller' => 'categories', 'action' => 'index','page'=>$page), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('activate');", 'confirm' => "Are you sure you want to Activate ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('activated');", 'class' => 'btn btn-success btn-cons')); ?> 
                    <?php echo $this->Ajax->submit("Deactivate", array('div' => false, 'url' => array('controller' => 'categories', 'action' => 'index', 'page'=>$page), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('deactivate');", 'confirm' => "Are you sure you want to Deactivate ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('deactivated');", 'class' => 'btn btn-success btn-cons')); ?> 
                    <?php echo $this->Ajax->submit("Delete", array('div' => false, 'url' => array('controller' => 'categories', 'action' => 'index', 'page'=>$page), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('delete');", 'confirm' => "Are you sure you want to Delete ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('deleted');", 'class' => 'btn btn-success btn-cons')); ?> 
                </div>
            </div>
            <?php
                if (isset($keyword) && $keyword != '') {
                    echo $this->Form->hidden('Category.keyword', array('type' => 'hidden', 'value' => $keyword));
                }
             ?>
        </div>
        <div class="dataTables_paginate paging_simple_numbers ad_page">
            
        </div>

    </div>
    <?php echo $this->Form->end(); ?>
<?php } else { ?>
<div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
    <div class="admin_no_record">No record found.</div>
<?php
}?>