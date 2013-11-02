<?php

class posts_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------
	 CONSTRUCTOR
	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	}
	
	//Add Posts Functionality
	public function p_add(){
		
		$_POST['user_id']  = $this->user->user_id;
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		DB::instance(DB_NAME)->insert('posts', $_POST);
		
		Router::redirect('/users/profile');
	}
	
	public function p_delete($post_id){
		//$post_id = $this->post_id;
		
		# Delete this connection
		$where_condition = 'WHERE post_id = '.$post_id;
		DB::instance(DB_NAME)->delete('posts', $where_condition);
			
		# Send them back
		Router::redirect("/users/profile");

	}
	
	
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
	
	
	public function like ($post_id, $user){
		$like = Array("`like`" => "Y"); //Had to include the backticks because "like" is a reserved word in SQL
		DB::instance(DB_NAME)->update("posts", $like, "WHERE post_id =".$post_id);
		
		$user = Array("who_likes" => $user);
		DB::instance(DB_NAME)->update("posts", $user, "WHERE post_id =".$post_id);
		
		Router::redirect("/users/profile/");
	}
	
	public function dislike ($post_id, $currentUser){
		$dislike = Array("dislike" => "Y");
		DB::instance(DB_NAME)->update("posts", $dislike, "WHERE post_id =".$post_id);
		
		$user = Array("who_dislikes" => $currentUser);
		DB::instance(DB_NAME)->update("posts", $user, "WHERE post_id =".$post_id);
		
		Router::redirect("/users/profile/");
	}
	

}



?>