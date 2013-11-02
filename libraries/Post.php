<?php

	class Post {
		
		//Select all posts from users who you follow
		public function getFollowedPosts($user_id){		
			
			$query = 'SELECT p.user_id AS post_user_id,
						 utu.user_id AS follower_id,
			             u.first_name,
			             u.last_name,
				         p.content,
						 p.created,
						 p.post_id,
						 p.dislike,
						 p.like,
						 p.who_likes,
						 p.who_dislikes
				  FROM posts p
				  JOIN users_users utu
				  ON p.user_id = utu.user_id_followed
				  JOIN users u
				  ON p.user_id = u.user_id
				  WHERE utu.user_id = '.$user_id.'
				  ORDER BY post_id desc';
		
			$posts = DB::instance(DB_NAME)->select_rows($query);

			return $posts;
		}
		
		
		//Select all users
		public function getAllUsers(){
			
			$query = "SELECT * FROM users";
		
			$users = DB::instance(DB_NAME)->select_rows($query);
		
			return $users;
		
		}
		
		//Select everyone who the current user is following
		public function getConnections($user_id){
		
			$query = "SELECT *
				  FROM users_users
				  WHERE user_id = ".$user_id;
		
			$connections = DB::instance(DB_NAME)->select_array($query, 'user_id_followed');
		
			return $connections;
		}
		
		public function p_delete($post_id){
			//$post_id = $this->post_id;
		
			# Delete this connection
			$where_condition = 'WHERE post_id = '.$post_id;
			DB::instance(DB_NAME)->delete('posts', $where_condition);
				
			# Send them back
			Router::redirect("/users/profile");
		
	}
		
		
	}


?>
