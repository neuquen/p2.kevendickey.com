	<?php if($user):?>
		<?php Router::redirect('/users/profile/'); ?>
	<?php else: ?>


		<div id="indexContent">
		<div id="welcome">
			<h1>Welcome to SQUAWK!</h1>
			<h2>A home for all you loud people who need an audience...</h2>
		</div>
		
		
		<div id="login">
			<form name="login" action="/users/p_login" method="post">
				<h3>Please Sign In</h3>
				<input class="textField" type="email" name="email" placeholder="Email Address" required/><br/>
				<input class="textField" type="password" name="password" placeholder="Password" required/><br/>
				<input class="button"    type="submit" value="Sign In"/>
				<?php if(isset($error)): ?>
					<div class='error'>LOGIN FAILED.  PLEASE TRY AGAIN.</div>
				<?php endif;?>
			</form>
		</div>
		
		<div id="signup">
			<form name="signup" action="/users/p_signup" method="post">
				<h3>Need to SQUAWK? Sign up</h3>
				<input class="textField" type="text" name="first_name" placeholder="First Name" required/><br/>
				<input class="textField" type="text" name="last_name" placeholder="Last Name" required/><br/>
				<input class="textField" type="email" name="email" placeholder="Email Address" required/><br/>
				<input class="textField" type="password" name="password" placeholder="Password" required/><br/>
				<input class="button"    type="submit" value="Sign Up" />
			</form>
		</div>
		</div>
		
		
		<div id="bird">
			<img src="/img/parrot.png" alt="Parrot">
		</div>
		
		
	<?php endif; ?>