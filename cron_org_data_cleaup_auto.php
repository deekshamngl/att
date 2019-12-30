<?php 
// created by sohan for  cleaned up data of dead org(trial expeird 90 days ago: all data deleted but keep org info only)
$ch = curl_init("https://ubiattendance.ubihrm.com/index.php/cron/clean_expired_org_data");
curl_exec($ch);
curl_close($ch);
?>