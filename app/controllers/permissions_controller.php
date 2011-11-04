<?php
class PermissionsController extends AppController {

	var $name = 'Permissions';

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->deny('*'); // This is a user only section.
	}


	function edit($org_id, $perm_id){
		if($this->Permission->Organisation->hasPermission($this->Auth->user('id'), 'EditPermissions' , $org_id) ){
			$this->Permission->id = $perm_id;

			$this->set('permissionTypes', array(
				'Edit' => 'Edit',
				'EditPermissions' => 'Edit Permissions',
				'Support'	=> 'Support Staff'
			));

			$this->set('org_id',$org_id);
			$this->set('perm_id',$perm_id);

			if(!empty($this->data)){
				if($this->Permission->saveField('permissionType', $this->data['Permission']['permissionType'])){
					$this->Session->setFlash("{$permission['User']['addressName']}'s Permission was updated");
					$this->redirect(array(
						'controller' => 'organisations',
						'action' => 'view',
						$org_id
					));
				}else{
					$this->Session->setFlash("There was an unexpcted error");
				}
			}

		}else{
			// The user does not have the required permission
			$this->Session->setFlash('You do not have permission to do this.');
			$this->redirect(array(
				'controller' => 'organisations',
				'action' => 'index'
			));
		}
	}


}
