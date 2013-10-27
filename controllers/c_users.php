<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
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
    	
    	# Peform SQL Query
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
 
    	# If the user isn't authenticated, redirect them to index
    	if(!$this->user) {
    		Router::redirect('/');
    		//die('Please enter a name and password. <a href="/">Login</a>');
    	}	
    	
    	# Set up the view
    	$this->template->content = View::instance('v_users_profile');
    	$this->template->title = "SQUAWK";
    	$this->template->bodyID = 'profile';
    	
    	
    	# Get posts data from the DB (References posts_controller index method which grabs the DB data)
    	$posts = new posts_controller();
    	$p = $posts->index();
    	
    	$users = new posts_controller();
    	$u = $users->users();
    	
    	$connections = new posts_controller();
    	$c = $connections->connections();
    	
    	
    	# Pass the data to the view
    	$this->template->content->user_name = $user_name;
    	$this->template->content->posts = $p;
    	$this->template->content->users = $u;
    	$this->template->content->connections = $c;
    	
    	# Display the view
    	echo $this->template;
    }

} # end of class