<?php
/**
 * @version     1.0.0
 * @package     com_booking
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Nguyen Thanh Trung <nttrung211@yahoo.com> - 
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_booking/assets/css/booking.css');

$db= JFactory::getDBO();
$db->setQuery("SELECT name FROM #__supplier WHERE id = ".$this->item->supplier_id);
$supplier = $db->loadResult();

$house = simplexml_load_string($this->item->information);
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'booking.cancel') {
            Joomla.submitform(task, document.getElementById('booking-form'));
        }
        else {
            
            if (task != 'booking.cancel' && document.formvalidator.isValid(document.id('booking-form'))) {
                
                Joomla.submitform(task, document.getElementById('booking-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_booking&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="booking-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_BOOKING_TITLE_BOOKING', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

            <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('supplier_id'); ?></div>
				<div class="controls"><?php echo $supplier; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('first_name'); ?></div>
				<div class="controls"><?php echo $this->item->first_name; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('last_name'); ?></div>
				<div class="controls"><?php echo $this->item->last_name; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('house_id'); ?></div>
				<div class="controls"><?php echo $this->item->house_id; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label">House name</div>
				<div class="controls"><?php echo $house->name; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('checkin'); ?></div>
				<div class="controls"><?php echo date("d-m-Y",$this->item->checkin); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('checkout'); ?></div>
				<div class="controls"><?php echo date("d-m-Y",$this->item->checkout); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label">Total euro</div>
				<div class="controls"><?php echo $this->item->total_eu; ?> EUR</div>
			</div>
			<div class="control-group">
				<div class="control-label">Total danish</div>
				<div class="controls"><?php echo number_format($this->item->total_da, 2, ',', '.'); ?> DKK</div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('booking_date'); ?></div>
				<div class="controls"><?php echo date("d-m-Y",$this->item->booking_date); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('status'); ?></div>
				<div class="controls"><?php if($this->item->status == 1) echo "Pending"; else if($this->item->status == 0) echo "Reject"; else if($this->item->status == 3) echo "Paid 30%"; else if($this->item->status == 4) echo "Paid 100%"; else if($this->item->status == 2) echo "Accepted"; else echo "Cancelled";?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('number_of_persons'); ?></div>
				<div class="controls"><?php echo $this->item->number_of_persons; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('address'); ?></div>
				<div class="controls"><?php echo $this->item->address; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('zip'); ?></div>
				<div class="controls"><?php echo $this->item->zip; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('city'); ?></div>
				<div class="controls"><?php echo $this->item->city; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('email'); ?></div>
				<div class="controls"><?php echo $this->item->email; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('phone'); ?></div>
				<div class="controls"><?php echo $this->item->phone; ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('comment'); ?></div>
				<div class="controls"><?php echo $this->item->comment; ?></div>
			</div>


                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>