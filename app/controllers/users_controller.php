<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('Auth', 'Session', 'Email');

	function beforeFilter(){
		$this->Auth->allow('register','login','verify');
	}

	function login(){
		/*
		 * Check the user has activated their account before letting them log in.
		 */
		if($this->data){
			if($this->Auth->login($this->data)){
				$user = $this->User->find(array('User.email' => $this->data['User']['email']), array('User.isActivated'));

				if($user['User']['isActivated'] == 0){
					$this->Session->setFlash('You account has not been activated yet. Please verify your e-mail before logging in.');
					$this->Auth->logout();
					$this->redirect(array('action' => 'login'));
				}
			}
		}
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
			if($this->data['password'] != $this->Auth->password($this->data['password_confirm'])){
				// The user's password and confirmation do not match.
				$this->Session->setFlash('The entered passwords do not match.');
				$this->redirect(array(
					'controller' => 'users',
					'action' => 'register'
				));
			}else{
				// Passwords match, make their account
				$this->User->set('signup_date', date('Y-m-d H:i:s'));
				if($this->User->save($this->data)){
					// If the user account was sucessfully saved.
					$this->_sendNewUserMail($this->User->read());
				}else{
					$this->Session->setFlash("There was an error creating your account");
					$this->redirect(array(
						'controller' => 'users',
						'action' => 'register'
					));
				}
			}	
		}else{
			$this->data['User']['password'] = null; // Clear the password field.
			/*
			 * The User did not submit data.
			 * Display a form
			 */
		}
	}

	function _sendNewUserMail($user){
		$this->Email->from = 'Supportic.us <no_reply@supportic.us>';
		$this->Email->to = $user["User"]["name"] . ' <' . $user["User"]["email"] . '>';
		$this->Email->subject = "Welcome to Supportic.us ".$user["User"]["name"].".";
		$this->Email->template = 'welcome_email';
		$this->Email->sendAs = 'both'; // Send HTML and plain-text e-mails
		$this->set('activation_url', 'https://' . env('SERVER_NAME') . '/users/activate/' . $user["User"]["id"] . '/' . $this->User->getActivationHash());
		$this->set('User', $user);
		$this->Email->send();	
	}

	function activate($user_id = null, $activation_code = null){
		/*
		 * Used to activate a user's account, thus verifying their E-mail address.
		 */
		$this->User->id = $user_id;

		if($this->User->exists() && ($activation_code == $this->User->getActivationHash())){
			$this->User->saveField('isActivated',1); // Activate their account

			/*
			 * Tell the user they can now log in
			 */
			$this->Session->setFlash('Thanks for verifying your E-mail. Please Log in to start using Supportic.us');
			$this->redirect(array('action' => 'login'));
		}
	}

}
