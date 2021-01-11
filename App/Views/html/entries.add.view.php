<?php
echo '<form class="do-submit" name="addbuilding" method="POST" action="'.$app_http.'">
            <input type="hidden" name="action" value="insert" />
            <div class="column column-half">
                <label for="entry[name]">Name</label>
                <input type="text" name="entry[name]" />
                <label for="entry[description]">Description</label>
                <textarea name="entry[description]"></textarea>
            </div>
            <input type="submit" name="submitentry" value="Add Entry" />
        </form>';
?>
