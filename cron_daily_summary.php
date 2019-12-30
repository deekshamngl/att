<?php 
// created by vijay for send the daily attendance daily data to the org head
$ch = curl_init("https://ubiattendance.ubihrm.com/index.php/cron/getalertOrg");
curl_exec($ch);
curl_close($ch);
?>