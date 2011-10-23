<?php
/* User Fixture generated on: 2011-10-20 19:08:16 : 1319134096 */
class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'addressName' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'ascii_bin', 'charset' => 'ascii'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 512, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'contry_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'MyISAM')
	);

	var $records = array(
		array( // Example Record
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'addressName' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'contry_id' => 1
		),
		array( // Should enter without issue
			'id' => null,
			'name' => 'Arnold McTavish',
			'addressName' => 'Soap',
			'email' => 'abxy@sharklasers.com',
			'password' => 'Q-Foce Cadet.',
			'country_id', => 185
		),
		array(
			'id' => null,
			'name' => 'J.S. Steinmann', // Should Fail (J.S.)
			'addressName' => 'Joseph Steinmann',
			'email' => 'x@example.com', // Should Fail (DNS)
			'password' => 'abc', // Should Fail (length)
			'country_id' => 192
		),
		array( // Should enter without issue
			'id' => null,
			'name' => 'Leo Adamek',
			'addressName' => 'Leo',
			'email' => 'leo@adamek.me',
			'password' => 'teapot',
			'country_id' => 217
		),
		array(
			'id' => null,
			'name' => 'I@n M@artin',
			'addressName' => 'Ian',
			'email' => 'Ian.Martin@altoncollege.ac.uk',
			'country_id' => 56
		),
		array( // Should Fail at e-mail
			'id' => null,
			'name' => 'Björk Guðmundsdóttir',
			'addressName' => 'Bjork',
			'email' => 'foo@example.com', // Fail (DNS MX)
			'country_id' => 137
		),
		array( // Fail at adressName and e-mail
			'id' => null,
			'name' => 'Amy-Rose',
			'addressName' => 'Amy-R0e',
			'email' => 'bar@b@az.com', // Fail (Format)
			'country_id' => 199
		),
	);
}
