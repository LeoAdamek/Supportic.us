<?php
class KnowledgeBasesController extends AppController {

	var $name = 'KnowledgeBases';
	var $uses = array('KnowledgeBase'); // Because CakePHP has trouble with this word.
	var $helpers  = array('Time');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index','view');
		$this->Auth->deny('edit','add','delete');
	}

	function index($oid = null){

		Configure::write('debug',0);

		if(isset($oid)){
			$this->KnowledgeBase->Organisation->id = $oid;
			if($this->KnowledgeBase->Organisation->exists()){
				
				// Get the Articles, Paginate and pass.
				$this->set('articles', $this->paginate(
					array(
						'KnowledgeBase.organisation_id' => $oid
					)
				));

			}else{
				$this->Session->setFlash("This Organisation does not exist.");
				$this->redirect(array(
					'controller' => 'organisations',
					'action' => 'index'
				));
			}
		}else{
				$this->Session->setFlash("No Oranisation Specified");
				$this->redirect(array(
					'controller' => 'organisations',
					'action' => 'index'
				));
		}
	}

	function view($article_id = null){
		if(!isset($article_id)){
			$this->Session->setFlash("No article specified.");
			$this->redirect(array('controller' => 'organisations'));
		}else{
			$this->KnowledgeBase->id = $article_id;
			if(!$this->KnowledgeBase->exists()){
				$this->Session->setFlash("This article does not exist");
				$this->redirect(array('controller' => 'organisations'));
			}else{
				$this->set('article',$this->KnowledgeBase->read(null, $article_id));
			}
		}
	}

	function add($oid = null){

		$this->KnowledgeBase->Organisation->id = $oid;

		if($this->KnowledgeBase->Organisation->exists()){
			if($this->KnowledgeBase->Organisation->hasPermission($this->Auth->user('id'), 'KB')){
				if(!empty($this->data)){
					$this->KnowledgeBase->create(); // Create a new article
					if($this->KnowledgeBase->save($this->data)){
						$this->Session->setFlash("Article Saved Sucessfully");
						$kb_id = $this->KnowledgeBase->getInsertId();
						$this->redirect(
							array(
								'controller' => 'knowledge_base',
								'action' => 'view',
								$kb_id
							)
						);
					}elseif(!$this->KnowledgeBase->validates($this->data)){
						$this->set('errors', $this->KnowledgeBase->invalidFields());
					}
				}
				$this->set('org_id', $this->KnowledgeBase->Organisation->field('id'));
			}else{
				$this->Session->setFlash("You do not have permission to write Articles for this Organisation");
				$this->redirect(
					array(
						'controller' => 'organisations',
						'action' => 'index'
					)
				);
			}
		}else{
			$this->Session->setFlash("Invalid Organisation, no Article can be created");
			$this->redirect(
				array(
					'controller' => 'organisations',
					'action' => 'index'
				)
			);
		}
	}

	function getChildCategories($oid = null, $parent_id = null){
		if($oid){
			if($parent_id){
				$categories = $this->KnowledgeBase->Category->getChildCategories($oid, $parent_id, 'KB');
			}else{
				$categories = $this->KnowledgeBase->Category->getRootCategories($oid, 'KB');
			}
		}else{
			$categories = null;
		}
		return $categories;
	}




}
