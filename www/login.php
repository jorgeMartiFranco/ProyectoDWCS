<?php
	include_once 'db.php';
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password');
		
		if($username && $password) {
			if($user = checkUser($username, $password)) {
				session_start();
				$_SESSION['user'] = $user;
				header('Location: index.html');
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Formulario de login</title>
		<meta charset = "UTF-8">
	</head>
	<body>	
		<form action = "login.php" method = "POST">
			<label for = "user">Usuario</label> 
			<input id = "user" name = "username" type = "text" value = "<?=$username ?? '';?>">		
			<label for = "pw">Clave</label> 
			<input id = "pw" name = "password" type = "password">					
			<input type = "submit">
		</form>
	</body>
</html>