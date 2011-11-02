<h2>Reply To Ticket: <?=$ticket['Ticket']['title']?> </h2>

	<?php

		echo $this->Form->create('Message', array('controller' => 'messages', 'action' => 'reply/'.$ticket['Ticket']['id']));
		echo $this->Form->input('Message.body', array(
			'class' => 'tinymce',
			'cols' => '20'
		));
		echo $this->Form->end('Reply!');

	?>

	<?php
		echo $this->Html->script('tiny_mce/tiny_mce');
		echo $this->Html->script('tiny_mce/jquery.tinymce');
		echo $this->Html->script('tickets/tinymce');
	?>
