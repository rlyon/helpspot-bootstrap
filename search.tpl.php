<?php
//Set page title
$this->assign('pg_title',lg_portal_search.': '.$this->get_q);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>


<ul class="breadcrumb">
  <li><a href="index.php"><?php echo lg_portal_home ?></a><span class="divider">/</span></li>
  <li class="active"><?php echo lg_portal_search ?>: <?php echo $this->get_q ?></li>
</ul>

<h3>Results found: <?php echo $this->splugin('Search','count', $this->get_q, $this->get_area) ?></h3> <br />

<?php if($this->splugin('Tags','searchCount',$this->get_q)): ?>
  <fieldset class="fieldset">
    <legend><b><?php echo lg_portal_searchtags ?></b></legend>
    <div class="tag-block tag-block-page">
      <?php foreach($this->splugin('Tags','searchTags',$this->get_q) AS $tags): ?>
        <a href="index.php?pg=tag.search&id=<?php echo $tags['xTag'] ?>">
          <?php echo $tags['sTag'] ?>
        </a> <span class="tag-sep">&nbsp;/&nbsp;</span>
      <?php endforeach; ?>
    </div>
  </fieldset>
<br />
<?php endif; ?>

<table class="table table-striped" width="100%" cellspacing="0">
<?php foreach($this->splugin('Search','search', $this->get_q, $this->get_area) AS $result): ?>
<tr>
  <td>
    <h5><a href="index.php<?php echo $result['link'] ?>"><?php echo $result['title'] ?></a></h5> <p><?php echo $result['desc'] ?></p>
  </td>
  <td class="score">
    <?php echo $result['score'] ?>
  </td>
</tr>
<?php endforeach; ?>
</table>

<?php include $this->loadTemplate('footer.tpl.php'); ?>
