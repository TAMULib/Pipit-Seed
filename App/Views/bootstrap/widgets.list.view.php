<div class="do-results">
    <div>
<?php
if ($parameters['pagedWidgets'] || $parameters['widgets']) {
    $results = [];
    if ($parameters['pagedWidgets']) {
        $resultsPage = $parameters['pagedWidgets'];
        $results = $resultsPage->getPageResults();
    } else {
        $results = $parameters['widgets'];
    }
?>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
<?php
    foreach ($results as $widget) {
        echo "<tr>
                    <td>{$widget['name']}</td>
                    <td class=\"capitalize\">";
echo '					<a class="btn btn-default do-loadmodal" href="'.$app_http.'?action=parts&widgetid='.$widget['id'].'">Parts</a>
                        <a class="btn btn-default do-loadmodal" href="'.$app_http.'?action=attachments&widgetid='.$widget['id'].'">Attachments</a>
                        <a class="btn btn-default do-loadmodal" href="'.$app_http.'?action=edit&id='.$widget['id'].'">Edit</a>
                        <form class="inline-block do-submit-confirm" name="removewidget" method="POST" action="'.$app_http.'">
                            <input type="hidden" name="action" value="remove" />
                            <input type="hidden" name="id" value="'.$widget['id'].'" />
                            <input class="btn btn-default" type="submit" name="submitremove" value="Remove" />
                        </form>';
echo "
                    </td>
                </tr>";
    }
?>
    </table>
<?php
    if ($resultsPage->getPageCount() > 1) {
        echo buildResultsPageNav($app_http,$resultsPage);
    }
} else {
    echo 'No widgets, yet!';
}
?>
    </div>
</div>
