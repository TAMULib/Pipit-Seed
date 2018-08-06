<div class="do-results">
<?php
if ($parameters['entries']) {
?>
    <table class="list">
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
<?php
    foreach ($parameters['entries'] as $entry) {
        echo "<tr>
                    <td>{$entry['name']}</td>
                    <td class=\"capitalize\">
                        <a class=\"inline-block button button-small do-loadmodal\" href=\"{$app_http}?action=edit&id={$entry['id']}\">Edit</a>";
echo '                  <form class="inline-block do-submit-confirm" name="removeentry" method="POST" action="'.$app_http.'">
                            <input type="hidden" name="action" value="remove" />
                            <input type="hidden" name="id" value="'.$entry['id'].'" />
                            <input class="inline-block small" type="submit" name="submitremove" value="Remove" />
                        </form>';
echo "
                    </td>
                </tr>";
    }
?>
    </table>
<?php
} else {
    echo 'No entries, yet!';
}
?>
</div>
