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
		
		$db->setQuery("SELECT checkin, booking_date FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$number_of_days_time = $info->checkin - $info->booking_date;
		$number_of_days = ceil($number_of_days_time/(60*60*24));
		
		if($number_of_days <= 10){
			$sent = $this->send_email_user_all($order_id);
			if($sent){
				$db->setQuery("UPDATE #__booking SET send_email_payall_time = ".time()." WHERE id = ".$order_id);
				$db->query();
				$db->setQuery("UPDATE #__booking SET send_email_payall = 1 WHERE id = ".$order_id);
				$db->query();
			} else {
				die('Sending email error in payment all');
			}
		} else {
			$sent = $this->send_email_user_30($order_id);
			if($sent){
				$db->setQuery("UPDATE #__booking SET send_email_30_time = ".time()." WHERE id = ".$order_id);
				$db->query();
				$db->setQuery("UPDATE #__booking SET send_email_30 = 1 WHERE id = ".$order_id);
				$db->query();
			} else {
				die('Sending email error in payment 30%');
			}
		}
		
		
		$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=accept', false));
	}
	
	function send_email_user_30($order_id){
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
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
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
	
	function send_email_user_all($order_id){
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
		•	<strong>".number_format($info->total_da, 2, ',', '.')." DKK</strong>, to be paid within <strong>3</strong> days after receveing this email (".date('d-m-Y', strtotime("+3 day")).").<br>
		<strong>Remember, the payment is due within 3 days after the receipt of this email, on pain of cancellation.</strong><br><br>
		
		You can pay via Credit Card by clicking on the link below:<br>
		<a href='".JURI::base()."index.php?option=com_booking&task=order.pay_all&order_id=".$order_id."'>".JURI::base()."index.php?option=com_booking&task=order.pay_all&order_id=".$order_id."</a><br><br>
		
		(If the link doesn't work copy and paste the link to the address bar of your browser) <br><hr><br>
		We remain at your disposal and we invite you to contact us at the number 41628001 or send us an email to info@domusholidays.com for any clarification.<br>
		Thank you for choosing a Domus Holidays property for your holiday.<br><br>
		
		Yours sincerely,<br>
		The Domus Holidays Team
		";
		$ok = $this->send_email($order_id, $info->email, $body, "Booking payment for");
		return $ok;
	}
	
	function pay_30(){
		$order_id = JRequest::getVar('order_id');
		
		$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=payment30&order_id='.$order_id, false));
	}
	
	
	function complete_payment_30(){
		$order_id = JRequest::getVar('order_id');
		
		$db = JFactory::getDBO();
		$db->setQuery("UPDATE #__booking SET status = 3 WHERE id = ".$order_id);
		$db->query();
		$db->setQuery("UPDATE #__booking SET send_email_30 = 0 WHERE id = ".$order_id);
		$db->query();
		
		$sent1 = $this->send_email_user_pay30($order_id);
		$sent2 = $this->send_email_admin_pay30($order_id);
		
		if($sent1 && $sent2){
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=paymentfinish30&order_id='.$order_id, false));
		} else {
			die('Sending email error in completing payment 30%');
		}
	}
	
	function send_email_user_pay30($order_id){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = "Dear ".$info->first_name." ".$info->first_name.", <br /><br />
		
		Thank you for booking with Domus Holidays.<br>
		We confirm your Booking <strong>".sprintf('%05d',$order_id)."</strong> for the house <strong>".$house->name."</strong> from <strong>".date("d-m-Y", $info->checkin)."</strong> for <strong>".$number_of_days."</strong> days. <br><br>
		
		<strong>Paid 30%</strong>
		<hr><br>
		
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf('%05d',$order_id)."<br>
		House name: ".$house->name."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."<br><hr><br>
		
		We will send email to paid 70% within 10 days before you checkin<br><br>

		Yours sincerely,<br />
		The DomusHolidays Team
		";
		$ok = $this->send_email($order_id, $info->email, $body, "Booking paid 30%");
		return $ok;
	}
	
	function send_email_admin_pay30($order_id){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT email FROM #__users WHERE id = 116");
		$receiver = $db->loadResult();
		
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = "Dear Administrator, <br /><br />
		
		Booking Number <strong>".sprintf('%05d',$order_id)."</strong> is paid 30%<br />
		
		<hr><br>
		
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf('%05d',$order_id)."<br>
		House name: ".$house->name."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."<br><br>
		
		Yours sincerely,<br />
		The DomusHolidays Team
		";
		$ok = $this->send_email($order_id, $receiver, $body, "Booking paid 30%");
		return $ok;
	}
	
	function pay_all(){
		$order_id = JRequest::getVar('order_id');
		
		$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=paymentall&order_id='.$order_id, false));
	}
	
	function complete_payment_all(){
		$order_id = JRequest::getVar('order_id');
		
		$db = JFactory::getDBO();
		$db->setQuery("UPDATE #__booking SET status = 4 WHERE id = ".$order_id);
		$db->query();
		$db->setQuery("UPDATE #__booking SET send_email_payall = 0 WHERE id = ".$order_id);
		$db->query();
		
		$sent1 = $this->send_email_user_payall($order_id);
		$sent2 = $this->send_email_admin_payall($order_id);
		
		if($sent1 && $sent2){
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=paymentfinish&order_id='.$order_id, false));
		} else {
			die('Sending email error in completing order');
		}
	}
	
	function send_email_user_payall($order_id){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = "Dear ".$info->first_name." ".$info->first_name.", <br /><br />
		
		Thank you for booking with Domus Holidays.<br>
		We confirm your Booking <strong>".sprintf('%05d',$order_id)."</strong> for the house <strong>".$house->name."</strong> from <strong>".date("d-m-Y", $info->checkin)."</strong> for <strong>".$number_of_days."</strong> days. <br><br>
		
		<strong>Paid 100%</strong>
		<hr><br>
		
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf('%05d',$order_id)."<br>
		House name: ".$house->name."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."<br><br>

		Yours sincerely,<br />
		The DomusHolidays Team
		";
		$ok = $this->send_email($order_id, $info->email, $body, "Booking finish");
		return $ok;
	}
	
	function send_email_admin_payall($order_id){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT email FROM #__users WHERE id = 116");
		$receiver = $db->loadResult();
		
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = "Dear Administrator, <br /><br />
		
		Booking Number <strong>".sprintf('%05d',$order_id)."</strong> is paid 100%<br />
		
		<hr><br>
		
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf('%05d',$order_id)."<br>
		House name: ".$house->name."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."<br><br>
		
		Yours sincerely,<br />
		The DomusHolidays Team
		";
		$ok = $this->send_email($order_id, $receiver, $body, "Booking finish");
		return $ok;
	}
	
	function cancel_payment(){
		$order_id = JRequest::getVar('order_id');
		
		$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=paymentcancel&order_id='.$order_id, false));
	}
	
	function check_payment_30(){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT id, send_email_30_time FROM #__booking WHERE send_email_30 = 1");
		$orders_30 = $db->loadObjectList();
		
		foreach($orders_30 as $order){
			$number_of_days_time = time() - $order->send_email_30_time;
			$number_of_days = ceil($number_of_days_time/(60*60*24));
			
			if($number_of_days == 9){
				$order_id = $order->id;
				
				$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
				$info = $db->loadObject();
				
				$house = simplexml_load_string($info->information);
				
				$number_of_days_time = $info->checkout - $info->checkin;
				$number_of_days = floor($number_of_days_time/(60*60*24));
				
				$body = "Dear ".$info->first_name." ".$info->first_name.", <br /><br />
				
				Booking Number <strong>".sprintf('%05d',$order_id)."</strong> is cancelled.<br />
				Because your order is not paid on time.<br />
				<hr><br>
			
				<strong>Booking Summary:</strong> <br>
				Booking Number: ".sprintf('%05d',$order_id)."<br>
				House name: ".$house->name."<br>
				From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
				Number of people: ".$info->number_of_persons."<br>
				Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
				
				<strong>Client Details:</strong><br>
				Name: ".$info->first_name." ".$info->last_name."<br>
				Address: ".$info->address."<br>
				Town: ".$info->city."<br>
				Telephone: ".$info->phone."<br>
				Email: ".$info->email."<br><br>
		
				Yours sincerely,<br />
				The DomusHolidays Team
				";
				$ok1 = $this->send_email($order_id, $info->email, $body, "Booking cancelled");
				
				
				$db->setQuery("SELECT email FROM #__supplier WHERE id = 1");
				$supplier_email = $db->loadResult();
				
				$body = "Dear Vacavilla, <br /><br />
				
				Booking Number <strong>".sprintf('%05d',$order_id)."</strong> is cancelled.<br />
				Because this order is not paid on time.<br />
				
				<hr><br>
			
				<strong>Booking Summary:</strong> <br>
				Booking Number: ".sprintf('%05d',$order_id)."<br>
				House name: ".$house->name."<br>
				From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
				Number of people: ".$info->number_of_persons."<br>
				Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
				
				<strong>Client Details:</strong><br>
				Name: ".$info->first_name." ".$info->last_name."<br>
				Address: ".$info->address."<br>
				Town: ".$info->city."<br>
				Telephone: ".$info->phone."<br>
				Email: ".$info->email."<br><br>
				
				Yours sincerely,<br />
				The DomusHolidays Team
				";
				$ok2 = $this->send_email($order_id, $supplier_email, $body, "Booking cancelled");
				if($ok1&&$ok2){
					$db->setQuery("UPDATE #__booking SET status = 5 WHERE id = ".$order_id);
					$db->query();
					$db->setQuery("UPDATE #__booking SET send_email_30 = 0 WHERE id = ".$order_id);
					$db->query();
				} else {
					die("Sending email error in checking payment 30%");
				}
			}
		}
	}
	
	function check_payment_all(){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT id, send_email_payall_time FROM #__booking WHERE send_email_payall = 1");
		$orders_all = $db->loadObjectList();
		
		foreach($orders_all as $order){
			$number_of_days_time = time() - $order->send_email_payall_time;
			$number_of_days = ceil($number_of_days_time/(60*60*24));
			
			if($number_of_days == 4){
				$order_id = $order->id;
				
				$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
				$info = $db->loadObject();
				
				$house = simplexml_load_string($info->information);
				
				$number_of_days_time = $info->checkout - $info->checkin;
				$number_of_days = floor($number_of_days_time/(60*60*24));
				
				$body = "Dear ".$info->first_name." ".$info->first_name.", <br /><br />
				
				Booking Number <strong>".sprintf('%05d',$order_id)."</strong> is cancelled.<br />
				Because your order is not paid on time.<br />
				<hr><br>
			
				<strong>Booking Summary:</strong> <br>
				Booking Number: ".sprintf('%05d',$order_id)."<br>
				House name: ".$house->name."<br>
				From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
				Number of people: ".$info->number_of_persons."<br>
				Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
				
				<strong>Client Details:</strong><br>
				Name: ".$info->first_name." ".$info->last_name."<br>
				Address: ".$info->address."<br>
				Town: ".$info->city."<br>
				Telephone: ".$info->phone."<br>
				Email: ".$info->email."<br><br>
		
				Yours sincerely,<br />
				The DomusHolidays Team
				";
				$ok1 = $this->send_email($order_id, $info->email, $body, "Booking cancelled");
				
				
				$db->setQuery("SELECT email FROM #__supplier WHERE id = 1");
				$supplier_email = $db->loadResult();
				
				$body = "Dear Vacavilla, <br /><br />
				
				Booking Number <strong>".sprintf('%05d',$order_id)."</strong> is cancelled.<br />
				Because this order is not paid on time.<br />
				
				<hr><br>
			
				<strong>Booking Summary:</strong> <br>
				Booking Number: ".sprintf('%05d',$order_id)."<br>
				House name: ".$house->name."<br>
				From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
				Number of people: ".$info->number_of_persons."<br>
				Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
				
				<strong>Client Details:</strong><br>
				Name: ".$info->first_name." ".$info->last_name."<br>
				Address: ".$info->address."<br>
				Town: ".$info->city."<br>
				Telephone: ".$info->phone."<br>
				Email: ".$info->email."<br><br>
				
				Yours sincerely,<br />
				The DomusHolidays Team
				";
				$ok2 = $this->send_email($order_id, $supplier_email, $body, "Booking cancelled");
				if($ok1&&$ok2){
					$db->setQuery("UPDATE #__booking SET status = 5 WHERE id = ".$order_id);
					$db->query();
					$db->setQuery("UPDATE #__booking SET send_email_payall = 0 WHERE id = ".$order_id);
					$db->query();
				} else {
					die("Sending email error in checking payment all");
				}
			}
		}
	}
	
	function check_and_send_pay70(){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT id, checkin FROM #__booking WHERE status = 3");
		$orders = $db->loadObjectList();
		
		foreach($orders as $order){
			$number_of_days_time = $order->checkin - time();
			$number_of_days = ceil($number_of_days_time/(60*60*24));
			
			if($number_of_days == 10){
				$ok = $this->send_email_user_70($order->id);
			}
		}
	}
	
	function send_email_user_70($order_id){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$db->setQuery("UPDATE #__booking SET send_email_payall_time = ".time()." WHERE id = ".$order_id);
		$db->query();
		
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
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."<br><hr><br>
		
		<strong>Payment:</strong><br>
		•	Balance: <strong>".number_format($info->total_da*0.7, 2, ',', '.')." DKK</strong>, to be paid within <strong>3</strong> days after receveing this email (".date('d-m-Y', strtotime("+3 day")).").<br>
		<strong>Remember, the payment is due within 3 days after the receipt of this email, on pain of cancellation.</strong><br><br>
		
		You can pay via Credit Card by clicking on the link below:<br>
		<a href='".JURI::base()."index.php?option=com_booking&task=order.pay_70&order_id=".$order_id."'>".JURI::base()."index.php?option=com_booking&task=order.pay_70&order_id=".$order_id."</a><br><br>
		
		(If the link doesn't work copy and paste the link to the address bar of your browser) <br><hr><br>
		We remain at your disposal and we invite you to contact us at the number 41628001 or send us an email to info@domusholidays.com for any clarification.<br>
		Thank you for choosing a Domus Holidays property for your holiday.<br><br>
		
		Yours sincerely,<br>
		The Domus Holidays Team
		";
		$ok = $this->send_email($order_id, $info->email, $body, "Booking payment 70% for");
		return $ok;
	}
	
	function pay_70(){
		$order_id = JRequest::getVar('order_id');
		$db = JFactory::getDBO();
		$db->setQuery("SELECT status FROM #__booking WHERE id = ".$order_id);
		$status = $db->loadResult();
		if($status == 3){
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=payment70&order_id='.$order_id, false));
		} else {
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=payment70fail&order_id='.$order_id, false));
		}
		
		
	}
	
	function complete_payment_70(){
		$order_id = JRequest::getVar('order_id');
		
		$db = JFactory::getDBO();
		$db->setQuery("UPDATE #__booking SET status = 4 WHERE id = ".$order_id);
		$db->query();
		$db->setQuery("UPDATE #__booking SET send_email_payall = 0 WHERE id = ".$order_id);
		$db->query();
		
		$sent1 = $this->send_email_user_payall($order_id);
		$sent2 = $this->send_email_admin_payall($order_id);
		
		if($sent1 && $sent2){
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=paymentfinish&order_id='.$order_id, false));
		} else {
			die('Sending email error in completing payment 70%');
		}
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