<?php
namespace App\Config;
use Core\Classes\Configuration as CoreConfiguration;

define('DYNAMIC_REPOSITORY_KEY', 'dynamicRepositories');

$GLOBALS[DYNAMIC_REPOSITORY_KEY] = array("DynamicRepoExample"=>new CoreConfiguration\DynamicDatabaseRepositoryConfiguration('dynamic_repo_ex','id','name',null,array('name','description')));
?>