<?php
/**
*	Any global functions should be placed, here.
*	The core functions included provide an autoloader that handles the including of Classes and Interfaces
*
*/

require_once PATH_CORE_LIB."functions.php";

function buildUploadForm($baseUrl) {
	$html = '<form class="do-upload form-inline" name="upload" method="POST" action="'.$baseUrl.'">';
	$html .= '	<input type="hidden" name="action" value="upload" />
				<input class="do-file-gloss" type="hidden" name="fileGloss" value="" />
				<img class="do-file-preview" src="" />
				<input class="inline-block" type="file" name="file_input" />
				<input class="btn btn-default" type="submit" name="submitupload" value="Upload File" />
			</form>';
	return $html;
}
?>