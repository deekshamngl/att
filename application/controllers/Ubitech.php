
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ubitech extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
        $this->load->model('ubitech_model');
        $this->load->helper(array('form', 'url'));
    }
	 
	public function index()
	{
		$this->load->view('ubitech/login');
	}
	public function login(){
		    $res[]=array();
			$val=$this->ubitech_model->login();
			echo $val;
			
	}
	
	public function dashboard()
	{
		handleLoginAdmin();		
		$this->load->view('ubitech/dashboard');
	}
	////-------------------------------------slider
	public function slider(){
		handleLoginAdmin();		
		$this->load->view('ubitech/slider');
	}
	public function getSliderData()
	{
		handleLoginAdmin();		
		$this->ubitech_model->getSliderData();	
	}
	
	public function getleadOwnerData()
	{
		handleLoginAdmin();		
		$this->ubitech_model->getleadOwnerData();	
	}
	public function editSlider()
	{
		handleLoginAdmin();		
		$this->ubitech_model->editSlider();	
	}
	public function deleteSlider()
	{
		handleLoginAdmin();		
		$this->ubitech_model->deleteSlider();	
	}
	///////-----------------------------------/slider
	public function uploadimg()
	{
		handleLoginAdmin();		
		$this->ubitech_model->uploadimg(); 
		$this->load->view('ubitech/slider');
	}
	
	public function addleadowner()
	{
		handleLoginAdmin();		
		$this->ubitech_model->addleadowner();
	}
	public function changePassword()
	{
		handleLoginAdmin();	
		$this->load->view('ubitech/changePassword');
	}
	public function updatePassword()
	{
		handleLoginAdmin();	
		$this->ubitech_model->updatePassword();
	}
	public function logout()
	{
		handleLoginAdmin();		
		unset($_SESSION["attendanceAdmin"]);
		redirect(URL."ubitech");
        exit();
	}
	
	public function deleteSliderData(){
		handleLoginAdmin();		
		$this->ubitech_model->deleteSliderData();
		//$this->load->view('ubitech/slider');
	}
	
	
	public function deleteLeadOwnerData()
	{
		handleLoginAdmin();		
		$this->ubitech_model->deleteLeadOwnerData();
	}
	public function editSliderData(){
		handleLoginAdmin();		
		$this->ubitech_model->editSliderData();
		redirect(URL."ubitech/slider");
        exit();
	}

	public function preconfigured(){

         //handleLoginAdmin();	
		 $this->load->view('ubitech/preconfigured');

	}

	public function probability(){

         //handleLoginAdmin();	
		 $this->load->view('ubitech/probability');

	}
	public function automaticnotification(){

		$this->load->view('ubitech/automatic');
		
	}

	public function getautomaticdata(){
		handleLoginAdmin();
		$result = $this->ubitech_model->getautomaticdata();
	}
	// public function manualnotification(){

	// 	$this->load->view('ubitech/manualnotification');
		
	// }
	
	public function editLeadOwnerData()
	{
		$this->ubitech_model->editLeadOwnerData();
	}
	public function archiveOrg(){
		$this->ubitech_model->archiveOrg();	
	}
	public function archiveAllOrg(){
		$this->ubitech_model->archiveAllOrg();	
	}
	public function DeleteAllOrg(){
		$this->ubitech_model->DeleteAllOrg();	
	}
	public function updateleadownerorg(){
		$this->ubitech_model->updateleadownerorg();	
	}
	public function unarchiveOrg()
	{
		$this->ubitech_model->unarchiveOrg();	
	}
	public function notrenedOrg(){
		$this->ubitech_model->notrenedOrg();	
	}
	public function renedOrg(){
		$this->ubitech_model->renedOrg();	
	}
	public function archiveOrg_del(){
		$this->ubitech_model->archiveOrg_del();	
	}
	public function organization($val="")
	{
		handleLoginAdmin(); 
		$country_data['h'] = $this->ubitech_model->getCountries();
		$country_data['l'] = $this->ubitech_model->getleadowner();
		if($val == 'paid')
		$this->load->view('ubitech/paidorganization',$country_data);
	    else if($val == 'trial')
		$this->load->view('ubitech/trialorganization',$country_data);
	else if($val == 'addorg')
		$this->load->view('ubitech/addorg',$country_data);
        else if($val == 'expiretril')
		{
		 $this->load->view('ubitech/expireorganization',$country_data);
		}
        else if($val == 'extendtrial')
		{
			$this->load->view('ubitech/extendedtrialorganization',$country_data);
		}
        else if($val == 'notrenew')
		{
			$this->load->view('ubitech/notreneworganization',$country_data);
		}
		else if($val == 'active')
		{
			$this->load->view('ubitech/expireorganizationactive',$country_data);
		}
		else if($val == 'customized')
		{
			 $this->load->view('ubitech/customizedorganization',$country_data);			
		}else if($val == 'archive')
		{
			 $this->load->view('ubitech/archive',$country_data);			
		}
		else if($val == 'cleanedup')
		{
			 $this->load->view('ubitech/cleanedup',$country_data);			
		}
        else
           $this->load->view('ubitech/organization',$country_data);
	}
  public function sendMailInId()
  {
	  $this->ubitech_model->sendMailInId();
  }
	
	public function unsubscribe()
	{
		$country_data['h'] = $this->ubitech_model->getCountries();
		$this->load->view('ubitech/unsubscribe',$country_data);
	}
	public function getunsubscribe()
	{
		handleLoginAdmin();
		$this->ubitech_model->getunsubscribe();
	}
	public function archived(){
		handleLoginAdmin(); 
        $this->ubitech_model->getOrganizationData('archive');
	}
	
	public function cleanedup(){
		handleLoginAdmin(); 
        $this->ubitech_model->getOrganizationData('cleanedup');
	}
	public function getOrganizationData(){
		handleLoginAdmin(); 
        $this->ubitech_model->getOrganizationData('all');
	}
	public function paidgetOrganizationData(){
		handleLoginAdmin(); 
        $this->ubitech_model->getOrganizationData('paid');
	}
	public function trialgetOrganizationData(){
		handleLoginAdmin(); 
        $this->ubitech_model->getOrganizationData('trial');
        
	}
	public function expireOrganizationData(){
		handleLoginAdmin();
        $this->ubitech_model->getOrganizationData('expiretril');
        
	}
	public function extendTrialOrganizationData(){
		handleLoginAdmin(); 
// var_dump('hii');
        $this->ubitech_model->getOrganizationData('extendtrial');
        // $a=$_REQUEST['conttype'];
		// var_dump($a);
        
	}
	public function notRenewOrganizationData(){
		handleLoginAdmin(); 
        $this->ubitech_model->getOrganizationData('notrenew');
	}
	public function expiredOrganization()
	{
		handleLoginAdmin(); 
        $this->ubitech_model->getOrganizationData('subscriptionexpired');
	}
	public function customizedOrganizationData()
	{
		handleLoginAdmin(); 
        $this->ubitech_model->getOrganizationData('customized');
	}
	public function extrauserOrganization()
	{
		handleLoginAdmin(); 
		$country_data['h'] = $this->ubitech_model->getCountries();
		$this->load->view('ubitech/extrauserorganization',$country_data);
	}
	
	public function getExtrauserOrg()
	{
		handleLoginAdmin();
		$this->ubitech_model->getExtrauserOrg();
	}
	public function getPackageData(){
		handleLoginAdmin(); 
        $this->ubitech_model->getPackageData();
		exit();
		
	}

	public function activitylog()
	{
		$this->load->view('ubitech/actvitylog');
	}
	public function getactivitylog(){
		$this->ubitech_model->getactivitylog();	
	}
	


	public function registerOrganization(){
		handleLoginAdmin();
		$result = $this->ubitech_model->register_org();
		$this->load->view('ubitech/organization');
	}

	public function do_upload(){
		handleLoginAdmin();

if (!empty($_FILES['imgE']['name'])){
	$config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                       // echo "if";
                        //$this->load->view('upload_form', $error);
                }
                else
                {
                        
                       // echo "else";
                       // $this->load->view('upload_success', $data);

        $data = array('upload_data' => $this->upload->data());

        // print_r($data);
        // die;
		
		$result = $this->ubitech_model->addnotification();

		
           redirect('index.php/ubitech/preconfigured', 'refresh');
                }
            }
            else{

            	$result = $this->ubitech_model->addnotification();

		
           redirect('index.php/ubitech/preconfigured', 'refresh');
            }




		// $this->load->view('ubitech/preconfigured');
	}

public function editautomatic(){

				handleLoginAdmin();

                if (!empty($_FILES['imgE']['name'])){
			     $config['upload_path']          = './uploads/';
                
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('imgE'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                       // echo "if";
                        //$this->load->view('upload_form', $error);
                }
                else
                {
                   
		      $data = array('upload_data' => $this->upload->data());

		// print_r($data);

		$result = $this->ubitech_model->editautomatic();
	}
}
	else{
		$result = $this->ubitech_model->editautomatic();
	}

}

	public function editnotification(){
		handleLoginAdmin();

                if (!empty($_FILES['imgE']['name'])){
			     $config['upload_path']          = './uploads/';
                
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('imgE'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                       // echo "if";
                        //$this->load->view('upload_form', $error);
                }
                else
                {
                   
		      $data = array('upload_data' => $this->upload->data());

		// print_r($data);

		$result = $this->ubitech_model->editnotification();
	}
}
	else{
		$result = $this->ubitech_model->editnotification();
	}
	}
		 
		// $this->load->view('ubitech/preconfigured');
	
		public function deletenotification(){

			handleLoginAdmin();
		$result = $this->ubitech_model->deletenotification();

	}
	public function getconfiguredata(){
		handleLoginAdmin();
		$result = $this->ubitech_model->getconfiguredata();



	}
	public function add_admin()
	{
		handleLoginAdmin();
		$result = $this->ubitech_model->add_admin();
		$id =  $_REQUEST['orgid1'];
		redirect(URL."ubitech/editOrganizationData/".$id);
		echo $result;
	}
	 public function registerPackage(){
		handleLoginAdmin();
		$result = $this->ubitech_model->registerPackageData();
		$this->load->view('ubitech/package');
		
		//redirect(URL."ubitech/registerPackage/");
	}  
	// public function editOrganizationData(){
		// handleLoginAdmin();		
		// $this->ubitech_model->editOrganizationData();
		// redirect(URL."ubitech/organization");
        // exit();
	// }
	public function editOrganizationData($id,$pageid=''){
		handleLoginAdmin();
		$result['res'] = $this->ubitech_model->getallState();
		$result['data'] = $this->ubitech_model->editOrganizationData($id);
		$result['h'] = $this->ubitech_model->getCountries();
		$result['t'] = $this->ubitech_model->getTrialData($id);
		$result['e'] = $this->ubitech_model->getextendeddata($id);
		$result['l'] = $this->ubitech_model->getAllLeadData($id);
		$result['orgid'] =$id;
		$result['pageid'] =$pageid;
		$this->load->view('ubitech/editorganization',$result);
	}
	public function getUserData($id){
		handleLoginAdmin(); 
        $this->ubitech_model->getUserData($id);
	}
	public function editUserData($id)
	{
		handleLoginAdmin(); 
        $this->ubitech_model->editUserData();
		redirect(URL."ubitech/editOrganizationData/".$id);
        exit();
	}
	public function updateOrganizationData($id)
	{
		handleLoginAdmin(); 
        echo  $this->ubitech_model->updateOrganizationData($id);
		redirect(URL."ubitech/editOrganizationData/".$id);
        exit();
	}
	
	public function updateaddonspermission($id)
	{
		handleLoginAdmin(); 

        echo  $this->ubitech_model->updateaddonspermission($id);
		redirect(URL."ubitech/editOrganizationData/".$id);
        exit();
	}
	
	public function trial(){
		$this->ubitech_model->trial();	
	}
	
	public function extendsubs(){
		$this->ubitech_model->extendsubs();	
	}
	public function extendsubs1(){
		$this->ubitech_model->extendsubs1();	
	}
	public function buy(){
		$this->ubitech_model->buy();	
	}

	public function upgraderenew(){
		$this->ubitech_model->upgraderenew();	
	}
	public function upgradeboth(){
		$this->ubitech_model->upgradeboth();	
	}
	
	public function upgradeuser(){
		$this->ubitech_model->upgradeuser();	
	}
	
	public function updateLimit(){
		$this->ubitech_model->updateLimit();	
	}
	
	public function trial_setting(){
	  $result['result']= $this->ubitech_model->trial_setting();
	  $this->load->view('ubitech/trial_setting',$result);	
	}
	public function orginfo(){
	  $result['h'] = $this->ubitech_model->get_trial_days();
	  $this->load->view('ubitech/orginfo',$result);	
	}
	public function info(){
	  $data['i'] = $this->ubitech_model->getOrganization();
	  $this->load->view('ubitech/orginfo',$data);	
	}
	public function trial_days(){
		$this->ubitech_model->trial_days();
	}
	public function trial_users(){
		$this->ubitech_model->trial_users();
	}
	public function package(){
		 $this->load->view('ubitech/package');	
	}
public function packages(){
	 //$result['h'] = $this->ubitech_model->getstorepackage1();
	   $result['p'] = $this->ubitech_model->getstorepackage1();
		 $this->load->view('ubitech/packages',$result);	
	}	
	
	public function newpackages(){
	 //$result['h'] = $this->ubitech_model->getstorepackage1();
	   $result['p'] = $this->ubitech_model->newpackages();
		 $this->load->view('ubitech/newpackages',$result);	
	}	
	public function attDiscount(){
		$data['res']=$this->ubitech_model->getDiscount();
		$this->load->view('ubitech/attDiscount',$data);
		//echo json_encode($data['res'][0]);
	}
		
	public function updatePackageData(){
		handleLoginAdmin(); 
        $this->ubitech_model->updatePackageData();
        redirect(URL."ubitech/package/");
		exit();
	}
	public function setAppStorePath(){
	  $result['h'] = $this->ubitech_model->get_trial_days();
	   $result['p'] = $this->ubitech_model->getstorepath();
	  $this->load->view('ubitech/setappstorepath',$result);	
	}
	
	
	public function leadowner()
	{
	  handleLoginAdmin();		
		$this->load->view('ubitech/leadowner');
	}
	public function updatePath(){
		$this->ubitech_model->updatePath();
	}
	public function updatePackge1()
	{
		$this->ubitech_model->updatePackge1();
	}
	
	public function updateNewPackages(){
		echo $this->ubitech_model->updateNewPackages();
	}
	public function updateAddons(){
		
		echo $this->ubitech_model->updateAddons();
	}
	public function updateDiscountPackages()
	{
	$this->ubitech_model->updateDiscountPackages();
	}
	public function getPaymentHistory($orgid=0)
	{
		$arr=array();
		$arr['orgid']=$orgid;
		$this->load->view('ubitech/getpaymenthistory',$arr);	
	}
	
	public function paymentfailed($orgid=0)
	{
		$arr=array();
		$arr['orgid']=$orgid;
		$this->load->view('ubitech/failedtransaction',$arr);	
	}
	
	

	
	public function getSuccessfullPayment($val)
	{
		if($val=='all')
		{
			$this->load->view('ubitech/getsuccesspaymentall');
		}
		else if($val=='manual')
		{
			$this->load->view('ubitech/getsuccesspaymentmanual');
		}
		else if($val=='payumoney')
		{
			$this->load->view('ubitech/getsuccesspaymentpayumoney');
		}
		else if($val=='paypal')
		{
			$this->load->view('ubitech/getpaymentpaypal');
		}
	}
	public function getPaymentHistoryData($orgid=0)
	{
		$arr=array();
		$this->ubitech_model->getPaymentHistoryData($orgid);	
	}
	
	public function getPaymentFailedHistoryData($orgid=0)
	{
		$arr=array();
		$this->ubitech_model->getPaymentFailedHistoryData($orgid);	
	}
	
	public function getSuccessfulPaymentData($val)
	{
	  $this->ubitech_model->getSuccessfulPaymentData($val);	
	}
	public function gstreport($orgid=0)
	{
		$arr=array();
		$arr['orgid']=$orgid;
		$this->load->view('ubitech/gstreport',$arr);	
	}
	public function gstreportdata($val)
	{
	  $this->ubitech_model->gstreportdata($val);	
	}

	public function ReferenceAmount(){
	  $result['result']= $this->ubitech_model->ReferenceAmount();
	  $this->load->view('ubitech/ReferenceAmount',$result);	
	}

	public function getReferenceAmount(){
		$this->ubitech_model->getReferenceAmount();
}
}