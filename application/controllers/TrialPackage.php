<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TrialPackage extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
        $this->load->model('TrialPackage_model');
    } 
	public function index()	
	{  
	   $this->TrialPackage_model->TrialExpired();	   
	}
}
