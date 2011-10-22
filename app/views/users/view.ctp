<h2><?=$user['User']['name']?> (<?=$user['User']['addressName']?>)</h2>

<p><?=$user['User']['addressName']?> is from <?=$this->Html->image('flags/'.low($user['Country']['code']).'.png')?> <?=$user['Country']['name']?> </p>
