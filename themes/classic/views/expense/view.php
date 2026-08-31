<?php
/* @var $this ExpenseController */
/* @var $model Expense */

$this->breadcrumbs = array(
    'Expenses' => array('index'),
    $model->id,
);
?>

<h1>View Expense #<?php echo $model->id; ?></h1>

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
