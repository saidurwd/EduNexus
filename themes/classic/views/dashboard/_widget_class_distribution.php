<?php
/* @var $this DashboardController */
/* @var $data array */
/* @var $institutionId int */
?>
<div class="jarviswidget" id="wid-dashboard-class-distribution-<?php echo $institutionId; ?>" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
    <header>
        <span class="widget-icon"> <i class="fa fa-bar-chart txt-color-green"></i> </span>
        <h2>Class Distribution</h2>
    </header>
    <div class="widget-body">
        <div id="class-distribution-chart-<?php echo $institutionId; ?>" style="height: 300px;"></div>
    </div>
</div>
<?php if (!empty($data['labels'])): ?>
<script type="text/javascript">
$(function () {
    $('#class-distribution-chart-<?php echo $institutionId; ?>').highcharts({
        chart: { type: 'column' },
        title: { text: null },
        xAxis: { categories: <?= CJSON::encode($data['labels']) ?> },
        yAxis: { title: { text: 'Students' } },
        series: [{
            name: 'Students',
            data: <?= CJSON::encode($data['counts']) ?>,
            color: '#418BEF'
        }]
    });
});
</script>
<?php endif; ?>
