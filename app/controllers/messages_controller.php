<?php

class MessagesController extends AppController {

	var $name = 'Messages';

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->deny('*');
	}
	
	function reply($ticket_id = null){
		if(empty($ticket_id)){
			$this->Session->setFlash("No Ticket Supplied");
			$this->redirect('/');
		}

		$ticket = $this->Message->Ticket->findById($ticket_id);

		if($ticket['User']['id'] != $this->Auth->user('id') && $ticket['Organisation']['User']['id'] != $this->Auth->user('id')){
			$this->Session->setFlash("You don't have access to this ticket");
			$this->redirect(array('controller'=>'organisations','action'=>'index'));
		};

		if(!empty($this->data)){
			$this->Message->create();
			$this->Message->set('ticket_id', $ticket_id);
			$this->Message->set('user_id', $this->Auth->user('id'));
			$this->Message->set('postdate', date("Y-m-d H:i:s"));
			$this->Message->set('body', $this->data['Message']['body']);
			if($this->Message->save()){
				$this->Session->setFlash('Reply Sucessful');
				$this->redirect(array(
					'controller' => 'tickets',
					'action' => 'view',
					$ticket_id
				));
			}else{
				$this->set('message', $this->Message->data);
			}
		}else{
			$this->set('ticket',$this->Message->Ticket->findById($ticket_id));
		}
	}

}


?>
