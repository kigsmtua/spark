<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Starter
 * Starter application for CodeIgniter 3
 * @package     CodeIgniter Starter Application
 * @author      John Kiragu Mutua
 * @copyright   Copyright (c) 2017 - 2021, John Kiragu. (http://.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 */


class Site extends MY_Controller
{
  

  function __construct()
  {
      parent::__construct();
  }

  public function index(){
 
     echo "This is the default page";
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
}
