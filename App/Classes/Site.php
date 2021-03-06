<?php
namespace App\Classes;
use Core\Classes as CoreClasses;
/** 
*	An app level Site class intended for customizations beyond what is offered by CoreSite
*	This is inactive by default. Enable by setting the SITE_CLASS constant to 'Site' in the configuration file
*	@author Jason Savell <jsavell@library.tamu.edu>
*/

class Site extends CoreClasses\CoreSite {
}