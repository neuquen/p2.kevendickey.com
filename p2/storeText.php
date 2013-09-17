<?php       
if(isset($_POST['submit'])) 
{
	$file = 'posts.txt';
	// Open the file to get existing content
	$msg = file_get_contents($file);
	// Append a new person to the file
	$msg .= (isset($_POST['msg']) ? $_POST['msg'] : null);
	// Write the contents back to the file
	file_put_contents($file, $msg);
    header("Location: profile.html");
}
?>
    
    



