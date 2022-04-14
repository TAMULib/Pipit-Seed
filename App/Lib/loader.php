<?php
namespace App\Lib;
use Pipit\Classes\Loaders\CoreLoader;
use Pipit\Lib\CoreFunctions;
use Pipit\Lib\CoreAutoload;

/**
*   App Loader - The entry point for the application. All endpoints lead, here.
*   Instantiates a Loader implementation and fires off the site load()
*
*   @author Jason Savell <jsavell@library.tamu.edu>
*
*/

require_once PATH_LIB."functions.php";

/**
*   This autoloader will search NAMESPACE_APP for a matching file containing the declaration of that class or interface.
*/
spl_autoload_register(function($class) {
    CoreAutoload::loadFile($class,NAMESPACE_APP,PATH_APP);
});

if (WITH_COMPOSER) {
    require PATH_VENDOR.'/autoload.php';
} else {
    require PATH_CORE_LIB.'/autoload.php';
}

$config = CoreFunctions::getInstance()->getAppConfiguration();

if (!empty($forceRedirectUrl)) {
    $config['forceRedirectUrl'] = $forceRedirectUrl;
    unset($forceRedirectUrl);
}

if (!empty($controllerConfig)) {
    $config['controllerConfig'] = $controllerConfig;
    unset($controllerConfig);
}

$logger = CoreFunctions::getInstance()->getLogger();

if (!empty($config['LOADER_CLASS'])) {
    $className = "{$config['NAMESPACE_APP']}Classes\\Loaders\\{$config['LOADER_CLASS']}";
    $siteLoader = new $className($config);
    $logger->debug("Using Configured Loader Class: {$className}");
} else {
    $siteLoader = new CoreLoader($config);
    $logger->debug("Using Default Loader Class: CoreLoader");
}
$siteLoader->load();
