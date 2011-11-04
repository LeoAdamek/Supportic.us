<?php
/* Permissions Test cases generated on: 2011-11-04 14:53:11 : 1320418391*/
App::import('Controller', 'Permissions');

class TestPermissionsController extends PermissionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PermissionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.permission', 'app.user', 'app.country', 'app.users', 'app.organisation', 'app.organisation_category', 'app.category', 'app.ticket', 'app.message', 'app.knowledge_base');

	function startTest() {
		$this->Permissions =& new TestPermissionsController();
		$this->Permissions->constructClasses();
	}

	function endTest() {
		unset($this->Permissions);
		ClassRegistry::flush();
	}

}
