<?php
namespace App\Classes;
use Core\Classes as CoreClasses;
/** 
*	An example app level logger. This can be activated in the config file and rewritten to be useful.
*	@author Jason Savell <jsavell@library.tamu.edu>
*/

class Logger extends CoreClasses\CoreLogger {
	public function writeToLog($entry) {
		$entry[1] = "(App Log) {$entry[1]}";
		parent::writeToLog($entry);
	}
}
