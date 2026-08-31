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
            <th class="text-left">Name of Subjects</th>
            <th class="text-center">Written</th>
            <th class="text-center">MCQ</th>
            <th class="text-center">Practical</th>
            <th class="text-center">Class Assessment</th>
            <th class="text-center">Subject Total</th>
            <th class="text-center">Letter Grade</th>
            <th class="text-center">GPA</th>
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
                <td colspan="8" class="uppercase td-background"><strong>Name: </strong><?= $value['name'] ?>, <strong>Roll: </strong><?= $value['roll'] ?>, <strong>Merit: </strong><?= Mark::getSemesterMeritData(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year)['group_position'] ?>, <strong>Total Marks: </strong><?= Mark::getSemesterTotalMarks(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year) ?>, <strong>GPA: </strong><?= Mark::getSemesterData(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year)['gpa'] ?>, <strong>Grade: </strong><?= Mark::getSemesterData(Yii::app()->user->institution, $value['student'], $class, $section, $group, $exam, $year)['letter_grade'] ?></td>
            </tr>
            <?php
            $command_subjects = $connection->createCommand('SELECT M.`full_mark`, M.`highest_mark`, M.`class_assessment`, M.`written`, M.`mcq`, M.`practical`, M.`subject_total`, M.`letter_grade`, M.`gpa`, M.`subject` subid, S.`subject`, S.`marge_id` 
                                        FROM {{mark}} M
                                        LEFT OUTER JOIN {{subject}} S ON S.`id`=M.`subject` 
                                        WHERE  M.`institution`=' . Yii::app()->user->institution . ' AND M.`student`=' . $value['student'] . ' AND type!="UNCOUNTABLE" AND M.`class`=' . $class . ' AND M.`section`=' . $section . ' AND M.`group`=' . $group . ' AND M.`exam`=' . $exam . ' AND M.`academic_year`=' . $year . ' ORDER BY S.`subject_serial` ASC, S.`code` ASC');
            $subjects = $command_subjects->queryAll();
            foreach ($subjects as $key => $values) {
                ?>
                <tr>
                    <td class="text-left"><?= $values['subject'] ?></td>
                    <td class="text-center"><?= $values['written'] ?></td>
                    <td class="text-center"><?= $values['mcq'] ?></td>
                    <td class="text-center"><?= $values['practical'] ?></td>
                    <td class="text-center"><?= $values['class_assessment'] ?></td>
                    <td class="text-center"><?= $values['subject_total'] ?></td>
                    <?php
                    if ($values['marge_id'] > 0 && $values['subid'] != $k) {
                        echo '<td class="text-center" rowspan="2">' . Mark::getMargeLetterGrade(Yii::app()->user->institution, $class, $values['marge_id'], $value['student'], $exam, $year) . '</td>';
                        echo '<td class="text-center" rowspan="2">' . Mark::getMargeGPA(Yii::app()->user->institution, $class, $values['marge_id'], $value['student'], $exam, $year) . '</td>';
                        $k = Mark::getAnotherMargeSubject(Yii::app()->user->institution, $class, $values['marge_id'], $values['subid']);
                    }
                    if ($values['marge_id'] == 0) {
                        echo '<td class="text-center">' . $values['letter_grade'] . '</td>';
                        echo '<td class="text-center">' . $values['gpa'] . '</td>';
                    }
                    ?>
                </tr> 
            <?php } ?>   
            <tr>
                <td colspan="8" class="text-left uppercase" style="font-size:14px;background-color:#DDD;">Continuous Assessment</td>
            </tr>
            <?php
            $command_subjectsunc = $connection->createCommand('SELECT M.`full_mark`, M.`highest_mark`, M.`class_assessment`, M.`written`, M.`mcq`, M.`practical`, M.`subject_total`, M.`letter_grade`, M.`gpa`, S.`subject`
                                        FROM {{mark}} M
                                        LEFT OUTER JOIN {{subject}} S ON S.`id`=M.`subject` 
                                        WHERE  M.`institution`=' . Yii::app()->user->institution . ' AND M.`student`=' . $value['student'] . ' AND S.`type`="UNCOUNTABLE" AND M.`class`=' . $class . ' AND M.`section`=' . $section . ' AND M.`group`=' . $group . ' AND M.`exam`=' . $exam . ' AND M.`academic_year`=' . $year . ' ORDER BY S.`subject_serial` ASC, S.`code` ASC');
            $subjectsunc = $command_subjectsunc->queryAll();
            foreach ($subjectsunc as $key => $values) {
                ?>
                <tr>
                    <td class="text-left"><?= $values['subject'] ?></td>
                    <td class="text-center"><?= $values['written'] ?></td>
                    <td class="text-center"><?= $values['mcq'] ?></td>
                    <td class="text-center"><?= $values['practical'] ?></td>
                    <td class="text-center"><?= $values['class_assessment'] ?></td>
                    <td class="text-center"><?= $values['subject_total'] ?></td>
                    <td class="text-center"><?= $values['letter_grade'] ?></td>
                    <td class="text-center"><?= $values['gpa'] ?></td>
                </tr> 
            <?php } ?> 
        <?php } ?>
    </tbody>
</table> 