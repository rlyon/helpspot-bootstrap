<?php
//Access book information
$this->book = $this->splugin('KB_Tree','getBook',$this->get_id);

//Security - $this->book returns false if get_id is not valid or is for a private book
if(!$this->book) exit();

//Set page title
$this->assign('pg_title',$this->book['sBookName']);
$this->assign('pg_note',$this->book['tDescription']);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<ul class="breadcrumb">
  <li><a href="index.php"><?php echo lg_portal_home ?></a><span class="divider">/</span></li>
  <li class="active"><?php echo $this->book['sBookName'] ?></li>
</ul>

<ul class="nav nav-stacked">
  <?php foreach($this->splugin('KB_Tree','getChapters',$this->get_id) AS $chapter): ?>
  <li><h4><?php echo $chapter['name'] ?></h4>
    <ul class="nav nav-pills nav-stacked">
    <?php foreach($this->splugin('KB_Tree','getPages',$chapter['xChapter']) AS $page): ?>
      <li><a href="index.php?pg=kb.page&id=<?php echo $page['xPage'] ?>" class="<?php echo $page['class'] ?>"><?php echo $page['name'] ?></a></li>
    <?php endforeach; ?>
    </ul>
  </li>
  <?php endforeach; ?>
</ul>

<p>
  <a href="index.php?pg=kb.printer.friendly&id=<?php echo $this->book['xBook'] ?>">
    <?php echo $this->book['sBookName'] ?>: <?php echo lg_portal_kbprinter ?>
  </a>
</p>

<?php include $this->loadTemplate('footer.tpl.php'); ?>
