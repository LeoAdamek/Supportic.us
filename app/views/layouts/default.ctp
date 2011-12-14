<?php $session->activate(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Supportic.us <?php if(isset($title_for_layout)){ echo " | ".$title_for_layout; }?></title>

		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

		<?=$this->Html->css('main.css')?>
		<?=$this->Html->css('print.css', 'stylesheet', array('media' => 'print'))?>
		<?=$this->Html->script('jQuery.min')?>
		<?=$this->Html->script('jquery-ui-1.8.16.custom.min')?>
		<?=$this->Html->css('jqui.css')?>
		<?=$this->Html->script('vtip-min')?>
		<?=$scripts_for_layout?>
		
	</head>

	<body>
	

		<div id="header">
			<h1><?=$this->Html->link('Supportic.us', '/')?></h1>
		</div>

		<div id="navigation">

				<?php // The Global Navigation ?>
				<ul class="menu">
					<li><?=$this->Html->link('Home','/')?></li>
					<li><?=$this->Html->link('Organisations', array('controller' => 'Organisations', 'action' => 'index'))?></li>
					<li>My Account
						<ul>
							<li><?=$this->Html->link('My Tickets', array('controller' => 'Tickets', 'action' => 'my_tickets'))?></li>
							<li><?=$this->Html->link('My Organisations', array('controller' => 'Organisations', 'action' => 'my_organisations'))?></li>
						</ul>
					</li>
				</ul>

				<?php // End Global Navigation ?>


				<div id="userpane">
					<?php if($session->check('Auth.User.id')): ?>
					<p style="color: white;">Logged In As: <?=$this->Html->link($session->read('Auth.User.addressName'), array('controller' => 'users', 'action' => 'edit'))?> | <?=$this->Html->link('Log Out', array(
						'controller' => 'users',
						'action' => 'logout'
					))?>
					<?php else: ?>
						<?=$this->Html->link('Log In', array(
							'controller' => 'users',
							'action' => 'login'
						))?>
					<?php endif; ?>
				</div>
		</div>
	
		<div id="content_wrapper">

			<?=$this->Session->flash()?>
			<?=$this->Session->flash('auth')?>

			<?=$content_for_layout?>
		</div>
	</body>
</html>
