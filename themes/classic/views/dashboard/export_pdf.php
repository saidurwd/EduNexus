<?php
/* @var $this DashboardController */
/* @var $data array */
/* @var $academicYear int */
/* @var $institution Institution */
$this->pageTitle = 'Dashboard Report - ' . $institution->institution;
?>
<div class="dashboard-print">
    <div class="report-header">
        <h1 class="text-center"><?php echo CHtml::encode($institution->institution); ?></h1>
        <?php if (!empty($institution->sub_title)): ?>
        <h3 class="text-center"><?php echo CHtml::encode($institution->sub_title); ?></h3>
        <?php endif; ?>
        <h2 class="text-center">Dashboard Report</h2>
        <p class="text-center">
            Generated on: <?php echo date('F j, Y, g:i A'); ?>
            <?php if ($academicYear): ?>
            | Academic Year: <?php echo CHtml::encode(AcademicYear::getData($academicYear, 'title')); ?>
            <?php endif; ?>
        </p>
        <hr>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>Overview</h3>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Total Students</strong></td>
                    <td class="text-right"><?php echo number_format($data['students']); ?></td>
                    <td><strong>Total Teachers</strong></td>
                    <td class="text-right"><?php echo number_format($data['teachers']); ?></td>
                </tr>
                <tr>
                    <td><strong>Today's Attendance Rate</strong></td>
                    <td class="text-right"><?php echo number_format($data['attendance_rate'], 1); ?>%</td>
                    <td><strong>Monthly Income</strong></td>
                    <td class="text-right">$<?php echo number_format($data['monthly_income'], 2); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <?php if (!empty($data['attendance_trend']['labels'])): ?>
    <div class="row">
        <div class="col-xs-12">
            <h3>Attendance Trend (Last 7 Days)</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-center">Present</th>
                        <th class="text-center">Absent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($data['attendance_trend']['labels']); $i++): ?>
                    <tr>
                        <td><?php echo CHtml::encode($data['attendance_trend']['labels'][$i]); ?></td>
                        <td class="text-center"><?php echo number_format($data['attendance_trend']['present'][$i]); ?></td>
                        <td class="text-center"><?php echo number_format($data['attendance_trend']['absent'][$i]); ?></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($data['class_distribution']['labels'])): ?>
    <div class="row">
        <div class="col-xs-12">
            <h3>Class Distribution</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th class="text-center">Students</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($data['class_distribution']['labels']); $i++): ?>
                    <tr>
                        <td><?php echo CHtml::encode($data['class_distribution']['labels'][$i]); ?></td>
                        <td class="text-center"><?php echo number_format($data['class_distribution']['counts'][$i]); ?></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($data['exam_performance']['labels'])): ?>
    <div class="row">
        <div class="col-xs-12">
            <h3>Exam Performance</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Exam</th>
                        <th class="text-center">Avg GPA</th>
                        <th class="text-center">Pass Rate %</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($data['exam_performance']['labels']); $i++): ?>
                    <tr>
                        <td><?php echo CHtml::encode($data['exam_performance']['labels'][$i]); ?></td>
                        <td class="text-center"><?php echo number_format($data['exam_performance']['gpa'][$i], 2); ?></td>
                        <td class="text-center"><?php echo number_format($data['exam_performance']['pass_rate'][$i], 1); ?>%</td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($data['fee_collection']['labels'])): ?>
    <div class="row">
        <div class="col-xs-12">
            <h3>Fee Collection</h3>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Collected</strong></td>
                    <td class="text-right">$<?php echo number_format($data['fee_collection']['collected'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Due</strong></td>
                    <td class="text-right">$<?php echo number_format($data['fee_collection']['due'], 2); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($data['income_expense']['labels'])): ?>
    <div class="row">
        <div class="col-xs-12">
            <h3>Income vs Expense (Last 6 Months)</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th class="text-right">Income</th>
                        <th class="text-right">Expense</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($data['income_expense']['labels']); $i++): ?>
                    <tr>
                        <td><?php echo CHtml::encode($data['income_expense']['labels'][$i]); ?></td>
                        <td class="text-right">$<?php echo number_format($data['income_expense']['income'][$i], 2); ?></td>
                        <td class="text-right">$<?php echo number_format($data['income_expense']['expense'][$i], 2); ?></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <div class="report-footer">
        <hr>
        <p class="text-center text-muted">
            This report was generated automatically by <?php echo CHtml::encode(Yii::app()->name); ?>
        </p>
    </div>
</div>
