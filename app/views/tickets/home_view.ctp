<?php

	/* Homepage for Supporticus.
	 * Uses the homepage for additional content
	 */

?>

<?php if($this->Session->check('Auth.User.id')): ?>

	<?php if(!empty($tickets)): ?>

		<h2>Supportic.us - My Home</h2>

	<?php else: ?>

		<h2>Supportic.us - My Home</h2>

		<div class="no_tickets">
			<h4>It appears all your problems have been resolved</h4>
			<small>Lucky You</small>
		</div>

	<?php endif; ?>

<?php else: ?>


<?php endif; ?>
