<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends MY_Controller
{
  

  function __construct()
  {
     parent::__construct();
  }
  
  public function index(){

    $this->load->library('authentication');
    if( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' )
        $this->require_min_level(1);
    $this->setup_login_form();
    $data = array();
    $data['mainContent'] = 'auth/login';
    $this->load->view('route',$data);
  }
  
  public function destroy(){
    $this->load->library('authentication');
    $this->authentication->logout();
    $redirect_protocol = USE_SSL ? 'https' : NULL;
    redirect( site_url( LOGIN_PAGE . '?logout=1', $redirect_protocol ) );
  }
}