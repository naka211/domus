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


?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_SUPPLIER_ID'); ?></th>
			<td><?php echo $this->item->supplier_id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_FIRST_NAME'); ?></th>
			<td><?php echo $this->item->first_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_LAST_NAME'); ?></th>
			<td><?php echo $this->item->last_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_HOUSE_ID'); ?></th>
			<td><?php echo $this->item->house_id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_INFORMATION'); ?></th>
			<td><?php echo $this->item->information; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_CHECKIN'); ?></th>
			<td><?php echo $this->item->checkin; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_CHECKOUT'); ?></th>
			<td><?php echo $this->item->checkout; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_TOTAL'); ?></th>
			<td><?php echo $this->item->total; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_BOOKING_DATE'); ?></th>
			<td><?php echo $this->item->booking_date; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_PAY_30'); ?></th>
			<td><?php echo $this->item->pay_30; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_PAY_ALL'); ?></th>
			<td><?php echo $this->item->pay_all; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_STATUS'); ?></th>
			<td><?php echo $this->item->status; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_NUMBER_OF_PERSONS'); ?></th>
			<td><?php echo $this->item->number_of_persons; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_ADDRESS'); ?></th>
			<td><?php echo $this->item->address; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_ZIP'); ?></th>
			<td><?php echo $this->item->zip; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_CITY'); ?></th>
			<td><?php echo $this->item->city; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_EMAIL'); ?></th>
			<td><?php echo $this->item->email; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_PHONE'); ?></th>
			<td><?php echo $this->item->phone; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKING_FORM_LBL_BOOKING_COMMENT'); ?></th>
			<td><?php echo $this->item->comment; ?></td>
</tr>

        </table>
    </div>
    
    <?php
else:
    echo JText::_('COM_BOOKING_ITEM_NOT_LOADED');
endif;
?>
