<?php
namespace App\Classes\Controllers;

class DefaultAdminController extends AppController {
    protected function configure() {
        $this->requireAdmin = true;
    }

    protected function loadDefault() {
        $this->setViewName("default");
    }
}
