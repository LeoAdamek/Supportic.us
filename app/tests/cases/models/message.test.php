<?php
/* Message Test cases generated on: 2011-10-24 17:55:47 : 1319475347*/
App::import('Model', 'Message');

class MessageTestCase extends CakeTestCase {
	var $fixtures = array('app.message', 'app.ticket', 'app.user', 'app.country', 'app.users', 'app.organisation', 'app.organisation_category', 'app.category', 'app.knowledge_base');

	function startTest() {
		$this->Message =& ClassRegistry::init('Message');
	}

	function endTest() {
		unset($this->Message);
		ClassRegistry::flush();
	}

}
