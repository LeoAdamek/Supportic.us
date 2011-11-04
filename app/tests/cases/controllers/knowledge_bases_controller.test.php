<?php
/* KnowledgeBases Test cases generated on: 2011-11-04 15:50:40 : 1320421840*/
App::import('Controller', 'KnowledgeBases');

class TestKnowledgeBasesController extends KnowledgeBasesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class KnowledgeBasesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.knowledge_basis');

	function startTest() {
		$this->KnowledgeBases =& new TestKnowledgeBasesController();
		$this->KnowledgeBases->constructClasses();
	}

	function endTest() {
		unset($this->KnowledgeBases);
		ClassRegistry::flush();
	}

}
