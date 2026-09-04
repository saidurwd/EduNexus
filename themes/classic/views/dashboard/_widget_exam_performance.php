<?php
/* @var $this DashboardController */
/* @var $data array */
/* @var $institutionId int */
?>
<div class="jarviswidget" id="wid-dashboard-exam-performance-<?php echo $institutionId; ?>" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
    <header>
        <span class="widget-icon"> <i class="fa fa-trophy txt-color-yellow"></i> </span>
        <h2>Exam Performance</h2>
    </header>
    <div class="widget-body">
        <div id="exam-performance-chart-<?php echo $institutionId; ?>" style="height: 300px;"></div>
    </div>
</div>
<?php if (!empty($data['labels'])): ?>
<script type="text/javascript">
$(function () {
    $('#exam-performance-chart-<?php echo $institutionId; ?>').highcharts({
        chart: { type: 'column' },
        title: { text: null },
        xAxis: { categories: <?= CJSON::encode($data['labels']) ?> },
        yAxis: [
            { title: { text: 'Avg GPA' }, min: 0, max: 5 },
            { title: { text: 'Pass Rate %' }, min: 0, max: 100, opposite: true }
        ],
        series: [{
            name: 'Avg GPA',
            data: <?= CJSON::encode($data['gpa']) ?>,
            color: '#2F7EBB'
        }, {
            name: 'Pass Rate %',
            data: <?= CJSON::encode($data['pass_rate']) ?>,
            color: '#00B19D',
            yAxis: 1
        }]
    });
});
</script>
<?php endif; ?>
