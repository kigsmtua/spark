<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends MY_Model
{

  public $_table = 'users';

  public $primary_key = 'user_id';

  public $before_create = array( 'timestamps' ,'hashpassword');

  public $validate = array(
     
       array(
        'field' => 'username',
        'label' => 'Email Address',
        'rules' => 'max_length[12]|is_unique[' . 'users' . '.username]',
        'errors' => ['is_unique' => 'Username already in use.']
      ),
      array(
        
        'field' => 'passwd',
        'label' => 'password',
        'rules' => ['trim','required'],
        'errors' => ['required' => 'The password field is required.']
      ),
      array(

          'field'=>'email',
          'label'=>'email',
          'rules'  => 'trim|required|valid_email|is_unique['.'users'.'.email]',
          'errors' => ['is_unique' => 'Email address already in use.']
      ),
  );

  function __construct()
  {
     parent::__construct();
  
  }
 

  protected function timestamps($user)
    {
        $user['created_at'] = $user['modified_at'] = date('Y-m-d H:i:s');
        return $user;
    }

  protected function hashpassword($user)
    {
        $user['passwd'] = $this->authentication->hash_passwd($user['passwd']);
        return $user;
    }

}
