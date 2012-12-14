<?php
//Set page title
$this->assign('pg_title',lg_portal_maintenance_title);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<div style="border:1px solid #ccc;padding:10px;font-weight:bold;">
	<?php echo lg_portal_maintenance_note ?>
</div>

<?php include $this->loadTemplate('footer.tpl.php'); ?>