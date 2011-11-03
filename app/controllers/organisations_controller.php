<?php
class OrganisationsController extends AppController {

	var $name = 'Organisations';

	var $paginate = array(
		'limit' => 25,
		'order' => array(
			'Organisation.name' => 'asc'
		)
	);

	var $components = array('Email');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->deny('add','edit','delete','manage');
	}

	function index(){
		/*
		 * List the Organisations is a paginated way.
		 */
		$this->Organisation->recursive = 0;
		if(!empty($this->data)){
			if($this->data['Organisation']['country'] != 0){
			$this->set('organisations', $this->paginate(
				array(
					'Organisation.name LIKE' => "%{$this->data['Organisation']['name']}%",
					'Organisation.country_id' => $this->data['Organisation']['country']
				)
			));
			}else{
				$this->set('organisations', $this->paginate(
					array(
						'Organisation.name LIKE' => "%{$this->data['Organisation']['name']}%"
					)
				));
			}
		}else{
			$this->set('organisations', $this->paginate());
		}

		$countries = $this->Organisation->Country->find('list');
		array_unshift($countries, array('0' => 'Any Country'));
		$this->set('countries', $countries);

	}

	function view($org_id = NULL){
		$org = $this->Organisation->findById($org_id);

		if(!empty($org)){
			$this->set('org',$org);
			$this->set('permissionList', array(
				'Edit' => $this->Organisation->hasPermission($this->Auth->user('id') , 'Edit'),
				'EditPermissions' => $this->Organisation->hasPermission($this->Auth->user('id'), 'EditPermissions'),
				'Support' => $this->Organisation->hasPermission($this->Auth->user('id'), 'Support')
			));
			$this->set('owner', $this->Organisation->getOwner($this->Organisation->field('id')));
		}
	}

	function edit($id = NULL){

		$organisation = $this->Organisation->findById($id);
		$this->set('organisation', $organisation);
		$this->set('countries',$this->Organisation->Country->find('list',array('fields' => 'Country.name')));
		$this->set('organisationCategories', $this->Organisation->OrganisationCategory->getRootCategories());
		$user_id = $this->Auth->user('id');

		$user_canEdit = $this->Organisation->hasPermission($this->Auth->user('id') , 'Edit'); // Check the current user has permission to edit this organisation

		if(!$user_canEdit){
			// Deny the user the ability to edit this organisation (because they don't have permission)
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
				$this->Organisation->Permission->set('organisation_id', $this->Organisation->getInsertId() ); // Get the ID of the organisation just saved
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

	function admin_add_access($orgId){
		/*
		 * @about: Allows users with permission editing access to edit the permissions of other users.
		 */

		$this->Organisation->id = $orgId;

		if(!$this->Organisation->exists()){
			$this->Session->setFlash("This Organisation Does Not Exist");
			$this->redirect(array(
				'controller' => 'organisations',
				'action' => 'index'
			));
		}else{
			$user_hasPermission = $this->Organisation->hasPermission($this->Auth->user('id'), 'EditPermissions');

			if(!$user_hasPermission){
				$this->Session->setFlash("You do not have permission to edit the permissions of users of this organisation");
				$this->redirect(array(
					'controller' => 'organisations',
					'action' => 'index',
					'prefix' => null
				));
			}else{
				if(!empty($this->data)){
					// The user is cleared, the organisation exists, and they submitted data.

					// Check the user exists
					$user = $this->Organisation->Permission->User->findByEmail($this->data['User']['email']);

					if(!$user){
						$this->_sendInvitation(array(
							'invitor' => array(
								'name' => $this->Auth->user('name'),
								'email' => $this->Auth->user('email')
							),
							'invitee' => $this->data['User']['email'],
							'organisation' => $this->Organisation->name
						));
						$this->Session->setFlash("{$this->data['User']['email']} Doesn't have an account, but we've sent an invite to them.");
						$this->redirect(array(
							'controller' => 'organisations',
							'action' => 'index'
						));
					}else{
						$this->Organisation->Permission->create();
						$this->Organisation->Permission->set('organisation_id' , $this->Organisation->id);
						$this->Organisation->Permission->set('permissionType' , $this->data['Permission']['permissionType']);

						$user = $this->Organisation->Permission->User->findByEmail($this->data['User']['email'], array(
							'fields' => 'User.id'
						)); // Get the ID of the user who the permission is for.

						$this->Organisation->Permission->set('user_id', $user['User']['id']);

						if($this->Organisation->Permission->save()){
							// The Permission was saved successfully.
							$this->Session->setFlash("The User {$this->data['User']['email']} was granted permission to {$this->data['Permission']['permissionType']}.");
							$this->data = null;
						}else{
							// There was an error saving the permission.
							$this->Session->setFlash("There was an error creating the permission.");
						}
					}
				}
			}
		}
		
		/*
		 * Generate the list of permission nodes
		 */

		$this->set('org', $this->Organisation->read());

		$this->set('permissionTypes', array(
			'Edit' => 'Can Edit this Organisation',
			'EditPermissions' => 'Can Edit the permissions within this Organisation',
		));

	}

	function _sendInvitation($options = array()){

		/*
		 * @about: If a user is granted a permission, but they do not have an account.
		 * An invitation is sent to them from the user who wants to grant them a permission.
		 */

		$this->Email->from = "Supportic.us <invitation@supportic.us>";
		$this->Email->to = "You <{$options['invitee']}>";
		$this->Email->subject = "You have been invited to Supportic.us by {$options['invitor']['name']}!";
		$this->Email->template = 'invitation';
		$this->Email->sendAs = 'both';
		$this->set('data', $options);
		$this->Email->send();
	}

	function admin_edit_access($orgId){
		/*
		 * @about: Allows permitted users to edit and delete already assigned permissions
		 */
		$this->Organisation->id = $orgId;
		if(!$this->Organisation->exists()){
			$this->Session->setFlash("This Organisation Does Not Exist");
			$this->redirect(array(
				'controller' => 'Organisations',
				'action' => 'index'
			));
		}else{
			$hasPermission = $this->Organisation->hasPermission($this->Auth->user('id'), 'EditPermissions');
			if(!$hasPermission){
				$this->Session->setFlash("You do not have permission to edit the permissions for this organisation");
				$this->redirect(array(
					'controller' => 'Organisations',
					'action' => 'index'
				));
			}else{
				// Load the permissions data, querying all related data.
				$permissions = $this->Organisation->Permission->find('all', array(
					'fields' => array('Organisation.*, Permission.*, User.*'),
					'conditions' => array(
						'Permission.organisation_id' => $orgId,
						'Permission.user_id !=' => $this->Auth->user('id'), /* Users can't edit their own permissions */
						'Permission.permissionType !=' => 'Owner' // The owner's permissions cannot be edited.
					)
				));

				$this->set('permissions',$permissions);

			}
		}
	}

}
