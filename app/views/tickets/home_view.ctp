<?php

	/* Homepage for Supporticus.
	 * Uses the homepage for additional content
	 */

?>

<?php if($this->Session->check('Auth.User.id')): ?>

	<?php if(!empty($tickets)): ?>

		<h2>Supportic.us - My Home</h2>

		<table>
			<tr>
				<th span="col">Title</th>
				<th span="col">Organisation</th>
				<th span="col">Posted</th>
			</tr>

		<?php foreach($tickets as $ticket): ?>
		
			<tr>
				<td>
					<?=$this->Html->link($ticket['Ticket']['title'], array(
						'controller' => 'tickets',
						'action' => 'view',
						$ticket['Ticket']['id'],
						$ticket['Ticket']['slug']
					))?>
				</td>
				<td><?=$ticket['Organisation']['name']?></td>
				<td><?=$ticket['Ticket']['postdate']?></td>
			</tr>
		
		<?php endforeach; ?>

		</table>

		<small><?=count($tickets)?> Tickets</small>

	<?php else: ?>

		<h2>Supportic.us - My Home</h2>

		<div class="no_tickets">
			<h4>It appears all your problems have been resolved</h4>
			<small>Lucky You</small>
		</div>

	<?php endif; ?>

<?php else: ?>

	<?php
		/*
		 * User is not logged in, display the 'About' Page
		 */
	?>

	<h2>Supportic.us</h2>
	
	<div style="padding-left: 20px;">
		<h4>What is Supportic.us?</h4>
			<p>Supportic.us is an online customer and corporate support system.<br />
			It is intended for use by people and organisations all over the world. To help solve issues and find information<br />
			</p>

	</div>


<?php endif; ?>
