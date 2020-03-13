<?php
	include_once 'controller/db.php';
	use MobilitySharp\controller;

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password');
		
		if($username && $password) {
			if($user = controller\checkUser($username, $password)) {
				session_start();
				$_SESSION['user'] = $user;
			}
		}
	}
	header('Location: '.$_POST['redirect']);
?>