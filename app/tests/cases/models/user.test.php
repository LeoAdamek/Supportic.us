<?php
/* User Test cases generated on: 2011-10-20 19:08:19 : 1319134099*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $fixtures = array('app.user');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

	/*
	 * Validation Unit Tests
	 */

	function testValidationAllowsNormalData(){
		$this->assertTrue($this->User->validates(array(
			'User' => array(
				'name' => 'Leo Adamek',
				'addressName' => 'Leo',
				'email' => 'leo@adamek.me',
				'password' => 'teapot',
				'signup_date' => date('Y-m-d H:i:s'),
				'country_id' => 200,
				'isActivated' => false
				)
			)	
		));

		$this->assertTrue($this->User->validates(array(
			'User' => array(
				'name' => 'Ian Martin',
				'addressName' => 'Ian',
				'email' => 'Ian.Martin@altoncollege.ac.uk',
				'password' => 'cupcake',
				'signup_date' => '2011-10-24 13:33:37',
				'country_id' => 199,
				'isActivated' => false
			))
		));
	}

	function testGeneratedPasswordsValidate(){
		$this->assertTrue($this->User->validates(array(
			'User' => array(
				'password' => $this->User->generatePassword(12) // Generated Password of 12 characters (should accept)
			))
		));
	}

	function testDisallowShortPasswords(){
		$this->assertFalse($this->User->validates(array(
			'User' => array(
				'password' => '123'
			))
		));
	}

	function testValidationHash(){
		//
	}

}
