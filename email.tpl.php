<?php
//Access forum information
$this->post = $this->splugin('Forums_Posts','getPost',$this->get_id);
$this->topic = $this->splugin('Forums_Posts','getTopic',$this->post['xTopicId']);

//Security - $this->post returns false if get_id is not valid or is for a private forum
if(!$this->post) exit();

//Set page title
$this->assign('pg_title',lg_portal_emailposter);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<h1><?php echo lg_portal_emailposter ?></h1>

<br />

<form action="index.php?pg=email&id=<?php echo $this->get_id ?>" method="POST">
<p><label class="datalabel"><?php echo lg_portal_to ?></label><br>
	<?php echo $this->post['sName'] ?>
</p>

<p><label class="datalabel"><?php echo lg_portal_subject ?></label><br>
	<?php echo $this->topic['sTopic'] ?>
</p>

<p><label for="message" class="datalabel"><?php echo lg_portal_message ?></label><br>
	<textarea name="message" cols="50" rows="8"></textarea>
</p>

<p><label for="name" class="datalabel"><?php echo lg_portal_yourname ?></label><br>
	<input type="text" name="yourname" size="40" maxlength="100" value="<?php echo $this->helper->visitor['name'] ?>" />
</p>

<p><label for="youremail" class="datalabel"><?php echo lg_portal_youremail ?></label><br>
	<input type="text" name="youremail" size="40" maxlength="250" value="<?php echo $this->helper->visitor['email'] ?>" />
</p>

<?php 
//Captcha form protection. You can turn this on and off via a setting in Admin->Settings->System Security. It's enabled by default 
//This text captcha should be sufficient for most automated spam. As of version 2.6 reCaptcha (http://recaptcha.net) is also supported for increased security. ?>
<?php include $this->loadTemplate('captcha.tpl.php'); ?>

<div class="formbuttondiv">
	<input type="submit" name="submit" value="<?php echo lg_portal_sendemail ?>" />
	<input type="hidden" name="id" value="<?php echo $this->get_id ?>" />
</div>
</form>

<?php include $this->loadTemplate('footer.tpl.php'); ?>