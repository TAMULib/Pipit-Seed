<div class="do-results">
<?php
if ($parameters['pagedWidgets']) {
	$resultsPage = $parameters['pagedWidgets'];
	$prevDisabled = ($resultsPage->getPage() <= 1) ? true:false;
	$nextDisabled = ($resultsPage->getPage() == $resultsPage->getPageCount()) ? true:false;
?>
	<table class="table">
		<tr>
			<th>Name</th>
			<th>Actions</th>
		</tr>
<?php
	foreach ($resultsPage->getPageResults() as $widget) {
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
?>
<nav aria-label="Page navigation">
  <ul class="pagination">
    <li<?php if ($prevDisabled) { echo ' class="disabled"';}?>>
      <a href="<?php echo $app_http.'?page='.($resultsPage->getPage()-1);?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
<?php
for ($x=1;$x <= $resultsPage->getPageCount();$x++) {
    echo '<li><a href="'.$app_http.'?page='.$x.'">'.$x.'</a></li>';
}
?>
    <li<?php if ($nextDisabled) { echo ' class="disabled"';}?>>
      <a href="<?php echo $app_http.'?page='.($resultsPage->getPage()+1);?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
<?php
	}
} else {
	echo 'No widgets, yet!';
}
?>
</div>
