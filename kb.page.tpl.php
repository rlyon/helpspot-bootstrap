<?php
//Access page information
$this->page    = $this->splugin('KB_Tree','getPage',$this->get_id);

//Security - $this->page returns false if get_id is not valid or is for a hidden page
if(!$this->page) exit();

//Navigation Crumb
$this->crumb = $this->splugin('KB_Tree','getCrumbToPage',$this->get_id);

//Set page title
$this->assign('pg_title',$this->page['sPageName']);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<ul class="breadcrumb">
  <li><a href="index.php"><?php echo lg_portal_home ?></a><span class="divider">/</span></li>
  <li><a href="index.php?pg=kb.book&id=<?php echo $this->crumb['xBook'] ?>"><?php echo $this->crumb['sBookName'] ?></a><span class="divider">/</span></li>
  <li><a href="index.php?pg=kb.chapter&id=<?php echo $this->crumb['xChapter'] ?>"><?php echo $this->crumb['sChapterName'] ?></a><span class="divider">/</span></li>
  <li class="active"><?php echo $this->crumb['sPageName'] ?></li>
</ul>

<p>
<?php echo $this->page['tPage'] ?>
</p>

<?php if($this->splugin('KB_PageTags','count',$this->get_id)): ?>
  <fieldset class="fieldset">
    <legend><b><?php echo lg_portal_tags ?></b></legend>
    <div class="tag-block tag-block-page">
      <?php foreach($this->splugin('KB_PageTags','getTags',$this->get_id) AS $tags): ?>
        <a href="index.php?pg=tag.search&id=<?php echo $tags['xTag'] ?>">
          <?php echo $tags['sTag'] ?>
        </a> <span class="tag-sep">&nbsp;/&nbsp;</span>
      <?php endforeach; ?>
    </div>
  </fieldset>
<br />
<?php endif; ?>

<?php if($this->splugin('KB_PageDownloads','count',$this->get_id)): ?>
  <fieldset class="fieldset">
    <legend><b><?php echo lg_portal_downloads ?></b></legend>
    
    <ul class="kbextralist">
      <?php foreach($this->splugin('KB_PageDownloads','getDownloads',$this->get_id) AS $download): ?>
      <li><?php echo $this->helper->mimeimg($download['sFilename']) ?> <a href="index.php?pg=file&from=2&id=<?php echo $download['xDocumentId'] ?>"><?php echo $download['sFilename'] ?></a>
      <?php endforeach; ?>
    </ul>
  
  </fieldset>
<br />  
<?php endif; ?>

<?php if($this->splugin('KB_PageRelated','count',$this->get_id)): ?>
  <fieldset class="fieldset">
    <legend><b><?php echo lg_portal_relatedpages ?></b></legend>
    
    <ul class="kbextralist">
      <?php foreach($this->splugin('KB_PageRelated','getRelated',$this->get_id) AS $related): ?>
      <li><a href="index.php?pg=kb.page&id=<?php echo $related['xRelatedPage'] ?>">
          <?php echo $related['sBookName'] ?> >
          <?php echo $related['sChapterName'] ?> >
          <?php echo $related['sPageName'] ?> 
        </a>
      <?php endforeach; ?>
    </ul>
  
  </fieldset>
<?php endif; ?>

<?php //If visitor has voted for this page before then thank them ?>
<?php if($this->helper->hasvoted($this->get_id)): ?>
  <div class="helpful"><b><?php echo lg_portal_hasvoted ?></b></div>
<?php else: ?>
  <div class="helpful">
  <?php echo lg_portal_hf ?>: <a href="#" onClick="document.forms['votehelpful'].submit();return false;"><?php echo lg_portal_helpful ?></a> | 
                <a href="#" onClick="document.forms['votenothelpful'].submit();return false;"><?php echo lg_portal_nothelpful ?></a>
  </div>
  <!-- voting forms, invoked via javascript -->
  <form action="index.php?pg=vote.helpful" name="votehelpful" method="POST"><input type="hidden" name="xPage" value="<?php echo $this->page['xPage'] ?>"></form>
  <form action="index.php?pg=vote.nothelpful" name="votenothelpful" method="POST"><input type="hidden" name="xPage" value="<?php echo $this->page['xPage'] ?>"></form>
<?php endif; ?>

<div class="datarow">
  <span class="pull-left"><?php echo $this->splugin('KB_Tree','getPrevPage', $this->get_id) ?></span>
  <span class="pull-right"><?php echo $this->splugin('KB_Tree','getNextPage', $this->get_id) ?></span>
</div>

<?php include $this->loadTemplate('footer.tpl.php'); ?>
