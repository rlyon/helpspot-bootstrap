<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--meta data-->
<?php echo $this->hd_CharSet ?> <!-- Charset meta tag taken from your language pack -->
<meta name="keywords" content="" />
<meta name="description" content="<?php echo $this->hd_name ?> - help desk and customer service portal" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="author" content="Institute for Bioinformatics and Evolutionary Studies" />
<?php if($this->get_page == 'request.check'): ?>
	<meta name="robots" content="noindex, nofollow" />
<?php else: ?>
	<meta name="robots" content="index, follow" />
<?php endif; ?>

<title><?php echo $this->pg_title ?></title>
	
<!--stylesheets-->
<link rel="stylesheet" type="text/css" href="custom_templates/css/bootstrap.min.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="custom_templates/css/docs.css" media="screen, projection" />
<link href="custom_templates/css/bootstrap-responsive.min.css" rel="stylesheet" />
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="custom_templates/js/jquery.js"></script>
<script type="text/javascript" src="custom_templates/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $this->cf_url ?>/index.php?pg=js"></script>
</head>
<body onload="<?php echo $this->pg_onload ?>" class="page-<?php echo $this->get_page_css_class ?>">

<!-- container div is closed in footer.tpl.php -->
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a> 
			<a class="brand" href="<?php echo $this->cf_url ?>"><?php echo $this->hd_name ?></a>
			<div class="nav-collapse collapse">
			<ul class="nav">
				<?php if($this->splugin('KB_Books','count')): ?>
				<li class="dropdown">
					<a href="index.php?pg=kb" class="dropdown-toggle" data-toggle="dropdown">Knowledge Books <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php foreach($this->splugin('KB_Books','getBooks') AS $book): ?>
						<li><a href="index.php?pg=kb.book&id=<?php echo $book['xBook'] ?>"><?php echo $book['sBookName'] ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endif; ?>
				<?php if($this->splugin('Forums_Forums','count')): ?>
				<li class="dropdown">
					<a href="index.php?pg=kb" class="dropdown-toggle" data-toggle="dropdown">Forums <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						<?php foreach($this->splugin('Forums_Forums','getForums') AS $forum): ?>
						<li><a href="index.php?pg=forums.topics&id=<?php echo $forum['xForumId'] ?>"><?php echo $forum['sForumName'] ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endif; ?>
				<li><a href="index.php?pg=request" class="<?php echo $this->helper->ns('request') ?>"><?php echo lg_portal_submitrequest ?></a></li>
				<li><a href="index.php?pg=request.check" class="<?php echo $this->helper->ns('check') ?>"><?php echo lg_portal_checkrequest ?></a></li>
			</ul>
			</div>
		</div>
	</div>
</div>

<header class="jumbotron subhead" id="overview">
	<div class="container">
		<div class="row">
		<div class="span9">
		<h1><?php echo $this->pg_title ?></h1>
		<p class="lead"><?php echo nl2br($this->pg_note) ?></p>
		</div>
		<div class="span3">
		<?php include $this->loadTemplate('searchbox.tpl.php'); ?> 
		</div>
		</div>
	</div>
</header>

<div class="container">
