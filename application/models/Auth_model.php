<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Authentication functions for CodeIgniter
 */
class Auth_model extends MY_Model
{

   ///Why the hell is this an error???
   ///@TODO figure out why that is the case
   public $_table = config_item('user_table');
  /**
   * Check the user table to see if a user exists by username or email address.
   * While this query is rather limited, you could easily join with
   * other custom tables, and return specific user profile data.
   *
   * @param   string  either the username or email address of a user
   * @return  mixed   either query data as object or FALSE
   */
   function get_user_data($identification_string){

       ///Select the folowing columns for authentication
       $selected_columns = [
         'userName',
         'emailAddress',
         'passwordStatus',
         'userID',
         'password',
         'userGroupID',
         'dateLastActive',
         'datePasswordLastChanged'
       ];

       $query = $this->db->select( $selected_columns )
   			->from( config_item('user_table') )
   			->where( 'LOWER( userName ) =', strtolower( $identification_string ) )
   			->or_where( 'LOWER( emailAddress ) =', strtolower( $identification_string ) )
   			->limit(1)
   			->get();

      if($query->num_rows()==1){
            ///We have exactly one user
            ///This becomes a long process for such
            ///application values

      }
   }
}
