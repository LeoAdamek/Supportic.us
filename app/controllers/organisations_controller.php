<?php
class OrganisationsController extends AppController {

	var $name = 'Organisations';
	var $helpers = array('Html','Form');
	var $components = array('Auth','Session');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->deny('add','edit','delete','manage');
	}

	function index(){
		/*
		 * List the Organisations is a paginated way.
		 */
		$this->Organisation->recursive = 0;
		$this->set('organisations', $this->paginate());
	}

	function add(){
		/*
		 * Controller Method for creating a new organisation
		 */
		$this->set('countries',$this->Organisation->Country->find('list',array('fields' => 'Country.name')));
		$this->set('organisationCategories', $this->Organisation->OrganisationCategory->find('list', array('fields' => 'OrganisationCategory.name')));


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
