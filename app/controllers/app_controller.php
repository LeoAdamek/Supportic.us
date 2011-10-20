<?php

	/*
	 * == File Info ==
	 * File: app_controller.php
	 *
	 * Use:
	 * This file is the main app controller, from which all other controllers gain their functionality.
	 */

	class AppController extends Controller {
		var $components = array('Auth','Session');

		function beforeFilter() {
			/*
			 * Override some default values, such has the password hashing algorithm
			 */

			Security::setHash('sha256');	// More Secure password hashing.

			$this->Auth->fields = array(
				'username' => 'email',			// Users use their E-mail address to log in.
				'password' => 'password'
			);
		}
	}



?>
