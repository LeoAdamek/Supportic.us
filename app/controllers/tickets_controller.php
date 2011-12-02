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
				$categories = $this->Ticket->Category->getChildCategories($org_id, $parent_id, "TICKET");
			}else{
				$categories = $this->Ticket->Category->getRootCategories($org_id, "TICKET");
			}
		}else{
			$categories = null;
		}
		header('Content-type: application/json');
		Configure::write('debug',0);
		echo json_encode($categories);
	}

	function home_view(){
		if($this->Auth->user('id')){
			$tickets = $this->Ticket->find('all',array(
				'conditions' => array(
					'user_id' => $this->Auth->user('id'),
					'status' => 'Unresolved'
				),
				'order' => 'postdate DESC',
				'limit' => '10'
			));
			$this->set('tickets',$tickets);
		}
	}

	function my_tickets(){
		/*
		 * @about: Show a user a pagnated, searchable list of their tickets
		 */

		if(empty($this->data)){
			$tickets = $this->Ticket->find('all',array(
				'user_id' => $this->Auth->user('id')
			));
		}else{
			// Process a search request
			if($this->data['Ticket']['priority'] == 'Any'){
				$tickets = $this->Ticket->find('all',array(
					'conditions' => array(
						'Ticket.user_id' => $this->Auth->user('id'),
						'Ticket.title LIKE' => "%{$this->data['Ticket']['title']}%"
					)
				));
			}else{
				$tickets = $this->Ticket->find('all',array(
					'conditions' => array(
						'Ticket.user_id' => $this->Auth->user('id'),
						'Ticket.title LIKE' => "%{$this->data['Ticket']['title']}%",
						'Ticket.priority' => $this->data['Ticket']['priority']
					)
				));
			}
		}

		// Add the last posted message to the ticket info
		foreach($tickets as $id => $ticket){
			$tickets[$id]['LastMessage'] = $this->Ticket->Message->find('first',array(
				'Message.ticket_id' => $ticket['Ticket']['id'],
				'order' => 'Message.postdate DESC'
			));
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

		$this->set('tickets',$tickets);
	}

	function my_org_tickets(){
		if(empty($this->data)){
			
			$organisations = $this->Ticket->Organisation->Permission->find('list',
				array(
					'fields' => 'Permission.organisation_id'
				),
				array(
					'conditions' => array(
						'user_id' => $this->Auth->user('id'),
						'permissionType' => array('Support','Owner')
					)
				)
			);

			$tickets = array();

			foreach($organisations as $index => $id){
				$o_tickets = $this->Ticket->find('all',
					array(
						'conditions' => array(
							'Ticket.organisation_id' => $id,
							'Ticket.status' => 'Unresolved'
						)
					)
				);

				if(!empty($o_tickets)){
					$tickets = array_merge($tickets, $o_tickets);
				}
			}

			$this->set('tickets', $tickets);

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

					App::import('Sanitize');
					$this->Ticket->set('title', Sanitize::html($this->data['Ticket']['title']));

					if($this->Ticket->validates() && $this->Ticket->save() && $this->Ticket->Message->validates()){
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

			$permission = $this->Ticket->Organisation->hasPermission($this->Auth->user('id'), $ticket['Organisation']['id'], 'Support');
			$owner = $this->Auth->user('id') == $ticket['Ticket']['user_id'];

			$canView = $permission && $owner;

			if($canView){
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
				$this->set('statuses',
					array(
						'Unresolved' => 'Unresolved',
						'Resolved' => 'Resolved',
						'Closed' => 'Closed'
					)
				);
			}
		}else{
			$this->Session->setFlash("Invalid Ticket.");
		}
	}

	function update_status($ticket_id = null){
		/*
		 * @about: Allows the current status of a ticket to be altered.
		 * @requestType: Expects an AJAX request.
		 */

		// This is an ajax request.
		$this->autoRender = false;
		Configure::write('debug', 0);
		header('Content-Type: application/json');

		$this->Ticket->id = $ticket_id;

		if($this->Ticket->exists()){
			$ticket = $this->Ticket->findById($ticket_id);

			$permission = $this->Ticket->Organisation->hasPermission($this->Auth->user('id'), $this->Ticket->field('organisation_id'), 'Support');
			$ticket_owner = $this->Ticket->field('user_id') == $this->Auth->user('id');
			$canUpdate = $permission && $ticket_owner;

			if(!$canUpdate){
				if($this->Ticket->saveField('status', $this->data['Ticket']['status'])){
					echo json_encode(
						array(
							'success' => true,
							'message' => "The Ticket was upated sucessfully."
						)
					);
				}else{
					echo json_encode(
						array(
							'success' => false,
							'message' => "Where was an unexpected error updating the ticket."
						)
					);

				}

			}else{
				echo json_encode(
					array(
						'success' => false,
						'message' => "You are not permitted to alter the status of this ticket."
					)
				);
			}
		}

	}

}


?>
