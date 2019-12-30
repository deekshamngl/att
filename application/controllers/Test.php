<?php

class Test extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
        
    } 
	public function index()
	{
		$address = "Kathmandu, Nepal";
        $formattedAddr = str_replace(' ','+',$address);
        //Send request and receive json data by address
        $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
        $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        $data['latitude']  = $output->results[0]->geometry->location->lat; 
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
        if(!empty($data)){
            return $data;
        }else{
            return false;
        } 
	    	/*echo file_get_contents('http://216.239.37.99/');
           echo file_get_contents('http://www.google.com/');*/

	}
}
