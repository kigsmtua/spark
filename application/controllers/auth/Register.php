<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Do all the registeration action based on this work
 */
class Register extends MY_Controller
{
  
  function __construct()
  {
     parent::__construct();
  }

  public function index(){
   
      $data = array();
      $data['mainContent'] = 'auth/register';
      $this->load->view('route',$data);
  }

  public function store(){
    

  }

}