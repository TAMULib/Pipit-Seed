<?php
$entry = $parameters['entry'];
echo '<form class="do-submit" name="editentry" method="POST" action="'.$app_http.'">
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="id" value="'.$entry['id'].'" />
            <div class="column column-half">
                <label for="entry[name]">Name</label>
                <input type="text" name="entry[name]" value="'.$entry['name'].'" />
                <label for="entry[description]">Description</label>
                <textarea name="entry[description]">'.$entry['description'].'</textarea>
            </div>
            <input type="submit" name="submitentry" value="Update Entry" />
        </form>';
?>
