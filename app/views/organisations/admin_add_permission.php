<h2>Grant Permissions within <?=$org['Organisation']['name']?></h2>

<?php

	echo $this->Form->create('Permission', array(
		'controller' => 'organisations',
		'action' => 'admin_add_permission',
		$org['Organisation']['id']
	));

	echo $this->Form->input('User.email', array(
		'label' => "User's E-mail Address",
		'class' => 'vtip',
		'title' => 
		"Enter the E-mail address of the user who you wish to grant permissions to. <br />
		If they don't have an account, they'll be sent an invite for one."
	));

	echo $this->Form->input('Permission.permissionType', array(
		'label' => "What Access Do You Want To Grant?",
		'class' => 'vtip',
		'title' => "Select the type of access you want to grant the user. (User's can have multiple permissions)"
	));

	echo $this->Form->end("Grant Access!");

?>
