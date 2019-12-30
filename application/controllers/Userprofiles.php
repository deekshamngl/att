	<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Userprofiles extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
        $this->load->model('login_model');
        $this->load->model('userprofiles_model');
		handleLogin();
    } 
	 public function index()
	{		//$res=array();
		 //$res['data'] = $this->userprofiles_model->getgeolocations();
		 //print_r($res);
		$this->load->view('home/userprofiles');	
	} 
	public function emportUploads(){
		$orgid =$_SESSION['orgid']; 
        $inputFileName=isset($_FILES["proposalfile"]["tmp_name"])?$_FILES["proposalfile"]["tmp_name"]:"";
		//$ext = end((explode(".", $inputFileName))); 
		$storage_name="newjoining.csv";
		//unlink("uploads/employee/$orgid"); 
		
		if (file_exists("uploads/employee/$orgid/$storage_name"))
			{ 
			unlink("uploads/employee/$orgid/$storage_name"); 
			}
		if (!file_exists("uploads/employee/$orgid/")) 
		{
				mkdir("uploads/employee/$orgid/",0755, true);
			}
		 $location="uploads/employee/$orgid/";
		 $config['upload_path'] = $location;
         $config['allowed_types'] = 'csv';    
		 $config['file_name'] = $storage_name; 
         $this->load->library('upload', $config);
         
        if (!$this->upload->do_upload('proposalfile'))
        {
          echo ($this->upload->display_errors());
            //$this->load->view('home/import', $error);
        }
        else
        {
            echo json_encode($this->upload->data());
           // $this->load->view('home/import', $data);
        } 
        
    }
	
	public function emport($id)
	{
		$data = array('pageid'=>$id);
		$this->load->view('home/import',$data);
	} 
	 public function inctiveemp()
		{
		$this->load->view('home/userprofiles1');	
		} 
	public function approvetimeoff()
	{
		$this->load->view('home/approvetimeoff');
	}
	public function getTimeoffs()
	{
		$this->userprofiles_model->getTimeoffs();
	}
	public function updatetimeoff()
	{
		$this->userprofiles_model->updatetimeoff();
	}
	public function approvetimeleave()
	{
		$this->load->view('home/approvetimeleave');
	}
	public function getLeaves()
	{
		$this->userprofiles_model->getLeaves();
	}
	
		public function getHourlyRate()
	{
		$this->userprofiles_model->getHourlyRate();
	}
	
		
	public function updateleave()
	{
		$this->userprofiles_model->updateleave();
	}
public function unarchiveallemp()
	{
	  $this->userprofiles_model->unarchiveallemp();
	}
	
	public function deleteallemp_permanent(){
		$this->userprofiles_model->deleteallemp_permanent();
	}
	/* public function index()
	{
		 $data['earlyEmployee'] = $this->login_model->getEarlyEmploy();
		$this->load->view('home/Earlydash',$data);	
	}  */
	public function showTMP(){
		$this->load->view('home/showTMP');
	}
	public function getEmpotTmp(){
		$data=$this->userprofiles_model->getEmpotTmp();
		//print_r($data);
	}
	public function getEmployeesData(){
		if($_SESSION['orgid']=='38135')
		{
			$this->userprofiles_model->getEmployeesData_testing();
		}
		$this->userprofiles_model->getEmployeesData();
	}
	public function getEmployeesDataInact(){
		
		$this->userprofiles_model->getInactiveEmpData();
		//$this->load->view('home/userprofiles1');	
	}
	public function deleteTmp(){
		$this->userprofiles_model->deleteTmp();
	}
	public function getCity(){
		$this->userprofiles_model->getCity();
		
	}
	public function insertUsermaster()
	{
	
		$this->userprofiles_model->insertUsermaster();
		// var_dump($this->db->last_query());
		// die;
	}
	
	public function emportEmp()
	{
		$arr = array();  
		$arr[0] =isset($_REQUEST['fname'])?($_REQUEST['fname']):0;
		// $arr[1]= isset($_REQUEST['lname'])?($_REQUEST['lname']):0;
		$arr[2]= isset($_REQUEST['email'])?($_REQUEST['email']):0;
		$arr[3]=isset($_REQUEST['cont'])? ($_REQUEST['cont']):0;
		$arr[4]= isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
		$arr[5]= isset($_REQUEST['dept'])?$_REQUEST['dept']:0;
		$arr[6]= isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
		//$arr[7]=isset($_REQUEST['cont'])?($_REQUEST['cont']):0;
		$arr[7]=isset($_REQUEST['ecode'])?$_REQUEST['ecode']:0;
		$arr[8]=isset($_REQUEST['country'])?$_REQUEST['country']:0;
		//print_r($arr);
		$result=$this->userprofiles_model->emportEmp($arr);
		echo json_encode($result);
		var_dump($this->db->last_query());
		die();
	}
	public function editUsermaster(){
		$this->userprofiles_model->editUsermaster();
	}
	
	public function deleteimg(){
		$this->userprofiles_model->deleteimg();
	}
	public function editshifts()
	{
	$this->userprofiles_model->editshifts();
	//echo json_encode($res);
	}
	
	public function editgeolocation()
	{
	$this->userprofiles_model->editgeolocation();
	}
	public function editdesignation()
	{
	$this->userprofiles_model->editdesignation();
	}
	
	public function editdepartment()
	{
	$this->userprofiles_model->editdepartment();
	}
	public function QRcode()
	{
		$Id = $_REQUEST['favorite'];
		$adata=$this->userprofiles_model->QRcode($Id);
		$data = array('adata'=>$adata);
		$this->load->view("home/qrcode",$data);
	}
	public function deleteUser(){
		$this->userprofiles_model->deleteUser__New();
	}
	public function updateUserStatus(){
		$this->userprofiles_model->updateUserStatus();
	}
	public function resetPassword()
	{
		$this->userprofiles_model->resetPassword();
	}
    public function archiveemployee()
	{
		$this->load->view('home/archiveemp');
	}
	public function getArchiveEmp()
	{
	  $this->userprofiles_model->getArchiveEmp();
	}
	public function UnarchiveUser()
	{
	  $this->userprofiles_model->UnarchiveUser();
	}
	public function deleteUserpermanent__New()
	{
		$this->userprofiles_model->deleteUserpermanent__New();
	}
	public function addemployee()
	{
		$this->load->view("home/addemployee");
	}
	public function monthlyreport()
	{
		$this->load->view("home/monthreport");
	}
	public function Testreport()
    {
		$this->userprofiles_model->Testreport();
	}
	public function departmentreport()
    {
		$this->userprofiles_model->departmentreport();
	}
	public function alldatareport($empid)
	{
		$data = array("empid"=>$empid);
		$this->load->view("home/alldatareport",$data);
	}
	
}
