<link href="https://supportic.us/css/main.css" rel=stylesheet" />

<h1>Welcome to Supportic.us <?php echo $user["User"]["name"];?>!</h1>

<p>Welcome to Supportic.us -- Online customer and corporate support.<br />
It's great to welcome you, but first there's one thing we need you to do,<br />
before you can log in, you need to activate your account by clicking this link.<br />
<a href="<?php echo $activation_url; ?>"><?php echo $activation_url;?></a>

If you can't click this link, copy and paste it into your browser, then you should be able to log in.<br />

~ Supportic.us Team.</p>
