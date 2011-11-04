<?php
/* KnowledgeBasis Test cases generated on: 2011-11-04 15:52:46 : 1320421966*/
App::import('Model', 'KnowledgeBasis');

class KnowledgeBasisTestCase extends CakeTestCase {
	var $fixtures = array('app.knowledge_basis', 'app.organisation', 'app.country', 'app.users', 'app.organisation_category', 'app.category', 'app.ticket', 'app.user', 'app.permission', 'app.message', 'app.knowledge_base');

	function startTest() {
		$this->KnowledgeBasis =& ClassRegistry::init('KnowledgeBasis');
	}

	function endTest() {
		unset($this->KnowledgeBasis);
		ClassRegistry::flush();
	}

}
