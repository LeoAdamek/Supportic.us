<h2>Help Articles</h2>

<?php if(empty($articles)): ?>

	<h3>This organisation has no help articles</h3>
	<small>Sorry about that...</small>

<?php else: ?>

	<table>
		<tr>
			<th span="col">Title</th>
			<th span="col">Category</th>
		</tr>

		<?php foreach($articles as $article): ?>

			<tr>
			<td>
				<?=$this->Html->link($article['KnowledgeBase']['title'], array(
					'controller' => 'knowledge_bases',
					'action' => 'view',
					$article['KnowledgeBase']['id'],
					$article['KnowledgeBase']['slug']
				));
				?>
			</td>
				<td><?=$article['Category']['name']?></td>
			</tr>

		<?php endforeach; ?>


<?php endif; ?>
