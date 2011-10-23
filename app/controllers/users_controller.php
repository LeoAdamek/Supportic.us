<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('Auth', 'Session', 'Email');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('register','login','verify','forgot_password');
		$this->Auth->deny('edit');
	}

	function login(){
	}

	function logout(){
		/*
		 * Log the user out of their account
		 */
		$this->redirect($this->Auth->logout());
	}

	function view($id = NULL){
		if(!$id){
			$this->Session->setFlash('This user does not exist');
			$this->redirect('/');
		}else{
			$user = $this->User->findById($id);
			if(!$user){
				$this->Session->setFlash('This user does not exist');
				$this->redirect('/');
			}else{
				$this->set('user',$user);
			}
		}
	}

	function forgot_password($email = null, $checkStr = null){
		if($email && $checkStr){
			$user = $this->User->findByEmail($email);
			$this->User->id = $user['User']['id'];
				if($this->User->generatePasswordResetHash() == $checkStr){
					// Correct URL was entered. Proceed with password reset
					$new_password = $this->User->generatePassword(12);
					$this->User->saveField('password', $this->Auth->password($new_password));
					$this->_sendNewPassword($user, $new_password);
					$this->Session->setFlash("Your Password was reset, Please check your e-mail for your new password");
					$this->redirect(array('controller' => 'users','action' => 'login'));
				}else{
					$this->Session->setFlash("Invalid Password Reset Code");
				}
			}elseif(!empty($this->data)){
				$user = $this->User->findByEmail($this->data['User']['email']);
				if(!isset($user['User']['id'])){
					$this->Session->setFlash("Invalid E-mail Address");
				}else{
					$this->User->id = $user['User']['id'];
					$reset_code = $this->User->generatePasswordResetHash();
					$this->_sendPasswordResetEmail($user, $reset_code);
					$this->Session->setFlash('A password reset link has been sent to '.$user['User']['email']);
			}

		}
	}

	function _sendPasswordResetEmail($user = null, $reset_code = null){
		if($user && $reset_code){
			$this->Email->from = 'Supportic.us <no_reply@supportic.us>';
			$this->Email->to = $user['User']['name'] . ' <'.$user['User']['email'].'>';
			$this->Email->subject = 'Confirm your password reset';
			$this->set('user',$user);
			$this->set('reset_url', 'https://'.env('SERVER_NAME').'/users/forgot_password/'.$user['User']['email'].'/'.$reset_code);
			$this->Email->sendAs = 'both';
			$this->Email->template = 'resetpassword';
			$this->Email->send();
		}
	}


	function _sendNewPassword($user, $new_password){
		$this->Email->form = 'Supportic.us <no_reply@supportic.us>';
		$this->Email->to = $user['User']['name'] . ' <'.$user['User']['email'].'>';
		$this->Email->subject = "Your new Suppportic.us Password";
		$this->set('user',$user);
		$this->set('password',$new_password);
		$this->Email->sendAs = 'both';
		$this->Email->template = 'newpassword';
		$this->Email->send();
	}

	function register(){
		/*
		 * Method to register a new account
		 */

		$this->set('title_for_layout', "Register");

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
				}elseif(!$this->User->validates()){
					$this->set('errors',$this->User->invalidFields());
				}else{
					$this->Session->setFlash("There was an error of some unexpected kind creating your account");
				}
			}else{
				$this->Session->setFlash("The Entered Passwords did not match.");
			}	
		}else{
			/*
			 * The User did not submit data.
			 * Display a form
			 */
		}
		// Always make sure the user never has their password returned to them
		$this->data['User']['password'] = null;
		$this->data['User']['password_confirm'] = null;
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

	function edit(){
		$this->set('title_for_layout', "My Account");
		$this->User->id = $this->Auth->user('id');
		if(empty($this->data)){
			$user = $this->User->read();
			$user['User']['password'] = null;
			$user['User']['isActivated'] = null;
			$this->data['User']['password_confirm'] = null;
			$this->data = $user;
		}else{
			if(($this->data['User']['password'] != null) && ($this->data['User']['password'] != $this->Auth->password($this->data['User']['password_confirm']))){
				$this->Session->setFlash("The Entered Passwords do not match");
				$this->data['User']['password'] = null;
			}else{
				if($this->User->save($this->data)){
					$this->Session->setFlash("Your Information was updated successfully.");
					$this->data['User']['password'] = null;
				}elseif(!$this->User->validates()){
					$this->Session->setFlash("There were errors updating your account");
					$this->set('errors',$this->User->invalidFields());
				}
			}
		}
		$this->data['User']['password'] = '';
		$this->data['User']['password_confirm'] = '';
	}	

}
