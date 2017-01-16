<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Codeignitor Starter - Mailing functions based on
 * DOMImplementation of mailgun api for use in sending emails at
 * A guranteed fast rate
 * @package     Codigniter Starter
 * @author      John Kiragu
 *
 */

 class Mailgun{

   public $CI;

   /**
    ** default constructor
    ** returns void
    **/
   function __construct(){
     $this->CI = & get_instance();
   }

   function sendMail(){

      ///do a simple curl to the api and all

   }

 }
