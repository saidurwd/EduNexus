<?php

$file = Yii::app()->basePath . '/../uploads/document/' . Yii::app()->user->institution . '/' . $model->document_file;
if (empty($model->document_file)) {
    Yii::app()->user->setFlash('error', "The file <strong>" . $model->title . "</strong> does not exist");
    $this->redirect(array('admin'));
}

if ((!is_file($file)) && (!file_exists($file))) {
    Yii::app()->user->setFlash('error', "The file <strong>" . $model->title . "</strong> does not exist");
    $this->redirect(array('admin'));
}
$content = file_get_contents($file);
header('Content-Description: File Transfer');
header("Content-type: application/octet-stream");
//header("Content-type: " . $this->returnMIMEType($model->document_file));
header('Content-Disposition: attachment; filename="' . basename($model->document_file) . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header("Content-Length: " . filesize($file));
ob_clean();
flush();
echo $content;
exit;
?>
