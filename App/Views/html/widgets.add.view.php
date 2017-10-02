<?php
echo '<form class="do-submit-validate" name="addbuilding" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="insert" />
			<div class="column column-half">
				<div class="form-group do-validate">
					<label for="widget[name]">Name</label>
					<input type="text" name="widget[name]" />
				</div>
				<div data-validator="validateNumeric" class="form-group do-validate">
					<label for="widget[part_count]">Count</label>
					<div class="alert alert-danger">Please enter a numeric value greater than zero</div>
					<input type="number" name="widget[part_count]" value="0" />
				</div>
				<div class="form-group">
					<label for="widget[description]">Description</label>
					<textarea name="widget[description]"></textarea>
				</div>
			</div>
			<input type="submit" name="submitwidget" value="Add Widget" />
		</form>';
?>