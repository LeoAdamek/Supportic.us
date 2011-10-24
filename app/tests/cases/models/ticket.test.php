<?php
/* Ticket Test cases generated on: 2011-10-24 17:52:46 : 1319475166*/
App::import('Model', 'Ticket');

class TicketTestCase extends CakeTestCase {
	var $fixtures = array('app.ticket', 'app.user', 'app.country', 'app.users', 'app.organisation', 'app.organisation_category', 'app.category', 'app.knowledge_base', 'app.message');

	function startTest() {
		$this->Ticket =& ClassRegistry::init('Ticket');
	}

	function endTest() {
		unset($this->Ticket);
		ClassRegistry::flush();
	}

}
