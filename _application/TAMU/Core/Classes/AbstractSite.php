<?php
namespace TAMU\Core\Classes;
use TAMU\Core\Interfaces as Interfaces;
/** 
*	An abstract implementation of the Site interface
*
*	@author Jason Savell <jsavell@library.tamu.edu>
*/

abstract class AbstractSite implements Interfaces\Site {
	private $globalUser;
	private $siteConfig;
	private $viewRenderer;
	private $pages;
	private $inputData;

	public function __construct(&$siteConfig,&$pages) {
		$this->globalUser = $globalUser;
		$this->siteConfig = $siteConfig;
		$this->viewRenderer = $viewRenderer;
		$this->pages = $pages;
		$this->prepInputData();
		$this->setUser();
	}

	private function setUser() {
		//build the user
		if (isset($this->siteConfig['USECAS']) && $this->siteConfig['USECAS']) {
			$this->globalUser = new Data\UserCAS();
			$casTicket = $this->getInputData()['ticket'];
			if (!empty($casTicket)) {
				if ($this->globalUser->processLogIn($casTicket)) {
					header("Location:{$this->siteConfig['PATH_HTTP']}");
				}
			} elseif (!$this->getGlobalUser()->isLoggedIn() && !isset($this->getInputData()['action'])) {
				$this->getGlobaluser()->initiateLogIn();
			}
		} else {
			$this->globalUser = new Data\User();
		}
	}

	public function getPages() {
		return $this->pages;
	}

	public function setViewRenderer($viewRenderer) {
		$this->viewRenderer = $viewRenderer;
	}

	public function getViewRenderer() {
		return $this->viewRenderer;
	}

	public function getControllerPath($controllerName) {
		$filename = null;
		//load admin controller if user is logged in and an admin page
		if (array_key_exists($controllerName,$this->pages) || $controllerName == 'user') {
			if (!empty($this->pages[$controllerName]['admin']) && $this->pages[$controllerName]['admin'] == true) {
				//if the user is an admin, load the admin controller, otherwise, return false;
				if ($this->globalUser->isAdmin()) {
					if ($controllerName) {
						$this->viewRenderer->registerAppContextProperty("app_http", "{$this->siteConfig['PATH_HTTP']}admin/{$controllerName}/");
						$filename = "{$this->siteConfig['PATH_CONTROLLERS']}admin/{$controllerName}.control.php";
					} else {
						$this->viewRenderer->registerAppContextProperty("app_http", "{$this->siteConfig['PATH_HTTP']}admin/");
						$filename = "{$this->siteConfig['PATH_CONTROLLERS']}admin/default.control.php";
					}
				}
			} elseif ($this->globalUser->isLoggedIn() || (!$this->globalUser->isLoggedIn() && $controllerName == 'user')) {
				//load standard controller
				$this->viewRenderer->registerAppContextProperty("app_http", "{$this->siteConfig['PATH_HTTP']}{$controllerName}/");

				$filename = "{$this->siteConfig['PATH_CONTROLLERS']}{$controllerName}.control.php";
			}
		} else {
			$this->viewRenderer->registerAppContextProperty("app_http", "{$this->siteConfig['PATH_HTTP']}");
			$filename = "{$this->siteConfig['PATH_CONTROLLERS']}default.control.php";
		}
		return $filename;
	}

	public function prepInputData() {
		if (!empty($_GET['action'])) {
			//restrict any controller actions that alter DB data to POST
			$restrictedActions = array("insert","remove","update");
			if (!in_array($_GET['action'],$restrictedActions)) {
				$data = $_GET;
			}
		} elseif (!empty($_POST['action'])) {
			$data = $_POST;
		} else {
			$data = $_REQUEST;
		}
		$this->setInputData($data);
	}

	private function setInputData($inputData) {
		$this->inputData = $inputData;
	}

	public function getInputData() {
		return $this->inputData;
	}

	public function getGlobalUser() {
		return $this->globalUser;
	}
}