<?php
define('APP_NAME', 'The Seed App'); 
define('APP_DIRECTORY', 'PHPSeedApp'); 
define('APP_BASE', '_application/');

define("SESSION_SCOPE",APP_DIRECTORY);

//defines the primary namespaces.
//the autoloader defined in Core/Lib/functions.php depends on these values to find and load Class and Interface files
//Individual files will need to have their namespaces updated to match if these are changed.
define("NAMESPACE_CORE","Core\\");
define("NAMESPACE_APP","App\\");

//server paths
define('PATH_ROOT', '/'); 
define('PATH_FILE', PATH_ROOT.APP_DIRECTORY.'/');
define('PATH_APP', PATH_FILE.APP_BASE);
define('PATH_LIB', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Lib/");
define('PATH_CORE_LIB', PATH_APP.str_replace('\\', '/', NAMESPACE_CORE)."Lib/");
define('PATH_CONTROLLERS', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Controllers/");
define('PATH_VIEWS', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Views/");

//web paths
define('PATH_HTTP', "http://localhost/".APP_DIRECTORY."/");
define('PATH_RESOURCES', PATH_HTTP."resources/");
define('PATH_THEMES', PATH_HTTP."resources/themes/");
define('PATH_CSS', PATH_HTTP."resources/css/");
define('PATH_JS', PATH_HTTP."resources/js/");
define('PATH_IMAGES', PATH_HTTP."resources/images/");

define('USECAS', false);

define('CAS_LOGIN', "cas/login");
define('CAS_CHECK', "cas/serviceValidate");
define('CAS_LOGOUT', "cas/logout");
define('CAS_URLS_BASE', NULL);
define('CAS_URLS_LOGIN', CAS_URLS_BASE.CAS_LOGIN."?service=".PATH_HTTP."&renew=true");
define('CAS_URLS_CHECK', CAS_URLS_BASE.CAS_CHECK."?service=".PATH_HTTP."&renew=true");
define('CAS_URLS_LOGOUT', CAS_URLS_BASE.CAS_LOGOUT."?service=".PATH_HTTP."user.php?action=logout");

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
define('DB_DATABASE', 'phpseedapp');
define("DB_DSN", 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE);
// mssql has only been tested on Windows 
//define("DB_PDO_DSN", 'sqlsrv:Server='.DB_HOST.';Database='.DB_DATABASE);

//debug mode for PDO database queries
define('DB_DEBUG', false);

//This array represents the app's pages. Used to generate user facing navigation and load controllers
//The keys correspond to controller names
//Each entry should have a corresponding user reachable file (with an arbitrary real directory path) that includes the config file and (defines a controller and includes the loader) or (redirects with $forceRedirectUrl)
//It's possible to have user reachable files that aren't represented in this array. They simply won't have a navigation link in the HTML header.
$sitePages = array(
			"widgets" => array("name"=>"widgets","path"=>"widgets"),
			"users" => array("name"=>"users","path"=>"users","admin"=>true));

//The ViewRenderer can be set, here, if we want to use something other than the default HTMLViewRenderer
//define('VIEW_RENDERER','BootstrapViewRenderer');

?>

