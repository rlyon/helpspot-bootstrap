<?php
//Access forum information
$this->forum = $this->splugin('Forums_Topics','getForum',$this->get_id);

//Security - $this->forum returns false if get_id is not valid or is for a private forum
if(!$this->forum) exit();

//Set page title
$this->assign('pg_title',$this->forum['sForumName']);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<p>
  <a href="index.php"><?php echo lg_portal_home ?></a>  &#8594;
  <b><?php echo $this->forum['sForumName'] ?></b>
</p>

<h1><?php echo $this->forum['sForumName'] ?></h1>

<div class="subheading"><?php echo $this->forum['sDescription'] ?></div>

<table width="555" cellspacing="0" class="forumtable">
<?php foreach($this->splugin('Forums_Topics','getTopics', $this->get_id, $this->get_start) AS $topic): ?>
<tr class="<?php echo $this->helper->altrow('rowOn','rowOff') ?>">
  <td>
    <?php if($topic['fSticky']): ?>
      <img src="<?php echo $this->cf_primaryurl ?>/portal/images/sticky.gif" align="center" alt="<?php echo lg_portal_sticky ?>" height="16" width="16" />
    <?php endif; ?>   
    <a href="index.php?pg=forums.posts&id=<?php echo $topic['xTopicId'] ?>&pc=<?php echo $topic['postcount'] ?>">   
      <?php echo $topic['sTopic'] ?></a> 
      - <?php echo $topic['postcount'] ?>
  </td>
  <td align="right" class="forum-name">
    <?php echo $topic['sName'] ?>
  </td>
</tr>
<?php endforeach; ?>

<tr class="<?php echo $this->helper->altrow('rowOn','rowOff') ?>">
 <td colspan="2" align="right">
  <?php if($this->get_start != 0): ?>
    <a href="index.php?pg=forums.topics&id=<?php echo $this->get_id ?>&start=<?php echo ($this->get_start - $this->hd_forumPageSize - 1) ?>"><?php echo lg_portal_prev ?></a>
  <?php endif; ?>
  <?php if($this->get_start != 0 && ($this->splugin('Forums_Topics','count') == $this->hd_forumPageSize)): ?>
    |
  <?php endif; ?>
  <?php if($this->splugin('Forums_Topics','count') == $this->hd_forumPageSize): ?>
    <a href="index.php?pg=forums.topics&id=<?php echo $this->get_id ?>&start=<?php echo ($this->get_start + $this->hd_forumPageSize + 1) ?>"><?php echo lg_portal_next ?></a>   
  <?php endif; ?> 
  
  <?php if($this->get_start == 0 && $this->hd_forumFeedsEnabled): ?>
  | <a href="index.php?pg=forums.feed&id=<?php echo $this->get_id ?>"><img src="<?php echo $this->cf_primaryurl ?>/portal/images/rss.gif" alt="" align="center" border="0" /></a>
  <?php endif; ?> 
 </td>
</tr>
</table>

<?php if(!$this->forum['fClosed']): ?>
<form action="index.php?pg=forums.topics&id=<?php echo $this->get_id ?>" method="post">
  <div class="forumform"> 
    <div class="forumoption"><?php echo lg_portal_createatopic ?></div>
    
    <p><label for="sTopic" class="datalabel"><?php echo lg_portal_topictitle ?></label><br />
      <?php echo $this->helper->showError('sTopic','<br />') ?>
      <input type="text" name="sTopic" size="60" maxlength="100" value="<?php echo $this->post_sTopic ?>" style="width:100%" />
    </p>
    
    <p><label for="tPost" class="datalabel"><?php echo lg_portal_message ?></label><br />
      <?php echo $this->helper->showError('tPost','<br />') ?>
      <textarea name="tPost" cols="50" rows="10" style="width:100%;"><?php echo $this->post_tPost ?></textarea>
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
    <input type="hidden" name="xForumId" value="<?php echo $this->forum['xForumId'] ?>" />
    <input type="submit" name="submit" value="<?php echo lg_portal_createtopic ?>" />
  </div>
  
  <!-- START: SPAM Protection DO NOT REMOVE -->
  <?php echo $this->helper->getSPAMCheckFields() ?>
  <!-- END: SPAM Protection DO NOT REMOVE --> 
  
</form>
<?php else: ?>
  <div class="formbuttondiv" align="center"><b><?php echo lg_portal_forumclosed ?></b></div>
<?php endif; ?>

<?php include $this->loadTemplate('footer.tpl.php'); ?>