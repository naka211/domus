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
	 //real
	/*public $check_30_days = 9; // 9 days after booking
	public $check_70_days = 10; // 10 days before check in
	public $check_all_days = 3; // 3 days before check in
	public $payment_all_days = 10; // 10 days before check in*/
	
	//test
	public $check_30_days = 1; // 1 days after booking
	public $check_70_days = 2; // 2 days before check in
	public $check_all_days = 1; // 1 days before check in
	public $payment_all_days = 2; // 2 days before check in
	
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
	
	function order1(){
		$session =& JFactory::getSession();
		$session->set( 'all', $_POST );
		
		$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order1', false));
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
		$values = array(JRequest::getVar('supplier'), 
			$db->quote(JRequest::getVar('first_name')), 
			$db->quote(JRequest::getVar('last_name')), 
			"'".$all['id']." - ".$all['house_name']."'", 
			"'".$all['data']."'", 
			$start_time, 
			$end_time, 
			$all['amountda'], 
			$all['amounteu'], 
			time(), 
			1, 
			$db->quote(JRequest::getVar('person')), 
			$db->quote(JRequest::getVar('address')), 
			$db->quote(JRequest::getVar('zip')), 
			$db->quote(JRequest::getVar('city')), 
			$db->quote(JRequest::getVar('email')), 
			$db->quote(JRequest::getVar('phone')), 
			$db->quote(JRequest::getVar('comment')));
		$query -> insert($db->quoteName('#__booking'))
    		->columns($db->quoteName($columns))
    		->values(implode(',', $values));
		$db->setQuery($query);
		$db->execute();
		$order_id = $db->insertid();
		
		// Send email
		$sent1 = $this->send_email_user($order_id, $all, $number_of_days, JRequest::getVar('supplier'));
		$sent2 = $this->send_email_supplier(JRequest::getVar('supplier'), $order_id, $all, $number_of_days);
		if($sent1 && $sent2){
			$session->clear("all");
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=finish&order_id='.$order_id, false));
		} else {
			die("Sending email error in save order");
		}
		// End send email
		
	}
	
	function send_email_user($order_id, $all, $number_of_days, $supplier_id){
		$house = simplexml_load_string($all['data']);
		
		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= '<div class="box">
            	<p>Dear '.JRequest::getVar('first_name')." ".JRequest::getVar('last_name').',<br>
                We confirm that your booking request <strong>'.sprintf($supplier_id.'%04d',$order_id).'</strong> for the house <strong>'.$all['house_name'].'</strong> from '.$all['start_date'].' for '.$number_of_days.' days, has been successfully sent to the owner.<br /><br />
                <strong>WE INFORM YOU THAT YOUR BOOKING WILL BE CONFIRMED ONLY WHEN WE RECEIVE THE BOOKING CONFIRMATION BY THE OWNER.</strong><br /><br />
                You will receive an answer within <strong>48 hours</strong>.
                </p>
    			</div>
				<div class="box"><p>
				<strong>Booking Request Summary:</strong><br />
				•	Booking Number: '.sprintf('%05d',$order_id).'<br />
				•	House name: '.$all['id'].' - '.$all['house_name'].'<br />
				•	From: '.$all['start_date'].' for '.$number_of_days.' days<br />
				•	Number of people: '.JRequest::getVar('person').'<br />
				•	Total price: '.number_format($all['amountda'], 2, ',', '.').' DKK<br /><br />
				<strong>Client Details:</strong><br />
				Name: '.JRequest::getVar('first_name').' '.JRequest::getVar('last_name').'<br />
				Address: '.JRequest::getVar('address').'<br />
				Town: '.JRequest::getVar('city').'<br />
				Telephone: '.JRequest::getVar('phone').'<br />
				Email: '.JRequest::getVar('email').'<br /><br />
				We remain at your disposal and we invite you to contact us at the number 41628001 or send us an email to info@domusholidays.com for any clarification.<br /><br />
				Thank you for choosing a DomusHolidays property for your holiday.<br /><br />
				</p></div>
    			';
		$body .= $this->getFooterEmail();
		
		$ok = $this->send_email($order_id, JRequest::getVar('email'), $body, "Booking request", $supplier_id);
		
		return $ok;
	}
	
	function send_email_supplier($supplier_id, $order_id, $all, $number_of_days){
		$db = JFactory::getDBO();
		$db->setQuery("SELECT email, name FROM #__supplier WHERE id = ".$supplier_id);
		$receiver = $db->loadObject();
		
		$house = simplexml_load_string($all['data']);
		
		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= "<div class='box'><p>
            	Dear ".$receiver->name.", <br /><br />
		<strong>Booking Request Summary:</strong><br />
		•	Booking Number: ".sprintf($supplier_id.'%04d',$order_id)."<br />
		•	House name: ".$all['id']." - ".$all['house_name']."<br />
		•	From: ".$all['start_date']." for ".$number_of_days." days<br />
		•	Number of people: ".JRequest::getVar('person')."<br />
		•	Total price: ".number_format($all['amountda'], 2, ',', '.')." DKK
		</p>
		<p>
		<strong>Client Details:</strong><br />
			Name: ".JRequest::getVar('first_name')." ".JRequest::getVar('last_name')."<br />
			Address: ".JRequest::getVar('address')."<br />
			Town: ".JRequest::getVar('city')."<br />
		</p>
		</div>
		<div class='box'><p>
		Please click the button below to accept or reject within 24 hours:<br />
		<a href='".JURI::base()."index.php?option=com_booking&task=order.accept_order&order_id=".$order_id."&supplier_id=".$supplier_id."'><img src='".JURI::base()."images/btn_accept.png'></a><br />
		<a href='".JURI::base()."index.php?option=com_booking&task=order.reject_order&order_id=".$order_id."&supplier_id=".$supplier_id."'><img src='".JURI::base()."images/btn_reject.png'></a><br /><br />
		</p>
		</div>
		";
		$body .= $this->getFooterEmail();
		
		$ok = $this->send_email($order_id, $receiver->email, $body, "Booking request", $supplier_id);
		return $ok;
	}
	
	function reject_order(){
		$order_id = JRequest::getVar('order_id');
		$supplier_id = JRequest::getVar('supplier_id');
		
		$db = JFactory::getDBO();
		$db->setQuery("UPDATE #__booking SET status = 0 WHERE id = ".$order_id);
		$db->query();
		
		$sent1 = $this->send_email_user_reject($order_id, $supplier_id);
		$sent2 = $this->send_email_admin_reject($order_id, $supplier_id);
		
		if($sent1 && $sent2){
			$this->setRedirect(JRoute::_('index.php?option=com_booking&view=order&layout=reject', false));
		} else {
			die('Sending email error in rejecting order');
		}
	}
	
	function send_email_user_reject($order_id, $supplier_id){
		if(empty($order_id)){
			$order_id = JRequest::getVar('order_id');
			$supplier_id = JRequest::getVar('supplier_id');
		}
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= '<div class="box">
            	<p>Dear '.$info->first_name.' '.$info->last_name.',
                <br>
                <br> Booking Number <strong>'.sprintf($supplier_id.'%04d',$order_id).'</strong> is rejected.
                <br> Because your chosen house is not available in that time.
                <br>Please search again: http://www.domusholidays.com</p>
    			</div>';
		$body .= $this->getFooterEmail();
		
		$ok = $this->send_email($order_id, $info->email, $body, "Booking reject", $supplier_id);
		return $ok;
	}
	
	function send_email_admin_reject($order_id, $supplier_id){
		if(empty($order_id)){
			$order_id = JRequest::getVar('order_id');
			$supplier_id = JRequest::getVar('supplier_id');
		}
		$db = JFactory::getDBO();
		$db->setQuery("SELECT email FROM #__users WHERE id = 116");
		$receiver = $db->loadResult();

		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= '<div class="box">
            	<p>Dear Administrator,
                <br>
                <br> Booking Number <strong>'.sprintf($supplier_id.'%04d',$order_id).'</strong> is rejected by Vacavilla.
                <br> Because the customer\'s chosen house is not available in that time.</p>
    			</div>';
		$body .= $this->getFooterEmail();
		
		$ok = $this->send_email($order_id, $receiver, $body, "Booking reject", $supplier_id);
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
		
		if($number_of_days <= $this->payment_all_days){
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
		if(empty($order_id)){
			$order_id = JRequest::getVar('order_id');
		}
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= "<div class='box'><p>Dear ".$info->first_name." ".$info->last_name.", <br /><br />
		
		Thank you for booking with Domus Holidays.<br>
		We confirm your Booking <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> for the house <strong>".$info->house_id."</strong> from <strong>".date("d-m-Y", $info->checkin)."</strong> for <strong>".$number_of_days."</strong> days. </p></div>

		<div class='box'><p>
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
		House name: ".$info->house_id."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>

		•	Deposit: <strong>".number_format($info->total_da*0.3, 2, ',', '.')." DKK</strong>, to be paid within <strong>8</strong> days after receveing this email (".date('d-m-Y', strtotime("+8 day")).").(To pay)<br>
		•	Balance: <strong>".number_format($info->total_da*0.7, 2, ',', '.')." DKK</strong>, to be paid within <strong>7-10</strong> days before you check-in.(Remain to pay)<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."
		</p></div>

		<div class='box'><p>
		<strong>Remember, the Deposit payment is due within 8 days after the receipt of this email, on pain of cancellation.</strong><br><br>
		
		You can pay with all major credit cards by clicking on the button below:<br>
		<a href='".JURI::base()."index.php?option=com_booking&task=order.pay_30&order_id=".$order_id."'><img src='".JURI::base()."images/click_to_pay.png'></a><br><br>
		
		(If the link doesn't work copy and paste the link to the address bar of your browser) <br><hr><br>
		We remain at your disposal and we invite you to contact us at the number 41628001 or send us an email to info@domusholidays.com for any clarification.<br>
		Thank you for choosing a Domus Holidays property for your holiday.
		</p></div>
		";
		$body .= $this->getFooterEmail();
		
		$ok = $this->send_email($order_id, $info->email, $body, "Booking payment 30% for bookingnumber", $info->supplier_id);
		return $ok;
	}
	
	function send_email_user_all($order_id){
		if(empty($order_id)){
			$order_id = JRequest::getVar('order_id');
		}
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= "<div class='box'><p>Dear ".$info->first_name." ".$info->last_name.", <br /><br />
		
		Thank you for booking with Domus Holidays.<br>
		We confirm your Booking <strong>".sprintf($info->supplier_id.'%05d',$order_id)."</strong> for the house <strong>".$info->house_id."</strong> from <strong>".date("d-m-Y", $info->checkin)."</strong> for <strong>".$number_of_days."</strong> days. </p></div>
		
		<div class='box'><p>
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf('%05d',$order_id)."<br>
		House name: ".$info->house_id."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_person."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>

		•	<strong>".number_format($info->total_da, 2, ',', '.')." DKK</strong>, to be paid within <strong>3</strong> days after receveing this email (".date('d-m-Y', strtotime("+3 day")).").(To pay)<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."
		</p></div>
		
		<div class='box'><p>
		<strong>Remember, the payment is due within 3 days after the receipt of this email, on pain of cancellation.</strong><br><br>
		
		You can pay via Credit Card by clicking on the link below:<br>
		<a href='".JURI::base()."index.php?option=com_booking&task=order.pay_all&order_id=".$order_id."'><img src='".JURI::base()."images/click_to_pay.png'></a><br><br>
		
		(If the link doesn't work copy and paste the link to the address bar of your browser) <br><hr><br>
		We remain at your disposal and we invite you to contact us at the number 41628001 or send us an email to info@domusholidays.com for any clarification.<br>
		Thank you for choosing a Domus Holidays property for your holiday.
		</p></div>
		";
		$body .= $this->getFooterEmail();

		$ok = $this->send_email($order_id, $info->email, $body, "Booking payment 100 % for bookingnumber", $info->supplier_id);
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
		if(empty($order_id)){
			$order_id = JRequest::getVar('order_id');
		}
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= "<div class='box'><p>Dear ".$info->first_name." ".$info->last_name.", <br /><br />
		
		Thank you for booking with Domus Holidays.<br>
		We confirm your Booking <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> for the house <strong>".$info->house_id."</strong> from <strong>".date("d-m-Y", $info->checkin)."</strong> for <strong>".$number_of_days."</strong> days.
		</p></div>
		
		<div class='box'><p>
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
		House name: ".$info->house_id."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>

		•	Deposit: <strong>".number_format($info->total_da*0.3, 2, ',', '.')." DKK</strong> (Paid)<br>
		•	Balance: <strong>".number_format($info->total_da*0.7, 2, ',', '.')." DKK</strong> (Remain to pay)<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."<br><br>
		
		<strong>We will send email to paid 70% within 7-10 days before you checkin</strong></p></div>";
		$body .= $this->getFooterEmail();
		
		$ok = $this->send_email($order_id, $info->email, $body, "Invoice confirmation 30 % for bookingnumber", $info->supplier_id);
		return $ok;
	}
	
	function send_email_admin_pay30($order_id){
		if(empty($order_id)){
			$order_id = JRequest::getVar('order_id');
		}
		$db = JFactory::getDBO();
		$db->setQuery("SELECT email FROM #__users WHERE id = 116");
		$receiver = $db->loadResult();
		
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= "<div class='box'><p>Dear Administrator, <br /><br />
		
		Booking Number <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> is paid 30%<br />
		
		</p></div>
		
		<div class='box'><p>
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
		House name: ".$info->house_id."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>

		•	Deposit: <strong>".number_format($info->total_da*0.3, 2, ',', '.')." DKK</strong> (Paid)<br>
		•	Balance: <strong>".number_format($info->total_da*0.7, 2, ',', '.')." DKK</strong> (Remain to pay)<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."
		</p></div>
		";
		$body .= $this->getFooterEmail();
		
		$ok = $this->send_email($order_id, $receiver, $body, "Invoice confirmation 30 % for bookingnumber", $info->supplier_id);
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
		if(empty($order_id)){
			$order_id = JRequest::getVar('order_id');
		}
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		

		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= "<div class='box'><p>Dear ".$info->first_name." ".$info->last_name.", <br /><br />
		
		Thank you for booking with Domus Holidays.<br>
		We confirm your Booking <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> for the house <strong>".$info->house_id."</strong> from <strong>".date("d-m-Y", $info->checkin)."</strong> for <strong>".$number_of_days."</strong> days.
		</p></div>
		
		<div class='box'><p>
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
		House name: ".$info->house_id."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>

		•	<strong>".number_format($info->total_da, 2, ',', '.')." DKK</strong>(Paid)<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."</p></div>
		";
		$body .= $this->getFooterEmail();
		
		$ok = $this->send_email($order_id, $info->email, $body, "Invoice confirmation full payment 100 % for bookingnumber", $info->supplier_id);
		return $ok;
	}
	
	function send_email_admin_payall($order_id){
		if(empty($order_id)){
			$order_id = JRequest::getVar('order_id');
		}
		$db = JFactory::getDBO();
		$db->setQuery("SELECT email FROM #__users WHERE id = 116");
		$receiver = $db->loadResult();
		
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= "<div class='box'><p>Dear Administrator, <br /><br />
		
		Booking Number <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> is paid 100%</p></div>
		
		<div class='box'><p>
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
		House name: ".$info->house_id."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>

		•	<strong>".number_format($info->total_da, 2, ',', '.')." DKK</strong>(Paid)<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."</p></div>
		";
		$body .= $this->getFooterEmail();

		$ok = $this->send_email($order_id, $receiver, $body, "Invoice confirmation full payment 100 % for bookingnumber", $info->supplier_id);
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
			
			if($number_of_days >= $this->check_30_days){
				$order_id = $order->id;
				
				$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
				$info = $db->loadObject();
				
				$house = simplexml_load_string($info->information);
				
				$number_of_days_time = $info->checkout - $info->checkin;
				$number_of_days = floor($number_of_days_time/(60*60*24));
				
				$body = '';
				$body .= $this->getHeaderEmail();
				$body .= "<div class='box'><p>Dear ".$info->first_name." ".$info->last_name.", <br /><br />
				
				Booking Number <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> is cancelled.<br />
				Because your order is not paid on time.
				</p></div>
			
				<div class='box'><p>
				<strong>Booking Summary:</strong> <br>
				Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
				House name: ".$info->house_id."<br>
				From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
				Number of people: ".$info->number_of_persons."<br>
				Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
				
				<strong>Client Details:</strong><br>
				Name: ".$info->first_name." ".$info->last_name."<br>
				Address: ".$info->address."<br>
				Town: ".$info->city."<br>
				Telephone: ".$info->phone."<br>
				Email: ".$info->email."</p></div>
				";
				$body .= $this->getFooterEmail();
				$ok1 = $this->send_email($order_id, $info->email, $body, "Booking cancelled", $info->supplier_id);
				
				
				$db->setQuery("SELECT email, name FROM #__supplier WHERE id = ".$info->supplier_id);
				$supplier = $db->loadObject();

				
				$body = '';
				$body .= $this->getHeaderEmail();
				$body .= "<div class='box'><p>Dear ".$supplier->name.", <br /><br />
				
				Booking Number <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> is cancelled.<br />
				Because this order is not paid on time.
				</p></div>
			
				<div class='box'><p>
				<strong>Booking Summary:</strong> <br>
				Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
				House name: ".$info->house_id."<br>
				From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
				Number of people: ".$info->number_of_persons."<br>
				Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
				
				<strong>Client Details:</strong><br>
				Name: ".$info->first_name." ".$info->last_name."<br>
				Address: ".$info->address."<br>
				Town: ".$info->city."<br>
				Telephone: ".$info->phone."<br>
				Email: ".$info->email."</p></div>
				";
				$body .= $this->getFooterEmail();

				$ok2 = $this->send_email($order_id, $supplier->email, $body, "Booking cancelled", $info->supplier_id);
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
			
			if($number_of_days == $this->check_all_days){
				$order_id = $order->id;
				
				$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
				$info = $db->loadObject();
				
				$house = simplexml_load_string($info->information);
				
				$number_of_days_time = $info->checkout - $info->checkin;
				$number_of_days = floor($number_of_days_time/(60*60*24));
				
				$body = '';
				$body .= $this->getHeaderEmail();
				$body .= "<div class='box'><p>Dear ".$info->first_name." ".$info->last_name.", <br /><br />
				
				Booking Number <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> is cancelled.<br />
				Because your order is not paid on time.
				</p></div>
				
				<div class='box'><p>
				<strong>Booking Summary:</strong> <br>
				Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
				House name: ".$info->house_id."<br>
				From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
				Number of people: ".$info->number_of_persons."<br>
				Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
				
				<strong>Client Details:</strong><br>
				Name: ".$info->first_name." ".$info->last_name."<br>
				Address: ".$info->address."<br>
				Town: ".$info->city."<br>
				Telephone: ".$info->phone."<br>
				Email: ".$info->email."</p></div>
				";
				$body .= $this->getFooterEmail();
				$ok1 = $this->send_email($order_id, $info->email, $body, "Booking cancelled", $info->supplier_id);
				
				
				$db->setQuery("SELECT email, name FROM #__supplier WHERE id = ".$info->supplier_id);
				$supplier = $db->loadObject();
				
				$body = '';
				$body .= $this->getHeaderEmail();
				$body .= "<div class='box'><p>Dear ".$supplier->name.", <br /><br />
				
				Booking Number <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> is cancelled.<br />
				Because this order is not paid on time.
				</p></div>
			
				<div class='box'><p>
				<strong>Booking Summary:</strong> <br>
				Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
				House name: ".$info->house_id."<br>
				From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
				Number of people: ".$info->number_of_persons."<br>
				Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>
				
				<strong>Client Details:</strong><br>
				Name: ".$info->first_name." ".$info->last_name."<br>
				Address: ".$info->address."<br>
				Town: ".$info->city."<br>
				Telephone: ".$info->phone."<br>
				Email: ".$info->email."
				</p></div>
				";
				$body .= $this->getFooterEmail();

				$ok2 = $this->send_email($order_id, $supplier->email, $body, "Booking cancelled", $info->supplier_id);
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
			
			if($number_of_days == $this->check_70_days){
				$ok = $this->send_email_user_70($order->id);
			}
		}
	}
	
	function send_email_user_70($order_id){
		if(empty($order_id)){
			$order_id = JRequest::getVar('order_id');
		}
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
		$info = $db->loadObject();
		
		$db->setQuery("UPDATE #__booking SET send_email_payall_time = ".time()." WHERE id = ".$order_id);
		$db->query();
		
		$house = simplexml_load_string($info->information);
		
		$number_of_days_time = $info->checkout - $info->checkin;
		$number_of_days = floor($number_of_days_time/(60*60*24));
		
		$body = '';
		$body .= $this->getHeaderEmail();
		$body .= "<div class='box'><p>Dear ".$info->first_name." ".$info->last_name.", <br /><br />
		
		Thank you for booking with Domus Holidays.<br>
		We confirm your Booking <strong>".sprintf($info->supplier_id.'%04d',$order_id)."</strong> for the house <strong>".$info->house_id."</strong> from <strong>".date("d-m-Y", $info->checkin)."</strong> for <strong>".$number_of_days."</strong> days.
		</p></div>
		
		<div class='box'><p>
		<strong>Booking Summary:</strong> <br>
		Booking Number: ".sprintf($info->supplier_id.'%04d',$order_id)."<br>
		House name: ".$info->house_id."<br>
		From: ".date("d-m-Y", $info->checkin)." for ".$number_of_days." days<br>
		Number of people: ".$info->number_of_persons."<br>
		Total price: ".number_format($info->total_da, 2, ',', '.')." DKK<br><br>

		•	Deposit: <strong>".number_format($info->total_da*0.3, 2, ',', '.')." DKK</strong> (Paid)<br>
		•	Balance: <strong>".number_format($info->total_da*0.7, 2, ',', '.')." DKK</strong> (To pay)<br><br>
		
		<strong>Client Details:</strong><br>
		Name: ".$info->first_name." ".$info->last_name."<br>
		Address: ".$info->address."<br>
		Town: ".$info->city."<br>
		Telephone: ".$info->phone."<br>
		Email: ".$info->email."
		</p></div>
		
		<div class='box'><p>
		<strong>Remember, the payment is due within 3 days after the receipt of this email, on pain of cancellation.</strong><br><br>
		
		You can pay with all major credit cards by clicking on the button below:<br>
		<a href='".JURI::base()."index.php?option=com_booking&task=order.pay_70&order_id=".$order_id."'><img src='".JURI::base()."images/click_to_pay.png'></a><br><br>
		
		(If the link doesn't work copy and paste the link to the address bar of your browser) <br><hr><br>
		We remain at your disposal and we invite you to contact us at the number 41628001 or send us an email to info@domusholidays.com for any clarification.<br>
		Thank you for choosing a Domus Holidays property for your holiday.</p></div>
		";
		$body .= $this->getFooterEmail();
		
		$ok = $this->send_email($order_id, $info->email, $body, "Booking payment 70% for bookingnumber", $info->supplier_id);
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
	
	function send_email($order_id, $receiver, $body, $subject, $supplier_id){
		$app = JFactory::getApplication();
		$mailfrom = $app->get('mailfrom');
		$fromname = $app->get('fromname');
			
		$mail = JFactory::getMailer();
		$mail->addRecipient($receiver);
		$mail->setSender(array($mailfrom, $fromname));
		$mail->setSubject($subject.': '.sprintf($supplier_id.'%04d',$order_id));
		$mail->isHTML(true);
		$mail->setBody($body);
		$sent = $mail->Send();
		return $sent;
	}
	
	public function testEmail(){
		$app = JFactory::getApplication();
		$mailfrom = $app->get('mailfrom');
		$fromname = $app->get('fromname');
			
		$mail = JFactory::getMailer();
		$mail->addRecipient('trung@mywebcreations.dk');
		//$mail->AddCC('trung@mywebcreations.dk');
		$mail->setSender(array($mailfrom, $fromname));
		$mail->setSubject('Bekræftet ordre '.time());
		$mail->isHTML(true);
		$mail->setBody('test mail function');
		$sent = $mail->Send();

		if($sent == 1){
			print_r($sent);exit;
		} else {
			print_r($sent);exit;
		}
	}

	public function getTestEmail(){
		$html = '';
		$html .= $this->getHeaderEmail();
		$html .= '<div class="box">
            <p>Dear Trung,
                <br>
                <br> Thank you for booking with Domus Holidays.
                <br> We confirm your Booking <strong>00030</strong> for the house <strong>1</strong> from <strong>03-12-2016</strong> for 7 days.</p>
        </div>
        <div class="box">
            <h6>Booking Summary:</h6>
            <p>Booking Number: 00030
                <br> House name: 1
                <br> From: 03-12-2016 for 7 days
                <br> Number of people: 2
                <br> Total price: 14.000,00 DKK</p>
            <h6>Client Details:</h6>
            <p>Name: asdasd sadasd
                <br> Address: test address
                <br> Town: kobenhave
                <br> Telephone: 123456789
                <br> Email: <a href="mailto:nttrung211@gmail.com">nttrung211@gmail.com</a></p>
        </div>';
        $html .= $this->getFooterEmail();
        print_r($html);exit();
	}

	public function getHeaderEmail(){
		return '<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Domusholidays.com</title>
    <style>
    body {
        padding: 0;
        margin: 0;
        font-family: Arial, sans-serif;
        background: #fff;
        color: #464646;
        font-size: 14px;
        line-height: 1.5em;
    }
    
    p {
        margin-top: 0;
    }
    
    h2 {
        font-size: 18px;
    }
    
    h6 {
        font-weight: 600;
        font-size: 16px;
        margin: 0 0 10px;
    }
    
    a {
        color: #4b8dd1;
        text-decoration: none;
    }
    
    a:hover {
        text-decoration: underline;
    }
    
    hr {
        border: 1px solid #f5f5f5;
    }
    
    #page {
        width: 800px;
        margin: 0 auto;
        background: #f2f2f2;
        padding: 30px;
    }
    
    .box {
        border: 1px solid #e1e1e1;
        background-color: #fff;
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .box:last-child {
        margin-bottom: 0;
    }
    .w50p {
    	width: 50%;
    	float: left;
    }
    .clear {clear: both;}
    </style>
</head>

<body>
    <div id="page">';
	}

	public function getFooterEmail(){
		return '<div class="box">
        	<p>Yours sincerely,
        	<br> The Domus Holidays Team</p>
			<img src="'.JURI::base().'images/email_logo.jpg" alt="">
			<p style="margin: 0"><strong>Domus Holidays ApS - Idrætsvej 62 - DK-2650 Hvidovre - CVR-nr. 37311774 - <a href="mailto:info@domusholidays.com">info@domusholidays.com</a></strong></p>
			
        </div></div></body></html>';
	}
}