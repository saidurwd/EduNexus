<?php
$class = $_REQUEST['class'];
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
        line-height: 12px;
    }
    .main_table{
        border: 1px solid #000000;
        float: left;
        margin-right: 5px;
    }
    .page-break {
        page-break-after: always;
    }
</style>
<?php
$i = 1;
$array = Report::admitCardReport($class, $exam, $year);
$total = count($array);
foreach ($array as $key => $value) {
    ?>
    <table class="main_table" width="49%">
        <tr>
            <td colspan="2">
                <table  width="100%" style="margin: 0px; padding: 0px;">
                    <tr>
                        <td style="text-align: center;"><?= Student::getPhotoAdmitCard($value["id"], 45) ?></td>
                        <td style="text-align: center;">
                            <div style="text-transform: uppercase; font-size: 10px; white-space: nowrap;"><?= Institution::getData(Yii::app()->user->institution, 'institution') ?></div>
                            <div style="text-transform: uppercase; font-size: 8px;"><?= Institution::getData(Yii::app()->user->institution, 'address') ?></div>
                            <div style="background-color: #666666; padding: 2px; color: #FFFFFF;text-transform: uppercase;">Exam Seat Plan</div>
                        </td>
                        <td style="text-align: center;">
                            <?= Institution::getPhoto(Yii::app()->user->institution, 'logo', 45) ?>
                        </td>
                    </tr>
                </table>
            </td>                                
        </tr>
        <tr>
            <td width="70%">
                <table  width="100%" style="text-align: left;">
                    <tr>
                        <td width="30%">Name</td>
                        <td width="1%">:</td>
                        <td width="69%"><?= $value["name"] ?></td>
                    </tr>
                    <tr>
                        <td>Student ID</td>
                        <td>:</td>
                        <td><?= $value["sid"] ?></td>
                    </tr>
                    <tr>
                        <td>Class Name</td>
                        <td>:</td>
                        <td><?= Classs::getData($value["class"], 'class') ?></td>
                    </tr>
                    <tr>
                        <td>Year/Session</td>
                        <td>:</td>
                        <td><?= AcademicYear::getData($value["academic_year"], 'title') ?></td>
                    </tr>
                    <tr>
                        <td>Exam Name</td>
                        <td>:</td>
                        <td><?= Exam::getData(@$exam, 'exam_name') ?></td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td>:</td>
                        <td><?= StudentGroup::getData($value["group"], 'title') ?></td>
                    </tr>
                    <tr>
                        <td>Section</td>
                        <td>:</td>
                        <td><?= Shift::getData($value["shift"], 'title') ?>-<?= Section::getData($value["section"], 'section') ?></td>
                    </tr>
                </table>
            </td>
            <td width="30%">
                <table  width="70%" border="2" style="text-align: center; font-weight: 600; text-transform: uppercase;">
                    <tr>
                        <td>Roll No.</td>
                    </tr>
                    <tr>
                        <td><?= $value["roll"] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
    if ($i % 2 == 0) {
        echo '<div style="clear: both; padding: 5px 0px;"><div style="border-top: 1px dotted #999;"></div></div>';
    }
    if ($i % 10 == 0) {
        echo '<div class="page-break">&nbsp;</div>';
    }
    $i++;
}
?>