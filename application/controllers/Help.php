<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Help
 * The help area
 */
class Help extends CI_Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    
	public function __construct()
    {
	    parent::__construct();
       // $this->load->model('admin_model');
		handleLogin();
    } 

    /**
     * This method controls what happens when you move to /help/index in your app.
     */
    function index()
    {
       // $this->view->render('help/index');
		$this->load->view('help/index');
    }
	function helpnav()
	{
		//$this->view->render('home/help');
		$this->load->view('home/help');			
	}
}
