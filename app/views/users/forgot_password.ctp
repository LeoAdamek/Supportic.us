<h2>Forgot your Password?</h2>

<p>If you have forgotten your password you can reset it using this form.<br />
Just enter your e-mail address below and a link to reset your password will be emailed to you</p>

<?php

	echo $this->Form->create('User', array('controller' => 'Users','action' => 'forgot_password'));
	echo $this->Form->input('email', array(
		'title' => 'Your E-mail Address',
		'class' => 'vtip'
	));

	echo $this->Form->end('Reset my password');

?>
