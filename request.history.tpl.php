<?php
//Set page title
$this->assign('pg_title',lg_portal_checkrequest);

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<?php include $this->loadTemplate('loginbar.tpl.php'); ?>

	<?php /* Check that the customer is logged in */ ?>
	<?php if($this->splugin('Request_Check','isLoggedIn')): ?>

		<table width="100%">
		<!-- optional header
		<tr>
			<th></th>
			<th>Request</th>
			<th>Opened On</th>
		</tr>	
		-->
		<?php 
		/* Loop over all the history data and output a simple row for each. You can add
		additional columns of information if you like, the $row variable holds all the same data as the HS_Request table.
		
		$this->hd_portalLoginSearchType is the variable set in Admin->Settings->Portal->Show Request History Based On:
		this setting determines if the requests returned are only those belonging to this email account or to any customer ID every associated with this email account.
		
		*/ ?>
		<?php if($this->splugin('Request_Check','requestHistoryDataCount',$this->hd_portalLoginSearchType) > 0): ?>
			<?php foreach($this->splugin('Request_Check','requestHistoryData',$this->hd_portalLoginSearchType) AS $row): ?>
				<tr class="<?php echo $this->helper->altrow('rowOn','rowOff') ?>">
					<td><a href="index.php?pg=request.check&id=<?php echo $row['accesskey'] ?>"><?php echo $row['xRequest'] ?></a></td>
					
					<?php //Show the name of the requester if we're returning all results for a customer ID rather than only for this customers email ?>
					<?php if($this->hd_portalLoginSearchType == 2): ?>
						<td style="white-space:nowrap;padding-right:3px;"><?php echo $row['sFirstName'] ?> <?php echo $row['sLastName'] ?></td>
					<?php endif; ?>
					
					<td><div class="request_summary"><?php echo $row['tNote'] ?></div></td>
					<td width="100"><?php echo $this->helper->shortDateFormat($row['dtGMTOpened']) ?></td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td><?php echo lg_portal_norequesthistory ?></td>
			</tr>
		<?php endif; ?>
		</table>
	
	<?php /* Closing if for login check */ ?>
	<?php endif; ?>
	
<?php include $this->loadTemplate('footer.tpl.php'); ?>
