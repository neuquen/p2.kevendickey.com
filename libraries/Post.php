<?php

	class Post {
		
		# Select all posts from users who you follow
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
				  	OR p.user_id = '.$user_id.' /*Auto-show posts from current user*/
				  GROUP BY p.post_id			
				  ORDER BY post_id desc';
		
			$posts = DB::instance(DB_NAME)->select_rows($query);

			return $posts;
		}
		
		
		// Select all users
		public function getAllUsers($user_id){
			
			$query = "SELECT * FROM users WHERE user_id != ".$user_id;
		
			$users = DB::instance(DB_NAME)->select_rows($query);
		
			return $users;
		
		}
		
		// Select everyone who the current user is following
		public function getConnections($user_id){
		
			$query = "SELECT *
				  FROM users_users
				  WHERE user_id = ".$user_id;
		
			$connections = DB::instance(DB_NAME)->select_array($query, 'user_id_followed');
		
			return $connections;
		}
		
	}


?>
