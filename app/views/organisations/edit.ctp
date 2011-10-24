<?php

	echo $this->Html->script('jquery.optionTree');
	echo $this->Html->script('Organisations_Categories_Filter');

	echo $this->Form->create('Organisation', array('action' => 'edit/'.$organisation['Organisation']['id']));
	echo $this->Form->input('name');
	echo $this->Form->input('is_Private', array(
		'type' => 'checkbox',
		'label' => 'Private Organisation <span style="color:#CCC;">(Only selected users can access this organisations)</span>'
	));

?>

	<label for="data[Organisation][OrganisationCategory_id]" class="required vtip" title="Help people find you by category">What does your organisation do?</label>

<?php

	echo $this->Form->input('organisationCategory_id', array(
		'title' => 'What does your organisation do?',
		'class' => 'vtip',
		'id' => 'OCId',
		'type' => 'hidden'
	));

?>

<?php

	echo $this->Form->input('country_id');
	echo $this->Form->end('Submit Changes');

?>
