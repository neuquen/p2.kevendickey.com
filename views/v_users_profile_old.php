<?php if(isset($user_name)): ?>
	<h1>This is the profile for <?=$user_name?></h1>
<?php else: ?>
	<h1>No user has been specified</h1>
<?php endif;?>


//It is ok to use logic in your display page if it is
//determining whether or not something should be displayed.