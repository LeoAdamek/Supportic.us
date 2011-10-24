<h2>Submit a new ticket to  <?=$info['Organisation']['name']?></h2>

<?php

	echo $this->Html->script('jquery.optionTree');
	echo $this->Html->script('ticket_categories_filter');

	echo $this->Form->create('Ticket', array('controller' => 'Tickets','action' => 'add/'.$info['Organisation']['id'].'/'.$info['Organisation']['slug']));
	echo $this->Form->input('Title', array(
		'label' => "What's the Problem?",
		'title' => 'A short Summary of the problem',
		'class' => 'vtip'
	));

	echo $this->Form->input('Message.body', array(
		'label' => 'Tell us about your problem...'
	));

	echo $this->Form->input('Category_id', array(
		'type' => 'hidden',
		'id' => 'categoryId'
	));

	echo $this->Form->end('Submit!');

?>
