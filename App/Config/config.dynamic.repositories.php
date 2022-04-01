<?php
namespace App\Config;
use Pipit\Classes\Configuration\DynamicDatabaseRepositoryConfiguration;

define('DYNAMIC_REPOSITORY_KEY', 'dynamicRepositories');

$GLOBALS[DYNAMIC_REPOSITORY_KEY] = array("DynamicRepoExample"=>new DynamicDatabaseRepositoryConfiguration('dynamic_repo_ex','id','name',null,array('name','description')));
