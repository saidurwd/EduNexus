<?php
/* @var $this DashboardController */
/* @var $data array */
/* @var $institutionId int */
?>
<div class="jarviswidget" id="wid-dashboard-teachers-<?php echo $institutionId; ?>" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
    <header>
        <span class="widget-icon"> <i class="fa fa-user txt-color-green"></i> </span>
        <h2>Total Teachers</h2>
    </header>
    <div class="widget-body">
        <div class="big-stat">
            <span class="value"><?php echo number_format($data['teachers']); ?></span>
        </div>
    </div>
</div>
