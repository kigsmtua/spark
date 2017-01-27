<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Starter
 * Starter application for CodeIgniter 3
 * @package     Community Auth
 * @author      John Kiragu Mutua
 * @copyright   Copyright (c) 2017 - 2021, John Kiragu. (http://.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 */

///@TODO Make sure  application values that a
class Site extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
  }


  public function index(){

  }
  public function login(){
    $this->load->library('authentication');
    $data = array();
    $data['mainContent'] = 'site/login';
    $this->load->view('route',$data);
  }

  public function about(){
    $data = array();
    $data['mainContent'] = 'site/pages/about';
    $this->load->view('route',$data);
  }

  public function contact(){
    $data = array();
    $data['mainContent'] = 'site/pages/contact';
    $this->load->view('route',$data);
  }

  public function logout(){

    $this->load->library('authentication');
    $this->authentication->logout();
    $redirect_protocol = USE_SSL ? 'https' : NULL;
    redirect( site_url( LOGIN_PAGE . '?logout=1', $redirect_protocol ) );
  }
}
