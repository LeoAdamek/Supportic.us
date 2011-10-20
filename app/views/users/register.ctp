<?php

	/*
	 * == File Info ==
	 * User Register
	 * ./app/views/users/register.ctp
	 *
	 * The Registration page for Supportic.us
	 */

	echo $this->Form->create('Users', array('action' => 'register'));

	echo $this->Form->input('User_Name');
	echo $this->Form->input('User_AddressName');
	echo $this->Form->input('User_Password');
	echo $this->Form->input('User_Password_Confirm', array('type' => 'password'));	
	echo $this->Form->input('User_Email');
	echo $this->Form->end('Register My Account!');


?>
