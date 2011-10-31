<h2>Submit a new ticket to  <?=$info['Organisation']['name']?></h2>


<script type="text/javascript">
var org_id = <?=$info['Organisation']['id']?>;
</script>

<?php

	echo $this->Html->script('jquery.optionTree_ticket');
	echo $this->Html->script('ticket_categories_filter');

	echo $this->Form->create('Ticket', array('controller' => 'Tickets','action' => 'add/'.$info['Organisation']['id'].'/'.$info['Organisation']['slug']));
	echo $this->Form->input('title', array(
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
