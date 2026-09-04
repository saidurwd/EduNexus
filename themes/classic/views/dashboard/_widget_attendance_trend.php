<?php
/* @var $this DashboardController */
/* @var $data array */
/* @var $institutionId int */
?>
<div class="jarviswidget" id="wid-dashboard-attendance-trend-<?php echo $institutionId; ?>" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
    <header>
        <span class="widget-icon"> <i class="fa fa-line-chart txt-color-blue"></i> </span>
        <h2>Attendance Trend (Last 7 Days)</h2>
    </header>
    <div class="widget-body">
        <div id="attendance-trend-chart-<?php echo $institutionId; ?>" style="height: 300px;"></div>
    </div>
</div>
<?php if (!empty($data['labels'])): ?>
<script type="text/javascript">
$(function () {
    $('#attendance-trend-chart-<?php echo $institutionId; ?>').highcharts({
        chart: { type: 'area' },
        title: { text: null },
        xAxis: { categories: <?= CJSON::encode($data['labels']) ?> },
        yAxis: { title: { text: 'Students' } },
        plotOptions: { area: { stacking: 'normal', lineColor: '#666', lineWidth: 1 } },
        series: [{
            name: 'Present',
            data: <?= CJSON::encode($data['present']) ?>,
            color: '#2F7EBB'
        }, {
            name: 'Absent',
            data: <?= CJSON::encode($data['absent']) ?>,
            color: '#E0115F'
        }]
    });
});
</script>
<?php endif; ?>
