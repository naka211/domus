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
		$number_of_days_time = $end_time - $start_time;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
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
		
		// Send email
		$sent1 = $this->send_email_user($order_id, $all, $number_of_days);
		$sent2 = $this->send_email_supplier($order_id, $all, $number_of_days);
		if($sent1 && $sent2){
			$session->clear("all");
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=finish&order_id='.$order_id, false));
		} else {
			die("Sending email error in save order");
		}
		// End send email
		
	}
	
	function send_email_user($order_id, $all, $number_of_days){
		$house = simplexml_load_string($all['data']);
		
		
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
		$ok = $this->send_email($order_id, JRequest::getVar('email'), $body, "Booking request");
		
		return $ok;
	}
	
	function send_email_supplier($order_id, $all, $number_of_days){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT email FROM #__supplier WHERE id = 1");
		$receiver = $db->loadResult();
		
		$house = simplexml_load_string($all['data']);
		
		$body = "Dear Vacavilla, <br /><br />
		<strong>Booking Request Summary:</strong><br />
		•	Booking Number: ".sprintf('%05d',$order_id)."<br />
		•	House name: ".$house->name."<br />
		•	From: ".$all['start_date']." for ".$number_of_days." days<br />
		•	Number of people: ".JRequest::getVar('person')."<br /><hr><br />
		
		Please check link below to accept or reject:<br />
		- <a href='".JURI::base()."index.php?option=com_booking&task=order.accept_order&order_id=".$order_id."'>Accept</a><br />
		- <a href='".JURI::base()."index.php?option=com_booking&task=order.reject_order&order_id=".$order_id."'>Reject</a><br /><br />
		Yours sincerely,<br />
		The DomusHolidays Team
		";
		
		$ok = $this->send_email($order_id, $receiver, $body, "Booking request");
		return $ok;
	}
	
	function reject_order(){
		$order_id = JRequest::getVar('order_id');
		
		$db = JFactory::getDBO();
		$db->setQuery("UPDATE #__booking SET status = 0 WHERE id = ".$order_id);
		$db->query();
		
		$sent1 = $this->send_email_user_reject($order_id);
		$sent2 = $this->send_email_admin_reject($order_id);
		
		if($sent1 && $sent2){
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=reject', false));
		} else {
			die('Sending email error in rejecting order');
		}
	}
	
	function send_email_user_reject($order_id){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$body = "Dear ".$info->first_name." ".$info->first_name.", <br /><br />
		
		Booking Number <strong>".sprintf('%05d',$order_id)."</strong> is rejected.<br />
		Because your chosen house is not available in that time.<br /><br />

		Yours sincerely,<br />
		The DomusHolidays Team
		";
		$ok = $this->send_email($order_id, $info->email, $body, "Booking reject");
		return $ok;
	}
	
	function send_email_admin_reject($order_id){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT email FROM #__users WHERE id = 116");
		$receiver = $db->loadResult();
		
		$body = "Dear Administrator, <br /><br />
		
		Booking Number <strong>".sprintf('%05d',$order_id)."</strong> is rejected by Vacavilla<br />
		Because the customer's chosen house is not available in that time.<br /><br />
		
		Yours sincerely,<br />
		The DomusHolidays Team
		";
		$ok = $this->send_email($order_id, $receiver, $body, "Booking reject");
		return $ok;
	}
	
	function accept_order(){
		$order_id = JRequest::getVar('order_id');
		
		$db = JFactory::getDBO();
		$db->setQuery("UPDATE #__booking SET status = 2 WHERE id = ".$order_id);
		$db->query();
		
		$sent = $this->send_email_user_accept($order_id);
		
		if($sent){
			$db->setQuery("UPDATE #__booking SET send_email_30_time = ".time()." WHERE id = ".$order_id);
			$db->query();
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=accept', false));
		} else {
			die('Sending email error');
		}
	}
	
	function send_email_user_accept($order_id){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = "Dear ".$info->first_name." ".$info->first_name.", <br /><br />
		
		Thank you for booking with Domus Holidays.<br>
		We confirm your Booking <strong>".sprintf('%05d',$order_id)."</strong> for the house <strong>".$house->name."</strong> from <strong>".date("d-m-Y", $info->checkin)."</strong> for <strong>".$number_of_days."</strong> days. <br><hr><br>
		
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf('%05d',$order_id)."<br>
		House name: ".$house->name."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_person."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->first_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."<br><hr><br>
		
		<strong>Payment:</strong><br>
		•	Advance: <strong>".number_format($info->total_da*0.3, 2, ',', '.')." DKK</strong>, to be paid within <strong>8</strong> days after receveing this email (".date('d-m-Y', strtotime("+8 day")).").<br>
		•	Balance: <strong>".number_format($info->total_da*0.7, 2, ',', '.')." DKK</strong>, to be paid within <strong>7-10</strong> days before you check-in.<br>
		<strong>Remember, the Advance payment is due within 8 days after the receipt of this email, on pain of cancellation.</strong><br><br>
		
		You can pay via Credit Card by clicking on the link below:<br>
		<a href='".JURI::base()."index.php?option=com_booking&task=order.pay_30&order_id=".$order_id."'>".JURI::base()."index.php?option=com_booking&task=order.pay_30&order_id=".$order_id."</a><br><br>
		
		(If the link doesn't work copy and paste the link to the address bar of your browser) <br><hr><br>
		We remain at your disposal and we invite you to contact us at the number 41628001 or send us an email to info@domusholidays.com for any clarification.<br>
		Thank you for choosing a Domus Holidays property for your holiday.<br><br>
		
		Yours sincerely,<br>
		The Domus Holidays Team
		";
		$ok = $this->send_email($order_id, $info->email, $body, "Booking payment 30% for");
		return $ok;
	}
	
	function pay_30(){
		$order_id = JRequest::getVar('order_id');
		die("Payment gateway is installing.");
	}
	
	function send_email($order_id, $receiver, $body, $subject){
		$app = JFactory::getApplication();
		$mailfrom = $app->get('mailfrom');
		$fromname = $app->get('fromname');
			
		$mail = JFactory::getMailer();
		$mail->addRecipient($receiver);
		$mail->setSender(array($mailfrom, $fromname));
		$mail->setSubject($subject.' '.sprintf('%05d',$order_id));
		$mail->isHTML(true);
		$mail->setBody($body);
		$sent = $mail->Send();
		return $sent;
	}
}