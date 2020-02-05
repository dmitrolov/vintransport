<?php
	require_once('model/model.php');
	if (!$_GET['p']) {
		header('Location: ?p=2');
		exit;
	}

	$page = $_GET['p'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>Privat24</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="icon" type="image/png" href="img/privat24.png" sizes="32x32">
		<meta name="theme-color" content="#212121">
		<script src="js/cookies.js"></script>
	</head>
	<body>
		<?php
			require_once('view/page'.$page.'.php');
		?>
	</body>
</html>