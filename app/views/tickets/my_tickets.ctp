<h1>My Tickets</h1>

<h4>About</h4>
<p>Here are a list of all tickets posted by you.</p>

	<table id="tickets">
		<tr>
			<th span="col"><?=$this->Paginator->sort('Date','Ticket.postdate')?></th>
			<th span="col"><?=$this->Paginator->sort('Title','Ticket.title')?></th>
			<th span="col"><?=$this->Paginator->sort('Organisation','Organisation.name')?></th>
			<th span="col"><?=$this->Paginator->sort('Last Reply','Message.postdate')?></th>
		</tr>

	<?php foreach($tickets as $ticket): ?>
		<tr>
		  <td><?=$ticket['Ticket']['postdate']?> (<?=$this->Time->timeAgoInWords($ticket['Ticket']['postdate'])?>)  </td>
			<td>
				<?=$this->Html->link($ticket['Ticket']['title'], array(
					'controller' => 'tickets',
					'action' => 'view',
					$ticket['Ticket']['id']
				));
				?>
			</td>
			<td> 
				<?=$ticket['Organisation']['name']?>
			</td>
			<td>[[LAST POST]]</td>
		</tr>
	<?php endforeach; ?>


	</table>
