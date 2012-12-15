<?php
/*
NOTE: Parts of this template can be customized to control different aspects of request creation. Read the details below.

PREFILLING FORM FIELDS:
You can prefill any form field by passing in URL encoded values via GET. For example, in your intranet you may add a link
to HelpSpot that looks like this:

http://www.example.com/support/index.php?pg=request&fullname=Bob+Smith&sUserId=453232&sEmail=bsmith%40example.com&additional=SAP+ID%3A844883

This would set the fields to:
fullname: Bob Smith
sEmail: bsmith@example.com
additional: SAP ID:844883

Make sure to read the details on the 'additional' field. It's very useful for sending extra information into HelpSpot about a request
*/

//Set page title
$this->assign('pg_title',lg_portal_request);

//Set onload
$this->assign('pg_onload', "ShowCategoryCustomFields();");

include $this->loadTemplate('header.tpl.php');
include $this->loadTemplate('navigation.tpl.php');
?>

<h4><?php echo lg_portal_req_note ?></h4>

<?php echo $this->helper->showError('general','<br />') ?>

<form id="request" action="index.php?pg=request" method="post" enctype="multipart/form-data">
  <fieldset>
    <legend>Contact Information</legend>
    <input type="hidden" name="required" value="sEmail,fullname" />
    <input type="hidden" name="additional" value="<?php echo $this->request_additional ?>" />

    <?php /* HelpSpot will automatically parse the name into first name and last name */?>
    <label for="fullname" class="datalabel required"><?php echo lg_portal_req_name ?></label>
    <?php echo $this->helper->showError('fullname','<br />') ?>
    <input type="text" name="fullname" size="40" maxlength="100" value="<?php echo $this->request_fullname ?>" />

    <label for="sEmail" class="datalabel required"><?php echo lg_portal_req_email ?></label>
    <?php echo $this->helper->showError('sEmail','<br />') ?>
    <input type="text" name="sEmail" size="40" maxlength="250" value="<?php echo $this->request_sEmail ?>" />

    <label for="sPhone" class="datalabel"><?php echo lg_portal_req_phone ?></label>
    <?php echo $this->helper->showError('sPhone','<br />') ?>
    <input type="text" name="sPhone" size="40" maxlength="250" value="<?php echo $this->request_sPhone ?>" />
  </fieldset>

  <fieldset>
    <legend><?php echo lg_portal_req_detailsheader ?></legend>

    <label for="fUrgent" class="datalabel"><?php echo lg_portal_req_urgent ?></label>
    <select name="fUrgent">
      <option value="0" <?php if($this->request_fUrgent == 0) echo 'selected' ?>><?php echo lg_portal_req_no ?></option>
      <option value="1" <?php if($this->request_fUrgent == 1) echo 'selected' ?>><?php echo lg_portal_req_yes ?></option>
    </select>
      
    <?php if($this->splugin('Categories','count')): ?>    
    <label for="xCategory" class="datalabel"><?php echo lg_portal_req_category ?></label>
    <select name="xCategory" id="xCategory" onchange="ShowCategoryCustomFields();">
      <option value=""></option>
      <?php foreach($this->splugin('Categories','getCategories') AS $category): ?>
      <option value="<?php echo $category['xCategory'] ?>" 
      <?php if($this->request_xCategory == $category['xCategory']) echo 'selected' ?>>
      <?php echo $category['sCategory'] ?>
      </option>
    <?php endforeach; ?>
      </select>
    <?php endif; ?>

    <?php foreach($this->splugin('CustomFields','getPublicCustomFields') AS $field): ?>
    <?php $requiredClass = $field['isRequired'] ? ' required' : ''; //Determine if field is required. If so set style class ?>
    <?php $fieldID     = 'Custom'.$field['fieldID']; //Set the field ID for use below ?>
    <?php $visible     = $field['isAlwaysVisible'] ? '' : 'display:none;'; //Set if the custom field is visible by default ?>
      
    <div id="<?php echo $fieldID ?>_wrapper" style="<?php echo $visible ?>"><label for="<?php echo $fieldID ?>" class="datalabel<?php echo $requiredClass ?>"><?php echo $field['fieldName'] ?></label><br />
    <?php echo $this->helper->showError($fieldID,'<br />') ?>
        
    <?php if($field['fieldType'] == 'select'): ?>
    <select name="<?php echo $fieldID ?>">
      <option value=""></option>
      <?php foreach($field['listItems'] AS $item): ?>
      <option value="<?php echo $item ?>" <?php if($this->$fieldID == $item) echo 'selected' ?>><?php echo $item ?></option>
      <?php endforeach; ?>
    </select>
    <?php elseif($field['fieldType'] == 'text'): ?>
      <input name="<?php echo $fieldID ?>" type="text" size="<?php echo $field['sTxtSize'] ?>" value="<?php echo $this->$fieldID ?>">
      <?php elseif($field['fieldType'] == 'lrgtext'): ?>
      <textarea name="<?php echo $fieldID ?>" rows="<?php echo $field['lrgTextRows'] ?>" style="width:100%;"><?php echo $this->$fieldID ?></textarea>
      <?php elseif($field['fieldType'] == 'checkbox'): ?>
      <input name="<?php echo $fieldID ?>" type="checkbox" value="1" <?php if($this->$fieldID == 1) echo 'checked' ?>>
      <?php elseif($field['fieldType'] == 'numtext'): ?>
      <input name="<?php echo $fieldID ?>" type="text" size="10" maxlength="10" value="<?php echo $this->$fieldID ?>">
    <?php elseif($field['fieldType'] == 'drilldown'): ?>  
      <?php echo $this->helper->getDrillDownField($field,' '); ?>
    <?php elseif($field['fieldType'] == 'decimal'): ?>  
      <input name="<?php echo $fieldID ?>" type="text" size="10" maxlength="10" value="<?php echo $this->$fieldID ?>">
    <?php elseif($field['fieldType'] == 'regex'): ?>
      <?php echo $this->helper->getRegexField($field); ?>
    <?php elseif($field['fieldType'] == 'date'): ?> 
      <?php echo $this->helper->getDateField($field); ?>
    <?php elseif($field['fieldType'] == 'datetime'): ?> 
      <?php echo $this->helper->getDateTimeField($field); ?>
    <?php endif; ?>
    </div>
    <?php endforeach; ?>
      
    <?php if($this->hd_portalFormFormat == 1): ?>

    <label for="did" class="datalabel"><?php echo lg_portal_req_did ?></label><br />
    <?php echo $this->helper->showError('did','<br />') ?>
    <textarea name="did" cols="50" rows="5" style="width:100%;"><?php echo $this->request_did ?></textarea>
      
    <label for="expected" class="datalabel"><?php echo lg_portal_req_expected ?></label><br />
    <?php echo $this->helper->showError('expected','<br />') ?>
    <textarea name="expected" cols="50" rows="5" style="width:100%;"><?php echo $this->request_expected ?></textarea>
      
    <label for="actual" class="datalabel"><?php echo lg_portal_req_actual ?></label>
    <?php echo $this->helper->showError('actual','<br />') ?>
    <textarea name="actual" cols="50" rows="5" style="width:100%;"><?php echo $this->request_actual ?></textarea>

    <?php elseif($this->hd_portalFormFormat == 0): ?>

    <label for="simple" class="datalabel"><?php echo lg_portal_req_simple ?></label>
    <?php echo $this->helper->showError('simple','<br />') ?>
    <textarea name="simple" cols="50" rows="10" style="width:100%;"><?php echo $this->request_simple ?></textarea>

    <?php endif; ?>

    <?php if($this->hd_allowFileAttachments == 1): ?>
    <label for="doc[]" class="datalabel"><?php echo lg_portal_req_file_upload ?></label>
    <input type="file" name="doc[]" size="40">
    <?php endif; ?>

    <?php include $this->loadTemplate('captcha.tpl.php'); ?>
  </fieldset>
  <input class="btn btn-info" type="submit" name="submit" value="<?php echo lg_portal_req_submitrequest ?>" />

  <!-- START: SPAM Protection DO NOT REMOVE -->
  <?php echo $this->helper->getSPAMCheckFields() ?>
  <!-- END: SPAM Protection DO NOT REMOVE --> 
</form>
  
<?php include $this->loadTemplate('footer.tpl.php'); ?>
