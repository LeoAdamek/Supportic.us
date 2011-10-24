<?php

	/*
	 * == File Info ==
	 * File: app_controller.php
	 *
	 * Use:
	 * This file is the main app controller, from which all other controllers gain their functionality.
	 */

	class AppController extends Controller {
		var $components = array('Auth','Session','DebugKit.Toolbar');
		var $helpers = array('Session','Js');

		function beforeFilter() {
			/*
			 * Override some default values, such has the password hashing algorithm
			 */

			Security::setHash('sha256');	// More Secure password hashing.

			$this->Auth->fields = array(
				'username' => 'email',			// Users use their E-mail address to log in.
				'password' => 'password'
			);

			$this->Auth->allow('*');

			// Error messages for Authentication.
			$this->Auth->loginError = "Invalid E-mail address, Password or your account has not been activated yet.";
			$this->Auth->authError = "You must be logged in to access this.";

			$this->Auth->userScope = array('User.isActivated' => true); // Users must have an activated account before they can log in.
		}
	}
?>
