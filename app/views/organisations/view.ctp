<h1><?=$org['Organisation']['name']?></h1>

<h4>About <?=$org['Organisation']['name']?> </h4>
	<p>
		Location: <?=$this->Html->image('flags/'.low($org['Country']['code']).'.png')?> <?=$org['Country']['name']?> <br />
		Created By: <?=$org['User']['name']?> <br />
		Category: <?=$org['OrganisationCategory']['name']?>
	</p>

