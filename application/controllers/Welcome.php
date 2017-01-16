<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

  /**
	 ** Initial implementation
	 ** @TODO Clean up and build smarter implementation
	 ** For this application and comes up with all values
	 **/
	public function index()
	{
	  	$data = array();
		  $data['mainContent'] = 'welcome_message';
	  	$this->load->view('route',$data);
	}

	public function dashboard(){

		$data = array();
		$data['mainContent'] = 'dashboard';
		$this->load->view('route',$data);

	}
}
