
<?php

echo $this->Form->create('Permission', array('controller' => 'permission', 'action' => "edit/{$org_id}/{$perm_id}"));
echo $this->Form->input('permissionType');
echo $this->Form->end('Update');


?>
