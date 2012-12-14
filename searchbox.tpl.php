<form id="search" class="navbar-form" action="index.php" method="get">
	<input type="hidden" name="pg" value="search">
	<div class="input-append">
		<input class="span2 inverse" type="text" name="q" id="q" value="<?php echo $this->get_q ?>"> 
		<input class="btn btn-inverse" type="submit" name="submit" value="<?php echo lg_portal_search ?>">
	</div>
	<div>
		<p>
		<select name="area" class="span2" id="area">				
			<?php if($this->splugin('KB_Books','count')): ?>
				<option value="kb" <?php if($this->get_area == 'kb') echo 'selected' ?>><?php echo lg_portal_searchkb ?></option>
			<?php endif; ?>
			<?php if($this->splugin('Forums_Forums','count')): ?>
				<option value="forum" <?php if($this->get_area == 'forum') echo 'selected' ?>><?php echo lg_portal_searchforum ?></option>
			<?php endif; ?>
		</select>
		</p>
	</div>
</form>
