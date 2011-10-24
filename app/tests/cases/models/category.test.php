<?php
/* Category Test cases generated on: 2011-10-24 18:07:31 : 1319476051*/
App::import('Model', 'Category');

class CategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.category', 'app.organisation', 'app.country', 'app.users', 'app.organisation_category', 'app.user', 'app.knowledge_base', 'app.ticket', 'app.message', 'app.knowledge_basis');

	function startTest() {
		$this->Category =& ClassRegistry::init('Category');
	}

	function endTest() {
		unset($this->Category);
		ClassRegistry::flush();
	}

}
