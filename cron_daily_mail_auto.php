<?php 
// created by deeksha for  testing mail automation of trial customers)
clearstatcache(); 
$url='https://ubiattendance.ubihrm.com/index.php/cron/sendTrialOrgMail';
$ch = curl_init($url);
$data='';
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
mail('deeksha@ubitechsolutions.com','ubiattendance auto Cron Notify Response',$response);
?>