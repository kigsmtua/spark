<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Login extends MY_Controller
{
  
  function __construct(argument)
  {
     parent::__construct();
  }

  
  public function index(){
    $this->load->library('authentication');
    if( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' )
        $this->require_min_level(1);
    $this->setup_login_form();
    $data = array();
    $data['mainContent'] = 'site/login';
    $this->load->view('route',$data);
  }
  
  ##Put it in simple terms all 
  ##Values will actually be used for all value
  public function destroy(){
    $this->load->library('authentication');
    $this->authentication->logout();
    $redirect_protocol = USE_SSL ? 'https' : NULL;
    redirect( site_url( LOGIN_PAGE . '?logout=1', $redirect_protocol ) );
  }
}