<?php

echo buildHTMLUploadForm($app_http);
?>
<div class="do-results">
    <h4>Files in: <?php echo $parameters['scanned_directory']; ?></h4>
<?php
if ($parameters['files']) {
?>
    <table class="list">
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
                        <a class=\"inline-block button button-small do-loadmodal\" href=\"{$app_http}?action=download&fileName={$file->getGloss()}\">Download</a>";
        echo '          <form class="inline-block do-submit-confirm" name="removefile" method="POST" action="'.$app_http.'">
                            <input type="hidden" name="action" value="remove" />
                            <input type="hidden" name="fileName" value="'.$file->getGloss().'" />
                            <input class="inline-block small" type="submit" name="submitremove" value="Remove" />
                        </form>';
        echo "      </td>
            </tr>";
    }
?>
    </table>
<?php
} else {
    echo "<div>There doesn't seem to be any files in this directory. Upload some?</div>";
}
?>
</div>
