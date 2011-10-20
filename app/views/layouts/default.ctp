<?php $session->activate(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Supporic.us</title>

		<meta http-eqiv="content-type" content="text/html;charset=utf-8" />

		<?=$this->Html->css('main.css')?>

		<?=$scripts_for_layout?>
		
	</head>

	<body>

		<div id="header">
				<h1>Supportic.us</h1>
		</div>

		<div id="navigation">
				<h3>{{Navigation}}</h3>
		</div>

		<div id="content_wrapper">

			<?=$this->Session->flash()?>

			<?=$content_for_layout?>
		</div>

		<?=$this->element('sql_dump')?>	

	</body>
</html>
