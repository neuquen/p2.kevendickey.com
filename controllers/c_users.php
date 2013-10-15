<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
    }

    public function signup() {
        echo "This is the signup page";
    }

    public function login() {
        echo "This is the login page";
    }

    public function logout() {
        echo "This is the logout page";
    }

    public function profile($user_name = NULL) {
 
    	# Set up the view
    	$this->template->content = View::instance('v_users_profile');
    	$this->template->title = "SQUAWK";
    	$this->template->bodyID = 'profile';
    	
    	# Define the Array for CSS content
    	$client_files_head = Array (
    		'/css/profile.css', 
    		'/css/master.css'
    	);
    	
    	# Use special load_client_files method to load files to page
    	$this->template->client_files_head = Utils::load_client_files($client_files_head);
    	
    	# Define the Array for JS content
    	$client_files_body = Array (
    		'/js/profile.js',
    		'/js/master.js'
    	);
    	
    	# Use special load_client_files method to load files to page
    	$this->template->client_files_body = Utils::load_client_files($client_files_body);
    	 
    	
    	# Pass the data to the view
    	$this->template->content->user_name = $user_name;
    	
    	# Display the view
    	echo $this->template;
    	
    	/* Alternate syntax
    	 * 
    	 *  $content = View::instance('v_users_profile');
    	 *	$content->user_name = $user_name;
    	 *	$this->template->content = $content;
    	 * 
    	 */
    	
    	
    	//Creating the variable (defaults to public) view which sets it equal
    	//to the instance method inside of the static class "View".  Pass
    	//in the name of the view as a parameter, without the extension.
    	//$view = View::instance('v_users_profile');
    	
    	//$view->user_name = $user_name;

    	//You should be separating display from logic so only echo the object itself.
    	//echo $view;
    	
    }

} # end of class