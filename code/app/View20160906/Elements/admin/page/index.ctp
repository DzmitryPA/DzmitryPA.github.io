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
<?php if ($staticpages) { ?>
    <div class="panel-body">
        <div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
        <div id="loaderID" style="display:none;width: 90%;position:absolute;text-align: center;margin-top:120px"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
        <div id='listID'>
            <?php
            $urlArray = array('controller' => 'pages', 'action' => 'index', $separator);
            $this->Paginator->_ajaxHelperClass = "Ajax";
            $this->Paginator->Ajax = $this->Ajax;
            $this->Paginator->options(array('update' => 'listID',
                'url' => $urlArray,
                'indicator' => 'loaderID'));
            ?>
            <?php echo $this->Form->create("Page", array("action" => "index", "method" => "Post")); ?>
            <div class="columns mrgih_tp">
                <div id="listingJS" style="display: none;" ></div>


                <section id="no-more-tables" class="lstng-section">
                    <div class="topn">
                        <div class="topn_left">Pages List</div>
                        <div class="topn_right" id="pagingLinks" align="right">
                            <?php __("Showing Page"); ?>
                            <div class="countrdm"><?php echo $this->Paginator->counter('No of Pages <span class="badge-gray">{:start}</span> - <span class="badge-gray">{:end}</span> of <span class="badge-gray">{:count}</span>'); ?></div>
                            &nbsp;
                            <span class="custom_link pagination"> 
                                <?php echo $this->Paginator->first('First', array()); ?>&nbsp;
                                <?php if ($this->Paginator->hasPrev('Page')) echo $this->Paginator->prev('Prev', array()); ?>&nbsp;
                                <?php echo $this->Paginator->numbers(array('separator' => '  ')); ?>&nbsp;
                                <?php if ($this->Paginator->hasNext('Page')) echo $this->Paginator->next('Next', array()); ?>&nbsp;
                                <?php echo $this->Paginator->last('Last', array()); ?>&nbsp;                    
                            </span>
                        </div>
                    </div>


                    <div class="tbl-resp-listing">
                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf ajshort">
                                <tr>
                                    <th class="sorting_paging"><?php echo $this->Paginator->sort('Page.static_page_title', 'Title'); ?></th>
                                    <th ><i class=" fa fa-gavel"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staticpages as $page) { ?>
                                    <tr>
                                        <td><span class="text-green"><?php echo $this->Html->link($page['Page']['static_page_title'], array('controller' => 'pages', 'action' => 'editPage', $page['Page']['static_page_heading']), array('class' => 'text-green')); ?></span></td>
                                        <td>
                                            <?php echo $this->Html->link('<i class="fa fa-pencil-square"></i>', array('controller' => 'pages', 'action' => 'editPage', $page['Page']['static_page_heading']), array('escape' => false, 'title' => 'Edit', 'class' => 'btn btn-warning btn-xs')); ?>
                                            <?php echo $this->Html->link('<i class="fa fa-info"></i>', '#info' . $page['Page']['id'], array('escape' => false, 'title' => 'View', 'class' => 'btn btn-primary btn-xs', 'rel' => 'facebox')); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <?php echo $this->Form->end(); ?>
            </div>
            <?php
        } else {
            ?>
            <div class="columns mrgih_tp">
                <table class="table table-striped table-advance table-hover table-bordered">
                    <tr>
                        <td><div id="noRcrdExist" class="norecext">There are no Pages to show.</div></td>
                    </tr>
                </table>
            </div>
        <?php }
        ?>
        <?php foreach ($staticpages as $page) { ?>

            <div id="info<?php echo $page['Page']['id']; ?>"
                 style="display: none;">
                <!-- Fieldset -->
                <div class="nzwh-wrapper">
                    <fieldset class="nzwh">
                        <legend class="nzwh">
                            <?php echo $page['Page']['static_page_title']; ?>
                        </legend>
                        <span style="width:100%;float:left;height:30px;">&nbsp;</span>
                        <?php echo $page['Page']['static_page_description']; ?>
                    </fieldset>
                </div>

            </div>
        <?php } ?>

