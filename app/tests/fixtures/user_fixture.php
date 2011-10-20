<?php
/* User Fixture generated on: 2011-10-20 14:40:43 : 1319118043 */
class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'User_ID' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'User_Name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'User_AddressName' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'ascii_bin', 'charset' => 'ascii'),
		'User_Email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique', 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'User_Password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'User_Country_ID' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'User_ID', 'unique' => 1), 'User_Email' => array('column' => 'User_Email', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'User_ID' => 1,
			'User_Name' => 'Lorem ipsum dolor sit amet',
			'User_AddressName' => 'Lorem ipsum dolor sit amet',
			'User_Email' => 'Lorem ipsum dolor sit amet',
			'User_Password' => 'Lorem ipsum dolor sit amet',
			'User_Country_ID' => 1
		),
	);
}
