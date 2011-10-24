<?php

	echo $this->Html->script('jquery.optionTree');
	echo $this->Html->script('Organisations_Categories_Filter');

	echo $this->Form->create('Organisation', array('controller'=>'organisations','action'=>'add'));
	echo $this->Form->input('name', array(
		'title' => "The name of your organisation, must be at least 6 characters.",
		'class' => "vtip"
	));
	echo $this->Form->input('is_private', array(
		'type' => 'checkbox',
		'label' => 'This organisation is private. <span style="color:#CCC">(Only Selected members can access this organisation)</span>'
	));
	echo $this->Form->input('country_id', array(
		'title' => 'The primary operating country of your organisation',
		'class' => 'vtip'
	));
	echo $this->Form->input('organisationCategory_id', array(
		'title' => 'What does your organisation do?',
		'class' => 'vtip',
		'id' => 'OCId',
		'type' => 'hidden'
	));

?>

	<div id="OrganisationSelectTree"></div>

<?php

	echo $this->Form->end('Create!');

?>
