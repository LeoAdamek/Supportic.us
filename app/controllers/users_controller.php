<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('Auth', 'Session');

	function beforeFilter(){
		$this->Auth->allow('register','login');
	}

	function login(){
		/*
		 * Stub Function.
		 * Definition for Auth Module
		 */
	}

	function logout(){
		/*
		 * Log the user out of their account
		 */
		$this->Auth->logout();
	}

	function register(){
		/*
		 * Method to register a new account
		 */
		if(!empty($this->data)){
			/*
			 * The User Submitted Data.
			 * Handle it
			 */
			$this->User->create(); // Create a new user object
			if($this->data['password'] != $this->Auth->password($this->data['password_confirm']){
				// The user's password and confirmation do not match.
				$this->Session->setFlash('The entered passwords do not match.');
				$this->redirect(array(
					'controller' => 'users',
					'action' => 'register'
				));
			}else{
				// Passwords match, make their account
				if($this->User->save($this->data){
					// If the user account was sucessfully saved.
					$this->_sendNewUserMail($this->User->read());
				}else{
					$this->Session->setFlash("There was an error creating your account");
					$this->redirect(array(
						'controller' => 'users',
						'action' => 'register'
					));
				}	
		}else{
			/*
			 * The User did not submit data.
			 * Display a form
			 */
		}
		}
	}

	function _sendNewUserMail($user){
				
	}
	

}
