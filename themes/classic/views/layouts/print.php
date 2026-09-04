<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="author" content="S.M. Saidur Rahman" />
        <meta name="generator" content="Optimo Solution" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css">
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>