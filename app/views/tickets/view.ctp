<?=$this->Html->script('tickets/view')?>

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
			<h4><?=$message['User']['name']?> (<?=$message['User']['addressName']?>) Said [<?=$this->Time->timeAgoInWords($message['Message']['postdate'])?>]</h4>
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

	<a id="updatestatus">Update the Status of this ticket</a>

<div id="update_dialog" title="Update this ticket" style="display:none">
	<h3>Update This Ticket</h3>

	<?php
		echo $this->Form->create('Ticket', array('controller' => 'tickets', 'action' => "update_status/{$ticket['Ticket']['id']}"));
		echo $this->Form->input('Ticket.status');
		echo $this->Form->submit('Update');
	?>
</div>
