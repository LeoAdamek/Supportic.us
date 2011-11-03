<h1><?=$org['Organisation']['name']?></h1>

<h4>About <?=$org['Organisation']['name']?> </h4>
	<p>
		Location: <?=$this->Html->image('flags/'.low($org['Country']['code']).'.png')?> <?=$org['Country']['name']?> <br />
		Created By: <?=$org['User']['name']?> <br />
		Category: <?=$org['OrganisationCategory']['name']?>
	</p>

	<h3><?php echo $this->Html->link('Submit A Ticket', array('controller' => 'tickets', 'action' => 'add', $org['Organisation']['id'])); ?></h3>

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

