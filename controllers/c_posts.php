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
		
		//$this->template = View::instance("V_posts_add");
		$this->template = View::instance("v_users_profile");
		
		echo $this->template;
	}
	
	//Add Posts Functionality
	public function p_add(){
		
		$_POST['user_id']  = $this->user->user_id;
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		DB::instance(DB_NAME)->insert('posts', $_POST);
	}
	
	
	//Stream of all Posts
	public function index(){
		
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
	
	public function p_index(){
		
	}
}



?>