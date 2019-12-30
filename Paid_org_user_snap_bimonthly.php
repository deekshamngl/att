<?php 
// created by vijay for  send monthly employees summary report for all paid org's to the super admin
$ch = curl_init("https://ubiattendance.ubihrm.com/index.php/cron/org_user_snap");
curl_exec($ch);
curl_close($ch);
?>