<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
        $this->load->model('login_model');
		handleLogin();
    }
	 
	public function index()
	{
		unset($_SESSION["attendanceAdmin"]);
			redirect(URL);
            exit();
	}
	
}
