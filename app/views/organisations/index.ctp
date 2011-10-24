
<table>
	<tr>
		<th><?php echo $this->Paginator->sort('Name','Organisation.name');?></th>
		<th><?php echo $this->Paginator->sort('Category','OrganisationCategory.name');?></th>
		<th><?php echo $this->Paginator->sort('Country','Country.name');?></th>
	</tr>

	<?php foreach($organisations as $org): ?>
		<tr>
			<td>
<?=$this->Html->link($org['Organisation']['name'], array(
	'controller' => 'organisations',
	'action' => 'view',
	$org['Organisation']['id'],
	$org['Organisation']['slug']
))?>

				<?php if($org['User']['id'] == $session->read('Auth.User.id')){
					echo $this->Html->link('Edit' , array('controller' => 'organisations', 'action' => 'edit', $org['Organisation']['id'], $org['Organisation']['slug'] ), array('class' => 'edit_action'));
				} ?>
			
			</td>
			<td><?=$org['OrganisationCategory']['name']?></td>
			<td><?=$this->Html->image('flags/'.low($org['Country']['code']).'.png')?> <?=$org['Country']['name']?></td>
		</tr>
	<?php endforeach; ?>
</table>

	<div class="paging">
		<?=$this->Paginator->prev( $this->Html->image('icons/resultset_previous.png', array('alt' => '<')), null , null , array('class' => 'disabled', 'escape' => false))?>
		<?=$this->Paginator->numbers()?>
		<?=$this->Paginator->next( $this->Html->image('icons/resultset_next.png', array('alt' => '>')) , null , null , array('class' => 'disabled', 'escape' => false )  )?>
		<br />
		Page: <?=$this->Paginator->counter()?>
	</div>

	<?=$this->Html->link('Create a new Organisation', array('action' => 'add'), array('class' => 'action'))?>
