<?php

	/*
	 * == File Info ==
	 * User Register
	 * ./app/views/users/register.ctp
	 *
	 * The Registration page for Supportic.us
	 */

	debug($countries);

	echo $this->Form->create('User', array('action' => 'register'));

	echo $this->Form->input('name');
	echo $this->Form->input('addressName');
	echo $this->Form->input('password');
	echo $this->Form->input('password_confirm', array(
		'type' => 'password',
		'class' => 'required'
	));
	echo $this->Form->input('email');
	echo $this->Form->input('country_id');
	echo $this->Form->end('Register My Account!');


?>
