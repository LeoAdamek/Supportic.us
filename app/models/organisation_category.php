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
				'OrganisationCategory.parent' => null
			)
		));
	}

	function getChildCategories($category_id){
		$children = $this->find('list', array(
			'fields' => 'OrganisationCategory.name',
			'conditions' => array(
				'OrganisationCategory.parent' => $category_id
			)
		));
		return $children;
	}

	function breadcrumbs($category_id = null){
		if($category_id){
			$this->id = $category_id;
		}

		$crumbs = $this->field('name');

		while($this->field('parent') != null){
			$this->id = $this->field('parent');
			$next_crumb = $this->field('name') . ' > ';
			$crumbs = $next_crumb . $crumbs;
		}

		return $crumbs;
	}

}
