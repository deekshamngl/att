<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_Controller {
	 public function __construct()
    {								
	    parent::__construct();
	    $this->load->model('Report_model');
		handleLogin();
    } 
	public function index()
	{
		$this->load->view('home/report');	
	}
	public function getEmployeesData(){
		
		$this->report_model->getEmployeesData();
	}
	public function getAbsent()
	{
		$this->report_model->getAbsent();	
	}
	
	function candidatebydate($sts=0)
    {
		$designation_model = $this->loadModel('Designation');
		$this->view->positions = $designation_model->getAllDesignationsBySts();
		$Dashboard_model = $this->loadModel('Dashboard');
		$this->view->schedule= $Dashboard_model->getTable($sts);
		$position = isset($_POST["position"])?$_POST["position"]:0;
		$candidate_model = $this->loadModel('Candidate');
		$this->view->positionid = $position;
        $this->view->position_name = $candidate_model->getName($position,"designation_table","designation_name","designation_id");
		$positionSts =isset($_POST['positionSts'])?($_POST['positionSts']):0;
		$startdate = isset($_POST["startdate"])?$_POST["startdate"]:"";
		$enddate = isset($_POST["enddate"])?$_POST["enddate"]:"";
		if($enddate=="")
		{
		$enddate=date("Y-m-d");
		}
		if($startdate=="")
		{
		$startdate=date('Y-m-d',(strtotime ( '-30 day',strtotime(date('Y-m-d'))) ));
		}
		$this->view->startdate=$startdate;
		$this->view->enddate=$enddate;
		$this->view->positionSts=$positionSts;
		$this->view->render('reports/candidatebydate');
    }
	public function EmployeesWiseReport()
	{
		  $this->load->view('home/EmployeesWiseReport');
		//$this->Report_model->getEmployeesWiseReport();
		//$this->Admin_model->getDepartmentReport();
	}
	public function getEmployeesWiseReport()
	{
		 // $this->load->view('home/EmployeesWiseReport');
		$this->Report_model->getEmployeesWiseReport();
		//$this->Admin_model->getDepartmentReport();
	}
	
	
}
