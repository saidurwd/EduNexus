<?php
$this->pageTitle = 'Tabulation Sheet';
$class = $_REQUEST['class'];
$section = $_REQUEST['section'];
$group = $_REQUEST['group'];
$exam = $_REQUEST['exam'];
$year = $_REQUEST['year'];
Yii::app()->clientScript->registerScript('print', "
<!--
    window.print();
//-->
");
?>
<style>
    body{
        font-size: 12px;
        font-family: Calibri;
    }    
    .table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    .table td, .table th {
        border: 1px solid #ddd;
        padding: 8px;
        vertical-align: middle;
    }
    .table tr:nth-child(even){background-color: #f2f2f2;}
    .table tr:hover {background-color: #ddd;}
    .table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
        text-transform: uppercase;
    }
    .td-background{
        background-color: #999;
        font-size: 14px;
    }
    .text-left{
        text-align: left;
    }
    .text-center{
        text-align: center;
    }
    .uppercase{
        text-transform: uppercase;
    }
    .page-break {
        page-break-after: always;
    }
</style>
<h1 style="text-transform: uppercase; text-align: center;"><?= Institution::getData(Yii::app()->user->institution, 'institution') ?></h1>
<h4 style="text-transform: uppercase; text-align: center;"><?= Institution::getData(Yii::app()->user->institution, 'address') ?></h4>
<h2 style="text-transform: uppercase; text-align: center; background-color: #DDD; padding: 5px 0px;">Tabulation Sheet</h2>
<table class="table">
    <thead>
        <tr>
            <th>Class</th>
            <th>Section</th>
            <th>Student Group</th>
            <th>Exam Name</th>
            <th>Academic Year</th>
        </tr> 
    </thead> 
    <tbody>
        <tr>
            <td><?= Classs::getData($class, 'class') ?></td>
            <td><?= Section::getData($section, 'section') ?></td>
            <td><?= StudentGroup::getData($group, 'title') ?></td>
            <td><?= Exam::getData($exam, 'exam_name') ?></td>
            <td><?= AcademicYear::getData($year, 'title') ?></td>
        </tr> 
    </tbody> 
</table>
<table class="table" style="margin-top: 10px;">
    <thead>
        <tr>
            <th class="text-left">Student Name</th>
            <th class="text-center">Roll</th>
            <th class="text-center">Class Position</th>
            <th class="text-center">Section Position</th>
            <th class="text-center">Group Position</th>
            <th class="text-center">Total Marks</th>
            <th class="text-center">GPA</th>
            <th class="text-center">Letter Grade</th>
        </tr> 
    </thead> 
    <tbody>
        <?php
        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT M.`student`, M.`roll`, S.`name`
                                                FROM {{mark}} M
                                                LEFT OUTER JOIN {{student}} S ON S.`id`=M.`student` 
                                                WHERE  M.`institution`=' . Yii::app()->user->institution . ' AND M.`class`=' . $class . ' AND M.`section`=' . $section . ' AND M.`group`=' . $group . ' AND M.`exam`=' . $exam . ' AND M.`academic_year`=' . $year . ' GROUP BY M.`student` ORDER BY M.`roll` ASC');
        $students = $command->queryAll();
        foreach ($students as $key => $value) {
            $k = 0;
            ?>        
            <tr>
                <td class="text-left"><?= $value['name'] ?></td>
                <td class="text-center"><?= $value['roll'] ?></td>
                <td class="text-center"><?= Mark::getSemesterMeritData(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year)['class_position'] ?></td>
                <td class="text-center"><?= Mark::getSemesterMeritData(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year)['section_position'] ?></td>
                <td class="text-center"><?= Mark::getSemesterMeritData(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year)['group_position'] ?></td>
                <td class="text-center"><?= Mark::getSemesterTotalMarks(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year) ?></td>
                <td class="text-center"><?= Mark::getSemesterData(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year)['gpa'] ?></td>
                <td class="text-center"><?= Mark::getSemesterData(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year)['letter_grade'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table> 