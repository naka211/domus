<?php
defined('_JEXEC') or die;
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
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content clearfix">  
				<div class="row">
					<div class="col-sm-5">
						<h4>{article 11}{title}{/article}</h4>
						{article 11}{text}{/article}
					</div> <!-- col-sm-6 -->   
					<div class="col-sm-5 col-sm-offset-1"> 
						<div class="form_contact">
							<h6>Kontakt formular</h6>
							<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate">
							<div class="form-group"> 
								<input type="text" class="form-control required" placeholder="Navn *" name="jform[contact_name]">
							</div>
							<div class="form-group"> 
								<input type="text" class="form-control required" placeholder="E-mail *" name="jform[contact_email]">
							</div>
							<div class="form-group"> 
								<input type="text" class="form-control required" placeholder="Telefon *"  name="jform[contact_phone]">
							</div>
							<div class="form-group"> 
								<textarea  rows="7" class="form-control required" placeholder="Besked *"  name="jform[contact_message]"></textarea>  
							</div>
							<p>Felter markeret med * skal udfyldes</p>
							<!--<a href="#" class="btn">SEND</a>-->
							<button class="btn btn-primary validate" type="submit">SEND</button>
							<input type="hidden" name="option" value="com_contact" />
							<input type="hidden" name="task" value="contact.submit" />
							<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
							<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
							<?php echo JHtml::_('form.token'); ?>
							</form>
						</div>
					</div> <!-- col-sm-6 --> 
				</div> <!-- row --> 
		</div><!--main-content -->
	</div><!--container-->
</section>
