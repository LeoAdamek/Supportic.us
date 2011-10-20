<?php

	/*
	 * == File Info ==
	 * User Register
	 * ./app/views/users/register.ctp
	 *
	 * The Registration page for Supportic.us
	 */

	echo $this->Form->create('user', array('action' => 'register'));

	echo $this->Form->input('name');
	echo $this->Form->input('addressName');
	echo $this->Form->input('password');
	echo $this->Form->input('password_confirm');
	echo $this->Form->input('email');
	echo $this->Form->end('Register My Account!');


?>
