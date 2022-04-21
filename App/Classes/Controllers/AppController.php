<?php
namespace App\Classes\Controllers;
use Pipit\Classes\Controllers as CoreControllers;

abstract class AppController extends CoreControllers\AbstractController {
    abstract protected function loadDefault();
}
