<?php
$class = $_REQUEST['class'];
$section = $_REQUEST['section'];
$year = $_REQUEST['year'];
?>
<style>
    body{
        font-size: 12px;
        font-family: Calibri;
    }
    .card_holder{
        width: 192px;
        height: 288px;
        height: auto;
        border-top: 1px solid #000;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
        border-bottom: 10px solid #006600;
        float: left;
        margin-right: 10px;
        padding: 0px;
        overflow: hidden;
    }
    .inst_name{
        text-transform: uppercase;
        font-size: 12px;
        color: #006600;
        font-weight: 600;
        text-align: center;
    }
    .inst_address{
        margin-top: 5px;
        text-transform: uppercase;
        font-size: 10px;
        color: #000;
        text-align: center;
        margin-bottom: 10px;
    }
    .student_name{
        font-size: 12px;
        text-align: center;
        color: #9B0468;
        text-transform: uppercase;
    }
    .student_title{
        text-align: left;
        margin-left: 4px;
        font-weight: 800;
        white-space: nowrap;
    }
    .student_image{
        /*width: 115px;*/
        height: 115px;
        text-align: center;
    }
    td{
        line-height: 10px;
    }
    .vertical-orientation {
        background-color: #006600; 
        color: #FFFFFF;
        text-align: center;
        padding-left: 15px;
        font-size: 12px;
        width: 35px;
    }
    .page-break {
        page-break-after: always;
    }
</style>
<?php
$i = 1;
$array = Report::idCardReport($class, $section, $year);
//$total = count($array);
foreach ($array as $key => $value) {
    ?>
    <table class="card_holder">
        <tr>
            <td class="inst_name" colspan="3"><?= Institution::getData(Yii::app()->user->institution, 'institution') ?></td>
        </tr>
        <tr>
            <td class="inst_address" colspan="3"><?= Institution::getData(Yii::app()->user->institution, 'address') ?></td>
        </tr>
        <tr>
            <td class="inst_address" colspan="3">IDENTITY CARD</td>
        </tr>
        <tr>
            <td class="vertical-orientation">&nbsp;</td>
            <td class="student_image"><?= Student::getPhotoAdmitCard($value["id"]) ?> </td>
            <td class="vertical-orientation" style="width: 35px;">&nbsp;</td>
        </tr>
        <tr>
            <td class="student_name" colspan="3"><?= $value["name"] ?>, ID: <?= $value["sid"] ?></td>
        </tr>
        <tr>
            <td colspan="3">
                <table>
                    <tr>
                        <td class="student_title">Class</td>
                        <td>:</td>
                        <td><?= Classs::getData($value["class"], 'class') ?></td>
                    </tr>
                    <tr>
                        <td class="student_title">Session</td>
                        <td>:</td>
                        <td><?= AcademicYear::getData($value["academic_year"], 'title') ?></td>
                    </tr>
                    <tr>
                        <td class="student_title">Blood</td>
                        <td>:</td>
                        <td><?= $value["blood_group"] ?></td>
                    </tr>
                    <tr>
                        <td class="student_title">Roll No</td>
                        <td>:</td>
                        <td><?= $value["roll"] ?></td>
                    </tr>
                    <tr>
                        <td class="student_title">Cell No.</td>
                        <td>:</td>
                        <td>+880<?= $value["phone"] ?></td>
                    </tr>
                    <tr>
                        <td class="student_title">Group</td>
                        <td>:</td>
                        <td><?= StudentGroup::getData($value["group"], 'title') ?></td>
                    </tr>
                </table>
            </td>
        </tr>            
    </table> 
    <?php
    if ($i % 3 == 0) {
        echo '<div style="clear: both;"><hr style="border: 1px dotted #DDDDDD;" /></div>';
    }

    if ($i % 9 == 0) {
        echo '<div class="page-break">&nbsp;</div>';
    }
    $i++;
}
?>
<script>
    window.print();
</script>