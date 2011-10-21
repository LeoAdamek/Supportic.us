<?php
class OrganisationsController extends AppController {

	var $name = 'Organisations';
	var $helpers = array('Html','Form');
	var $components = array('Auth','Session');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->deny('add','edit','delete','manage');
	}

	function add(){
		/*
		 * Controller Method for creating a new organisation
		 */
		$this->set('countries',$this->Organisation->Country->find('list',array('fields' => 'Country.name')));


		if(!empty($this->data)){
			$this->Organisation->create(); // Make a new Organisation
			$this->Organisation->set('user_id',$this->Auth->user('id'));
			if($this->Organisation->save($this->data)){
				$this->Session->setFlash("Organisation created sucessfully");
				$this->redirect('/');
			}else{
				$this->Session->setFlash("There was an error creating the organisation");
				$this->redirect(array(
					'controller' => 'Organisations',
					'action' => 'add'
				));
			}
		}
	}

}
