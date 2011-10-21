<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('Auth', 'Session', 'Email');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('register','login','verify');
	}

	function login(){
		$isLoggedIn = $this->Auth->login($this->data);
		if($isLoggedIn){
			$user = $this->User->findById($this->Auth->read('User.id'));

			$this->Session->setFlash("Thank you for logging in ".$user['User']['addressName'].".");
		}

		$this->set('isLoggedIn',$isLoggedIn);
	}

	function logout(){
		/*
		 * Log the user out of their account
		 */
		$this->redirect($this->Auth->logout());
	}

	function register(){
		/*
		 * Method to register a new account
		 */


			$countries = $this->User->Country->find('list', array(
				'fields' => 'Country.name'
			));
			$this->set('countries', compact('countries'));
	

		if(!empty($this->data)){
			/*
			 * The User Submitted Data.
			 * Handle it
			 */
			$this->User->create(); // Create a new user object
			if($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm']) ){
				// Passwords match, make their account
				$this->User->set('signup_date', date('Y-m-d H:i:s'));
				$this->User->set('isActivaed',0);
				if($this->User->save($this->data)){
					// If the user account was sucessfully saved.
					$this->_sendNewUserMail($this->User->read());
					$this->Session->setFlash('Your account has been created '.$this->data['User']['name'].' Please check your email to activate your account');
					$this->redirect('/');
				}else{
					$this->Session->setFlash("There was an error creating your account");
					$this->redirect(array(
						'controller' => 'users',
						'action' => 'register'
					));
				}
			}else{
				$this->Session->setFlash("The Entered Passwords did not match.");
			}	
		}else{
			$this->data['User']['password'] = null;
			$this->data['User']['password_confirm'] = null;
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
		$this->set('user', $user);
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
