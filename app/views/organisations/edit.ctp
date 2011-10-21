<?php

	echo $this->Form->create('Organisation', array('action' => 'edit/'.$organisation['Organisation']['id']));
	echo $this->Form->input('Name');
	echo $this->Form->input('is_Private', array(
		'type' => 'checkbox',
		'label' => 'Private Organisation <span style="color:#CCC;">(Only selected users can access this organisations)</span>'
	));

	echo $this->Form->input('organisationCategory_id');
	echo $this->Form->input('Country_id');
	echo $this->Form->end('Submit Changes');

?>
