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

	function testValidation(){
		$baseTestData = array(
				'name' => 'Leo Adamek',
				'addressName' => 'Leo',
				'email' => 'leo@adamek.me',
				'password' => 'teapot',
				'signup_date' => date('Y-m-d H:i:s'),
				'country_id' => 199,
				'isActivated' => 0
			);

		$additionalTestCases = array(
			array(	// Valid Data
				array(),	// Base Test Case
				array('name' => 'Ian Martin'),
				array('name' => 'Amy-Rose'),
				array('name' =>	'Iån Mátîn'), // Fails (Possible Encoding Issue)
				array('name' => 'Björk Guðmundsdóttir'), // Fails (Possible Encodign Issue)
				array('name' => 'Michael Bernard-Anthony'),
				array('name' => 'Abu Karim Muhammad al-Jamil ibn Nidal ibn Abdulaziz al-Filistini'),

				array('addressName' => 'Ian Martin'),
				array('addressName' => 'Ian'),
				array('addressName' => 'Mao Ze Dong'),
				array('addressName' => 'Bjork'),
				array('addressName' => 'Boris'),
				array('addressName' => 'Amy'),
				array('addressName' => 'Amy-Rose'),
				array('addressName' => 'Perez Quinones'),
				array('addressName' => 'Joe Bloggs'),
				array('addressName' => 'Joe M Bloggs'),

				array('password' => 'cupcake'),
				array('password' => 'teacake'),
				array('password' => 'gumdrop'),
				array('password' => '123456'),
				array('password' => $this->User->generatePassword(6)),
				array('password' => $this->User->generatePassword(12)),
			),
			array( // Invalid Data
				array('name' => 'Ian Martin!'), // (!) is now allowed
				array('name' => 'I@n M@rtin'), // (@) is not allowed
				array('name' => 'Ian_Martin'), // (_) is not allowed

				array('addressName' => 'Amy_Rose'), // (_) is not allowed
				array('addressName' => 'Amy-R0se'), // (0) is not allowed
				array('addressName' => 'Pérez Quiñones'), // (é,ñ) are not allowed
				array('addressName' => 'Joe M. Bloggs'), // (.) is not allowed

				array('password' => '123'), // too short
				array('password' => 'abcde'), // too short
				array('password' => 'a'), // too short
				array('password' => 'jeans'),  // too short
				array('password' => $this->User->generatePassword(5)), // too short

				array('email' => 'foo@bar'), // invalid format
				array('email' => 'b@ar@baz.com'), // invalid format
				

			)
		);

		$Ucases = $this->__generateCasesOnGivenConditions($baseTestData, $additionalTestCases, 1);


		echo "<h2> Testing Validation </h2>";

		foreach($Ucases as $expected => $cases){
			foreach($cases as $case){
				$result = $this->User->save($case);

				if($expected != $result){
					debug($case);
				}

				if($expected){
				 	$this->assertTrue($result);
				}else{
					$this->assertFalse($result);
				}
			}
		}
	}

	function __generateCasesOnGivenConditions($baseCase, $testCases, $offset){
		$return = array();
		$trueConditions = $testCases[0];
		$falseConditions = $testCases[1];

		foreach($trueConditions as $index => $param){
			mt_srand();
			$param['email'] = 'example_' . $index + mt_rand(pow(2,32), pow(2,64)) . '@example.com';
			$return[true][] = array_merge($baseCase, $param);
		}

		foreach($falseConditions as $index => $param){
			mt_srand();
			$param['email'] = 'example_' . $index + count($trueConditions) + mt_rand(pow(2,32), pow(2,64)) . '@example.com';
			$return[false][] = array_merge($baseCase, $param);
		}

		return $return;
	}
}
