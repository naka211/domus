<?php
/**
 * @version     1.0.0
 * @package     com_booking
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Nguyen Thanh Trung <nttrung211@yahoo.com> - 
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Bookings list controller class.
 */
class BookingControllerOrder extends BookingController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Bookings', $prefix = 'BookingModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	
	function order(){
		$session =& JFactory::getSession();
		$session->set( 'all', $_POST );
		
		$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order', false));
	}
	
	function save_order(){
		$session = JFactory::getSession();
		$all = $session->get( 'all');
		$start_tmp = explode('-', $all['start_date']);
		$start_time = mktime(0, 0, 0, $start_tmp[1], $start_tmp[0], $start_tmp[2]);
		$end_tmp = explode('-', $all['end_date']);
		$end_time = mktime(0, 0, 0, $end_tmp[1], $end_tmp[0], $end_tmp[2]);
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$columns = array('supplier_id', 'first_name', 'last_name', 'house_id', 'information', 'checkin', 'checkout', 'total_da', 'total_eu', 'booking_date', 'status', 'number_of_persons', 'address', 'zip', 'city', 'email', 'phone','comment');
		$values = array(1, $db->quote(JRequest::getVar('first_name')), $db->quote(JRequest::getVar('last_name')), $all['id'], "'".$all['data']."'", $start_time, $end_time, $all['amountda'], $all['amounteu'], time(), 1, $db->quote(JRequest::getVar('person')), $db->quote(JRequest::getVar('address')), $db->quote(JRequest::getVar('zip')), $db->quote(JRequest::getVar('city')), $db->quote(JRequest::getVar('email')), $db->quote(JRequest::getVar('phone')), $db->quote(JRequest::getVar('comment')));
		$query -> insert($db->quoteName('#__booking'))
    		->columns($db->quoteName($columns))
    		->values(implode(',', $values));
		$db->setQuery($query);
		$db->execute();
		$order_id = $db->insertid();

		// Send email supplier
		$sent1 = $this->send_email_user($order_id, $all);
		if($sent1){
			$session->clear("all");
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=finish&order_id='.$order_id, false));
		} else {
			die('teo');
		}
		// End send email
		
	}
	
	function send_email_user($order_id, $all){
		$house = simplexml_load_string($all['data']);
		$start_tmp = explode('-', $all['start_date']);
		$start_time = mktime(0, 0, 0, $start_tmp[1], $start_tmp[0], $start_tmp[2]);
		$end_tmp = explode('-', $all['end_date']);
		$end_time = mktime(0, 0, 0, $end_tmp[1], $end_tmp[0], $end_tmp[2]);
		$number_of_days_time = $end_time - $start_time;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = "Dear ".JRequest::getVar('first_name')." ".JRequest::getVar('last_name').", <br/>
		We confirm that your booking request <strong>".sprintf('%05d',$order_id)."</strong> for the house <strong>".$house->name."</strong> from ".$all['start_date']." for ".$number_of_days." days, has been successfully sent to the owner.<br /><br />
		<strong>WE INFORM YOU THAT YOUR BOOKING WILL BE CONFIRMED ONLY WHEN WE RECEIVE THE BOOKING CONFIRMATION BY THE OWNER.</strong><br /><br />
		You will receive an answer within <strong>48 hours</strong>.<br /><hr><br />
		<strong>Booking Request Summary:</strong><br />
		•	Booking Number: ".sprintf('%05d',$order_id)."<br />
		•	House name: ".$house->name."<br />
		•	From: ".$all['start_date']." for ".$number_of_days." days<br />
		•	Number of people: ".JRequest::getVar('person')."<br />
		•	Total price: ".number_format($all['amountda'], 2, ',', '.')." DKK<br /><br />
		<strong>Client Details:</strong><br />
		Name: ".JRequest::getVar('first_name')." ".JRequest::getVar('last_name')."<br />
		Address: ".JRequest::getVar('address')."<br />
		Town: ".JRequest::getVar('city')."<br />
		Telephone: ".JRequest::getVar('phone')."<br />
		Email: ".JRequest::getVar('email')."<br /><hr><br />
		We remain at your disposal and we invite you to contact us at the number 41628001 or send us an email to info@domusholidays.com for any clarification.<br /><br />
		Thank you for choosing a DomusHolidays property for your holiday.<br /><br />
		Yours sincerely,<br />
		The DomusHolidays Team";
		$ok = $this->send_email($order_id, JRequest::getVar('email'), $body);
		
		return $ok;
	}
	
	function send_email_supplier($order_id, $all){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT email FROM #__supplier WHERE id = 1");
		$receiver = $db->loadResult();
		
		$this->send_email($order_id, $receiver, $body);
	}
	
	function send_email($order_id, $receiver, $body){
		$app = JFactory::getApplication();
		$mailfrom = $app->get('mailfrom');
		$fromname = $app->get('fromname');
			
		$mail = JFactory::getMailer();
		$mail->addRecipient($receiver);
		$mail->setSender(array($mailfrom, $fromname));
		$mail->setSubject('Booking Request '.sprintf('%05d',$order_id));
		$mail->isHTML(true);
		$mail->setBody($body);
		$sent = $mail->Send();
		return $sent;
	}
}