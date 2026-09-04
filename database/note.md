# Run manually
php protected/yiic dashboardSnapshot/generate

# Add to crontab for daily execution at 1:00 AM
0 1 * * * php /path/to/protected/yiic dashboardSnapshot/generate

The command iterates all institutions and snapshots: student/teacher counts, daily attendance, monthly income, 7-day attendance trend, class distribution, exam performance, fee collection, and income/expense trends.

Run SQL migration to create os_dashboard_snapshot table
Configure cache in protected/config/main.php:
'cache' => array(
    'class' => 'CDbCache',
),
Set up cron job for daily snapshot generation
Verify menu/ACL entries for Dashboard access

--------------
Deployment Checklist
Run SQL migration to create os_dashboard_snapshot table
Enable cache in protected/config/main.php:
'cache' => array('class' => 'CDbCache'),
Add menu entry in os_menu and os_menu_access for dashboard
Add ACL entries in os_acl for dashboard/index, dashboard/widgetData, dashboard/exportPdf
Set up cron job (optional):
0 1 * * * php /path/to/protected/yiic dashboardSnapshot/generate
Verify user group IDs in the dashboard JS role-based visibility code

---------------------
Next Steps
Enable cache in protected/config/main.php:
'cache' => array('class' => 'CDbCache'),
Generate initial snapshots:
php protected/yiic dashboardSnapshot/generate
Set up daily cron (optional):
0 1 * * * php /path/to/protected/yiic dashboardSnapshot/generate
65.1 t/s


