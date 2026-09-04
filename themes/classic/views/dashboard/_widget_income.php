<?php
/* @var $this DashboardController */
/* @var $data array */
/* @var $institutionId int */
?>
<div class="jarviswidget" id="wid-dashboard-income-<?php echo $institutionId; ?>" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
    <header>
        <span class="widget-icon"> <i class="fa fa-money txt-color-purple"></i> </span>
        <h2>Monthly Income</h2>
    </header>
    <div class="widget-body">
        <div class="big-stat">
            <span class="value">$<?php echo number_format($data['monthly_income'], 2); ?></span>
        </div>
    </div>
</div>
