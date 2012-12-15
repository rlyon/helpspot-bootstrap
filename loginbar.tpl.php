<?php if($this->helper->isLoggedIntoRequestHistory()): ?>
  <p align="right">
    <?php echo $this->splugin('Request_Check','loggedInEmailOrUsername') ?> | 
    <a href="index.php?pg=request.history"><?php echo lg_portal_requesthistory ?></a> | 
    <?php if($this->hd_requestCheckAuthType == "internal"): ?>
    <?php //only show the change password link if we're using internal authentication on the portal ?>  
      <a href="" onclick="$('change_password_box').toggle();return false;"><?php echo lg_portal_req_changepassword ?></a> |
    <?php endif; ?>
    <a href="index.php?pg=logout"><?php echo lg_portal_req_logout ?></a>
  </p>
  
  <?php 
  //The table below is the change password box. It's hidden by default and is shown when the change password link above is clicked.
  //The form values are sent via an ajax request which is sent from the javascript function defined in the js template.
  ?>
  <form onsubmit="return false;">
  <table id="change_password_box" style="display:none;border:1px solid #ccc;padding:10px;margin-bottom:10px;">
    <tr>
      <td><?php echo lg_portal_req_newpassword ?></td>
      <td><?php echo lg_portal_req_confirm ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="text" name="new_password" id="new_password" size="20" value="" /></td>
      <td><input type="text" name="new_password_confirm" id="new_password_confirm" size="20" value="" /></td>
      <td><input type="button" value="<?php echo lg_portal_req_save ?>" onclick="ChangePortalLoginPassword();" /></td>
    </tr>
  </table>
  </form>
<?php endif; ?>