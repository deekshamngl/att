<?php

/**
 * LeaveModel
 * This is basically a simple CRUD (Create/Read/Update/Delete) demonstration.
 */
class LeaveapprovalModel
{
    /**
     * Constructor, expects a Database connection
     * @param Database $db The Database object
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Get method for fetching the records of department
     * @return array an array with several objects (the results)
     */
   public function getpreviousTimeOffApprovalSts($user_id,$org_id,$employeetimeoffid){
			$sql1 = "select * from TimeoffApproval WHERE TimeofId =? AND ApproverId=? and OrganizationId=?";
			$query1 = $this->db->prepare($sql1);
			$query1->execute(array( $employeetimeoffid,$user_id,$org_id));
			$con=$query1->rowCount();
			$ApproverSts=3;
			if($r=$query1->fetch()){
				$ApproverSts=$r->ApproverSts;
			}
			return $ApproverSts;
		}
		
		/// to show timeoff status
		public function getTimeOffApprovalSts($employeetimeoffid){
			$sql1 = "select * from  Timeoff WHERE 	Id =? ";
			$query1 = $this->db->prepare($sql1);
			$query1->execute(array( $employeetimeoffid));
			$con=$query1->rowCount();
			$ApproverSts='';
			if($r=$query1->fetch()){
				$ApproverSts=$r->ApprovalSts;
			}
			return $ApproverSts;
		}
	
	
		}
