<h2><?=$session->read('Auth.User.addressName')?>'s Organisations</h2>


<?php if(empty($Organisations)): ?>
	<small>You are not connected to any organisations</small>

<?php else: ?>

<table>
	<tr>
		<th span="col">Organisation</th>
		<th span="col">Available Actions</th>
	</tr>

<?php foreach($Organisations as $i => $org): ?>
	<tr>
		<td>
			<?=$this->Html->link($org['Organisation']['name'], array(
				'controller' => 'organisations',
				'action' => 'view',
				$org['Organisation']['id']),
				array('escape' => false))?>
		</td>
		<td><?=$org['Permission']['permissionType']?></td>
	</tr>
<?php endforeach; ?>

<?php endif; ?>
