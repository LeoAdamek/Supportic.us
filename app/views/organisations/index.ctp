<h1>Organisations</h1>


<a id="searchToggle">Search Organisations</a>
<div id="searchform">
<?php
	echo $this->Form->create('Organisation',array('controller' => 'Organisations','action' => 'index'));
	echo $this->Form->input('Organisation.name', array('class' => 'search'));
	echo $this->Form->input('Organisation.country');
	echo $this->Form->end('Search');
?>
<?=$this->Html->script('organisations_search')?>
</div>




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
			
			</td>
			<td><?=$org['OrganisationCategory']['name']?></td>
			<td><?=$this->Html->image('flags/'.low($org['Country']['code']).'.png')?> <?=$org['Country']['name']?></td>
		</tr>
	<?php endforeach; ?>
</table>

	<div class="paging">
		<?=$this->Paginator->prev( $this->Html->image('icons/resultset_previous.png', array('alt' => '<')), array('escape' => false) , array('escape' => false) , array('class' => 'disabled', 'escape' => false))?>
		<?=$this->Paginator->numbers()?>
		<?=$this->Paginator->next( $this->Html->image('icons/resultset_next.png', array('alt' => '>')) , array('escape' => false) , null , array('class' => 'disabled', 'escape' => false )  )?>
		<br />
		Page: <?=$this->Paginator->counter()?>
	</div>

	<br />
	<br />

	<?=$this->Html->link('Create a new Organisation', array('action' => 'add'), array('class' => 'action'))?>
