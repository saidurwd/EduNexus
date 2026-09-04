<?php
/* @var $this DashboardController */
/* @var $data array */
/* @var $institutionId int */
?>
<div class="jarviswidget" id="wid-dashboard-fee-collection-<?php echo $institutionId; ?>" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
    <header>
        <span class="widget-icon"> <i class="fa fa-pie-chart txt-color-red"></i> </span>
        <h2>Fee Collection vs Due</h2>
    </header>
    <div class="widget-body">
        <div id="fee-collection-chart-<?php echo $institutionId; ?>" style="height: 300px;"></div>
    </div>
</div>
<?php if (!empty($data['labels'])): ?>
<script type="text/javascript">
$(function () {
    $('#fee-collection-chart-<?php echo $institutionId; ?>').highcharts({
        chart: { type: 'pie' },
        title: { text: null },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' }
            }
        },
        series: [{
            name: 'Amount',
            colorByPoint: true,
            data: [{
                name: 'Collected',
                y: <?= $data['collected'] ?>,
                color: '#2F7EBB'
            }, {
                name: 'Due',
                y: <?= $data['due'] ?>,
                color: '#E0115F'
            }]
        }]
    });
});
</script>
<?php endif; ?>
