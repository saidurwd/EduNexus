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
<?php
$connection = Yii::app()->db;
$command = $connection->createCommand('SELECT * FROM {{green_leaf}} GROUP BY DATE_FORMAT(`Plucking`, "%Y-%m")');
$array_ym = $command->queryAll();
foreach ($array_ym as $key => $value) {
    $connection1 = Yii::app()->db;
    $command1 = $connection1->createCommand('SELECT * FROM {{green_leaf}} WHERE DATE_FORMAT(`Plucking`, "%Y-%m") = DATE_FORMAT("' . $value['Plucking'] . '", "%Y-%m") GROUP BY Division, Section');
    $array1 = $command1->queryAll();
    echo '<table class="table" style="margin-top: 30px;">';

    echo '<thead>';
    echo '<tr>';
    echo '<th colspan="2">Green Leaf ' . date("F Y", strtotime($value['Plucking'])) . '</th>';
    for ($i = 1; $i <= 31; $i++) {
        echo '<th>' . $i . '</th>';
    }
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($array1 as $key => $value1) {
        echo '<tr>';
        echo '<td>' . $value1['Division'] . '</td>';
        echo '<td>' . $value1['Section'] . '</td>';
        $connection2 = Yii::app()->db;
        $command2 = $connection1->createCommand('SELECT * FROM {{green_leaf}} WHERE DATE_FORMAT(`Plucking`, "%Y-%m") = DATE_FORMAT("' . $value['Plucking'] . '", "%Y-%m") AND Division="' . $value1['Division'] . '" AND Section="' . $value1['Section'] . '" ORDER BY `Plucking` ASC');
        $array2 = $command2->queryAll();

        $newArr = array();
        for ($q = 0; $q < 31; $q++) {
            $newArr[] = array(
                $q => 0,
            );
        }

        foreach ($array2 as $key => $value2) {
            $position = date("j", strtotime(@$value2['Plucking']));
            $inserted_value = @$value2['Kgs'];
            array_splice($newArr, $position, 1, array($position => array($position => $inserted_value)));
        }

        foreach ($newArr as $key => $value3) {
            if ($key != 0)
                echo '<td>' . @$value3[$key] . '</td>';
        }

        echo '</tr>';
    }
    echo '</tbody></table> ';
}
?>