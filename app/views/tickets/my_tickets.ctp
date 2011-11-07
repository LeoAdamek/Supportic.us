<h1>My Tickets</h1>

<h4>About</h4>
<p>Here are a list of all tickets posted by you.</p>

<div id="searchform">
<h3> Search Your Tickets </h3>

<?php

	// Tickets search form
	echo $this->Form->create();
	echo $this->Form->input('Ticket.title');
	echo $this->Form->input('Ticket.priority');
	echo $this->Form->end('Search');

?>


</div>
<a id="searchToggle">Search These Tickets</a>




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
				), array('escape' => false));
				?>
			</td>
			<td> 
				<?=$ticket['Organisation']['name']?>
			</td>
			<td>[[LAST POST]]</td>
		</tr>
	<?php endforeach; ?>


	</table>

<?=$this->Html->script('tickets/ticket_search.js')?>
