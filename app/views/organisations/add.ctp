<?php

	$this->Form->create('Organisation', array('controller'=>'organisations','action'=>'add'));
	$this->Form->input('name');
	$this->Form->input('is_private');
	$this->Form->input('country_id');
	$this->Form->end('Create!');

?>
