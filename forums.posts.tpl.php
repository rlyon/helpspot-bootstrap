<?php
//Access topic information
$this->topic = $this->splugin('Forums_Posts','getTopic',$this->get_id);
$this->forum = $this->splugin('Forums_Topics','getForum',$this->topic['xForumId']);

//Security - $this->topic returns false if get_id is not valid or is for a private forum
if(!$this->topic) exit();

//Set page title
$this->assign('pg_title',$this->topic['sTopic']);

//Navigation Crumb
$this->crumb = $this->splugin('Forums_Posts','getCrumbToTopic',$this->get_id);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<p>
	<a href="index.php"><?php echo lg_portal_home ?></a>  &#8594;
	<a href="index.php?pg=forums.topics&id=<?php echo $this->crumb['xForumId'] ?>"><?php echo $this->crumb['sForumName'] ?></a> &#8594;
	<b><?php echo $this->crumb['sTopic'] ?></b>
</p>

<h1><?php echo $this->topic['sTopic'] ?></h1>	<br />

<?php foreach($this->splugin('Forums_Posts','getPosts', $this->get_id) AS $post): ?>
<table width="555" cellspacing="0" class="<?php echo $this->helper->altrow('rowOn','rowOff') ?> forumtable">
<tr>
	<td class="forumpost"><a name="<?php echo $post['xPostId'] ?>"></a>
		<?php echo $post['tPost'] ?>
	</td>
</tr>
<tr>
	<td align="right">
		<?php if(!empty($post['sURL'])): ?>
			<b><a href="<?php echo $post['sURL'] ?>"><?php echo $post['sName'] ?></a></b>
		<?php else: ?>
			<b><?php echo $post['sName'] ?></b>
		<?php endif; ?>
		
		<?php if(!empty($post['sLabel'])): ?>
			(<span class="forumlabel"><?php echo $post['sLabel'] ?></span>)
		<?php endif; ?>
		
		<?php if(!empty($post['sEmail'])): ?>
			| <a href="index.php?pg=email&id=<?php echo $post['xPostId'] ?>"><?php echo lg_portal_email ?></a>
		<?php endif; ?>
		
		<br>
		
		<?php 
			//If you want to show a normal date use this function:
			//$this->helper->longDateFormat($post['dtGMTPosted'])
			echo $this->helper->forumDateSinceFormat($post['dtGMTPosted']) 
		?>
	</td>
</tr>
</table>
<?php endforeach; ?>

<?php if($this->splugin('Forums_PostTags','count',$this->get_id)): ?>
	<fieldset class="fieldset">
		<legend><b><?php echo lg_portal_tags ?></b></legend>
		<div class="tag-block tag-block-page">
			<?php foreach($this->splugin('Forums_PostTags','getTags',$this->get_id) AS $tags): ?>
				<a href="index.php?pg=tag.search&id=<?php echo $tags['xTag'] ?>">
					<?php echo $tags['sTag'] ?>
				</a> <span class="tag-sep">&nbsp;/&nbsp;</span>
			<?php endforeach; ?>
		</div>
	</fieldset>
<br />
<?php endif; ?>

<?php if(!$this->helper->isTopicClosed($this->topic,$this->forum)): ?>
<form action="index.php?pg=forums.posts&id=<?php echo $this->get_id ?>" method="post">
	<div class="forumform">	
		<div class="forumoption"><?php echo lg_portal_postreply ?></div>
		
		<p><label for="tPost" class="datalabel"><?php echo lg_portal_message ?></label><br />
			<?php echo $this->helper->showError('tPost','<br />') ?>
			<textarea name="tPost" cols="50" rows="10" style="width:100%"><?php echo $this->post_tPost ?></textarea>
		</p>
		
		<p><label for="sName" class="datalabel"><?php echo lg_portal_postername ?></label><br />
			<?php echo $this->helper->showError('sName','<br />') ?>
			<input type="text" name="sName" size="40" maxlength="100" value="<?php echo $this->helper->visitor['name'] ?>" />
		</p>
		
		<p><label for="sEmail" class="datalabel"><?php echo lg_portal_posteremail ?></label><br />
			<input type="text" name="sEmail" size="40" maxlength="250" value="<?php echo $this->helper->visitor['email'] ?>" />
		</p>
		
		<p><label for="sURL" class="datalabel"><?php echo lg_portal_posterurl ?></label><br />
			<input type="text" name="sURL" size="40" maxlength="250" value="<?php echo $this->helper->visitor['url'] ?>" />
		</p>
		
		<?php 
		//Captcha form protection. You can turn this on and off via a setting in Admin->Settings->System Security. It's enabled by default 
		//This text captcha should be sufficient for most automated spam. As of version 2.6 reCaptcha (http://recaptcha.net) is also supported for increased security. ?>
		<?php include $this->loadTemplate('captcha.tpl.php'); ?>	
		
		<p>
			<input type="checkbox" name="fEmailUpdate" value="1" /> <?php echo lg_portal_emailupdate ?>
		</p>		
	</div>	
	<div class="formbuttondiv">
		<input type="hidden" name="xTopicId" value="<?php echo $this->topic['xTopicId'] ?>" />
		<input type="submit" name="submit" value="<?php echo lg_portal_reply ?>" />
	</div>
	
	<!-- START: SPAM Protection DO NOT REMOVE -->
	<?php echo $this->helper->getSPAMCheckFields() ?>
	<!-- END: SPAM Protection DO NOT REMOVE -->		
	
</form>
<?php else: ?>
	<div class="formbuttondiv" align="center"><b><?php echo lg_portal_topicclosed ?></b></div>
<?php endif; ?>

<?php include $this->loadTemplate('footer.tpl.php'); ?>