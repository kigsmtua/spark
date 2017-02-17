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

 class Dashboard extends MY_Controller
 {

   function __construct()
   {
       parent::__construct();

   }

   function index(){
     $data = array();
     $data['mainContent']='dashboard';
     $this->load->view('route',$data);
  }
 }
