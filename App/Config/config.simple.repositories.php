<?php
namespace App\Config;
use Core\Classes\Configuration as CoreConfiguration;

define('SIMPLE_REPOSITORY_KEY', 'simpleRepositories');

$GLOBALS[SIMPLE_REPOSITORY_KEY] = array("SimpleRepoExample"=>new CoreConfiguration\SimpleRepositoryConfiguration('simple_repo_ex','id','name',null,array('name','description')));
?>