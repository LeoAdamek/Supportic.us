<?php
/* OrganisationCategory Test cases generated on: 2011-10-21 15:26:46 : 1319207206*/
App::import('Model', 'OrganisationCategory');

class OrganisationCategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.organisation_category', 'app.organisation', 'app.country', 'app.users', 'app.category', 'app.knowledge_base', 'app.permission', 'app.ticket');

	function startTest() {
		$this->OrganisationCategory =& ClassRegistry::init('OrganisationCategory');
	}

	function endTest() {
		unset($this->OrganisationCategory);
		ClassRegistry::flush();
	}

}
