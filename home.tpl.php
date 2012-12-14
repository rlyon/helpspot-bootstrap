<?php
//Set page title
$this->assign('pg_title',$this->hd_name);
$this->assign('pg_note', $this->hd_portalHomepageMsg);
include $this->loadTemplate('header.tpl.php');
?>
<p></p>
<ul class="thumbnails">
<?php foreach($this->splugin('KB_Books','getBooks') AS $book): ?>
	<li class="span3">
		<div class="thumbnail" style="height: 275px;">
        		<a style="height: 100px; vertical-align:middle; display:inline-block;" class="span2 btn btn-primary btn-large" href="index.php?pg=kb.book&id=<?php echo $book['xBook'] ?>">
				<?php echo $book['sBookName'] ?>
			</a>
        		<p class="lead" style="text-align: center;"><?php echo nl2br($book['tDescription']) ?></p>
		</div>
	</li>
<?php endforeach; ?>
</ul>

<!--
<?php if($this->splugin('KB_HighlightedPages','count') > 0): //Only show highlighted pages if there are any ?>
	<table width="555" cellspacing="0" class="forumtable">
	<tr>
		<td>
			<h2><?php echo lg_portal_highlightedpages ?></h2>	<br />
		</td>
	</tr> 
	<?php foreach($this->splugin('KB_HighlightedPages','getHighlightedPages') AS $page): ?>
	<tr class="<?php echo $this->helper->altrow('rowOn','rowOff') ?>">
		<td>
			<a href="index.php?pg=kb.page&id=<?php echo $page['xPage'] ?>">
				<?php echo $page['sBookName'] ?> ~ <?php echo $page['sPageName'] ?></a> 
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
<?php $this->helper->reset_altrow(); ?>

<?php if($this->splugin('Tags','count') > 0): //Only show tags if there are any ?>
	<table width="555" cellspacing="0" class="forumtable tag-cloud-homepage">
	<tr>
		<td>
			<h2><?php echo lg_portal_tags ?></h2>	<br />
		</td>
	</tr>
	<tr>
		<td class="tag-cloud-td">
			<div class="tag-block tag-block-home">
			<?php foreach($this->splugin('Tags','getCloud') AS $tag): ?>
				<a href="index.php?pg=tag.search&id=<?php echo $tag['xTag'] ?>"  style="font-size:<?php echo $tag['font-size'] ?>%;"><?php echo $tag['sTag'] ?></a> <span class="tag-sep">&nbsp;/&nbsp;</span> 
			<?php endforeach; ?>
			</div>
		</td>
	</tr>
	</table>
<?php endif; ?>

<?php if($this->splugin('Forums_LatestTopics','count') > 0): //Only show most recent forum posts if there are any ?>
	<table width="555" cellspacing="0" class="forumtable">
	<tr>
		<td>
			<h2><?php echo lg_portal_latesttopic ?></h2>	<br />
		</td>
	</tr>
	<?php foreach($this->splugin('Forums_LatestTopics','getLatestTopics', 10) AS $topic): ?>
	<tr class="<?php echo $this->helper->altrow('rowOn','rowOff') ?>">
		<td>
			<a href="index.php?pg=forums.posts&id=<?php echo $topic['xTopicId'] ?>&pc=<?php echo $topic['postcount'] ?>">
				<?php echo $topic['sTopic'] ?></a> - <?php echo $topic['postcount'] ?>
		</td>
		<td align="right" class="forum-name">
			<?php echo $topic['sName'] ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
<?php $this->helper->reset_altrow(); ?>

<?php if($this->splugin('KB_HelpfulPages','count') > 0): //Only show most helpful pages if there are any ?>
	<table width="555" cellspacing="0" class="forumtable">
	<tr>
		<td>
			<h2><?php echo lg_portal_helpfulpages ?></h2>	<br />
		</td>
	</tr>
	<?php foreach($this->splugin('KB_HelpfulPages','getHelpfulPages', 10) AS $page): ?>
	<tr class="<?php echo $this->helper->altrow('rowOn','rowOff') ?>">
		<td>
			<a href="index.php?pg=kb.page&id=<?php echo $page['xPage'] ?>">
				<?php echo $page['sBookName'] ?> ~ <?php echo $page['sPageName'] ?></a> 
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
-->
<?php include $this->loadTemplate('footer.tpl.php'); ?>
