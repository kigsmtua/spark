<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Keep It simple Stupid
 */
class Register extends MY_Controller
{
  
  
  function __construct()
  {
     parent::__construct();
     $this->load->model('user_model','user');
  }

  public function index(){
      $data = array();
      $data['mainContent'] = 'auth/register';
      $this->load->view('route',$data);
  }

  public function store(){
     $data = array();
     $data['username'] = $this->input->post('username');
     $data['email'] = $this->input->post('email');
     $data['passwd'] = $this->input->post('password');
     $data['auth_level'] = 1;
     $data['banned'] = '0';
     $insert = $this->user->insert($data);
     if($insert){
         

       
     }else{
        redirect('auth/register');
     }
    
  }

}