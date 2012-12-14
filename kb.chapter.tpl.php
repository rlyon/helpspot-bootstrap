<?php
//Access chapter information
$this->chapter = $this->splugin('KB_Tree','getChapter',$this->get_id);

//Security - $this->chapter returns false if get_id is not valid or is for a hidden chapter
if(!$this->chapter) exit();

//Navigation Crumb
$this->crumb = $this->splugin('KB_Tree','getCrumbToChapter',$this->get_id);

//Set page title
$this->assign('pg_title',$this->chapter['sChapterName']);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<ul class="breadcrumb">
	<li><a href="index.php"><?php echo lg_portal_home ?></a><span class="divider">/</span></li>
	<li><a href="index.php?pg=kb.book&id=<?php echo $this->crumb['xBook'] ?>"><?php echo $this->crumb['sBookName'] ?></a><span class="divider">/</span></li>
	<li class="active"><?php echo $this->crumb['sChapterName'] ?></li>
</ul>

<ul class="nav nav-stacked">
        <li><h4><?php echo $this->chapter['sChapterName'] ?></h4>
                <ul class="nav nav-pills nav-stacked">
		<?php foreach($this->splugin('KB_Tree','getPages', $this->get_id) AS $page): ?>
			<li><a href="index.php?pg=kb.page&id=<?php echo $page['xPage'] ?>" class="<?php echo $page['class'] ?>"><?php echo $page['name'] ?></a></li>
                <?php endforeach; ?>
                </ul>
        </li>
</ul>

<div class="datarow">
	<span class="pull-left"><?php echo $this->splugin('KB_Tree','getPrevPage', $this->get_id) ?></span>
	<span class="pull-right"><?php echo $this->splugin('KB_Tree','getNextPage', $this->get_id) ?></span>
</div>

<?php include $this->loadTemplate('footer.tpl.php'); ?>
