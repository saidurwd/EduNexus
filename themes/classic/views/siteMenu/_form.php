<?php
/* @var $this SiteMenuController */
/* @var $model SiteMenu */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'site-menu-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'smart-form'),
        ));
?>
<fieldset>
    <div class="row">
        <section class="col col-12">
            <p class="note">Fields with <span class="required">*</span> are required.</p>
        </section>
    </div>
    <div class="row">
        <section class="col col-12">
            <?php echo $form->errorSummary($model, '<i class="fa fa-bell text-danger"></i> Please fix the following input errors:', '', array('class' => 'text-danger', 'style' => 'padding-left:20px;')); ?>
        </section>
    </div>  
    <div class="row">
        <section class="col col-6">
            <label class="label"><?php echo $form->labelEx($model, 'parent'); ?></label>
            <label class="select">
                <?php
                if ($model->isNewRecord) {
                    echo SiteMenu::get_category_new('SiteMenu', 'parent');
                } else {
                    echo SiteMenu::get_category_update('SiteMenu', 'parent', $model->parent);
                }
                ?>
                <?php echo $form->error($model, 'class'); ?>
            </label>
        </section>
    </div>
    <div class="row">
        <section class="col col-6">
            <label class="label"><?php echo $form->labelEx($model, 'title'); ?></label>
            <label class="input">
                <?php echo $form->textField($model, 'title', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Title')); ?>
                <?php echo $form->error($model, 'title'); ?>
            </label>
        </section>
    </div>
    <div class="row">
        <section class="col col-6">
            <label class="label"><?php echo $form->labelEx($model, 'component'); ?></label>
            <label class="select">
                <?php
                echo $form->dropDownList($model, 'component', array(
                    'site' => 'Home/Contact',
                    'studentLeave' => 'Student Leave',
                    'content' => 'Content/Gallery',
                    'document' => 'Document',
                    'report' => 'Reports',
                    'student' => 'Admission',
                        ), array('empty' => 'Select Component', 'class' => 'select2'));
                ?>
                <?php echo $form->error($model, 'component'); ?>
            </label>
        </section>
    </div>
    <div class="row">
        <section class="col col-6">
            <label class="label"><?php echo $form->labelEx($model, 'action'); ?></label>
            <label class="select">
                <?php
                echo $form->dropDownList($model, 'action', array(
                    'index' => 'Website Home/Content List/Document List',
                    'contact' => 'Contact Us',
                    'create' => 'Student Leave Application',
                    'page' => 'Content View',
                    'gallery' => 'Gallery List',
                    'progressreport' => 'Progress Report',
                    'tabulationsheet' => 'Tabulation Sheet Report',
                    'meritlist' => 'Merit List Report',
                    'faillist' => 'Fail List Report',
                    'admission' => 'Online Admission',
                        ), array('empty' => 'Select Action', 'class' => 'select2'));
                ?>
                <?php echo $form->error($model, 'action'); ?>
            </label>
        </section>
    </div>
    <div class="row">
        <section class="col col-6">
            <label class="label"><?php echo $form->labelEx($model, 'identity'); ?></label>
            <label class="input">
                <?php echo $form->textField($model, 'identity', array('maxlength' => 10, 'class' => 'col-sm-12', 'placeholder' => 'ID')); ?>
                <?php echo $form->error($model, 'identity'); ?>
            </label>
        </section>
    </div>
    <div class="row">
        <section class="col col-6">
            <label class="label"><?php echo $form->labelEx($model, 'menu_class'); ?></label>
            <label class="input">
                <?php echo $form->textField($model, 'menu_class', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'CSS Class')); ?>
                <?php echo $form->error($model, 'menu_class'); ?>
            </label>
        </section>
    </div>
    <div class="row">
        <section class="col col-6">
            <label class="label"><?php echo $form->labelEx($model, 'ordering'); ?></label>
            <label class="input">
                <?php echo $form->textField($model, 'ordering', array('maxlength' => 10, 'class' => 'col-sm-12', 'placeholder' => 'Ordering')); ?>
                <?php echo $form->error($model, 'ordering'); ?>
            </label>
        </section>
    </div>
    <div class="row">
        <section class="col col-6">
            <label class="label"><?php echo $form->labelEx($model, 'status'); ?></label>
            <label class="select">
                <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive'), array('class' => 'select2')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </label>
        </section>
    </div>
</fieldset>
<footer>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
</footer>
<?php $this->endWidget(); ?>
</div><!-- form -->