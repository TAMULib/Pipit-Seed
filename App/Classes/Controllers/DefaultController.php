<?php
namespace App\Classes\Controllers;

class DefaultController extends AppController {
    protected function loadDefault() {
        $viewName = (!empty($this->getControllerConfig()['name'])) ? $this->getControllerConfig()['name'] : 'default';
        $this->setViewName($viewName);
    }
}
