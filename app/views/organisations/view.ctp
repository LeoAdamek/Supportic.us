<h1><?=$org['Organisation']['name']?></h1>

<h4>About <?=$org['Organisation']['name']?> </h4>
	<p>
		Location: <?=$this->Html->image('flags/'.low($org['Country']['code']).'.png')?> <?=$org['Country']['name']?> <br />
		Created By: <?=$org['User']['name']?> <br />
		Category: <?=$org['OrganisationCategory']['name']?>
	</p>

	<br />
	<br />

	<?php echo $this->Html->link('Submit A Ticket', array('controller' => 'tickets', 'action' => 'add', $org['Organisation']['id']),array('class' => 'action')); ?>
	<?php echo $this->Html->link('View Help Articles', array('controller' => 'knowledge_bases', $org['Organisation']['id'], $org['Organisation']['slug']),array('class' => 'action')); ?>

	<?php if($permissionList['Edit']): ?>

		<?=$this->Html->link('Edit This Organisation', array(
			'controller' => 'organisations',
			'action' => 'edit',
			$org['Organisation']['id']
		),array(
			'class' => 'action'
		))?>

	<?php endif; ?>

<?php if($permissionList['EditPermissions']){ 
		echo $this->Html->link('Grant Access Privilages', array(
			'controller' => 'organisations',
			'action' => 'admin_add_access',
			$org['Organisation']['id']
		),array(
			'class' => 'action'
		));

		echo $this->Html->link('Edit Access Priviliages', array(
			'controller' => 'organisations',
			'action' => 'admin_edit_access',
			$org['Organisation']['id']
		),array(
			'class' => 'action'
		));
	} ?>

<?php if($permissionList['Support']){
	echo $this->Html->link('View Tickets', array(
		'controller' => 'tickets',
		'action' => 'my_org_tickets',
	),array(
		'class' => 'action'
	));
}
?>
