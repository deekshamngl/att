<?php

/**
 * Class Dashboard
 * This is a demo controller that simply shows an area that is only visible for the logged in user
 * because of Auth::handleLogin(); in line 19.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Approvalbymail extends CI_Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Leaveapproval_model');
        // this controller should only be visible/usable by logged in users, so we put login-check here
       // Auth::handleLogin();
    }

    /**
     * This method controls what happens when you move to /dashboard/index in your app.
     */


	function viewapprovetimeoffapproval($user_id=1,$org_id=10,$employeetimeoffid=1,$approverresult=0)
	{
		
		try{


			$ptoff=$this->Leaveapproval_model->getpreviousTimeOffApprovalSts($user_id,$org_id,$employeetimeoffid);
			$gtos=$this->Leaveapproval_model->getTimeOffApprovalSts($employeetimeoffid);
			
			$arr = array('uid'=> $user_id, 'orgid' => $org_id, 'timeoffid' => $employeetimeoffid, 'approverresult' => $approverresult , 'ptoff' => $ptoff, 'gtos'=>$gtos);
			// $this->view->userid = $arr[0] = $user_id;
			// // $user_id = 
			// $this->view->org_id = $arr[1] = $org_id;
			// $this->view->employeetimeoffid = $arr[2] = $employeetimeoffid;
			// $this->view->approverresult = $arr[3] = $approverresult;
			// $arr[4] = "";
			// $arr[5] = "";
			// $dept = $this->loadModel('Leaveapproval');
			
			
			//$this->view->appSts = true;
			$this->load->view('leave/timeoff/approvetimeoffbymail',$arr);
		
			//echo json_encode($deptarray);	
			//echo $deptarray['successMsg'];
			//echo "<h3>" .$deptarray['successMsg']. "</h3>";
		}catch(Exception $e){
			Trace($e->getMessage());
		}
	}
	
	
		
}
