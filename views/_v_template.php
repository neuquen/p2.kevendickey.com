<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<link href="/css/main.css" rel="stylesheet" typ="text/css">
	<link href='http://fonts.googleapis.com/css?family=Poller+One' rel='stylesheet' type='text/css'>	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<?php
	$url = explode('/',$_SERVER['REQUEST_URI']);
	$dir = $url[1] ? $url[2] : 'index';
?>

<body <?php if(isset($bodyID)) echo "id='$bodyID'" ?>>

	<?php if(isset($content)) echo $content; ?>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>
</body>
</html>