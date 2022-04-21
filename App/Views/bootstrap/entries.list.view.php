<div class="do-results">
<?php
if ($parameters['entries']) {
?>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
<?php
    foreach ($parameters['entries'] as $entry) {
        echo "<tr>
                    <td>{$entry['name']}</td>
                    <td class=\"capitalize\">";
echo '                  <a class="btn btn-default do-loadmodal" href="'.$app_http.'?action=edit&id='.$entry['id'].'">Edit</a>
                        <form class="inline-block do-submit-confirm" name="removeentry" method="POST" action="'.$app_http.'">
                            <input type="hidden" name="action" value="remove" />
                            <input type="hidden" name="id" value="'.$entry['id'].'" />
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
    echo 'No entries yet!';
}
?>
</div>
