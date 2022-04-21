<?php
namespace App\Classes\ViewRenderers;
use Pipit\Classes\ViewRenderers\HTMLViewRenderer;

/**
*   An app level customization of Core's HTMLViewRenderer to demonstrate extending a Core ViewRender implementation
*   Specific ViewRenderers can be activated by setting the VIEW_RENDERER constant to the class name of the desired ViewRenderer
*
*   Looks in the ACTIVE_THEME Views directory for a given view first. If not found, tries 'bootstrap', then 'html' directories.
*
*   @author Jason Savell <jsavell@library.tamu.edu>
*/
class AppViewRenderer extends HTMLViewRenderer {
    protected $viewPaths = array('bootstrap','html');

    public function setView($viewFile,$isAdmin=false) {
        $viewSet = false;
        if (!parent::setView($viewFile,$isAdmin)) {
            $config = $this->getAppConfiguration();
            $mainViewPath = $this->getViewPath();
            foreach ($this->viewPaths as $viewPath) {
                $this->setViewPath($config['PATH_VIEWS'].$viewPath.'/');
                if (parent::setView($viewFile,$isAdmin)) {
                    $viewSet = true;
                    break;
                }
            }
            $this->setViewPath($mainViewPath);
        }
        return $viewSet;
    }
}
