<div id="company_ch" style="width: 100%; height: 250px;"></div>
<script>
<?php if($dayCount == 365){ ?>
   $(function () {
    $('#company_ch').highcharts({
        title: { text: ''},
        xAxis: { categories: [<?php echo $catArray;?>] },
        yAxis: {
            title: { text: 'Number of Companies' },
            gridLineWidth: 1,
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        exporting: { enabled: false },
        credits: { enabled: false},
        legend: { enabled: false},
        series: [{
            name: 'Companies',
            data: [<?php echo $finalArray;?>]
        }]
    });
}); 
<?php }else{ ?>
    $(function () {
    $('#company_ch').highcharts({
        title: { text: ''},
        xAxis: { type: 'datetime', dateTimeLabelFormats: { day: '%e %b'}},
        yAxis: {
            title: { text: 'Number of Companies' },
            gridLineWidth: 1,
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        exporting: { enabled: false },
        credits: { enabled: false},
        legend: { enabled: false},
        series: [{
            name: 'Companies',
            data: [<?php echo $finalArray;?>]
        }]
    });
   
});
<?php } ?>
 $("#company_chart_loader").hide();
</script>