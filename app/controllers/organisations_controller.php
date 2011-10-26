<?php
class OrganisationsController extends AppController {

	var $name = 'Organisations';

	var $paginate = array(
		'limit' => 25,
		'order' => array(
			'Organisation.name' => 'asc'
		)
	);

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

	function view($org_id = NULL){
		$org = $this->Organisation->findById($org_id);

		if(!empty($org)){
			$this->set('org',$org);
			$this->set('isOwner', $this->Organisation->isCurrentUserOwner($this->Auth->user('id')));
			$this->set('owner', $this->Organisation->getOwner($this->Organisation->field('id')));
		}
	}

	function edit($id = NULL){

		$organisation = $this->Organisation->findById($id);
		$this->set('organisation', $organisation);
		$this->set('countries',$this->Organisation->Country->find('list',array('fields' => 'Country.name')));
		$this->set('organisationCategories', $this->Organisation->OrganisationCategory->getRootCategories());
		$user_id = $this->Auth->user('id');

	 	$user_isOwner = $this->Organisation->isCurrentUserOwner($this->Auth->user('id'));	

		if(!$user_isOwner){
			$this->Session->setFlash("You don't have permission to edit this organisation.");
			$this->redirect(array('action' => 'index'));
		}

		if(!$id && empty($this->data)){
			$this->Session->setFlash("Invalid Organisation");
			$this->redirect(array('action' => 'index'));
		}else{
			if(!empty($this->data) && $user_isOwner){ // Only the owner can edit an organisation
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
			if($this->Organisation->save($this->data)){

				// Make sure that the user who created this organisation is set as its owner.
				$this->Organisation->Permission->create();
				$this->Organisation->Permission->set('organisation_id', $this->Organisation->getInsertId() );
				$this->Organisation->Permission->set('user_id', $this->Auth->user('id'));
				$this->Organisation->Permission->set('permissionType', 'Owner');
				$this->Organisation->Permission->save();


				$this->Session->setFlash("Organisation created sucessfully");
				$this->redirect(array('controller' => 'organisations', 'action' => 'index'));
			}else{
				$this->Session->setFlash("There was an error creating the organisation");
			}
		}
	}

}
