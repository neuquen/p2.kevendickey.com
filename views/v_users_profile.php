

	<div class="fillPage">
	
			<div id="stickyNav">
				<div id="username">Welcome<?php if($user) echo ', '.$user->first_name; ?></div>
				<form id="logout" name="logout" action="/users/logout" method="post">
					<input class="button" type="submit" value="Log Out"/>
				</form>
			</div>
	
	
	<div id="profileContent">

		<div id="left">
			<div class="menuItem" id="addPost">
				<form id="post" name="post" action="/posts/p_add" method="post">
					<textarea name="content" rows="5" required></textarea>
					<input class="button" type="submit" value="SQUAWK!"/>
				</form>
			</div>
			
			<div class="menuItem" id="squawkers">
				<div class="topSquawkers">
					Other Squawkers:
				</div>
				<?php foreach($users as $user): ?>
					<div class="bottomSquawkers">
				    <!-- Print this user's name -->
				    <?=$user['first_name']?> <?=$user['last_name']?>
				
				    <!-- If there exists a connection with this user, show a unfollow link -->
				    <?php if(isset($connections[$user['user_id']])): ?>
				        <a id="unfollow" href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a>
				
				    <!-- Otherwise, show the follow link -->
				    <?php else: ?>
				        <a id="follow" href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
				    <?php endif; ?>
				
				    
					</div>
				<?php endforeach; ?>
				
			</div>

			
		</div>
		
		<div id="right">
			<?php foreach($posts as $post): ?>
				<div class="menuItem" >
					
					<div class="topMenu">
						<div class="time">
							<form action="/posts/p_delete/<?=$post['post_id']?>" method="post">
								<input type="submit" name="post_id" value="X"/>
						    </form>
							<?=Time::display($post['created'])?>
							
						</div>
						
						<?=$post['first_name']?>
					</div>	
					<div class="bottomMenu">
						<div class="like">
							<!-- If someone likes or dislikes a post, show a highlighted picture and include text -->
							<?php if($post['dislike'] == "Y"): ?>
							<div class="likeUser"><?= $user->first_name ?> dislikes this</div>
							<a href="/posts/dislike/<?=$post['post_id']?>"><img src="/img/thumbsdown.png" alt=""></a>
							<!-- Otherwise, show the normal links -->
							<?php else: ?>
							<a href="/posts/dislike/<?=$post['post_id']?>"><img src="/img/thumbsdown-grey.png" alt=""></a>
							<?php endif; ?>
							
							<?php if($post['like'] == "Y"): ?>
							<div class="likeUser"><?php $user->first_name ?> likes this</div>
							<a href="/posts/like/<?=$post['post_id']?>"><img src="/img/thumbsup.png" alt=""></a>
							<?php else: ?>
							<a href="/posts/like/<?=$post['post_id']?>"><img src="/img/thumbsup-grey.png" alt=""></a>
							<?php endif; ?>
						</div>
						<?=$post['content']?>
						
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="clear"></div>	
	</div>
	<div id="bird">
		<img alt="Parrot" src="/img/parrot.png">
	</div>
	
	</div> <!-- Page Fill Div -->


