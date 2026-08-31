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
        font-family: Calibri, Arial;
    }
    .admitHome{
        border: 1px solid #006600; 
        width: 100%; 
        padding: 0px;
        margin-bottom: 5px; 
        /*                height: 455px; 
                        width: 595px;*/
    }
    .table-custom  td{
        border:1px solid #006600;
        margin: 0px;
        padding: 0px;
    }
    .table-custom  th{
        border:1px solid #006600;
        margin: 0px;
        padding: 0px;
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
    <div class="admitHome">
        <table width=100% style="text-align:center;">
            <tr>
                <td style="background: #006600;">
                    <h2 align="center" style="padding:2px 0px; margin: 0px; color: #fff; font-size: 14px; text-transform: uppercase;"><?= Institution::getData(Yii::app()->user->institution, 'institution') ?></h2>
                </td>
            </tr>
            <tr><td><h3  style="padding: 0px; margin: 0px; font-size: 12px; text-transform: uppercase;"><?= Institution::getData(Yii::app()->user->institution, 'address') ?></h3></td></tr>
        </table>
        <table width=100%>
            <tr>
                <td width="33%">
                    <table border="1" width="35%" style="text-align: center;">
                        <tr style="border: #000 solid 1px;">
                            <th style=" " width="52">Room No</th>
                            <th style="" width="52">Bench No</th> 
                            <th style=" " width="52">Seat No</th>
                        </tr>
                        <tr style="">
                            <td style=" ">&nbsp;</td>
                            <td style=" ">&nbsp;</td> 
                            <td style=" ">&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td width="34%" style="text-align: center;">
                    <?= Institution::getPhoto(Yii::app()->user->institution, 'logo', 100) ?> 
                    <div style="font-size: 14px; text-decoration: underline; font-weight: 600;">Admit Card</div>
                </td>
                <td width="33%" style="text-align: center;">
                    <?= Student::getPhotoAdmitCard($value["id"]) ?> 
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td>
                    <table class="">
                        <tr>
                            <td width="110">Student Name</td>
                            <td width="10">:</td>
                            <td width="110"><?= $value["name"] ?></td>
                        </tr>
                        <tr>
                            <td width="110">Student ID</td>
                            <td width="10">:</td>
                            <td width="110"><?= $value["sid"] ?></td>
                        </tr>
                        <tr>
                            <td width="110">Group</td>
                            <td width="10">:</td>
                            <td width="110"><?= StudentGroup::getData($value["group"], 'title') ?></td>
                        </tr>
                        <tr>
                            <td width="110">Section</td>
                            <td width="10">:</td>
                            <td width="110"><?= Shift::getData($value["shift"], 'title') ?>-<?= Section::getData($value["section"], 'section') ?></td>
                        </tr>
                        <tr>
                            <td width="110">Roll No.</td>
                            <td width="10">:</td>
                            <td width="110"><?= $value["roll"] ?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="">
                        <tr>
                            <td width="110">Class</td>
                            <td width="10">:</td>
                            <td width="110"><?= Classs::getData($value["class"], 'class') ?></td>
                        </tr>
                        <tr>
                            <td width="110">Year/Session</td>
                            <td width="10">:</td>
                            <td width="110"><?= AcademicYear::getData($value["academic_year"], 'title') ?></td>
                        </tr>
                        <tr>
                            <td width="110">Exam Name</td>
                            <td width="10">:</td>
                            <td width="110"><?= Exam::getData(@$exam, 'exam_name') ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table  width="100%">
            <tr>
                <td style="font-size:7px" width="50%"><?= Yii::app()->params['PoweredBy'] ?></td>
                <td width="25%" align="right" style="text-align: center;">  
                    <hr style="padding: 0; margin: 50px 0 3px 0;">
                    <p style="padding: 0; margin: 3px 0 0px 0;">Class Teacher</p>
                </td>
                <td align="right" style="text-align: center;">
                    <p><?= Institution::getPhoto(Yii::app()->user->institution, 'signature', 100) ?></p>
                    <hr style="padding: 0; margin: 0 0 3px 0;">
                    <p style="padding: 0; margin: 0;">Head Teacher</p>
                </td>
            </tr>
        </table>
    </div>
    <?php
    if ($i % 3 == 0) {
        echo '<div class="page-break">&nbsp;</div>';
    }
    $i++;
}
?>