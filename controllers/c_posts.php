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
		
		print_r($_POST);
		
		//Router::redirect('/users/profile');
	}
	
	public function p_delete($post_id){
		//$post_id = $this->post_id;
		
		# Delete this connection
		$where_condition = 'WHERE post_id = '.$post_id;
		DB::instance(DB_NAME)->delete('posts', $where_condition);
			
		# Send them back
		Router::redirect("/users/profile");

	}
	
/* TRANSFERRED TO CORE/LIBRARIES/POST.PHP
	//Retrieve stream of all Posts
	// TODO: Rename to getPosts or getAllPosts()
	public function index(){
		
		//$this->template->content = View::instance('v_posts_index');
		//$this->template->content = View::instance('v_users_profile');
		
		$query = 'SELECT p.user_id AS post_user_id,
						 utu.user_id AS follower_id,
			             u.first_name,
			             u.last_name,
				         p.content,
						 p.created
				  FROM posts p
				  JOIN users_users utu
				  ON p.user_id = utu.user_id_followed
				  JOIN users u
				  ON p.user_id = u.user_id
				  WHERE utu.user_id = '.$this->user->user_id.'
				  ORDER BY post_id desc';
		
		$posts = DB::instance(DB_NAME)->select_rows($query);
		
		//$this->template->content->posts = $posts;
		
		//echo $this->template;
		return $posts;
	}
	
	public function users(){
		
		//$this->template->content = View::instance("v_users_profile");
		
		# Select all users
		$query = "SELECT * FROM users";
		
		$users = DB::instance(DB_NAME)->select_rows($query);
		

		//$this->template->content->users = $users;
		
		
		return $users;
		
	}
	
	public function connections(){
		
		//$this->template->content = View::instance("v_users_profile");
		
		# Select everyone that the current logged-in user is following
		$query = "SELECT *
				  FROM users_users
				  WHERE user_id = ".$this->user->user_id;
		
		$connections = DB::instance(DB_NAME)->select_array($query, 'user_id_followed');
		
		//$this->template->content->connections = $connections;
		
		return $connections;
	}
*/
	
	public function follow($user_id_followed) {
	
	    # Prepare the data array to be inserted
	    $data = Array(
	        "created" => Time::now(),
	        "user_id" => $this->user->user_id,
	        "user_id_followed" => $user_id_followed
	        );
	
	    # Do the insert
	    DB::instance(DB_NAME)->insert('users_users', $data);
	
	    # Send them back
	    Router::redirect("/users/profile");
	
	}

	public function unfollow($user_id_followed) {
	
	    # Delete this connection
	    $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
	    DB::instance(DB_NAME)->delete('users_users', $where_condition);
	
	    # Send them back
	    Router::redirect("/users/profile");
	
	}
	

}



?>