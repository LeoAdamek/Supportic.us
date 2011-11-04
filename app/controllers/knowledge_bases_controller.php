<?php
class KnowledgeBasesController extends AppController {

	var $name = 'KnowledgeBases';
	var $helpers  = array('Time');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index','view');
		$this->Auth->deny('edit','add','delete');
	}

	function index($oid = null){
		if(isset($oid)){
			$this->KnowledgeBase->Organisation->id = $oid;
			if($this->KnowledgeBase->Organisation->exists()){
				
				$articles = $this->Kn

			}else{
				$this->Session->setFlash("This Organisation does not exist.");
				$this->redirect(array(
					'controller' => 'organisations',
					'action' => 'index'
				));
			}
		}else{
				$this->Session->setFlash("No Oranisation Specified");
				$this->redirect(array(
					'controller' => 'organisations',
					'action' => 'index'
				));
		}
	}

}
