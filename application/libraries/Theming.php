<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permissions - Permissions Library
 * Permissions Library  for basing user Permissions values
 * @package     Codeignitor Starter
 * @author      John Kiragu Mutua
 * @copyright   Copyright (c) 2017 - 2021, John Kiragu Mutua. (http://mutuakiragu.wordpress.com/)
 * @license     Apache 2
 */
 class  Theming
 {

    /**
     ** Base CodeIgniter module
     **/
    private $CI;

   
    /**
     ** Default Theme For The application
     **/
    private $default_theme;

    


    /**
     ** constructor for Permissions module
     **/
    function __construct()
    {

        $this->CI = & get_instance();

        $this->default_theme = config_item('default_theme');

    }

    

    public function setayout(){

        #Location of the layout that 
        #We want to include
        #Permissions library Will 
        #Load all the data that we need from ths session
        $this

    }

 }