<?php

	echo $this->Form->create('Organisation', array('controller'=>'organisations','action'=>'add'));
	echo $this->Form->input('name');
	echo $this->Form->input('is_private');
	echo $this->Form->input('country_id');
	echo $this->Form->end('Create!');

?>
