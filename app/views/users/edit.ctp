<h2>Edit Your Account</h2>

<?php
	echo $this->Form->create('User',array('controller' => 'Users','action' => 'edit'));
	echo $this->Form->input('name', array(
		'label' => 'Your Name',
		'title' => 'Your name, as you would write it normally',
		'class' => 'vtip'
	));
	echo $this->Form->input('addressName', array(
		'label' => 'How would you like to be called?',
		'title' => 'A friendly name to be used by support staff, may only contain letters A-Z, hyphens (-) and Spaces',
		'class' => 'vtip'
	));
	echo $this->Form->input('password', array(
		'label' => 'Your Password <span style="color: #CCC">(Only Enter a Value if you wish to change your password)</span>',
		'title' => 'Enter a New Passsword (Must be at least 6 characters)',
		'class' => 'vtip'
	));
	echo $this->Form->input('password_confirm', array(
		'type'  => 'password',
		'label' => 'Confirm your password <span style="color: #CCC">(Only if changing your password)</span>',
		'title' => 'Confirm your password, if changing it.',
		'class' => 'vtip'
	));
	echo $this->Form->input('email',array(
		'label' => 'Your E-mail Address',
		'title' => 'Your E-mail Address (Please enter a valid address)',
		'class' => 'vtip'
	));

	echo $this->Form->end('Update My Account');

?>
