<?php
$configFile = "../App/Config/config.php";

if (!is_file($configFile)) {
    echo 'Make sure to create and configure the config file!';
} else {
    include $configFile;
    $controllerConfig = array('name'=>'default');
    include PATH_LIB."loader.php";
}
