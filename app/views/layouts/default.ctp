<?php $session->activate(); ?>


<html>
	<head>
		<title>Supporic.us</title>
	
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
