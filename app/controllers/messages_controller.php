<?php

class MessagesController extends AppController {

	var $name = 'Messages';

	
	function reply($ticket_id){
		$this->Message->Ticket->id = $ticket_id;

		if($this->Message->Ticket->exists()){
			// The Ticket is Valid
			$ticket = $this->Message->Ticket->read();
			if($ticket['User']['id'] != $this->Auth->user('id')){ // This line will be changed

				if(!empty($this->data)){
					$this->Message->create(); // Create a new message
					$this->Message->set('postdate', date('Y-m-d H:i:s'));
					$this->Message->set('user_id', $this->Auth->user('id'));
					$this->Message->set('ticket_id', $ticket_id);
					if($this->Message->save($this->data)){
						$this->Session->setFlash("Your Reply Was Posted!");
						$this->redirect(array(
							'controller' => 'tickets',
							'action' => 'view',
							$ticket['Ticket']['id'],
							$ticket['Ticket']['slug']
						));
					}else{
						$this->Session->setFlash("There was an error saving your reply");
						$this->set('errors',$this->Message->invalidFields());
					}	
				}
			}
			$this->set('ticket',$ticket);
		}else{
			$this->Session->setFlash("Invalid Ticket");
		}
	}

}


?>
