<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Starter
 * Starter application for CodeIgniter 3
 * @package     Codeignitor Starter
 * @author      John Kiragu Mutua
 * @copyright   Copyright (c) 2017 - 2021, John Kiragu. (http://.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 */
 class User extends CI_Controller
 {

   function __construct()
   {
       parent::__construct();
       $this->load->model('validation_callables');
   }

   public function index(){
        $data = array();
        $data['mainContent'] = 'site/signup';
        $this->load->view('route',$data);
   }

   /**
    * Most minimal user creation. You will of course make your
    * own interface for adding users, and you may even let users
    * register and create their own accounts.
    * The password used in the $user_data array needs to meet the
    * following default strength requirements:
    *   - Must be at least 8 characters long
    *   - Must be at less than 72 characters long
    *   - Must have at least one digit
    *   - Must have at least one lower case letter
    *   - Must have at least one upper case letter
    *   - Must not have any space, tab, or other whitespace characters
    *   - No backslash, apostrophe or quote chars are allowed
    */
   public function create()
   {
       ///This becomes an authentication Model
       ///actually passes application validation_rules
       $this->load->library('authentication');
       $user_data = [
           'userName'   => 'kigsmtua',
           'password'     => 'PepeLePew7',
           'emailAddress'      => 'mutuakiragu@gmail.com',
           'passwordStatus' => 1,
           'userGroupID'=>3,
           'dateLastActive'=>date('Y-m-d H:i:s'),
           'datePasswordLastChanged'=> date('Y-m-d H:i:s'),
           'createdBy'=>1,
           'dateCreated'=>date('Y-m-d H:i:s')
       ];
       

   $this->form_validation->set_rules( $validation_rules );

   if( $this->form_validation->run() )
   {
           $user_data['password']     = $this->authentication->hash_passwd($user_data['password']);
           $user_data['userID']    = 1;
           // If username is not used, it must be entered into the record as NULL
           if( empty( $user_data['userName'] ) )
           {
               $user_data['userName'] = NULL;
           }
     $this->db->set($user_data)
       ->insert(config_item('user_table'));
     if( $this->db->affected_rows() == 1 )
       ////We are going to
       echo '<h1>Congratulations</h1>' . '<p>User ' . $user_data['userName'] . ' was created.</p>';
   }
   else
   {
     echo '<h1>User Creation Error(s)</h1>' . validation_errors();
   }
  }
 }
