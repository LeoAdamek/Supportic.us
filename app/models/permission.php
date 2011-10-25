<?php
class Permission extends AppModel {
	var $name = 'Permission';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Organisation' => array(
			'className' => 'Organisation',
			'foreignKey' => 'organisation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
