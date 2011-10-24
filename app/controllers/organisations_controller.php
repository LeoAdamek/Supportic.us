<?php
class OrganisationsController extends AppController {

	var $name = 'Organisations';

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

	function edit($id = NULL){

		$organisation = $this->Organisation->findById($id);
		$this->set('organisation', $organisation);
		$this->set('countries',$this->Organisation->Country->find('list',array('fields' => 'Country.name')));
		$this->set('organisationCategories', $this->Organisation->OrganisationCategory->getRootCategories());
		$user_id = $this->Auth->user('id');

		$useer_isOwner = ($organisation['User']['id'] == $user_id);

		if(!$id && empty($this->data)){
			$this->Session->setFlash("Invalid Organisation");
			$this->redirect(array('action' => 'index'));
		}else{
			if(!empty($this->data) && $user_isOwner){
				if($this->Organisation->save($this->data)){
					$this->Session->setFlash("Changes Made Sucessfully");
				}
			}
		}

		$this->data = $organisation;
	}

	function getSubCategories($parent_id = null){
		$this->autoRender = false;
		if($parent_id){
			$categories = $this->Organisation->OrganisationCategory->getChildCategories($parent_id);
		}else{
			$categories = $this->Organisation->OrganisationCategory->getRootCategories();
		}
		header('Content-type: application/json');
		Configure::write('debug',0); // We can't have debug info in the json.
		echo json_encode($categories);
	}

	function add(){
		/*
		 * Controller Method for creating a new organisation
		 */
		$this->set('countries',$this->Organisation->Country->find('list',array('fields' => 'Country.name')));
		$this->set('organisationCategories', $this->Organisation->OrganisationCategory->getRootCategories());


		if(!empty($this->data)){
			$this->Organisation->create(); // Make a new Organisation
			$this->Organisation->set('user_id',$this->Auth->user('id'));
			if($this->Organisation->save($this->data)){
				$this->Session->setFlash("Organisation created sucessfully");
				$this->redirect(array('controller' => 'organisations', 'action' => 'index'));
			}else{
				$this->Session->setFlash("There was an error creating the organisation");
			}
		}
	}

}
