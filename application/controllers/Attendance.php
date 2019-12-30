<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Attendance extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
        $this->load->model('Attendance_model');
		handleLogin();
    }
	public function index()	
	{	
		$deprt['id']=isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$this->load->view('home/empOutLocation',$deprt);
	}
	public function getOutLocationEmp()
	{
	  $this->Attendance_model->getOutLocationEmp();	
	}
	public function getWeeklyAverageSummary($type) 
	{
	 $this->Attendance_model->getWeeklyAverageSummary($type);
	}
	
	public function getMonthlyAverageSummary($type) 
	{
	 $this->Attendance_model->getMonthlyAverageSummary($type);
	}
	public function attendanceOutsideThefencedArea()
	{
		$this->Attendance_model->attendanceOutsideThefencedArea();
	}
	
	
}
