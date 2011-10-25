<?php
/* Permission Fixture generated on: 2011-10-25 22:30:16 : 1319578216 */
class PermissionFixture extends CakeTestFixture {
	var $name = 'Permission';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'permissionType' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'ascii_bin', 'charset' => 'ascii'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'organisation_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'ascii', 'collate' => 'ascii_bin', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'permissionType' => 'Lorem ipsum dolor sit amet',
			'user_id' => 1,
			'organisation_id' => 1
		),
	);
}
