<?php
$this->pageTitle = 'Progress Report';
$class = $_REQUEST['class'];
$section = $_REQUEST['section'];
$group = $_REQUEST['group'];
$exam = $_REQUEST['exam'];
$year = $_REQUEST['year'];
$exam_array = Exam::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution.' AND `class`=' . $class . ' AND `academic_year`=' . $year, 'order' => "id"));
$exam = $exam_array[array_key_last($exam_array)]['id'];
$exam_array_total = count($exam_array);
Yii::app()->clientScript->registerScript('print', "
<!--
    window.print();
//-->
");
?>
<style>
    body{
        font-size: 12px;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        /*font-family: Calibri;*/
    }
    table { 
        border-spacing: 0;
        border-collapse: collapse;
        text-align: center;
    }
    .text-center{
        text-align: center;
    }
    .text-left{
        text-align: left;
    }
    .page-break {
        page-break-after: always;
    }
    td{
        padding: 0px;
        margin: 0px;
    }
    .uppercase{
        text-transform: uppercase;
    }
    .page-break {
        page-break-after: always;
    }
</style>
<?php
$connection = Yii::app()->db;
$command = $connection->createCommand('SELECT S.`id`, S.`roll`, S.`name`, S.`class`, S.`sid`, P.`father`, P.`mother`
                                        FROM {{student}} S
                                        LEFT OUTER JOIN {{parent}} P ON P.`id`=S.`guardian`
                                        WHERE  S.`institution`=' . Yii::app()->user->institution . ' AND S.`class`=' . $class . ' AND S.`section`=' . $section . ' AND S.`group`=' . $group . ' AND S.`academic_year`=' . $year . ' ORDER BY S.`roll` ASC');
$students = $command->queryAll();
foreach ($students as $key => $value) {    
    ?>
    <div style="border: 5px solid #666; margin-top: 5px; padding: 5px;">
        <div style="border: 1px dotted #333; padding: 10px;">
            <table width="100%">
                <tr>
                    <td colspan="3" style="text-align: center;text-transform: uppercase;"><h1><?= Institution::getData(Yii::app()->user->institution, 'institution') ?></h1></td>
                </tr>
                <tr>
                    <td width="25%" style="text-align: left;">
                        <?= Student::getPhotoAdmitCard($value["id"]) ?> 
                    </td>
                    <td width="50%" style="text-align: center; vertical-align: top;">
                        <h4 style="text-transform: uppercase;"><?= Institution::getData(Yii::app()->user->institution, 'address') ?></h4>
                        <p><?= Institution::getPhoto(Yii::app()->user->institution, 'logo', 100) ?></p>
                        <h4 style="text-decoration: underline;"><strong>ACADEMIC TRANSCRIPT</strong></h4>
                    </td>
                    <td width="25%" style="vertical-align: top;">
                        <table width="100%" border="1" style="text-align: center;">
                            <tr>
                                <th>Range</th>
                                <th>Grade</th>
                                <th>GPA</th>
                            </tr>
                            <tr>
                                <td>80 -100</td>
                                <td>A+</td>
                                <td>5.0</td>
                            </tr>
                            <tr>
                                <td>70 -79</td>
                                <td>A</td>
                                <td>4.0</td>
                            </tr>
                            <tr>
                                <td>60 -69</td>
                                <td>A-</td>
                                <td>3.5</td>
                            </tr>
                            <tr>
                                <td>50 -59</td>
                                <td>B</td>
                                <td>3.0</td>
                            </tr>
                            <tr>
                                <td>40 -49</td>
                                <td>C</td>
                                <td>2.0</td>
                            </tr>
                            <tr>
                                <td>33 -39</td>
                                <td>D</td>
                                <td>1.0</td>
                            </tr>
                            <tr>
                                <td>00 -32</td>
                                <td>F</td>
                                <td>0.0</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="100%" style="text-align: left;">
                <tr>
                    <td width="50%">
                        <table width="100%" style="text-align: left;">
                            <tr>
                                <td width="50%">Name of Student</td>
                                <td width="2%">:</td>  
                                <td width="48%"><?= $value["name"] ?></td>  
                            </tr>
                            <tr>
                                <td width="50%">Father's Name</td>
                                <td width="2%">:</td>  
                                <td width="48%"><?= $value["father"] ?></td>     
                            </tr>
                            <tr>
                                <td width="50%">Mother's Name</td>
                                <td width="2%">:</td>  
                                <td width="48%"><?= $value["mother"] ?></td>      
                            </tr>                                
                            <tr>
                                <td width="50%">Roll No.</td>
                                <td width="2%">:</td>  
                                <td width="48%"><?= $value["roll"] ?></td>      
                            </tr>
                            <tr>
                                <td width="50%">Class</td>
                                <td width="2%">:</td>  
                                <td width="48%"><?= Classs::getData($value["class"], 'class') ?></td>      
                            </tr>
                        </table>
                    </td>
                    <td width="50%">
                        <table width="100%" style="text-align: left;">
                            <tr>
                                <td width="50%">Student ID</td>
                                <td width="2%">:</td>  
                                <td width="48%"><?= $value["sid"] ?></td>      
                            </tr>
                            <tr>
                                <td width="50%">Exam</td>
                                <td width="2%">:</td>  
                                <td width="48%">GRAND FINAL</td>
                            </tr>
                            <tr>
                                <td width="50%">Year/Session</td>
                                <td width="2%">:</td>  
                                <td width="48%"><?= AcademicYear::getData($year, 'title') ?></td>     
                            </tr>
                            <tr>
                                <td width="50%">Group</td>
                                <td width="2%">:</td>    
                                <td width="48%"><?= StudentGroup::getData($group, 'title') ?></td>
                            </tr>
                        </table>
                    </td>      
                </tr>
            </table>
            <table width="100%" border="1" style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th class="text-left" colspan="2">&nbsp;</th>
                        <?php 
                        foreach ($exam_array as $key => $valueEX) {
                        echo '<th class="text-center" colspan="7">'.$valueEX['exam_name'].'</th>';
                         } ?>
                         <th class="text-center" colspan="2">GRAND FINAL</th>
                    </tr>
                    <tr>
                        <th class="text-left">Name of the Subjects</th>
                        <th class="text-center">Full Marks</th>
                        <?php 
                        foreach ($exam_array as $key => $valueEX) {
                            echo '<th class="text-center">CA</th>';
                            echo '<th class="text-center">CR</th>';
                            echo '<th class="text-center">MCQ</th>';
                            echo '<th class="text-center">PR</th>';
                            echo '<th class="text-center">Total Marks</th>';
                            echo '<th class="text-center">Grade</th>';
                            echo '<th class="text-center">GPA</th>';
                         } ?>
                         <th class="text-center">Grade</th>
                        <th class="text-center">GPA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
//                    $subject_array = Subject::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution.' AND `class`=' . $class . ' AND `type`!="UNCOUNTABLE" AND `status`="Active"', 'order' => "subject_serial"));
                    $command_subjectss = $connection->createCommand('SELECT S.`id`, M.`full_mark`, M.`highest_mark`, M.`class_assessment`, M.`written`, M.`mcq`, M.`practical`, M.`subject_total`, M.`letter_grade`, M.`gpa`, M.`subject` subid, S.`subject`, S.`marge_id`, M.`marge_grade`, M.`marge_gpa`  
                                                                    FROM {{mark}} M
                                                                    LEFT OUTER JOIN {{subject}} S ON S.`id`=M.`subject` 
                                                                    WHERE  M.`institution`=' . Yii::app()->user->institution . ' AND M.`student`=' . $value['id'] . ' AND S.`type`!="UNCOUNTABLE" AND M.`class`=' . $class . ' AND M.`section`=' . $section . ' AND M.`group`=' . $group . ' AND M.`academic_year`=' . $year . ' GROUP BY M.`subject` ORDER BY S.`subject_serial` ASC, S.`code` ASC');
                    $subject_array = $command_subjectss->queryAll();
                    foreach ($subject_array as $key => $valueSUB) {
                        $k = 0;
                        echo '<tr>';
                        echo '<td class="text-left">' . $valueSUB['subject'] . '</td>';
                        echo '<td class="text-center">' . $valueSUB['full_mark'] . '</td>';
                        foreach ($exam_array as $key => $valueEX) {
                            $command_subjects = $connection->createCommand('SELECT M.`full_mark`, M.`highest_mark`, M.`class_assessment`, M.`written`, M.`mcq`, M.`practical`, M.`subject_total`, M.`letter_grade`, M.`gpa`, M.`marge_grade`, M.`marge_gpa`, M.`subject` subid, S.`subject`, S.`marge_id` 
                            FROM {{mark}} M
                            LEFT OUTER JOIN {{subject}} S ON S.`id`=M.`subject` 
                            WHERE  M.`institution`=' . Yii::app()->user->institution . ' AND M.`student`=' . $value['id'] . ' AND M.`subject`='.$valueSUB['id'].' AND M.`class`=' . $class . ' AND M.`section`=' . $section . ' AND M.`group`=' . $group . ' AND M.`exam`=' . $valueEX['id'] . ' AND M.`academic_year`=' . $year . ' ORDER BY S.`subject_serial` ASC, S.`code` ASC');
                            $subjects = $command_subjects->queryAll();
                            foreach ($subjects as $key => $values) {
                                echo '<td class="text-center">' . $values['class_assessment'] . '</td>';
                                echo '<td class="text-center">' . $values['written'] . '</td>';
                                echo '<td class="text-center">' . $values['mcq'] . '</td>';
                                echo '<td class="text-center">' . $values['practical'] . '</td>';
                                echo '<td class="text-center">' . $k.$values['subject_total'] . '</td>';
                                echo '<td class="text-center">' . $values['letter_grade'] . '</td>';
                                echo '<td class="text-center">' . $values['gpa'] . '</td>';
                                /*
                                if ($values['marge_id'] > 0 && $values['subid'] != $k) {
                                    echo '<td class="text-center" rowspan="2">' . $values['marge_grade'] . '</td>';
                                    echo '<td class="text-center" rowspan="2">' . $values['marge_gpa'] . '</td>';
                                    $k = Mark::getAnotherMargeSubject(Yii::app()->user->institution, $class, $values['marge_id'], $values['subid']);
                                }
                                if ($values['marge_id'] == 0) {
                                    echo '<td class="text-center">' . $values['letter_grade'] . '</td>';
                                    echo '<td class="text-center">' . $values['gpa'] . '</td>';
                                }
                                */
                            }                                                        
                        }
                        echo '<td class="text-center">&nbsp;</td>';
                        echo '<td class="text-center">&nbsp;</td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr>
                        <td style="text-align: center; font-weight: 800;">Total Exam Marks</td>
                        <td style="text-align: center; font-weight: 800;"><?=Mark::getSemesterTotalActualMarks(Yii::app()->user->institution, $value['id'], $class, $section, $group, $exam, $year) ?></td>
                        <?php
                        foreach ($exam_array as $key => $valueEX) {
                            echo '<td colspan="4" style="text-align: center; font-weight: 800;">Obtained Marks</td>';
                            echo '<td style="text-align: center; font-weight: 800;">'.Mark::getSemesterTotalMarks(Yii::app()->user->institution, $value['id'], $class, $section, $group, $valueEX['id'], $year).'</td>';
                            echo '<td style="text-align: center; font-weight: 800;">'.Mark::getSemesterData(Yii::app()->user->institution, $value['id'], $class, $section, $group, $valueEX['id'], $year)['letter_grade'].'</td>';
                            echo '<td style="text-align: center; font-weight: 800;">'.Mark::getSemesterData(Yii::app()->user->institution, $value['id'], $class, $section, $group, $valueEX['id'], $year)['gpa'].'</td>';
                        }
                        ?>
                        <td style="text-align: center; font-weight: 800;"><?=Mark::getSemesterData(Yii::app()->user->institution, $value['id'], $class, $section, $group, $exam, $year)['letter_grade'] ?></td>
                        <td style="text-align: center; font-weight: 800;"><?=Mark::getSemesterData(Yii::app()->user->institution, $value['id'], $class, $section, $group, $exam, $year)['gpa'] ?></td>
                    </tr>
                    <tr>
                    <?php
                        $ContinuousColspan = ($exam_array_total * 7) + 4;
                    ?>
                        <td colspan="<?=$ContinuousColspan?>" class="text-left uppercase" style="font-size: 14px; background-color: #DDD;">Continuous Assessment</td>
                    </tr>
                    <?php
//                    $subject_array = Subject::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution.' AND `class`=' . $class . ' AND `type`="UNCOUNTABLE" AND `status`="Active"', 'order' => "subject_serial"));
                    $command_subjectsss = $connection->createCommand('SELECT S.`id`, M.`full_mark`, M.`highest_mark`, M.`class_assessment`, M.`written`, M.`mcq`, M.`practical`, M.`subject_total`, M.`letter_grade`, M.`gpa`, M.`subject` subid, S.`subject`, S.`marge_id`, M.`marge_grade`, M.`marge_gpa`  
                                                                    FROM {{mark}} M
                                                                    LEFT OUTER JOIN {{subject}} S ON S.`id`=M.`subject` 
                                                                    WHERE  M.`institution`=' . Yii::app()->user->institution . ' AND M.`student`=' . $value['id'] . ' AND S.`type`="UNCOUNTABLE" AND M.`class`=' . $class . ' AND M.`section`=' . $section . ' AND M.`group`=' . $group . ' AND M.`academic_year`=' . $year . ' GROUP BY M.`subject` ORDER BY S.`subject_serial` ASC, S.`code` ASC');
                    $subject_array = $command_subjectsss->queryAll();
                    foreach ($subject_array as $key => $valueSUB) {
                        echo '<tr>';
                        echo '<td class="text-left">' . $valueSUB['subject'] . '</td>';
                        echo '<td class="text-center">' . $valueSUB['full_mark'] . '</td>';
                        foreach ($exam_array as $key => $valueEX) {
                            $command_subjects = $connection->createCommand('SELECT M.`full_mark`, M.`highest_mark`, M.`class_assessment`, M.`written`, M.`mcq`, M.`practical`, M.`subject_total`, M.`letter_grade`, M.`gpa`, M.`subject` subid, S.`subject`, S.`marge_id` 
                            FROM {{mark}} M
                            LEFT OUTER JOIN {{subject}} S ON S.`id`=M.`subject` 
                            WHERE  M.`institution`=' . Yii::app()->user->institution . ' AND M.`student`=' . $value['id'] . ' AND M.`subject`='.$valueSUB['id'].' AND M.`class`=' . $class . ' AND M.`section`=' . $section . ' AND M.`group`=' . $group . ' AND M.`exam`=' . $valueEX['id'] . ' AND M.`academic_year`=' . $year . ' ORDER BY S.`subject_serial` ASC, S.`code` ASC');
                            $subjects = $command_subjects->queryAll();
                            foreach ($subjects as $key => $values) {
                                echo '<td class="text-center">' . $values['class_assessment'] . '</td>';
                                echo '<td class="text-center">' . $values['written'] . '</td>';
                                echo '<td class="text-center">' . $values['mcq'] . '</td>';
                                echo '<td class="text-center">' . $values['practical'] . '</td>';
                                echo '<td class="text-center">' . $values['subject_total'] . '</td>';
                            }
                        }
                        echo '<td class="text-center">' . $values['letter_grade'] . '</td>';
                        echo '<td class="text-center">' . $values['gpa'] . '</td>';
//                        echo '<td class="text-center">' . Mark::getGrandFinalGrade(Yii::app()->user->institution, $value['id'], $class, $section, $group, $valueSUB['id'], $year) . '</td>';
//                        echo '<td class="text-center">' . Mark::getGrandFinalGPA(Yii::app()->user->institution, $value['id'], $class, $section, $group, $valueSUB['id'], $year) . '</td>';
                        echo '</tr>';
                    }
                    ?>                  
                </tbody>
            </table>
            <table width="100%" style="margin-top: 10px;">
                <tr>
                    <td width="33%" style="vertical-align: top;">
                        <table width="100%" border="1">
                            <tr>
                                <th class="text-left">Class Position</th>
                                <td class="text-center"><?= Mark::getSemesterMeritData(Yii::app()->user->institution, $value['id'], $class, $section, $group, $exam, $year)['group_position'] ?></td>
                            </tr>
                            <tr>
                                <th class="text-left">GPA (Without 4th)</th>
                                <td class="text-center"><?= Mark::getSemesterData(Yii::app()->user->institution, $value['id'], $class, $section, $group, $exam, $year)['gpa_actual'] ?></td>
                            </tr>
                            <tr>
                                <th class="text-left">Failed Subject(s)</th>
                                <td class="text-center"><?= Mark::getSemesterMeritData(Yii::app()->user->institution, $value['id'], $class, $section, $group, $exam, $year)['failed_subject'] ?></td>
                            </tr>
                            <tr>
                                <th class="text-left">Working Days</th>
                                <td class="text-center"></td>
                            </tr>
                            <tr>
                                <th class="text-left">Total Present</th>
                                <td class="text-center"></td>
                            </tr>
                        </table>
                    </td>
                    <td width="1%"></td>
                    <td width="32%" style="vertical-align: top;">
                        <table width="100%" border="1">
                            <tr>
                                <th colspan="2"> Moral & Behavior Evaluation </th>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td class="text-left">Excellent</td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td class="text-left">Better</td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td class="text-left">Good</td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td class="text-left">Need Improvement</td>
                            </tr>
                        </table>
                    </td>
                    <td width="1%"></td>
                    <td width="33%" style="vertical-align: top;">
                        <table width="100%" border="1">
                            <tr>
                                <th colspan="2">Co-Curricular Activities </th>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td class="text-left">Sports</td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td class="text-left">Cultural Function</td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td class="text-left">Scout/BNCC</td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td class="text-left">Math Olympiad</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="100%" style="margin-top: 40px; font-size: 12px;">
                <tr>
                    <td width="33%">
                        <hr />
                        <div class="text-center">Guardian</div>
                    </td>
                    <td width="33%">
                        <hr />
                        <div class="text-center">Class Teacher</div>
                    </td>
                    <td width="33%">
                        <?= Institution::getPhoto(Yii::app()->user->institution, 'signature', 100) ?>
                        <hr />
                        <div class="text-center">Head Teacher</div>
                    </td>
                </tr>
            </table>               
        </div>
    </div>
    <div class="page-break">&nbsp;</div>
<?php } ?> 