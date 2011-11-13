<h2>Tickets Assigned To You</h2>

<small>
	These tickets have been assigned to you by organisations for whom you are a marked as a support staff.
</small>

	<?php if(empty($tickets)): ?>
		<small> You have no tickets assigned... Lucky you ;) </small>
	<?php else: ?>
		<table>
			<tr>
				<th span="col">Organisation</th>
				<th span="col">Title</th>
				<th span="col">Category</th>
				<th span="col">Posted By</th>
				<th span="col">Priority</th>
			</tr>
		
		<?php foreach($tickets as $ticket): ?>
		<tr class="ticket-<?=low($ticket['Ticket']['priority'])?>">
				<td><?=$ticket['Organisation']['name']?></td>
				<td>
					<?=
						$this->Html->link($ticket['Ticket']['title'],
							array(
								'controller' => 'tickets',
								'action' => 'view',
								$ticket['Ticket']['id'],
								$ticket['Ticket']['slug']
							)
						);
					?>
				</td>
				<td><?=$ticket['Category']['name']?></td>
				<td><?=$ticket['User']['name']?> (<?=$ticket['User']['addressName']?>)</td>
				<td><?=$ticket['Ticket']['priority']?><td/>
			</tr>
		<?php endforeach; ?>

		Total: <?=count($tickets)?> Tickets.

	<?php endif; ?>
