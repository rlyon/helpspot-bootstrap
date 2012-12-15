<?php
//Set page title
$this->assign('pg_title',lg_portal_forums);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<h1><?php echo lg_portal_forums ?></h1> <br />

<?php foreach($this->splugin('Forums_Forums','getForums') AS $forum): ?>
<div class="<?php echo $this->helper->altrow('rowOn','rowOff') ?>">
  <a href="index.php?pg=forums.topics&id=<?php echo $forum['xForumId'] ?>"><?php echo $forum['sForumName'] ?></a>
  <br>
  <?php echo $forum['sDescription'] ?>
</div>
<?php endforeach; ?>

<?php include $this->loadTemplate('footer.tpl.php'); ?>