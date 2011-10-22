<?php

	/*
	 * == File Info ==
	 * User Register
	 * ./app/views/users/register.ctp
	 *
	 * The Registration page for Supportic.us
	 */


?>


<?php

	echo $this->Form->create('User', array('action' => 'register'));

	echo $this->Form->input('name', array(
		'label' => 'Your Name',
		'title' => 'Your name, as you would write it normally',
		'class' => 'vtip'
	));
	echo $this->Form->input('addressName', array(
		'label' => 'How would you like to be known?',
		'title' => 'A friendly name for support staff to use, may only contain A-Z, hyphens (-) and spaces',
		'class' => 'vtip'
	));
	echo $this->Form->input('password', array(
		'title' => 'Your super-secret password, must be at least 6 characters',
		'class' => 'vtip'
	));
	echo $this->Form->input('password_confirm', array(
		'type' => 'password',
		'title' => 'Please confirm your password',
		'class' => 'vtip'
	));
	echo $this->Form->input('email', array(
		'label' => 'Your E-mail Address',
		'title' => 'Please Supply a valid E-mail address, you will need to verify it before logging in.',
		'class' => 'vtip'
	));
	echo $this->Form->input('country_id', array(
		'label' => 'Where do you live?',
		'title' => 'Tell use where you live so you can find companies and groups close to you.',
		'class' => 'vtip'
	));
	echo $this->Form->end('Register My Account!');


?>
