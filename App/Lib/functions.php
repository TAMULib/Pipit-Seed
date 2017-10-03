<?php
/**
*	Any global functions should be placed, here.
*	The core functions included provide an autoloader that handles the including of Classes and Interfaces
*
*/

require_once PATH_CORE_LIB."functions.php";

function buildUploadForm($baseUrl,$modalContext=null,$action='upload',$subaction=null,$hiddenFields=null) {
	$html = '<form class="do-upload form-inline" name="upload" method="POST" action="'.$baseUrl.'">';
	if ($modalContext) {
		$html .= '<input type="hidden" name="modal_context" value="'.$modalContext.'" />';
	}
	$html .= '	<input type="hidden" name="action" value="'.$action.'" />';
	if ($subaction) {
		$html .= '<input type="hidden" name="subaction" value="'.$subaction.'" />';
	}
	if ($hiddenFields) {
		foreach ($hiddenFields as $field) {
			$html .= '<input type="hidden" name="'.$field['name'].'" value="'.$field['value'].'" />';
		}
	}

	$html .= '	<input class="do-file-gloss" type="hidden" name="fileGloss" value="" />
				<div class="do-file-preview"></div>
				<input class="inline-block" type="file" name="file_input" />
				<input class="btn btn-default" type="submit" name="submitupload" value="Upload File" />
			</form>';
	return $html;
}

function buildHTMLUploadForm($baseUrl,$modalContext=null,$action='upload',$subaction=null,$hiddenFields=null) {
	$html = '<form class="do-upload vertical-spacer-bottom " name="upload" method="POST" action="'.$baseUrl.'">';
	if ($modalContext) {
		$html .= '<input type="hidden" name="modal_context" value="'.$modalContext.'" />';
	}
	$html .= '	<input type="hidden" name="action" value="'.$action.'" />';
	if ($subaction) {
		$html .= '<input type="hidden" name="subaction" value="'.$subaction.'" />';
	}
	if ($hiddenFields) {
		foreach ($hiddenFields as $field) {
			$html .= '<input type="hidden" name="'.$field['name'].'" value="'.$field['value'].'" />';
		}
	}

	$html .= '	<input class="do-file-gloss" type="hidden" name="fileGloss" value="" />
				<div class="do-file-preview"></div>
				<input class="inline-block" type="file" name="file_input" />
				<input class="inline-block small" type="submit" name="submitupload" value="Upload File" />
			</form>';
	return $html;
}
?>