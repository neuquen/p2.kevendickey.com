

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
			
			
			
			
			
			<div class="menuItem">
				<p>FRIENDS</p>
				<p>FRIENDS</p>
				<p>FRIENDS</p>
				<p>FRIENDS</p>
				<p>FRIENDS</p>
				<p>FRIENDS</p>
				<p>FRIENDS</p>
				<p>FRIENDS</p>
				<p>FRIENDS</p>
				<p>FRIENDS</p>
			</div>

			
		</div>
		
		<div id="right">
			<?php foreach($posts as $post): ?>
				<div class="menuItem" >
				<?=$post['first_name']?><br>
				<hr>
				<?=$post['content']?><br><br>
				</div>
			<?php endforeach; ?>
			
			
			
			
				
			
			
			<div class="menuItem" >
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
			</div>
			
			<div class="menuItem" >
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
			</div>
			
			<div class="menuItem" >
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
			</div>
			
			<div class="menuItem" >
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
				<p>STUFF AND THINGS</p>
			</div>
			
		</div>
		<div class="clear"></div>	
	</div>
	<div id="bird">
		<img alt="Parrot" src="/img/parrot.png">
	</div>
	
	</div> <!-- Page Fill Div -->


