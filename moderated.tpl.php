<?php
//Set page title
$this->assign('pg_title',lg_portal_spamredirect);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<div style="border:1px solid #ccc;padding:10px;">
	<?php echo lg_portal_spamrenote ?>
	
	<br />
	
	<div align="center"><a href="<?php echo $_GET['return'] ?>"><b><?php echo lg_portal_spamreturn ?></b></a></div>
</div>

<?php include $this->loadTemplate('footer.tpl.php'); ?>