<?php

	echo $this->Form->create('Organisation', array('controller'=>'organisations','action'=>'add'));
	echo $this->Form->input('name');
	echo $this->Form->input('is_private', array(
		'type' => 'checkbox',
		'label' => 'This organisation is private. <span style="color:#CCC">(Only Selected members can access this organisation)</span>'
	));
	echo $this->Form->input('country_id');
	echo $this->Form->input('organisationCategory_id');
	echo $this->Form->end('Create!');

?>
