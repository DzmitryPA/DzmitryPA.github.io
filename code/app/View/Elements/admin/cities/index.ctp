<?php if ($cities) { ?>
    <?php echo $this->Form->create("City", array("action" => "index", "method" => "Post")); ?>
    <div class="panel-body">
        <div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
        <div id="loaderID" style="display:none;width: 90%;position:absolute;text-align: center;margin-top:120px"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
        <?php
        $paginationParam = $this->Paginator->params(); $page = $paginationParam['page'];
        $urlArray = array_merge(array('controller' => 'cities', 'action' => 'index', $stateslug, $separator));
        $this->Paginator->_ajaxHelperClass = "Ajax";
        $this->Paginator->Ajax = $this->Ajax;
        $this->Paginator->options(array('update' => 'listID', 'url' => $urlArray, 'indicator' => 'loaderID'));
        ?>
        <section id="no-more-tables" class="lstng-section">
            <div class="topn">
                <div class="topn_left"><?php echo $stateInfo['State']['state_name'] ?> Cities List</div>
                <div class="topn_right" id="pagingLinks" align="right">
                    <div class="countrdm"><?php echo $this->Paginator->counter('No. of Records <span class="badge-gray">{:start}</span> - <span class="badge-gray">{:end}</span> of <span class="badge-gray">{:count}</span>'); ?></div>
                    <span class="custom_link pagination"> 
                        <?php echo $this->Paginator->first('First', array()); ?>&nbsp;
                        <?php if ($this->Paginator->hasPrev('City')) echo $this->Paginator->prev('Prev', array()); ?>&nbsp;
                        <?php echo $this->Paginator->numbers(array('separator' => '  ')); ?>&nbsp;
                        <?php if ($this->Paginator->hasNext('City')) echo $this->Paginator->next('Next', array()); ?>&nbsp;
                        <?php echo $this->Paginator->last('Last', array()); ?>&nbsp;                    
                    </span>
                </div>
            </div>    
            
            <div class="tbl-resp-listing">
            <table class="table table-bordered table-striped table-condensed cf">
                <thead class="cf ajshort">
                    <tr>
                        <th style="width:5%"><input name="chkRecordId" value="0" onClick="checkAll(this.form)" type='checkbox' class="checkall" /></th>
                        <th class="sorting_paging"><?php echo $this->Paginator->sort('City.city_name', 'City'); ?></th>
                        <th class="sorting_paging crtdicon"><i class="fa fa-calendar"></i> <?php echo $this->Paginator->sort('City.created', 'Created'); ?></th>
                        <th class="action_dvv"><i class=" fa fa-gavel"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($cities as $city) {
                        if ($i % 2 == 0) {
                            $class = 'colr1';
                        } else {
                            $class = '';
                        }
                        ?>
                        <tr>
                            <td data-title="Select">
                                <input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $city['City']['id']; ?>" />
                            </td>
                            <td data-title="City"><?php echo $city['City']['city_name']; ?></td>
                            <td data-title="Created"><?php echo date('F d, Y', strtotime($city['City']['created'])); ?></td>
                            <td data-title="Action">
                                <div id="loaderIDAct<?php echo $city['City']['id']; ?>" style="display:none;position:absolute;margin:0px 0 0 4px;z-index: 9999;"><?php echo $this->Html->image("loading.gif"); ?></div>
                                <span id="status<?php echo $city['City']['id']; ?>">
                                    <?php
                                    if ($city['City']['status'] == '1') {
                                        echo $this->Ajax->link('<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>', array('controller' => 'cities', 'action' => 'deactivateCity', $city['City']['slug']), array('update' => 'status' . $city['City']['id'], 'indicator' => 'loaderIDAct' . $city['City']['id'], 'confirm' => 'Are you sure you want to Deactivate ?', 'escape' => false, 'title' => 'Deactivate'));
                                    } else {
                                        echo $this->Ajax->link('<button class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button>', array('controller' => 'cities', 'action' => 'activateCity', $city['City']['slug']), array('update' => 'status' . $city['City']['id'], 'indicator' => 'loaderIDAct' . $city['City']['id'], 'confirm' => 'Are you sure you want to Activate ?', 'escape' => false, 'title' => 'Activate'));
                                    }
                                    ?>
                                </span>     
                                <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array("controller" => "cities", "action" => 'edit', $city['City']['slug'], $stateslug, 'page'=>$page), array('escape' => false, 'class' => "btn btn-warning btn-xs", 'title' => 'Edit')); ?>
                                <?php echo $this->Html->link('<i class="fa fa-trash-o "></i>', array('controller' => 'cities', 'action' => 'delete', $city['City']['slug'], $stateslug, 'page'=>$page), array('update' => 'deleted' . $city['City']['id'], 'indicator' => 'loaderID', 'class' => 'btn btn-primary btn-xs', 'confirm' => 'Are you sure you want to Delete ?', 'escape' => false, 'title' => 'Delete')); ?>
                               
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
                    <?php echo $this->Form->text('City.idList', array('type' => 'hidden', 'value' => '', 'id' => 'idList')); ?>
                    <?php echo $this->Form->text('City.action', array('type' => 'hidden', 'value' => 'activate', 'id' => 'action')); ?>
                    <?php echo $this->Ajax->submit("Activate", array('div' => false, 'url' => array('controller' => 'cities', 'action' => 'index', $stateslug, 'page'=>$page), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('activate');", 'confirm' => "Are you sure you want to Activate ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('activated');", 'class' => 'btn btn-success btn-cons')); ?> 
                    <?php echo $this->Ajax->submit("Deactivate", array('div' => false, 'url' => array('controller' => 'cities', 'action' => 'index', $stateslug, 'page'=>$page), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('deactivate');", 'confirm' => "Are you sure you want to Deactivate ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('deactivated');", 'class' => 'btn btn-success btn-cons')); ?> 
                    <?php echo $this->Ajax->submit("Delete", array('div' => false, 'url' => array('controller' => 'cities', 'action' => 'index', $stateslug, 'page'=>$page), 'update' => 'listID', 'indicator' => 'loaderID', 'before' => "setAction('delete');", 'confirm' => "Are you sure you want to Delete ?", 'condition' => "isAnySelect(this.form)", "complete" => "showMessage('deleted');", 'class' => 'btn btn-success btn-cons')); ?> 
                </div>
            </div>
            <?php
                if (isset($keyword) && $keyword != '') {
                    echo $this->Form->hidden('City.keyword', array('type' => 'hidden', 'value' => $keyword));
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