<?php
echo '<form class="do-submit-validate" name="addwidget" method="POST" action="'.$app_http.'">
            <input type="hidden" name="action" value="insert" />
            <div class="form-group do-validate">
                <label for="widget[name]">Name</label>
                <input class="form-control" type="text" name="widget[name]" />
            </div>
            <div data-validator="validateNumeric" class="form-group do-validate">
                <label for="widget[part_count]">Count</label>
                <div class="alert alert-danger">Please enter a numeric value greater than zero</div>
                <input class="form-control" type="number" name="widget[part_count]" />
            </div>
            <div class="form-group">
                <label for="widget[description]">Description</label>
                <textarea class="form-control" name="widget[description]"></textarea>
            </div>
            <input class="btn btn-default" type="submit" name="submitwidget" value="Add Widget" />
        </form>';
?>
