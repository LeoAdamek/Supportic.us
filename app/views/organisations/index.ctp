
<table>
	<tr>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('category');?></th>
		<th><?php echo $this->Paginator->sort('country');?></th>
	</tr>

	<?php foreach($organisations as $org): ?>
		<tr>
			<td><?=$org['Organisation']['name']?></td>
			<td><?=$org['OrganisationCategory']['name']?></td>
			<td><?=$org['Country']['name']?></td>
		</tr>
	<?php endforeach; ?>
</table>

	<div class="paging">
		<?=$this->Paginator->prev( $this->Html->image('icons/resultset_previous.png', array('alt' => '<')), null , null , array('class' => 'disabled', 'escape' => false))?>
		| <?=$this->Paginator->numbers()?>
		| <?=$this->Paginator->next( $this->Html->image('icons/resultset_next.png', array('alt' => '>')) , null , null , array('class' => 'disabled', 'escape' => false )  )?>
	</div>

	<?=$this->Html->link('Create a new Organisation', array('action' => 'add'))?>
