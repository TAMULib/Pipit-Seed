<div class="do-results">
    <form class="do-submit vertical-spacer-bottom" name="addpart" method="POST" action="<?php echo $app_http;?>">
<?php
$widget = $parameters['widget'];
$modalContext = 'action=parts&widgetid='.$widget->getId();
echo '  <input type="hidden" name="modal_context" value="'.$modalContext.'" />
        <input type="hidden" name="action" value="parts" />
        <input type="hidden" name="subaction" value="add" />
        <input type="hidden" name="widgetid" value="'.$widget->getId().'" />
        <div class="input-group col col-sm-6 col-xs-10">
            <input class="form-control" type="text" name="part[name]" />
            <span class="input-group-btn">
                <input class="btn btn-default" type="submit" name="submitadd" value="Add" />
            </span>
        </div>
    </form>';
if ($parameters['parts']) {
?>
    <table class="table">
        <tr>
            <th>Part</th>
            <th>Actions</th>
        </tr>
<?php
    foreach ($parameters['parts'] as $part) {
        echo "<tr>
                    <td>{$part['name']}</td>
                    <td class=\"capitalize\">";
echo '                  <form class="inline-block do-submit-confirm" name="removepart" method="POST" action="'.$app_http.'">
                            <input type="hidden" name="modal_context" value="'.$modalContext.'" />
                            <input type="hidden" name="action" value="parts" />
                            <input type="hidden" name="subaction" value="remove" />
                            <input type="hidden" name="partid" value="'.$part['id'].'" />
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
    echo 'No parts, yet!';
}

?>
</div>
