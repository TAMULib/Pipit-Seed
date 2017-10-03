<?php
$modalContext = 'action=attachments&widgetid='.$parameters['widget']['id'];

echo buildUploadForm($app_http,$modalContext,'attachments','add',array(array("name"=>"widgetid","value"=>$parameters['widget']['id'])));
?>
<div class="do-results">
<?php
if ($parameters['attachments']) {
?>
	<table class="table">
		<tr>
			<th>Attachment</th>
			<th>Uploaded</th>
			<th>Uploader</th>
			<th>Actions</th>
		</tr>
<?php
	foreach ($parameters['attachments'] as $file) {
		echo "<tr>
					<td>{$file->getGloss()}</td>
					<td>{$file->getUploadDate()}</td>
					<td>{$file->getUploaderData()['username']}</td>
					<td class=\"capitalize\">
						<a class=\"btn btn-default\" href=\"{$app_http}?action=attachments&subaction=download&attachmentid={$file->getId()}\">Download</a>";
		echo '			<form class="inline-block do-submit-confirm" name="removeattachment" method="POST" action="'.$app_http.'">
							<input type="hidden" name="modal_context" value="'.$modalContext.'" />
							<input type="hidden" name="action" value="attachments" />
							<input type="hidden" name="subaction" value="remove" />
							<input type="hidden" name="attachmentid" value="'.$file->getId().'" />
							<input class="btn btn-default" type="submit" name="submitremove" value="Remove" />
						</form>';
echo "
					</td>
				</tr>";
	}
?>
	</table>
<?php
} else {
	echo '<div>No attachments, yet!</div>';
}

?>
</div>
