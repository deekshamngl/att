<?php
class TrialPackage_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
    }

    function TrialExpired(){
		$CurrentDate = date('Y-m-d');
		
		//$query1 = $this->db->query("select end_date,OrganizationId,DATEDIFF(end_date,'$CurrentDate') AS daysremain from licence_ubiattendance where DATEDIFF(end_date,'$CurrentDate') = 7 OR DATEDIFF(end_date,'$CurrentDate') = 5 OR DATEDIFF(end_date,'$CurrentDate') = 2 OR DATEDIFF(end_date,'$CurrentDate') = 0 OR DATEDIFF(end_date,'$CurrentDate') = -2");
		$query1 = $this->db->query("select OrganizationId,(select Email from Organization where Id = OrganizationId) as email,DATEDIFF(end_date,'$CurrentDate') AS daysremain from licence_ubiattendance where DATEDIFF(end_date,'$CurrentDate') = 7 OR DATEDIFF(end_date,'$CurrentDate') = 5 OR DATEDIFF(end_date,'$CurrentDate') = 2 OR DATEDIFF(end_date,'$CurrentDate') = 0 OR DATEDIFF(end_date,'$CurrentDate') = -2");
		
		foreach ($query1->result_array() as $row1)
		{	
		     $daysremain = $row1['daysremain']; 	   
			 $email = $row1['email'];
              if($email != ""){			 
				 $to = $email;
				 $subject = "My subject";
				 $txt = "Hello world!";
				 $headers = "From: webmaster@example.com" . "\r\n" .
				 "CC: somebodyelse@example.com";
				 mail($to,$subject,$txt,$headers);
			  }			 
		}
				
	} 	
}
?>