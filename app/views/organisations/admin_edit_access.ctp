<h2>Edit the Permissions</h2>

<table>
	<tr>
		<th span="col">Name</th>
		<th span="col">Permission Granted</th>
	</tr>

	<?php foreach($permissions as $index => $permission): ?>

		<tr>
			<td><?=$permission['User']['name']?> (<?=$permission['User']['addressName']?>) </td>
			<td><?=$permission['Permission']['permissionType']?> <?=$this->Html->link('Edit', array(
				'controller' => 'permissions',
				'action' => 'edit',
				$permission['Organisation']['id'],
				$permission['Permission']['id']
			))?></td>
		</tr>

	<?php endforeach; ?>

