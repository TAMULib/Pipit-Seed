<?php
$viewRenderer->registerAppContextProperty("app_http", "{$config['path_http']}login.php");

if (!empty($data['action'])) {
	switch ($data['action']) {
		case 'logout':
			if ($globaluser->isLoggedIn()) {
				if ($globaluser->logOut()) {
					$system[] = "You've been logged out";
					$viewfile = "user.login.view.php";
				} else {
					$system[] = 'There was an error logging you out';
				}
			} else {
				$system[] = "You don't seem to be logged in";
				$viewfile = "user.login.view.php";
			}
		break;
		case 'login':
			if ($data['user']['username'] && $data['user']['password']) {
				if ($globaluser->logIn($data['user']['username'],$data['user']['password'])) {
					header("Location:{$config['path_http']}");
				} else {
					$system[] = 'Invalid username/password combination';
					$viewfile = "user.login.view.php";
				}
			} else {
				$system[] = 'Please provide both your username and password';
			}
		break;
	}
} else {
	if ($globaluser->isLoggedIn()) {
		$viewfile = "user.info.view.php";
	} else {
		$viewfile = "user.login.view.php";
	}
}
?>