<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Your Name is Required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'illegalCharacters' => array(
				'rule' => '/^(\p{L}| |\-|\.)+$/u', // Validate string for all letters from all character sets in all languages of the world.
				'message' => 'Your name contains disallowed characters',
			),
		),
		'addressName' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'An Address Name is Required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'validCharacters' => array(
				'rule' => '/^[A-Za-z\- ]+$/i',
				'message' => 'This name can only contain letters (A-Z) Hyphens (-) and spaces'
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Your E-mail address must be valid',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'A Valid E-mail address is required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'This E-mail address has already been registered',
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'A Password is required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minlength' => array(
				'rule' => array('minlength',6),
				'message' => 'Passwords must be at least 6 characters in length.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'contry_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	var $belongsTo = array(
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id'
		)
	);




	function getActivationHash(){
		/*
		 * Generates an 8 character activation code for the user account
		 * This is used to check that the user's email address is valid.
		 */
		if(!isset($this->id)){
			return false;
		}else{
			return substr(Security::hash(Configure::read('Security.salt') . $this->field('signup_date') . date('Ymd')), 0, 8);
		}
	}

	public function generatePassword($len = 6){
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890+-_=&*()@#';
		$pass = '';
		for($i = 0; $i < $len; $i++){
			$pass .= $chars[mt_rand(0,strlen($chars))];
		}
		return $pass;
	}

	function generatePasswordResetHash(){
		if(!isset($this->id)){
			return false;
		}else{
			return substr(Security::hash(Configure::read('Security.salt') . $this->field('email') . date('Ymd')), 0, 12);
		}
	}
}
