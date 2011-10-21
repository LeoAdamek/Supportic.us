
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
		<?=$this->Paginator->prev('<',array(), null, array('class' => 'disabled'))?>
		| <?=$this->Paginator->numbers()?>
		| <?=$this->Paginator->next('>',array(),null,array('class' => 'disabled'))?>
	</div>

	<?=$this->Html->link('Create a new Organisation', array('action' => 'add'))?>
