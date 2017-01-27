<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Authentication functions for CodeIgniter
 */
class Auth_model extends MY_Model
{
  /**
   * Check the user table to see if a user exists by username or email address.
   * While this query is rather limited, you could easily join with
   * other custom tables, and return specific user profile data.
   * @param   string  either the username or email address of a user
   * @return  mixed   either query data as object or FALSE
   */
   function get_user_data($identification_string){
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
           $row = $query->row_array();
           ///$acl = $this->add_acl_to_auth_data( $row['user_id'] );
           return (object) $row;
       }
       return FALSE;
   }
   // --------------------------------------------------------------
   // --------------------------------------------------------------
   /**
    * Return the user agent info for login update
    */
   protected function _user_agent()
   {
     $this->load->library('user_agent');

     if( $this->agent->is_browser() ){
       $agent = $this->agent->browser() . ' ' . $this->agent->version();
     }else if( $this->agent->is_robot() ){
       $agent = $this->agent->robot();
     }else if( $this->agent->is_mobile() ){
       $agent = $this->agent->mobile();
     }else{
       $agent = 'Unidentified User Agent';
     }

     $platform = $this->agent->platform();

     return $platform
       ? $agent . ' on ' . $platform
       : $agent;
   }

    //@TODO write query to fetch all
    //Values that are required for permissions module
   function get_acl_data($user_id){
        ///Actions  that can be perfomed
   }
   // --------------------------------------------------------------
   /**
    * Update the user's user table record when they login
    *
    * @param  array  the user's user table data
    * @param  string  the login time in MySQL format
    * @param  array  the session ID
    * @Brilliant idea what happens for this idea
    */
   public function login_update( $user_id, $login_time, $session_id )
   {
     if( config_item('disallow_multiple_logins') === TRUE )
     {
       $this->db->where( 'userID', $user_id )
         ->delete( config_item('auth_sessions_table') );
     }
     $data = ['dateLastActive' => $login_time];
     $this->db->where( 'userID' , $user_id )
       ->update( config_item('user_table') , $data );
     $data = [
       'id'         => $session_id,
       'user_id'    => $user_id,
       'login_time' => $login_time,
       'ip_address' => $this->input->ip_address(),
       'user_agent' => $this->_user_agent()
     ];
     $this->db->insert( config_item('auth_sessions_table') , $data );
   }

   // -----------------------------------------------------------------------

   /**
    * Check user table and confirm there is a record where:
    *
    * 1) The user ID matches
    * 2) The login time matches
    *
    * If there is a matching record, return a specified subset of the record.
    *
    * @param   int     the user ID
    * @return  string  the login time in MySQL format
    */
   public function check_login_status( $user_id, $login_time )
   {
     $selected_columns = [
       'u.userName',
       'u.emailAddress',
       'u.auth_level',
       'u.user_id',
       'u.banned'
     ];
     $this->db->select( $selected_columns )
       ->from( config_item('user_table') . ' u' )
       ->join( config_item('auth_sessions_table') . ' s', 'u.user_id = s.user_id' )
       ->where( 's.user_id', $user_id )
       ->where( 's.login_time', $login_time );
     if( is_null( $this->session->regenerated_session_id ) )
     {
       $this->db->where( 's.id', $this->session->session_id );
     }
     // If it was regenerated, we can only compare the old session ID for this request
     else
     {
       $this->db->where( 's.id', $this->session->pre_regenerated_session_id );
     }
     $this->db->limit(1);
     $query = $this->db->get();
     if( $query->num_rows() == 1 )
     {
       $row = $query->row_array();
       // @TODO add this ACL query(access control limit query )
       ///$acl = $this->add_acl_to_auth_data( $row['user_id'] );
       return (object) $row;
     }
     return FALSE;
   }

   /**
    * Update a user's user record session ID if it was regenerated
    */
   public function update_user_session_id( $user_id )
   {
     if( ! is_null( $this->session->regenerated_session_id ) )
     {
       $this->db->where( 'user_id', $user_id )
         ->where( 'id', $this->session->pre_regenerated_session_id )
         ->update(
           config_item('auth_sessions_table'),
           ['id' => $this->session->regenerated_session_id]
       );
     }
   }

   // -----------------------------------------------------------------------

 	/**
 	 * Clear user holds that have expired
 	 */
 	public function clear_expired_holds()
 	{
 		$expiration = date('Y-m-d H:i:s', time() - config_item('seconds_on_hold') );

 		$this->db->delete( config_item('IP_hold_table'), ['time <' => $expiration] );

 		$this->db->delete( config_item('username_or_email_hold_table'), ['time <' => $expiration] );
 	}

  // --------------------------------------------------------------

	/**
	 * Clear login errors that have expired
	 */
	public function clear_login_errors()
	{
		$expiration = date('Y-m-d H:i:s', time() - config_item('seconds_on_hold') );

		$this->db->delete( config_item('errors_table'), ['time <' => $expiration] );
	}

  // --------------------------------------------------------------

	/**
	 * Check that the IP address, username, or email address is not on hold.
	 *
	 * @param   bool   if check is from recovery (FALSE if from login)
	 * @return  bool
	 */
	public function check_holds( $recovery )
	{
		$ip_hold = $this->check_ip_hold();

		$string_hold = $this->check_username_or_email_hold( $recovery );

		if( $ip_hold === TRUE OR $string_hold === TRUE )
			return TRUE;

		return FALSE;

	}

  /**
	 * Check that the IP address is not on hold
	 *
	 * @return  bool
	 */
	public function check_ip_hold()
	{
		$ip_hold = $this->db->get_where(
			config_item('IP_hold_table'),
			['ip_address' => $this->input->ip_address()]
		);

		if( $ip_hold->num_rows() > 0 )
			return TRUE;

		return FALSE;
	}


  // --------------------------------------------------------------

  /**
   * Check that the username or email address is not on hold
   * @param   bool   if check is from recovery (FALSE if from login)
   * @return  bool
   */
  public function check_username_or_email_hold( $recovery )
  {
    $posted_string = ( ! $recovery )
      ? $this->input->post( 'login_string' )
      : $this->input->post( 'email', TRUE );

    // Check posted string for basic validity.
    if( ! empty( $posted_string ) && strlen( $posted_string ) < 256 )
    {
      $string_hold = $this->db->get_where(
        config_item('username_or_email_hold_table'),
        ['username_or_email' => $posted_string]
      );

      if( $string_hold->num_rows() > 0 )
        return TRUE;
    }

    return FALSE;
  }


  // --------------------------------------------------------------
	/**
	 * Insert a login error into the database
	 *
	 * @param  array  the details of the login attempt
	 */
	public function create_login_error( $data )
	{
		$this->db->set( $data )
			->insert( config_item('errors_table') );
	}

  // --------------------------------------------------------------

  /**
   * Check login errors table to determine if a IP address, username,
   * or email address should be placed on hold.
   *
   * @param  string  the supplied username or email address
   */
  public function check_login_attempts( $string )
  {
    $ip_address = $this->input->ip_address();

    // Check if this IP now has too many login attempts
    $count1 = $this->db->where( 'ip_address', $ip_address )
      ->count_all_results( config_item('errors_table') );

    if( $count1 == config_item('max_allowed_attempts') )
    {
      // Place the IP on hold
      $data = [
        'ip_address' => $ip_address,
        'time'       => date('Y-m-d H:i:s')
      ];

      $this->db->set( $data )
        ->insert( config_item('IP_hold_table') );
    }

    /**
     * If for some reason login attempts exceed
     * the max_allowed_attempts number, we have
     * the option of banning the user by IP address.
     */
    else if(
      $count1 > config_item('max_allowed_attempts') &&
      $count1 >= config_item('deny_access_at')
    )
    {
      /**
       * Send email to admin here ******************
       * Good idea actually implement the email sending
       * At this point we love the implementation variables
       * All this values have nothing that comes up here
       */

      if( config_item('deny_access_at') > 0 )
      {
        // Log the IP address in the denied_access database
        $data = [
          'ip_address'  => $ip_address,
          'time'        => date('Y-m-d H:i:s'),
          'reason_code' => '1'
        ];
        $this->_insert_denial( $data );
        // Output white screen of death
        header('HTTP/1.1 403 Forbidden');
        die();
      }
    }
    /**
     * Initialize variable to show total of failed
     * login attempts where username or email logged
     */
    $count2 = 0;
    // Check to see if this username/email-address has too many login attempts
    if( $string != '' )
    {
      $count2 = $this->db->where( 'username_or_email', $string )
        ->count_all_results( config_item('errors_table') );

      if( $count2 == config_item('max_allowed_attempts') )
      {
        // Place the username/email-address on hold
        $data = [
          'username_or_email' => $string,
          'time'              => date('Y-m-d H:i:s')
        ];

        $this->db->set( $data )
          ->insert( config_item('username_or_email_hold_table') );
      }
    }
    return max( $count1, $count2 );
  }


  // --------------------------------------------------------------

  /**
   * Get all data from the denied access table,
   * or set the field parameter to retrieve a single field.
   */
  public function get_deny_list( $field = FALSE )
  {
    if( $field !== FALSE )
      $this->db->select( $field );

    $query = $this->db->from( config_item('denied_access_table') )->get();

    if( $query->num_rows() > 0 )
      return $query->result();

    return FALSE;
  }

  // --------------------------------------------------------------

	/**
	 * Add a record to the denied access table
	 */
	protected function _insert_denial( $data )
	{
		if( $data['ip_address'] == '0.0.0.0' )
			return FALSE;

		$this->db->set( $data )
			->insert( config_item('denied_access_table') );

		$this->_rebuild_deny_list();
	}


  // --------------------------------------------------------------

	/**
	 * Remove a record from the denied access table.
	 * This method is not used by any action in Community Auth's
	 * example controllers. It has been left here for convenience.
	 */
	protected function _remove_denial( $ips )
	{
		$i = 0;
		foreach( $ips as $ip)
		{
			if( $i == 0 ){
				$this->db->where('ip_address', $ip );
			}else{
				$this->db->or_where('ip_address', $ip );
			}
			$i++;
		}
		$this->db->delete( config_item('denied_access_table') );
		$this->_rebuild_deny_list();
	}

  // --------------------------------------------------------------

  /**
   * Rebuild the deny list in the local Apache configuration file
   */
  protected function _rebuild_deny_list()
  {
    // Get all of the IP addresses in the denied access database
    $query_result = $this->get_deny_list('ip_address');
    // If we have denials
    if( $query_result !== FALSE )
    {
      // Create the denial list to be inserted into the Apache config file
      $deny_list = '<Limit GET POST>' . "\n" . 'order deny,allow';
      foreach( $query_result as $row )
      {
        $deny_list .= "\n" . 'deny from ' . $row->ip_address;
      }
      $deny_list .= "\n" . '</Limit>' . "\n";
    }
    // Get the path to the Apache config file
    $htaccess = config_item('apache_config_file_location');
    $this->load->helper('file');
    // Store the file permissions so we can reset them after writing to the file
    $initial_file_permissions = fileperms( $htaccess );
    // Change the file permissions so we can read/write
    @chmod( $htaccess, 0644);
    // Read in the contents of the Apache config file
    $string = read_file( $htaccess );
    // Remove the original deny list
    $arr = explode( 'END DENY LIST --', $string );
    // Add the new deny list to the top of the file contents
    $string = "# MAKE SURE TO LEAVE THE DENY LIST AT THE TOP OF THE FILE !!!\n" .
        "# BEGIN DENY LIST --\n" .
        $deny_list .
        "# END DENY LIST --\n\n" .
        trim( $arr[1] ) . "\n";
    // Write the new file contents
    if ( ! write_file( $htaccess, $string ) )
    {
         die('Could not write to Apache configuration file');
    }
    // Change the file permissions back to what they were before the read/write
    @chmod( $htaccess, $initial_file_permissions );
  }

  // --------------------------------------------------------------

  /**
   * After a failed login attempt, this hook may be called to
   * do anything you wish.
   *
   * @param  int  the number of failed login attempts as
   *              determined by check_login_attempts()
   */
  public function failed_login_attempt_hook( $login_errors_count )
  {
    return;
  }

  // -----------------------------------------------------------------------

  /**
   * Remove the auth session record when somebody logs out
   *
   * @param  int  the user's ID
   * @param  string  the session ID
   */
  public function logout( $user_id, $session_id )
  {
    $this->db->where( 'user_id' , $user_id )
      ->where( 'id', $session_id )
      ->delete( config_item('auth_sessions_table') );
  }

  // --------------------------------------------------------------

  /**
   * Garbage collection routine for old or orphaned auth sessions.
   * The auth sessions records are normally deleted if the user
   * logs out, but if they simply close the browser, the record
   * needs to be removed though garbage collection. This is subject
   * to settings you have for sessions in config/config.
   */
  public function auth_sessions_gc()
  {
    // GC for database based sessions
    if( config_item('sess_driver') == 'database' )
    {
      // Immediately delete orphaned auth sessions
      $this->db->query('
        DELETE a
        FROM `' . config_item('auth_sessions_table') . '` a
        LEFT JOIN `' . config_item('sessions_table') . '` b
        ON  b.id = a.id
        WHERE b.id IS NULL
      ');
    }
    // GC for sessions not expiring on browser close
    if( config_item('sess_expiration') != 0 )
    {
      $this->db->query('
        DELETE FROM `' . config_item('auth_sessions_table') . '`
        WHERE modified_at < CURDATE() - INTERVAL ' . config_item('sess_expiration') . ' SECOND
      ');
    }
  }
  // -----------------------------------------------------------------------
}
