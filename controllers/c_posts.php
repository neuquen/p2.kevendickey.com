<?php

class posts_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------
	 CONSTRUCTOR
	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	}
	
	//Add Posts
	public function add(){
		
		//$this->template = View::instance("v_posts_add");
		$this->template = View::instance("v_users_profile");
		
		echo $this->template;
	}
	
	//Add Posts Functionality
	public function p_add(){
		
		$_POST['user_id']  = $this->user->user_id;
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		DB::instance(DB_NAME)->insert('posts', $_POST);
		
		Router::redirect('/users/profile');
	}
	
	
	//Retrieve stream of all Posts
	// TODO: Rename to getPosts or getAllPosts()
	public function index(){
		
		//$this->template->content = View::instance('v_posts_index');
		$this->template->content = View::instance('v_users_profile');
		
		$query = 'SELECT p.*,
			             u.first_name,
			             u.last_name
				  FROM posts p
				  JOIN users u
				  ON p.user_id = u.user_id
				  ORDER BY post_id desc';
		
		$posts = DB::instance(DB_NAME)->select_rows($query);
		
		//$this->template->content->posts = $posts;
		
		//echo $this->template;
		return $posts;
	}
	
	public function users(){
		
		$this->template->content = View::instance("v_users_profile");
		
		# Select all users
		$query = "SELECT * FROM users";
		
		$users = DB::instance(DB_NAME)->select_rows($query);
		

		$this->template->content->users = $users;
		
		
		return $users;
		
	}
	
	public function connections(){
		
		$this->template->content = View::instance("v_users_profile");
		
		# Select everyone that the current logged-in user is following
		$query = "SELECT *
				  FROM users_users
				  WHERE user_id = ".$this->user->user_id;
		
		$connections = DB::instance(DB_NAME)->select_array($query, 'user_id_followed');
		
		$this->template->content->connections = $connections;
		
		return $connections;
	}
	
	
	public function p_users(){
		
	}
}



?>