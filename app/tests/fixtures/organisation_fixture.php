<?php
/* Organisation Fixture generated on: 2011-10-21 14:10:32 : 1319202632 */
class OrganisationFixture extends CakeTestFixture {
	var $name = 'Organisation';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'contry_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'organisationCategory_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'isPrivate' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'contry_id' => 1,
			'organisationCategory_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'isPrivate' => 1
		),
	);
}
