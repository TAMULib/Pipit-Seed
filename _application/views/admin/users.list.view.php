<?php
echo '<div class="do-results">';
if ($users) {
	echo '<table class="list">
				<tr>
					<th>Last Name</th>
					<th>First Name</th>
					<th>Email</th>
					<th>Actions</th>
				</tr>';
	foreach ($users as $user) {
		if (!empty($user['inactive'])) {
			$rowClass = ' class="inactive"';
			$enableToggle = 'enable';
		} else {
			$rowClass = null;
			$enableToggle = 'disable';
		}
		echo "<tr{$rowClass}>
					<td>{$user['name_last']}</td>
					<td>{$user['name_first']}</td>
					<td>{$user['email']}</td>
					<td class=\"capitalize\">
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=edit&id={$user['id']}\">Edit</a> | 
						<a class=\"do-remove\" href=\"{$app_http}?action={$enableToggle}&id={$user['id']}\">{$enableToggle}</a>
					</td>
				</tr>";
	}
	echo '</table>';
} else {
	echo 'No users, yet!';
}
echo '</div>';
?>