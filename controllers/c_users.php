<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        //$this->template->content = View::instance('v_posts_index');
		$this->template = View::instance('v_users_index');
		
		$query = 'SELECT p.*,
			             u.first_name,
			             u.last_name
				  FROM posts p
				  JOIN users u
				  ON p.user_id = u.user_id';
		
		$posts = DB::instance(DB_NAME)->select_rows($query);
		
		$this->template->content->posts = $posts;
		
		echo $this->template;
    }

    //Displays the signup information (N/A. Displayed in index page.)
    public function signup() {
        # Set up the view
    	$this->template->content = View::instance('v_users_signup');
    	$this->template->title   = "Sign Up";
    	
        
    	# Render the view
    	echo $this->template;
    }
    
    //Processes the signup information
    public function p_signup() {
    	
    	# Gets current unix timestamp(uses static Time method from framework)
    	$_POST['created'] = Time::now();
    	
    	# Encrypts password (Salt = random string to make it more complicated)
    	$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
    	
    	# Give each user a token which will allow re-entry into website (ie- ticket at an event)
    	# Combination of 1. Token Salt, 2. Users Email, 3. Random string
    	$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
    	
    	# Echos array in order to test/debug
    	echo "<pre>";
    	print_r($_POST);
    	echo "</pre>";
    	
    	DB::instance(DB_NAME)->insert_row('users', $_POST);
    	
    	#Redirects to different page
    	Router::redirect('/users/profile/');
    }

    //Display the login page (N/A. Displayed in index page.)
    public function login($error = NULL) {
        # Set up the view
    	$this->template->content = View::instance('v_users_login');
    	$this->template->title   = "Login";
    	$this->template->content->error = $error;
    	
    	# Render the view
    	echo $this->template;
    }
    
    //Process the login information
    public function p_login(){
    	
    	# Encrypts password (Salt = random string to make it more complicated)
    	$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
    	
    	$query = 
	    	"SELECT token 
	        FROM users 
	        WHERE email = '".$_POST['email']."' 
	        AND password = '".$_POST['password']."'";

    	$token = DB::instance(DB_NAME)->select_field($query);
    	
    	# Success
    	if ($token){
    		# Sets session cookie to allow for re-entry
    		# setcookie() = 1. name of cookie, 2. value of cookie, 3. expiration date, 4. Where available (everywhere)
    		setcookie('token', $token, strtotime('+1 year'), '/');
    		Router::redirect('/users/profile');
    	} 
    	# Fail
    	else {
    		Router::redirect('/index/index/error');
    	}
    }

    public function logout() {
        #Generate a new token
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
        
        #Set up Data
        $data = Array("token" => $new_token);
        
        #Update the users table
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");
        
        #Delete the other cookie
        setcookie('token', '', strtotime('-1 year'), '/');
    	
    	#Route them to index
    	Router::redirect('/');
    }

    public function profile($user_name = NULL) {
 
    	if(!$this->user) {
    		Router::redirect('/');
    		//die('Please enter a name and password. <a href="/">Login</a>');
    	}	
    	
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
    
    
    public function insert_db($first, $last){
    	$insert = "INSERT INTO users
    			   (first_name, last_name)
    			   Values
    			   ('$first', '$last')";
    	
    	echo $insert;
    	
    	DB::instance(DB_NAME)->query($insert);
	
    }
    
    
    public function update_db($email){
    	$update = "UPDATE users
    			   SET email = '$email'
    			   WHERE first_name = 'Audrey'";
    	
    	
    	echo $update;
    	
    	DB::instance(DB_NAME)->query($update);
    }
    
    
    public function test_db(){
	    $new_user = Array(
	    		"first_name" => "John",
	    		"last_name" => "Doe",
	    		"email" => "jd@gmail.com"
	    		);
	    		
	    DB::instance(DB_NAME)->insert('users', $new_user);
    
    }

} # end of class