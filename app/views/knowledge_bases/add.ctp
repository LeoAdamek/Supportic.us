<h2>Create a new Article</h2>

	<?php
		echo $this->Form->create('KnowledgeBase', array('controller' => 'KnowledgeBase', 'action' => "add/{$org_id}"));
		echo $this->Form->input('title');
		echo $this->Form->input('body', array(
			'class' => 'tinyMCE',
			'cols' => '20'
		));
		echo $this->Form->input('category_id', array(
			'type' => 'hidden'
		));
		echo $this->Form->end('Create');

	?>
