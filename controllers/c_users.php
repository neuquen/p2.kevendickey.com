<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
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
    	
    	# Check for duplicate email
    	$uniqueEmail = $this->userObj->confirm_unique_email($_POST['email']);
    	
    	if($uniqueEmail) {
    	
	    	# Prevent XSS by converting special characters
			function clean($string){
				return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
			}
			
			# Allows you to clean an Array
			$clean = array_map('clean', $_POST);
			
	    	# Insert the new user
	    	$new_user = DB::instance(DB_NAME)->insert_row('users', $clean);
	    	
	    	# Go ahead and log them in
		    if($new_user) {
			    setcookie('token',$_POST['token'], strtotime('+1 year'), '/');
			    
			    # Auto-follow yourself
			    $data = Array(
			    		"created" => Time::now(),
			    		"user_id" => $new_user,
			    		"user_id_followed" => $new_user
			    );
			    
			    # Create connection in DB
			    DB::instance(DB_NAME)->insert('users_users', $data);
			}
		    
		    # Send them to their profile
		    Router::redirect('/users/profile');
	    
    	} else {
    		Router::redirect('/index/email/emailError');
    	}
    	
    	
    }
    
    //Process the login information
    public function p_login(){
    	
    	# Encrypts password (Salt = random string to make it more complicated)
    	$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
    	
    	
    	# Get token from DB
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
    		
    		Router::redirect('/users/profile/');
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
    	
    	#Reference Post class (/libraries/Post.php)
    	$posts = new Post();
    	
    	# Get stream of posts from the DB
    	$p = $posts->getFollowedPosts($this->user->user_id);
    	
    	# Get users/connections (followers) data from DB
    	$u = $posts->getAllUsers($this->user->user_id);
    	$c = $posts->getConnections($this->user->user_id);
    	
    	# Pass the data to the view
    	$this->template->content->user_name = $user_name;
    	$this->template->content->posts = $p;
    	$this->template->content->users = $u;
    	$this->template->content->connections = $c;
    	
    	# Display the view
    	echo $this->template;
    }

} # end of class