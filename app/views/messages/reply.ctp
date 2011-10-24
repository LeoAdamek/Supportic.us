<h2>Reply To Ticket: <?=$ticket['Ticket']['title']?> </h2>

	<?php

		echo $this->Form->create('Message', array('controller' => 'messages', 'action' => 'reply/'.$ticket['Ticket']['id']));
		echo $this->Form->input('body');
		echo $this->Form->end('Reply!');

	?>
