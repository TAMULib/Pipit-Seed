<?php
class usercas extends user {
	private $casPaths;
	private $serverInfo;

	public function __construct($appUrl) {
		parent::__construct();
		$casData['hostname'] = (isset($casData['hostname'])) ? $casData['hostname']:'cas-dev.tamu.edu';
		$this->serverInfo['path'] = $appUrl;
		$this->casPaths['login'] = "cas/login";
		$this->casPaths['check'] = "cas/serviceValidate";
		$this->casPaths['logout'] = "cas/logout";
		$this->casPaths['urls']['base'] = "https://{$casData['hostname']}/";
		$this->casPaths['urls']['login'] = "{$this->casPaths['urls']['base']}{$this->casPaths['login']}?service={$this->serverInfo['path']}&renew=true";
		$this->casPaths['urls']['check'] = "{$this->casPaths['urls']['base']}{$this->casPaths['check']}?service={$this->serverInfo['path']}&renew=true";
		$this->casPaths['urls']['logout'] = "{$this->casPaths['urls']['base']}{$this->casPaths['logout']}?service={$this->serverInfo['path']}logout.php&renew=true";
	}

	public function processLogIn($ticket) {
		$file = @file($this->casPaths['urls']['check']."&renew=true&ticket={$ticket}");
		if (!$file) {
			die("The authentication process failed to validate through CAS.");
		}
		if ($file[5]) {
			$rawUserName = simplexml_load_string($file[5]);
			$this->sessionName = "keymstr".time();
			$_SESSION['sessionName'] = $this->sessionName;
			//using quotes to force conversion of rawUserName to string
			$_SESSION[$this->sessionName]['user']['username'] = "{$rawUserName[0]}";
			$tusers = new users();
			if ($tusers->searchUsersAdvanced(array("username"=>$_SESSION[$this->sessionName]['user']['username'],"isadmin"=>1))) {
				$_SESSION[$this->sessionName]['user']['isadmin'] = 1;
			}
			$this->buildProfile();
			return true;		
		}
		return false;
	}

	public function initiatelogIn() {
		header("Location: {$this->casPaths['urls']['login']}");
	}

	public function logOut() {
		parent::logOut();
		header("Location: {$this->casPaths['urls']['logout']}");
	}
}
?>