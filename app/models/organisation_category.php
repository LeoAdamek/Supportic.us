<?php
class OrganisationCategory extends AppModel {
	var $name = 'OrganisationCategory';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minlength' => array(
				'rule' => array('minlength',6),
				'message' => 'Category names must be at least 6 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Organisation' => array(
			'className' => 'Organisation',
			'foreignKey' => 'organisationCategory_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	function getRootCategories(){
		return $this->find('list', array(
			'fields' => 'OrganisationCategory.name',
			'conditions' => array(
				'OrganisationCategory_parent_id' => null
			)
		));
	}

	function getChildCategories($category_id){
		return $this->find('list', array(
			'fields' => 'OrganisationCategory.name',
			'conditions' => array(
				'OrganisationCategory_parent_id' => $category_id
			)
		));
	}
}
