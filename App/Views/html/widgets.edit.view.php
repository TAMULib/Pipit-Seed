<?php
$widget = $parameters['widget'];
echo '<form class="do-submit-validate" name="editwidget" method="POST" action="'.$app_http.'">
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="id" value="'.$widget['id'].'" />
            <div class="column column-half">
                <div class="form-group do-validate">
                    <label for="widget[name]">Name</label>
                    <input type="text" name="widget[name]" value="'.$widget['name'].'" />
                </div>
                <div data-validator="validateNumeric" class="form-group do-validate">
                    <label for="widget[part_count]">Count</label>
                    <input type="number" name="widget[part_count]" value="'.$widget['part_count'].'" />
                </div>
                <div class="form-group">
                    <label for="widget[description]">Description</label>
                    <textarea name="widget[description]">'.$widget['description'].'</textarea>
                </div>
            </div>
            <input type="submit" name="submitwidget" value="Update Widget" />
        </form>';
?>
