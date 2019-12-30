
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Superadmin extends CI_Controller {
	 public function __construct()
		{
			parent::__construct();
			$this->load->model('Superadmin_model');
		}
	 public function index($val="")
		{
		$country_data['h'] = $this->Superadmin_model->getCountries();
		if($val == 'paid')
		$this->load->view('ubitech/paidorganization',$country_data);
	    else if($val == 'trial')
		$this->load->view('ubitech/trialorganization',$country_data);
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
        else
           $this->load->view('ubitech/pending',$country_data);
		}
		
	
	public function getOrganizationData(){
		handleLoginAdmin(); 
        $this->Superadmin_model->getOrganizationData('pendingall');
	}
}
