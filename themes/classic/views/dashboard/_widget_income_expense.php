<?php
/* @var $this DashboardController */
/* @var $data array */
/* @var $institutionId int */
?>
<div class="jarviswidget" id="wid-dashboard-income-expense-<?php echo $institutionId; ?>" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
    <header>
        <span class="widget-icon"> <i class="fa fa-line-chart txt-color-green"></i> </span>
        <h2>Income vs Expense (Last 6 Months)</h2>
    </header>
    <div class="widget-body">
        <div id="income-expense-chart-<?php echo $institutionId; ?>" style="height: 300px;"></div>
    </div>
</div>
<?php if (!empty($data['labels'])): ?>
<script type="text/javascript">
$(function () {
    $('#income-expense-chart-<?php echo $institutionId; ?>').highcharts({
        chart: { type: 'column' },
        title: { text: null },
        xAxis: { categories: <?= CJSON::encode($data['labels']) ?> },
        yAxis: { title: { text: 'Amount ($)' } },
        plotOptions: { column: { stacking: 'normal' } },
        series: [{
            name: 'Income',
            data: <?= CJSON::encode($data['income']) ?>,
            color: '#2F7EBB'
        }, {
            name: 'Expense',
            data: <?= CJSON::encode($data['expense']) ?>,
            color: '#E0115F'
        }]
    });
});
</script>
<?php endif; ?>
