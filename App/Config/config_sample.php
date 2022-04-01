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

define("SESSION_SCOPE",APP_DIRECTORY);

//defines the primary namespaces.
//the autoloader defined in Pipit/Lib/functions.php depends on these values to find and load Class and Interface files
//Individual files will need to have their namespaces updated to match if these are changed.
define("NAMESPACE_CORE","Pipit\\");
define("NAMESPACE_APP","App\\");

//server paths
//These don't need to be touched unless you're changing the location of the respective directories
define('PATH_CONFIG', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Config/");
define('PATH_LIB', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Lib/");
define('PATH_CORE_LIB', PATH_CORE.str_replace('\\', '/', NAMESPACE_CORE)."Lib/");
define('PATH_CONTROLLERS', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Controllers/");
define('PATH_VIEWS', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Views/");

//Sets where user uploaded files will be placed
//Core\Classes\Helpers\FileManager is dependent on this configuration
define('UPLOAD_PATH',PATH_ROOT.'uploads/');

//web paths
//These don't need to be touched unless you want to put your site assets somewhere else
define('PATH_RESOURCES', PATH_HTTP."resources/");
define('PATH_THEMES', PATH_RESOURCES."themes/");
define('PATH_CSS', PATH_RESOURCES."css/");
define('PATH_JS', PATH_RESOURCES."js/");
define('PATH_IMAGES', PATH_RESOURCES."images/");

//Setting this to true triggers an attempt to log in to a CAS server using the following CAS configuration
define('USECAS', false);

define('CAS_URLS_BASE', NULL);
define('CAS_LOGIN', "cas/login");
define('CAS_CHECK', "cas/serviceValidate");
define('CAS_LOGOUT', "cas/logout");
define('CAS_URLS_LOGIN', CAS_URLS_BASE.CAS_LOGIN."?service=".PATH_HTTP."&renew=true");
define('CAS_URLS_CHECK', CAS_URLS_BASE.CAS_CHECK."?service=".PATH_HTTP."&renew=true");
define('CAS_URLS_LOGOUT', CAS_URLS_BASE.CAS_LOGOUT."?service=".PATH_HTTP."user.php?action=logout");
define('CAS_REDIRECT_URL', PATH_HTTP);

//ldap config
define('LDAP_URL', NULL);
define('LDAP_PORT', NULL);
define('LDAP_USER', NULL);
define('LDAP_PASSWORD', NULL);
define('LDAP_BASE_DN', NULL);
define('LDAP_SEARCH_FILTER', NULL);
//ToDo upgrade to PHP 5.6+ to allow for Array constants
//const LDAP_SEARCH_ATTRIBUTES = array();
//const LDAP_USER_MAP = array();
define('LDAP_INACTIVE_USER_KEY', NULL);
define('LDAP_USERNAME_KEY', NULL);

//db config
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_HOST', '');
define('DB_DATABASE', 'pipit_seed');
define("DB_DSN", 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE);

//If switching to a non-MySQL flavor of SQL, expect to troubleshoot
//define("DB_DSN", 'sqlsrv:Server='.DB_HOST.';Database='.DB_DATABASE);
//define("DB_DSN", 'dblib:host='.DB_HOST.';dbname='.DB_DATABASE);

//debug mode for PDO database queries
define('DB_DEBUG', false);

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

//When set, CoreSite will try to use NAMESPACE_APP\Classes\Data\USER_CLASS as the globalUser
//define('USER_CLASS','User');

define('SECURITY_PUBLIC',-1);
define('SECURITY_USER',0);
define('SECURITY_ADMIN',1);

?>
