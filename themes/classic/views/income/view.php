<?php
/* @var $this IncomeController */
/* @var $model Income */

$this->breadcrumbs = array(
    'Incomes' => array('index'),
    $model->id,
);
?>

<h1>View Income #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'coa',
        'expense_date',
        'amount',
        'note',
        'file',
        'created_on',
        'created_by',
    ),
));
?>
