<?php
/* @var $this DashboardController */
$this->pageTitle = 'Dashboard - ' . Yii::app()->name;
$this->breadcrumbs = array(
    'Dashboard',
);
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            Dashboard
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <div class="pull-right">
            <?php if (!empty($academicYears)): ?>
            <div class="form-group" style="display: inline-block; margin-right: 10px;">
                <select id="dashboard-academic-year" class="select2" style="min-width: 200px;">
                    <?php foreach ($academicYears as $year): ?>
                    <option value="<?php echo $year->id; ?>" <?php echo ($academicYear == $year->id) ? 'selected' : ''; ?>>
                        <?php echo CHtml::encode($year->title . ' (' . $year->year . ')'); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="form-group" style="display: inline-block; margin-right: 10px;">
                <input type="text" id="dashboard-date-range" class="form-control" placeholder="Select Date Range" style="width: 240px;">
            </div>
            <button type="button" id="dashboard-refresh" class="btn btn-default" title="Refresh Dashboard">
                <i class="fa fa-refresh"></i>
            </button>
            <button type="button" id="dashboard-auto-refresh" class="btn btn-default" title="Auto Refresh (Off)">
                <i class="fa fa-clock-o"></i>
            </button>
            <a href="<?php echo Yii::app()->createUrl('dashboard/exportPdf'); ?>" target="_blank" class="btn btn-default" title="Print Dashboard">
                <i class="fa fa-print"></i>
            </a>
        </div>
    </div>
</div>

<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- row -->
    <div class="row">
        <!-- Students Widget -->
        <article class="col-xs-12 col-sm-6 col-md-3">
            <div class="jarviswidget" id="wid-students" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-users txt-color-blue"></i> </span>
                    <h2>Total Students</h2>
                </header>
                <div class="widget-body">
                    <div class="big-stat">
                        <span class="value"><?php echo number_format($data['students']); ?></span>
                    </div>
                </div>
            </div>
        </article>

        <!-- Teachers Widget -->
        <article class="col-xs-12 col-sm-6 col-md-3">
            <div class="jarviswidget" id="wid-teachers" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-user txt-color-green"></i> </span>
                    <h2>Total Teachers</h2>
                </header>
                <div class="widget-body">
                    <div class="big-stat">
                        <span class="value"><?php echo number_format($data['teachers']); ?></span>
                    </div>
                </div>
            </div>
        </article>

        <!-- Attendance Rate Widget -->
        <article class="col-xs-12 col-sm-6 col-md-3">
            <div class="jarviswidget" id="wid-attendance" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-calendar txt-color-orange"></i> </span>
                    <h2>Today's Attendance</h2>
                </header>
                <div class="widget-body">
                    <div class="big-stat">
                        <span class="value"><?php echo number_format($data['attendance_rate'], 1); ?>%</span>
                    </div>
                </div>
            </div>
        </article>

        <!-- Monthly Income Widget -->
        <article class="col-xs-12 col-sm-6 col-md-3">
            <div class="jarviswidget" id="wid-income" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-money txt-color-purple"></i> </span>
                    <h2>Monthly Income</h2>
                </header>
                <div class="widget-body">
                    <div class="big-stat">
                        <span class="value">$<?php echo number_format($data['monthly_income'], 2); ?></span>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <!-- end row -->

    <!-- Attendance Trend Row -->
    <div class="row">
        <article class="col-xs-12 col-md-8">
            <div class="jarviswidget" id="wid-attendance-trend" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-line-chart txt-color-blue"></i> </span>
                    <h2>Attendance Trend (Last 7 Days)</h2>
                </header>
                <div class="widget-body">
                    <div id="attendance-trend-chart" style="height: 300px;"></div>
                </div>
            </div>
        </article>

        <!-- Class Distribution -->
        <article class="col-xs-12 col-md-4">
            <div class="jarviswidget" id="wid-class-distribution" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-bar-chart txt-color-green"></i> </span>
                    <h2>Class Distribution</h2>
                </header>
                <div class="widget-body">
                    <div id="class-distribution-chart" style="height: 300px;"></div>
                </div>
            </div>
        </article>
    </div>
    <!-- end row -->

    <!-- Exam Performance Row -->
    <div class="row">
        <article class="col-xs-12 col-md-6">
            <div class="jarviswidget" id="wid-exam-performance" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-trophy txt-color-yellow"></i> </span>
                    <h2>Exam Performance</h2>
                </header>
                <div class="widget-body">
                    <div id="exam-performance-chart" style="height: 300px;"></div>
                </div>
            </div>
        </article>

        <!-- Fee Collection -->
        <article class="col-xs-12 col-md-6">
            <div class="jarviswidget" id="wid-fee-collection" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-pie-chart txt-color-red"></i> </span>
                    <h2>Fee Collection vs Due</h2>
                </header>
                <div class="widget-body">
                    <div id="fee-collection-chart" style="height: 300px;"></div>
                </div>
            </div>
        </article>
    </div>
    <!-- end row -->

    <!-- Income vs Expense Row -->
    <div class="row">
        <article class="col-xs-12 col-md-8">
            <div class="jarviswidget" id="wid-income-expense" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-line-chart txt-color-green"></i> </span>
                    <h2>Income vs Expense (Last 6 Months)</h2>
                </header>
                <div class="widget-body">
                    <div id="income-expense-chart" style="height: 300px;"></div>
                </div>
            </div>
        </article>
    </div>
    <!-- end row -->
</section>
<!-- end widget grid -->

<script type="text/javascript">
pageSetUp();

<?php if (!empty($data['attendance_trend']['labels'])): ?>
$(function () {
    $('#attendance-trend-chart').highcharts({
        chart: { type: 'area' },
        title: { text: null },
        xAxis: { categories: <?= CJSON::encode($data['attendance_trend']['labels']) ?> },
        yAxis: { title: { text: 'Students' } },
        plotOptions: { area: { stacking: 'normal', lineColor: '#666', lineWidth: 1 } },
        series: [{
            name: 'Present',
            data: <?= CJSON::encode($data['attendance_trend']['present']) ?>,
            color: '#2F7EBB'
        }, {
            name: 'Absent',
            data: <?= CJSON::encode($data['attendance_trend']['absent']) ?>,
            color: '#E0115F'
        }]
    });
});
<?php endif; ?>

<?php if (!empty($data['class_distribution']['labels'])): ?>
$(function () {
    $('#class-distribution-chart').highcharts({
        chart: { type: 'column' },
        title: { text: null },
        xAxis: { categories: <?= CJSON::encode($data['class_distribution']['labels']) ?> },
        yAxis: { title: { text: 'Students' } },
        series: [{
            name: 'Students',
            data: <?= CJSON::encode($data['class_distribution']['counts']) ?>,
            color: '#418BEF'
        }]
    });
});
<?php endif; ?>

<?php if (!empty($data['exam_performance']['labels'])): ?>
$(function () {
    $('#exam-performance-chart').highcharts({
        chart: { type: 'column' },
        title: { text: null },
        xAxis: { categories: <?= CJSON::encode($data['exam_performance']['labels']) ?> },
        yAxis: [
            { title: { text: 'Avg GPA' }, min: 0, max: 5 },
            { title: { text: 'Pass Rate %' }, min: 0, max: 100, opposite: true }
        ],
        series: [{
            name: 'Avg GPA',
            data: <?= CJSON::encode($data['exam_performance']['gpa']) ?>,
            color: '#2F7EBB'
        }, {
            name: 'Pass Rate %',
            data: <?= CJSON::encode($data['exam_performance']['pass_rate']) ?>,
            color: '#00B19D',
            yAxis: 1
        }]
    });
});
<?php endif; ?>

<?php if (!empty($data['fee_collection']['labels'])): ?>
$(function () {
    $('#fee-collection-chart').highcharts({
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
                y: <?= $data['fee_collection']['collected'] ?>,
                color: '#2F7EBB'
            }, {
                name: 'Due',
                y: <?= $data['fee_collection']['due'] ?>,
                color: '#E0115F'
            }]
        }]
    });
});
<?php endif; ?>

<?php if (!empty($data['income_expense']['labels'])): ?>
$(function () {
    $('#income-expense-chart').highcharts({
        chart: { type: 'column' },
        title: { text: null },
        xAxis: { categories: <?= CJSON::encode($data['income_expense']['labels']) ?> },
        yAxis: { title: { text: 'Amount ($)' } },
        plotOptions: { column: { stacking: 'normal' } },
        series: [{
            name: 'Income',
            data: <?= CJSON::encode($data['income_expense']['income']) ?>,
            color: '#2F7EBB'
        }, {
            name: 'Expense',
            data: <?= CJSON::encode($data['income_expense']['expense']) ?>,
            color: '#E0115F'
        }]
    });
});
<?php endif; ?>
</script>

<script type="text/javascript">
var dashboardAutoRefresh = false;
var dashboardAutoRefreshInterval = null;
var dashboardUserGroup = <?= (int)Yii::app()->user->group ?>;

function refreshDashboardWidgets() {
    var academicYear = $('#dashboard-academic-year').val();
    
    $.each(['attendance_trend', 'class_distribution', 'exam_performance', 'fee_collection', 'income_expense'], function(index, widget) {
        $.ajax({
            url: '<?php echo Yii::app()->createUrl("dashboard/widgetData"); ?>',
            data: { widget: widget, academic_year: academicYear },
            dataType: 'json',
            success: function(data) {
                updateDashboardWidget(widget, data);
            }
        });
    });
}

function updateDashboardWidget(widget, data) {
    switch(widget) {
        case 'attendance_trend':
            if ($('#attendance-trend-chart').highcharts()) {
                $('#attendance-trend-chart').highcharts().destroy();
            }
            if (!$.isEmptyObject(data) && data.labels) {
                $('#attendance-trend-chart').highcharts({
                    chart: { type: 'area' },
                    title: { text: null },
                    xAxis: { categories: data.labels },
                    yAxis: { title: { text: 'Students' } },
                    plotOptions: { area: { stacking: 'normal', lineColor: '#666', lineWidth: 1 } },
                    series: [{
                        name: 'Present',
                        data: data.present,
                        color: '#2F7EBB'
                    }, {
                        name: 'Absent',
                        data: data.absent,
                        color: '#E0115F'
                    }]
                });
            }
            break;
            
        case 'class_distribution':
            if ($('#class-distribution-chart').highcharts()) {
                $('#class-distribution-chart').highcharts().destroy();
            }
            if (!$.isEmptyObject(data) && data.labels) {
                $('#class-distribution-chart').highcharts({
                    chart: { type: 'column' },
                    title: { text: null },
                    xAxis: { categories: data.labels },
                    yAxis: { title: { text: 'Students' } },
                    series: [{
                        name: 'Students',
                        data: data.counts,
                        color: '#418BEF'
                    }]
                });
            }
            break;
            
        case 'exam_performance':
            if ($('#exam-performance-chart').highcharts()) {
                $('#exam-performance-chart').highcharts().destroy();
            }
            if (!$.isEmptyObject(data) && data.labels) {
                $('#exam-performance-chart').highcharts({
                    chart: { type: 'column' },
                    title: { text: null },
                    xAxis: { categories: data.labels },
                    yAxis: [
                        { title: { text: 'Avg GPA' }, min: 0, max: 5 },
                        { title: { text: 'Pass Rate %' }, min: 0, max: 100, opposite: true }
                    ],
                    series: [{
                        name: 'Avg GPA',
                        data: data.gpa,
                        color: '#2F7EBB'
                    }, {
                        name: 'Pass Rate %',
                        data: data.pass_rate,
                        color: '#00B19D',
                        yAxis: 1
                    }]
                });
            }
            break;
            
        case 'fee_collection':
            if ($('#fee-collection-chart').highcharts()) {
                $('#fee-collection-chart').highcharts().destroy();
            }
            if (!$.isEmptyObject(data) && data.labels) {
                $('#fee-collection-chart').highcharts({
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
                            y: data.collected,
                            color: '#2F7EBB'
                        }, {
                            name: 'Due',
                            y: data.due,
                            color: '#E0115F'
                        }]
                    }]
                });
            }
            break;
            
        case 'income_expense':
            if ($('#income-expense-chart').highcharts()) {
                $('#income-expense-chart').highcharts().destroy();
            }
            if (!$.isEmptyObject(data) && data.labels) {
                $('#income-expense-chart').highcharts({
                    chart: { type: 'column' },
                    title: { text: null },
                    xAxis: { categories: data.labels },
                    yAxis: { title: { text: 'Amount ($)' } },
                    plotOptions: { column: { stacking: 'normal' } },
                    series: [{
                        name: 'Income',
                        data: data.income,
                        color: '#2F7EBB'
                    }, {
                        name: 'Expense',
                        data: data.expense,
                        color: '#E0115F'
                    }]
                });
            }
            break;
    }
}

$(document).ready(function() {
    if ($('#dashboard-academic-year').length) {
        $('#dashboard-academic-year').on('change', function() {
            var academicYear = $(this).val();
            if (academicYear) {
                window.location.href = '<?php echo Yii::app()->createUrl("dashboard/index"); ?>?academic_year=' + academicYear;
            }
        });
    }
    
    if ($('#dashboard-refresh').length) {
        $('#dashboard-refresh').on('click', function() {
            $(this).find('i').addClass('fa-spin');
            refreshDashboardWidgets();
            setTimeout(function() {
                $('#dashboard-refresh').find('i').removeClass('fa-spin');
            }, 1000);
        });
    }
    
    if ($('#dashboard-auto-refresh').length) {
        $('#dashboard-auto-refresh').on('click', function() {
            dashboardAutoRefresh = !dashboardAutoRefresh;
            var $btn = $(this);
            
            if (dashboardAutoRefresh) {
                $btn.addClass('btn-success').removeClass('btn-default');
                $btn.attr('title', 'Auto Refresh (On)');
                dashboardAutoRefreshInterval = setInterval(refreshDashboardWidgets, 300000);
            } else {
                $btn.addClass('btn-default').removeClass('btn-success');
                $btn.attr('title', 'Auto Refresh (Off)');
                clearInterval(dashboardAutoRefreshInterval);
            }
        });
    }
    
    if ($('#dashboard-date-range').length) {
        var dateRangeInput = $('#dashboard-date-range');
        var fromDate, toDate;
        
        dateRangeInput.on('focus', function() {
            if (!fromDate) {
                fromDate = $('<input type="text" class="datepicker" placeholder="From" style="width: 100px; margin-right: 5px;">');
                toDate = $('<input type="text" class="datepicker" placeholder="To" style="width: 100px;">');
                var $this = $(this);
                $this.after(fromDate).after(toDate);
                $this.hide();
                
                fromDate.datepicker({
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(selectedDate) {
                        toDate.datepicker('option', 'minDate', selectedDate);
                        applyDateRange();
                    }
                });
                
                toDate.datepicker({
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(selectedDate) {
                        fromDate.datepicker('option', 'maxDate', selectedDate);
                        applyDateRange();
                    }
                });
            }
        });
        
        function applyDateRange() {
            var start = fromDate.val();
            var end = toDate.val();
            if (start && end) {
                var startDate = new Date(start);
                var endDate = new Date(end);
                var days = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl("dashboard/widgetData"); ?>',
                    data: { widget: 'attendance_trend', days: days, start_date: start, end_date: end },
                    dataType: 'json',
                    success: function(data) {
                        updateDashboardWidget('attendance_trend', data);
                    }
                });
                dateRangeInput.val(start + ' to ' + end);
            }
        }
    }
    
    if (dashboardUserGroup == 3 || dashboardUserGroup == 4) {
        $('#wid-fee-collection, #wid-income-expense').closest('.row').hide();
    }
    
    if (dashboardUserGroup == 3) {
        $('#wid-exam-performance').closest('.row').hide();
    }
});
</script>
