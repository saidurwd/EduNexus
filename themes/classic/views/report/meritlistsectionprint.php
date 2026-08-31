<?php
$this->pageTitle = 'Merit List';
$class = $_REQUEST['class'];
$section = $_REQUEST['section'];
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
<h2 style="text-transform: uppercase; text-align: center; background-color: #DDD; padding: 5px 0px;">Merit List - Section Wise</h2>
<table class="table">
    <thead>
        <tr>
            <th>Class</th>
            <th>Section</th>
            <th>Exam Name</th>
            <th>Academic Year</th>
        </tr> 
    </thead> 
    <tbody>
        <tr>
            <td><?= Classs::getData($class, 'class') ?></td>
            <td><?= Section::getData($section, 'section') ?></td>
            <td><?= Exam::getData($exam, 'exam_name') ?></td>
            <td><?= AcademicYear::getData($year, 'title') ?></td>
        </tr> 
    </tbody> 
</table>
<table class="table" style="margin-top: 10px;">
    <thead>
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-left">Student</th>            
            <th class="text-center">SID</th>
            <th class="text-center">Group</th>
            <th class="text-center">Roll No.</th>
            <th class="text-center">Total Marks</th>
            <th class="text-center">Grade</th>
            <th class="text-center">GPA</th>
            <th class="text-center">Merit Position</th>
        </tr> 
    </thead> 
    <tbody>
        <?php
        $i = 1;
        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT SG.`title`, M.`total_mark`, M.`letter_grade`, M.`gpa`, M.`section_position`, S.`name`, M.`sid`, M.`roll`
                                                FROM {{merit_position}} M
                                                LEFT OUTER JOIN {{student}} S ON S.`id`= M.`student` 
                                                LEFT OUTER JOIN {{student_group}} SG ON SG.`id`= M.`group` 
                                                WHERE  M.`institution`=' . Yii::app()->user->institution . ' AND M.`class`=' . $class . ' AND M.`section`=' . $section . ' AND M.`exam`=' . $exam . ' AND M.`academic_year`=' . $year . ' AND M.`failed_subject`=0 ORDER BY M.`section_position` ASC');
        $students = $command->queryAll();
        foreach ($students as $key => $values) {
            ?>
            <tr>
                <td class="text-center"><?= $i ?></td>
                <td class="text-left"><?= $values['name'] ?></td>                
                <td class="text-center"><?= $values['sid'] ?></td>
                <td class="text-center"><?= $values['title'] ?></td>
                <td class="text-center"><?= $values['roll'] ?></td>
                <td class="text-center"><?= $values['total_mark'] ?></td>
                <td class="text-center"><?= $values['letter_grade'] ?></td>
                <td class="text-center"><?= $values['gpa'] ?></td>
                <td class="text-center"><?= $values['section_position'] ?></td>
            </tr> 
            <?php $i++;
        }
        ?>   
    </tbody>
</table> 