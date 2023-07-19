<div id="customer-pie-chart1"></div>


<script lang="javascript" type="text/javascript">
        $(document).ready(function () {
            $('#jqChart2').jqChart({
                title: { text: ' Showing this month (<?php echo date('F').' 1'  ?>  to  <?php echo date('F').' '.date('d') ?>)' },
                tooltips: { type: 'shared' },
                animation: { duration: 1 },
                series: [
                    {
                        type: 'line',
                        title: 'Clients',
                        
                        strokeStyle: '#FF6527',
                        lineWidth: 2,
                        data: [[<?php echo implode('],[', $user_datas); ?>]]
                    },
                    {
                        type: 'line',
                             

                        title: 'Hairstylists',
                        strokeStyle: '#57A8F2',
                        lineWidth: 2,
                        data: [[<?php echo implode('],[', $hair_datas); ?>]]
                    }
                ]
            });
        });
    </script>