<div class="do-results">
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
    <table class="list">
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
<?php
    foreach ($results as $widget) {
        echo "<tr>
                    <td>{$widget->getName()}</td>
                    <td class=\"capitalize\">
                        <a class=\"inline-block button button-small do-loadmodal\" href=\"{$app_http}?action=parts&widgetid={$widget->getId()}\">Parts</a>
                        <a class=\"inline-block button button-small do-loadmodal\" href=\"{$app_http}?action=attachments&widgetid={$widget->getId()}\">Attachments</a>
                        <a class=\"inline-block button button-small do-loadmodal\" href=\"{$app_http}?action=edit&id={$widget->getId()}\">Edit</a>";
echo '                  <form class="inline-block do-submit-confirm" name="removewidget" method="POST" action="'.$app_http.'">
                            <input type="hidden" name="action" value="remove" />
                            <input type="hidden" name="id" value="'.$widget->getId().'" />
                            <input class="inline-block small" type="submit" name="submitremove" value="Remove" />
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
