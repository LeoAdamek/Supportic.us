<h2>Reply To Ticket: <?=$ticket['Ticket']['title']?> </h2>

	<?php

		echo $this->Form->create('Ticket', array('controller' => 'tickets', 'action' => 'reply/'.$ticket['Ticket']['id'].'/'.$ticket['Ticket']['slug']));
		echo $this->Form->input('Message.body');
		echo $this->Form->end('Reply!');

	?>
