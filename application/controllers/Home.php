<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	 public function __construct()
    {
        parent::__construct();
		$this->load->helpers('auth');
		//echo encrypt('ubipass');
		//handleLogin();
    }
	 
	public function index(){
		//echo 'home controller';
		//$this->load->view('home');
	}

public function priya(){

	$this->load->view('leave/timeoff/priya.php');
}
}