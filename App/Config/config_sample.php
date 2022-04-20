<?php

//This must be set to the real file path to the base directory of your server, e.g. '/var/www/html/'
define('PATH_ROOT', '/var/www/html/');

define('APP_NAME', 'The PipitSeed App');
define('APP_DIRECTORY', 'Pipit-Seed');

define('PATH_APP', PATH_ROOT.APP_DIRECTORY.'/');

define('WITH_COMPOSER',true);

if (WITH_COMPOSER) {
	define('VENDOR_DIRECTORY', 'vendor');
	define('PATH_VENDOR', PATH_APP.VENDOR_DIRECTORY.'/');
	define('PATH_CORE', PATH_VENDOR.'tamu-lib/pipit/');
} else {
    define('PATH_CORE', PATH_ROOT.'Pipit/');
}

//Optionally change this to your domain or IP.
//Add port if non-standard
define('PATH_HTTP', "http://localhost/".APP_DIRECTORY."/site/");

define("SESSION_SCOPE", APP_DIRECTORY);

//defines the primary namespaces.
//the autoloader defined in Pipit/Lib/functions.php depends on these values to find and load Class and Interface files
//Individual files will need to have their namespaces updated to match if these are changed.
define("NAMESPACE_CORE", "Pipit\\");
define("NAMESPACE_APP", "App\\");

/**
 * Server Paths
 *
 * These don't need to be touched unless you're changing the location of the respective directories
 */

//The location of the module ini files
define('PATH_CONFIG', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Config/");
define('PATH_LIB', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Lib/");
define('PATH_CORE_LIB', PATH_CORE.str_replace('\\', '/', NAMESPACE_CORE)."Lib/");
define('PATH_CONTROLLERS', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Controllers/");
define('PATH_VIEWS', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Views/");

//web paths
//These don't need to be touched unless you want to put your site assets somewhere else
define('PATH_RESOURCES', PATH_HTTP."resources/");
define('PATH_THEMES', PATH_RESOURCES."themes/");
define('PATH_CSS', PATH_RESOURCES."css/");
define('PATH_JS', PATH_RESOURCES."js/");
define('PATH_IMAGES', PATH_RESOURCES."images/");

/*
* To enable CAS:
* - Set USECAS to true
* - Configure user.cas.config.ini
* - Define CAS_USER_REPO
*/
define('USECAS', false);

//When set, CoreSite will try to use NAMESPACE_APP\Classes\Data\USER_CLASS as the globalUser
//Required for CAS use: A DataRepository representing the app's Users (requires existence of 'username' and 'iscas' fields)
//define('CAS_USER_REPO','Users');

//Optionally define a custom implementation of \Pipit\Interfaces\User to be used for the GlobalUser
//define('USER_CLASS',NAMESPACE_APP.'\\Classes\Data\\AppUserCAS');

//To override the default CoreLogger, uncomment this and add functionality to the App\\Classes\\Logger
//You could also extend the Core or App Loggers or implement the Logger interface directly. Just define the resulting namespaced class, here:
//define("LOGGER_CLASS",NAMESPACE_APP."Classes\\Logger");

//Set the log level: 0 = Everything, 3 = Errors only
define("LOG_LEVEL",3);

//If LOADER_CLASS is not set, the app will use CoreLoader by default.
//define('LOADER_CLASS','AppLoader');

//If SITE_CLASS is not set, the app will use CoreSite by default.
//define('SITE_CLASS','Site');

//If VIEW_RENDERER is not set, the app will use the HTMLViewRenderer by default.
//define('VIEW_RENDERER','AppViewRenderer');

//Define the theme folder HTMLViewRenderer based ViewRenderers should use (default options are 'bootstrap' and 'html')
define('ACTIVE_THEME','bootstrap');

/**
 * The page access levels (use when defining pages in the site.pages config file)
 */
define('SECURITY_PUBLIC',-1);
define('SECURITY_USER',0);
define('SECURITY_ADMIN',1);

?>
