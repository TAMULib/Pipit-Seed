<?php
namespace App\Classes\Controllers;

class DefaultController extends AppController {
    protected function loadDefault() {
        $viewName = (!empty($this->getControllerConfig()['viewName'])) ? $this->getControllerConfig()['viewName']:'default';
        $this->setViewName($viewName);
    }
}
