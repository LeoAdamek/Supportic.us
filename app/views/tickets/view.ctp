<h2>Ticket: <?=$ticket['Ticket']['title']?></h2>

	<h3>Posted By: <?php
		if($ticket['User']['id'] == $session->read('Auth.User.id')){
			echo 'You';
		}else{
			echo $ticket['User']['name'];
		}
	?> </h3>

	<h4>Messages</h4>

	<div id="message_container">
		<?php foreach($messages as $message): ?>

			<div class="message">
			<h4><?=$message['User']['name']?> (<?=$message['User']['addressName']?>) Said:</h4>
					<p><?=$message['Message']['body']?></p>
			</div>

		<?php endforeach; ?>

	</div>

	<?=$this->Html->link('Reply To This Ticket', array(
		'controller' => 'messages',
		'action' => 'reply',
		$ticket['Ticket']['id'],
		$ticket['Ticket']['slug']
	))?>

