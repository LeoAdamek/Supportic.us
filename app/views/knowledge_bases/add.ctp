<h2>Create a new Article</h2>

	<?php
		echo $this->Html->script('tiny_mce/tiny_mce');
		echo $this->Html->script('tiny_mce/jquery.tinymce');
		echo $this->Html->script('kb/tinymce');
	?>


	<?php
		echo $this->Form->create('KnowledgeBase', array('controller' => 'KnowledgeBase', 'action' => "add/{$org_id}"));
		echo $this->Form->input('title');
		echo $this->Form->input('body', array(
			'class' => 'tinymce',
			'cols' => '20'
		));
		echo $this->Form->input('category_id', array(
			'type' => 'hidden'
		));
		echo $this->Form->end('Create');

	?>
