<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Login extends MY_Controller
{
  
  function __construct(argument)
  {
     ##There will be many errors
     ##That  will occur here and 
     ##Pass the main application value
     parent::__construct();
  }

  
  ##This means the index function of the application  comes actually here
  ##To actually be based on this implementation
  public function index(){
    $this->load->library('authentication');
    if( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' )
        $this->require_min_level(1);
    $this->setup_login_form();
    $data = array();
    $data['mainContent'] = 'site/login';
    $this->load->view('route',$data);
  }

  ##Kill the session and redirect
  ##The  user to the login page
  public function destroy(){


  }
}