<?php
namespace App\Lib;
use Core\Classes as CoreClasses;
use Core\Lib as CoreLib;

/**
*	App Loader - The entry point for the application. All endpoints lead, here.
*	Instantiates a Loader implementation and fires off the site load()
*	
*	@author Jason Savell <jsavell@library.tamu.edu>
*
*/

require_once PATH_LIB."functions.php";

/**
*   This autoloader will search NAMESPACE_APP for a matching file containing the declaration of that class or interface.
*/
spl_autoload_register(function($class) {
    CoreLib\loadFile($class,NAMESPACE_APP,PATH_APP);
});

if (WITH_COMPOSER) {
	require PATH_VENDOR.'/autoload.php';
} else {
	require PATH_CORE_LIB.'/autoload.php';
}

require_once PATH_CONFIG.'config.dynamic.repositories.php';
require_once PATH_CONFIG.'config.pages.php';

$config = get_defined_constants(true)["user"];
if (!empty($sitePages)) {
	$config['sitePages'] = $sitePages;
	unset($sitePages);
}

if (!empty($GLOBALS[DYNAMIC_REPOSITORY_KEY])) {
	$config[DYNAMIC_REPOSITORY_KEY] = $GLOBALS[DYNAMIC_REPOSITORY_KEY];
	unset($GLOBALS[DYNAMIC_REPOSITORY_KEY]);
}

if (!empty($forceRedirectUrl)) {
	$config['forceRedirectUrl'] = $forceRedirectUrl;
	unset($forceRedirectUrl);
}

if (!empty($controllerConfig)) {
	$config['controllerConfig'] = $controllerConfig;
	unset($controllerConfig);
}

$logger = CoreLib\getLogger();

if (!empty($config['LOADER_CLASS'])) {
	$className = "{$config['NAMESPACE_APP']}Classes\\Loaders\\{$config['LOADER_CLASS']}";
	$siteLoader = new $className($config);
	$logger->debug("Using Configured Loader Class: {$className}");
} else {
	$siteLoader = new CoreClasses\Loaders\CoreLoader($config);
	$logger->debug("Using Default Loader Class: CoreLoader");
}
$siteLoader->load();
?>