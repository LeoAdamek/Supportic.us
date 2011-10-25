<?php
class Role extends AppModel {
	var $name = 'Role';
	var $displayField = 'name';

	var $actsAs = array(
		'Acl' => array(
			'type' => 'requester'
		)
	);

	var $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'role_id'
		)
	);

	function parentNode(){
		return null;
	}
}
