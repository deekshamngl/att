<?php

/**
 * LeaveModel
 * This is basically a simple CRUD (Create/Read/Update/Delete) demonstration.
 */
class Leaveapproval_model extends CI_Model
{
    /**
     * Constructor, expects a Database connection
     * @param Database $db The Database object
     */
    // public function __construct(Database $db)
    // {
    //     $this->load->database($db);
    // }

    /**
     * Get method for fetching the records of department
     * @return array an array with several objects (the results)
     */
   public function getpreviousTimeOffApprovalSts($user_id,$org_id,$employeetimeoffid){
			$sql1 = "select * from TimeoffApproval WHERE TimeofId =? AND ApproverId=? and OrganizationId=?";
			$query1 = $this->db->query($sql1,array( $employeetimeoffid,$user_id,$org_id));
			// $query1->execute(array( $employeetimeoffid,$user_id,$org_id));
			// $con=$query1->rowCount();
			$count1= $this->db->affected_rows();
			$ApproverSts=3;
			if($r=$query1->result()){
				$ApproverSts=$r->ApproverSts;
			}
			return $ApproverSts;
			var_dump($this->db->last_query());
		}
		
		/// to show timeoff status
		public function getTimeOffApprovalSts($employeetimeoffid){
			$sql1 = "select * from  Timeoff WHERE 	Id =? ";
			$query1 = $this->db->query($sql1,array( $employeetimeoffid));
			// $query1->execute(array( $employeetimeoffid));
			// $con=$query1->rowCount();
			$count1= $this->db->affected_rows();
			$ApproverSts='';
			if($r=$query1->result()){
				$ApproverSts=$r->ApprovalSts;
			}
			return $ApproverSts;
			
		}
	
	
		}
