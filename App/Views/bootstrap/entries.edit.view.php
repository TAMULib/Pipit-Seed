<?php
$entry = $parameters['entry'];
?>
<form class="do-submit" name="editentry" method="POST" action="<?php echo $app_http;?>">
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="id" value="<?php echo $entry['id'];?>" />
    <div class="form-group">
        <label for="entry[name]">Name</label>
        <input class="form-control" type="text" name="entry[name]" value="<?php echo $entry['name'];?>" />
    </div>
    <div class="form-group">
        <label for="entry[description]">Description</label>
        <textarea class="form-control" name="entry[description]"><?php echo $entry['description'];?></textarea>
    </div>
    <input class="btn btn-default" type="submit" name="submitentry" value="Update Entry" />
</form>
