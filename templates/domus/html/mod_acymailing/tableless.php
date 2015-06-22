<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.formvalidator');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
		jQuery('input').on('change invalid', function() {
			var textfield = jQuery(this).get(0);
			textfield.setCustomValidity('');
			
			if (!textfield.validity.valid) {
			  textfield.setCustomValidity('Venligst udfyld dette felt');  
			}
		});
	});
</script>
<section class="newsletter">
	<div class="container">
		<p>Få inspiration, nyheder og fantastiske priser. Send mig nyeste rejseinspiration, insidertips og gode priser fra Domus Holidays</p>
		<form class="form-inline form-validate" id="<?php echo $formName; ?>" action="<?php echo JRoute::_('index.php'); ?>" onsubmit="return submitacymailingform('optin','<?php echo $formName;?>')" method="post" name="<?php echo $formName ?>" <?php if(!empty($fieldsClass->formoption)) echo $fieldsClass->formoption; ?> >
			<div class="row">
				<div class="col-sm-5">
					<div class="form-group">
						<input id="user_name_<?php echo $formName; ?>" placeholder="Navn *" class="inputbox form-control required" type="text" name="user[name]" style="width:<?php echo $fieldsize; ?>" value="" title="<?php echo $nameCaption;?>"/>
					</div> 
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<input id="user_email_<?php echo $formName; ?>" placeholder="E-mail *" class="inputbox form-control required validate-email" type="text" name="user[email]" style="width:<?php echo $fieldsize; ?>" value="" title="<?php echo $emailCaption;?>" />
					</div> 
				</div>
				<div class="col-sm-2">
					 <div class="form-group">
						<!--<button type="submit" class="btn">TILMELD</button>-->
						<input class="button subbutton btn btn-primary validate" type="submit" value="TILMELD" name="Submit"/>
					</div> 
				</div>  
			</div>
			<?php $ajax = ($params->get('redirectmode') == '3') ? 1 : 0;?>
			<input type="hidden" name="ajax" value="<?php echo $ajax; ?>"/>
			<input type="hidden" name="acy_source" value="<?php echo 'module_'.$module->id ?>" />
			<input type="hidden" name="ctrl" value="sub"/>
			<input type="hidden" name="task" value="notask"/>
			<input type="hidden" name="redirect" value="<?php echo urlencode($redirectUrl); ?>"/>
			<input type="hidden" name="redirectunsub" value="<?php echo urlencode($redirectUrlUnsub); ?>"/>
			<input type="hidden" name="option" value="<?php echo ACYMAILING_COMPONENT ?>"/>
			<?php if(!empty($identifiedUser->userid)){ ?><input type="hidden" name="visiblelists" value="<?php echo $visibleLists;?>"/><?php } ?>
			<input type="hidden" name="hiddenlists" value="<?php echo $hiddenLists;?>"/>
			<input type="hidden" name="acyformname" value="<?php echo $formName; ?>" />
		</form> 
	</div>
</section>