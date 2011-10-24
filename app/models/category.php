<?php
class Category extends AppModel {
	var $name = 'Category';
	var $displayField = 'name';
	var $validate = array(
		'organisation_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
				'message' => 'The Category must have a name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minlength' => array(
				'rule' => array('minlength', 6),
				'message' => 'The Category name must be at least 6 characters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Organisation' => array(
			'className' => 'Organisation',
			'foreignKey' => 'organisation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'category_id',
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
			'fields' => 'Category.name',
			'conditions' => array(
				'Category.category_parent_id' => null
			)
		));
	}

	function getChildCategories($parent_id){
		return $this->find('list', array(
			'fields' => 'Category.name',
			'conditions' => array(
				'Category.category_parent_id' => $parent_id
			)
		));
	}

}
