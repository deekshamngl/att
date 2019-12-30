<?php 
/*
	This cron made by vijay.
	Working: get and mail the list of organization about to expire their subscription of ubiAttenedance. (cron mail the list of org exp by today-2,today-1,today,today+1,today+2)
*/
$ch = curl_init("https://ubiattendance.ubihrm.com/index.php/Cron/getOrgListAboutToExpire");
curl_exec($ch);
curl_close($ch);



/*
	This cron made by vijay.
	Working: send the mail for Track  Employees with customized Attendance Reports the org which has registered their first emp last day.
	AND
	What more you get in the paid account : on third day of first emp registreration
*/
/*              // get is stopped by nagendra
 $ch = curl_init("https://ubiattendance.ubihrm.com/index.php/Cron/sendRoutineMail");
curl_exec($ch);
curl_close($ch);
*/

?>