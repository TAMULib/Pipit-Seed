<?php
namespace App\Classes\ViewRenderers;
use Pipit\Classes\ViewRenderers\HTMLViewRenderer;

/**
*   An app level customization of Core's HTMLViewRenderer to demonstrate extending a Core ViewRender implementation
*   Specific ViewRenderers can be activated by setting the VIEW_RENDERER constant to the class name of the desired ViewRenderer
*
*   Looks in the 'bootstrap' Views directory for a given view first. If not found, falls back to the 'html' directory.
*
*   @author Jason Savell <jsavell@library.tamu.edu>
*/
class AppViewRenderer extends HTMLViewRenderer {
    protected $viewPaths = array('bootstrap','html');

    public function __construct($globalUser,$pages,$data,$controllerName) {
        parent::__construct($globalUser,$pages,$data,$controllerName);
        $this->setViewPath($this->viewPaths[0]);
    }

    public function setView($viewFile,$isAdmin=false) {
        $viewSet = false;
        foreach ($this->viewPaths as $viewPath) {
            $this->setViewPath($viewPath);
            if (parent::setView($viewFile,$isAdmin)) {
                $viewSet = true;
                break;
            }
        }
        $this->setViewPath($this->viewPaths[0]);
        if ($viewSet) {
            return true;
        }
        return false;
    }
}
