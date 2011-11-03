<?php

class TicketsController extends AppController {

	var $name = 'Tickets';
	var $uses = array('Ticket','Organisation');
	var $helpers = array('Time');

	var $paginate = array(
		'fields' => array(
			'Organisation.*','Ticket.*'
		),
		'limit' => 25,
		'order' => array(
			'Ticket.postdate' => 'desc'
		)
	);

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->deny('add','view','my_tickets');
	}

	function getSubCategories($org_id = NULL, $parent_id = null){
		$this->autoRender = false;
		if($org_id){
			if($parent_id){
				$categories = $this->Ticket->Category->getChildCategories($org_id, $parent_id);
			}else{
				$categories = $this->Ticket->Category->getRootCategories($org_id);
			}
		}else{
			$categories = null;
		}
		header('Content-type: application/json');
		Configure::write('debug',0);
		echo json_encode($categories);
	}


	function my_tickets(){
		/*
		 * @about: Show a user a pagnated, searchable list of their tickets
		 */

		if(empty($this->data)){
			$this->set('tickets',$this->paginate(
					array(
						'Ticket.user_id' => $this->Auth->user('id')
					)
				));
		}else{
			// Process a search request
			if($this->data['Ticket']['priority'] == 'Any'){
				$this->set('tickets', $this->paginate(
					array(
						'Ticket.user_id' => $this->Auth->user('id'),
						'Ticket.title LIKE' => "%{$this->data['Ticket']['title']}%"
					)
				));
			}else{
				$this->set('tickets', $this->paginate(
					array(
						'Ticket.user_id' => $this->Auth->user('id'),
						'Ticket.title LIKE' => "%{$this->data['Ticket']['title']}%",
						'Ticket.priority' => $this->data['Ticket']['priority']
					)
				));
			}
		}
		$this->set('priorities',
			array(
				'Any' => 'Any',
				'Low' => 'Low',
				'Normal' => 'Normal',
				'Important' => 'Important',
				'Urgent' => 'Urgent'
			)
		);		
	}

	function my_org_tickets(){
		if(empty($this->data)){
			// The user did not submit a search
			// Display all
		}else{
			// User submitted a search
			// Process it
		}
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
			$ticket = $this->Ticket->findById($ticket_id);
			if($ticket['User']['id'] != $this->Auth->user('id') && !$this->Ticket->Organisation->hasPermission($this->Auth->user('id'), 'Tickets')){
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
