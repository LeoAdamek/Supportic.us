<?php
class Organisation extends AppModel {
	var $name = 'Organisation';
	var $displayField = 'name';

	var $actsAs = array('Sluggable');

	var $validate = array(
		'country_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'organisationCategory_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'isPrivate' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'OrganisationCategory' => array(
			'className' => 'OrganisationCategory',
			'foreignKey' => 'organisationCategory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'organisation_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'KnowledgeBase' => array(
			'className' => 'KnowledgeBase',
			'foreignKey' => 'organisation_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'organisation_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Permission' => array(
			'className' => 'Permission',
			'foreignKey' => 'organisation_id',
		)
	);


	function isCurrentUserOwner($user_id){
			$ownerId = $this->Permission->find('first', array(
				'fields' => 'Permission.user_id',
				'conditions' => array(
					'Permission.organisation_id' => $this->field('id'),
					'Permission.permissionType' => 'Owner'
				)
			));

			return $ownerId['Permission']['user_id'] == $user_id;
	}

	function getOwner($orgId){

		$ownerId = $this->Permission->find('first', array(
			'fields' => 'user_id',
			'conditions' => array(
				'organisation_id' => $orgId,
				'permissionType' => 'Owner'
			)
		));

		$owner = $this->Permission->User->find('first', array(
			'conditions' => array(
				'User.id' => $ownerId['Permission']['user_id']
			)
		));

		return $owner;
	}

	function afterFind($results, $primary){
		/*
		 * @about: When we find an organisation, we also want to get its owner.
		 */

		if(!$primary){
			return $results; // Do nothing if the organisations were queried as an assosiation.
		}

		$this->recursive = -1;
		$this->OrganisationCategory->recursive = 0;

		foreach($results as $index => $values){
			if(isset($values['Organisation']['id'])){
				$owner = $this->getOwner( $values['Organisation']['id'] );
				$results[$index]['User'] = $owner['User'];
				$crumbs = $this->OrganisationCategory->breadcrumbs($values['Organisation']['organisationCategory_id']);
				$results[$index]['crumbs'] = $crumbs;
			}
		}
		return $results;
	}

	function hasPermission($user_id, $permission_type, $organisation_id = null){
		/*
		 * @about: Check that the $user_id has the $permission_type for $organisation_id
		 * Checks for $permission_type and the 'Owner' Permission.
		 *
		 * @returns: bool
		 *
		 * @param:
		 * 	$user_id - Integer
		 * 	$permission_type - String
		 * 	$organisation_id - Integer (Optional: Default, $this->id)
		 *
		 */

		if(!$organisation_id && !isset($this->id)){
			return false;
		}elseif(!$organisation_id && isset($this->id)){
			$organisation_id = $this->id;
		}

		$permission = $this->Permission->find('all', array(
			'conditions' => array(
				'Permission.user_id' => $user_id,
				'Permission.organisation_id' => $organisation_id,
				'Permission.permissionType' => array($permission_type, 'Owner') // check for $permission_type OR 'Owner'
			)
		));

		if($permission){
			return true;
		}else{
			return false;
		}

	}
}
