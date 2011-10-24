<?php

class TicketsController extends AppController {

	var $name = 'Tickets';
	var $helpers = array('Time');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->deny('*');
	}

	function getSubCategories($parent_id = null){
		$this->autoRender = false;
		if($parent_id){
			$categories = $this->Ticket->Category->getChildCategories($parent_id);
		}else{
			$categories = $this->Ticket->Category->getRootCategories();
		}
		header('Content-type: application/json');
		Configure::write('debug',0);
		echo json_encode($categories);
	}


	function add($org_id = NULL){
		if($org_id){
			$this->Ticket->Organisation->id = $org_id;
			if($this->Ticket->Organisation->exists()){
				// The current organisatin exists
				if(!empty($this->data)){
					$this->Ticket->create();
					$this->Ticket->set('postdate', date('Y-m-d H:i:s'));
					$this->Ticket->set('user_id', $this->Auth->user('id'));
					$this->Ticket->set('organisation_id', $org_id);
					$this->Ticket->set('status','Unresolved');
					if($this->Ticket->validates() && $this->Ticket->save($this->data) && $this->Ticket->Message->validates()){
						// The Ticket was Saved Sucessfully
						$this->Session->setFlash("The Ticket Has Been Saved.");
						$ticket = $this->Ticket->read();
						$this->Ticket->Message->set('ticket_id',$ticket['Ticket']['id']);
						$this->Ticket->Message->set('postdate',date('Y-m-d H:i:s'));
						$this->Ticket->Message->set('user_id', $this->Auth->user('id'));
						$this->Ticket->Message->save($this->data);
						$this->redirect(array('controller' => 'Tickets', 'action' => 'view', $ticket['Ticket']['id'], $ticket['Ticket']['slug']));
					}elseif(!$this->Ticket->validates()){
						$this->set('errors',$this->Ticket->invalidFields());
					}
				}

				$this->set('categories', $this->Ticket->Category->find('list', array('fields' => 'Category.name', 'conditions' => array('Category.organisation_id' => $org_id))));
				$this->set('info',$this->Ticket->Organisation->read(null));
				$this->set('priorities', array(
					'Low' => 'Low',
					'Medium' => 'Medium',
					'Important' => 'Important',
					'Urgent' => 'Urgent'
				));

			}else{
				// An Invalid Organisation was entered

			}
		}else{
			// User did not supply an organisation ID.
			
		}
	}	

	function view($ticket_id){
		$this->Ticket->id = $ticket_id;
		if($this->Ticket->exists()){
			// The Ticket is real
			$ticket = $this->Ticket->read();
			if($ticket['User']['id'] != $this->Auth->user('id') && $ticket['Organisation']['User']['id'] != $this->Auth->user('id')){ // This line will be changed.
				$this->Session->setFlash("This is not your ticket.");
				$this->redirect(array('controller'=>'organisations','action'=>'index'));
			}else{
				// It's their ticket, show them the stuff.
				$this->set('ticket',$ticket);
				$this->set('messages', $this->Ticket->Message->find('all', array(
					'conditions' => array(
						'Message.ticket_id' => $ticket_id
					)
				)));
			}
		}else{
			$this->Session->setFlash("Invalid Ticket.");
		}
	}


}


?>
