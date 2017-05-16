<form class="do-submit" name="addentry" method="POST" action="<?php echo $app_http;?>">
	<input type="hidden" name="action" value="insert" />
	<div class="form-group">
		<label for="entry[name]">Name</label>
		<input class="form-control" type="text" name="entry[name]" />
	</div>
	<div class="form-group">
		<label for="entry[description]">Description</label>
		<textarea class="form-control" name="entry[description]"></textarea>
	</div>
	<input class="btn btn-default" type="submit" name="submitentry" value="Add Entry" />
</form>
