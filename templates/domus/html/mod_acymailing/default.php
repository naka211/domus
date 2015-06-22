<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.formvalidator');
?>
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Nyhedsbrev tilmelding</h4>
				<p>Få inspiration, nyheder og fantastiske priser. Send mig nyeste rejseinspiration, insidertips og gode priser fra Domus Holidays</p>
			</div>
			<div class="modal-body">
				<form class="form-validate" id="<?php echo $formName; ?>" action="<?php echo JRoute::_('index.php'); ?>" onsubmit="return submitacymailingform('optin','<?php echo $formName;?>')" method="post" name="<?php echo $formName ?>" <?php if(!empty($fieldsClass->formoption)) echo $fieldsClass->formoption; ?>>
					<div class="form-group">
						<input id="user_name_<?php echo $formName; ?>" placeholder="Navn *" class="inputbox form-control required" type="text" name="user[name]" value=""/>
					</div> 
					<div class="form-group">
						<input id="user_email_<?php echo $formName; ?>" placeholder="E-mail *" class="inputbox form-control required validate-email" type="text" name="user[email]" value="" />
					</div>
					<p>Felter markeret med * skal udfyldes</p>
					<button type="submit" class="btn validate">TILMELD</button>
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
		</div>
	</div>
</div>