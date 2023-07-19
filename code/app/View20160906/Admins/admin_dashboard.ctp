<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <!--<ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i> Dashboard</li>
        </ol>-->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $countCompanies ?></h3>

                        <p>Total Companies</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-building-o"></i>
                    </div>
                    <a href="<?php echo HTTP_PATH ?>/admin/users/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $countIndustries ?></h3>

                        <p>Total Industries</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-industry"></i>
                    </div>
                    <a href="<?php echo HTTP_PATH ?>/admin/industries/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <?php /* ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>44</h3>
                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <?php */ ?>
             

            <div class="col-lg-12 col-xs-12">
                <h4 class="admin_st">Companies Statics</h2>
                <div class="relative_box_esjad">
                    <div class="company_tab">
                        <span class="cpc" id="cchart0" onclick="updateChart(0)">Today</span>
                        <span class="cpc" id="cchart1"  onclick="updateChart(1)">Yesterday</span>
                        <span class="cpc active" id="cchart2"  onclick="updateChart(2)">Last 30 days</span>
                        <span  class="cpc" id="cchart3" onclick="updateChart(3)">Last 12 months</span>
                    </div>
                    <div class="chart_loader" id="company_chart_loader"><?php echo $this->Html->image('website_load.svg');?></div>
                    <div class="admin_chart" id="company_chart"><?php //echo $this->element('admin/chart/company_chart');?></div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {
        updateChart(2);
    });
    
    function updateChart(daycnt){
        $('.cpc').removeClass('active');
        $('#cchart'+daycnt).addClass('active');
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>/admin/admins/companyChart/'+daycnt,
            beforeSend: function() {  $("#company_chart_loader").show();},
            success: function(result) {
                $("#company_chart").html(result);
            }

        });
    }

</script>