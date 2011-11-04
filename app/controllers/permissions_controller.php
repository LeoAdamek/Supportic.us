<?php
class PermissionsController extends AppController {

	var $name = 'Permissions';

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->deny('*'); // This is a user only section.
	}


}
