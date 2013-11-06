<?php

class index_controller extends base_controller {
	
	
	/*-------------------------------------------------------------------------------------------------
	CONSTRUCTOR
	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	} 
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index($error = NULL) {
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
			$this->template->content = View::instance('v_index_index');
			
		# Now set the <title> tag
			$this->template->title = "SQUAWK";
			
		# Pass data to the view	
			$this->template->bodyID = 'index';
			$this->template->content->error = $error;
	
		# CSS/JS includes
	    	$client_files_body = Array('/js/main.js');
	    	$this->template->client_files_body = Utils::load_client_files($client_files_body);
	      					     		
		# Render the view
			echo $this->template;

	} # End of method
	
	//Displays error message if duplicate email found
	public function email($emailError = NULL){
		$this->template->content = View::instance('v_index_index');
		$this->template->bodyID = 'index';
		$this->template->content->emailError = $emailError;
		echo $this->template;
	}
	
} # End of class
