<?php

echo buildUploadForm($app_http);
?>
<div class="do-results">
	<h4>Files in: <?php echo $parameters['scanned_directory']; ?></h4>
<?php
if ($parameters['files']) {
?>
	<table class="table">
		<tr>
			<th>Name</th>
			<th>Actions</th>
		</tr>
<?php
	foreach ($parameters['files'] as $file) {
		echo "<tr>
					<td>
						{$file->getGloss()}
					</td>
					<td>
						<a class=\"btn btn-default\" href=\"{$app_http}?action=download&fileName={$file->getGloss()}\">Download</a>";
		echo '			<form class="inline-block do-submit-confirm" name="removefile" method="POST" action="'.$app_http.'">
							<input type="hidden" name="action" value="remove" />
							<input type="hidden" name="fileName" value="'.$file->getGloss().'" />
							<input class="btn btn-default" type="submit" name="submitremove" value="Remove" />
						</form>';
		echo "		</td>
			</tr>";
	}
?>
	</table>
<?php
} else {
	echo "There doesn't seem to be any files in this directory. Upload some?";
}
?>
</div>
