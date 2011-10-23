<?php $session->activate(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Supporic.us <?php if(isset($title_for_layout)){ echo " | ".$title_for_layout; }?></title>

		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

		<?=$this->Html->css('main.css')?>
		<?=$this->Javascript->link('jQuery.min.js')?>
		<?=$this->Javascript->link('vtip-min.js')?>
		<?=$scripts_for_layout?>
		
	</head>

	<body>
	

		<div id="header">
				<h1>Supportic.us</h1>
		</div>

		<div id="navigation">
				<h3>Navigation</h3>
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
