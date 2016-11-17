<?php

/**
 * @version     1.0.0
 * @package     com_booking
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Nguyen Thanh Trung <nttrung211@yahoo.com> - 
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class BookingController extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) {
        require_once JPATH_COMPONENT . '/helpers/booking.php';

        $view = JFactory::getApplication()->input->getCmd('view', 'bookings');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }

	function saveOrder(){
		$startDate = JRequest::getVar('startDate');
		$endDate = JRequest::getVar('endDate');
		$quantity = JRequest::getVar('quantity');
		$firstName = JRequest::getVar('firstName');
		$lastName = JRequest::getVar('lastName');
		$name = $firstName." ".$lastName;
		$address = JRequest::getVar('address');
		$zip = JRequest::getVar('zip');
		$city = JRequest::getVar('city');
		$email = JRequest::getVar('email');
		$phone = JRequest::getVar('phone');
		$comment = JRequest::getVar('comment');
		$newsletter = JRequest::getVar('newsletter');
		$houseName = JRequest::getVar('houseName');
		
		$startDateStr = strtotime(str_replace("/", "-", $startDate));
		$endDateStr = strtotime(str_replace("/", "-", $endDate));
		
		$db = JFactory::getDBO();
		$q = "INSERT INTO #__booking (first_name, last_name, house_id, checkin, checkout, booking_date, number_of_persons, address, zip, city, email, phone, comment) VALUES ('".$firstName."', '".$lastName."', '".$houseName."', '".$startDateStr."', '".$endDateStr."', '".time()."', ".$quantity.", '".$address."', '".$zip."', '".$city."', '".$email."', '".$phone."', '".$comment."')";
		$db->setQuery($q);
		$db->execute();
		
		$orderId = $db->insertid();
		
		if($newsletter == 1){
			$q = "SELECT subid FROM #__acymailing_subscriber WHERE email = '".$email."'";
			$db->setQuery($q);
			$subid = $db->loadResult();
			if(empty($subid)){
				$q = "INSERT INTO #__acymailing_subscriber (email, name, created, enabled, accept, html, source) VALUES ('".$email."', '".$name."', '".time()."', 1, 1, 1, 'module_98')";
				$db->setQuery($q);
				$db->execute();
				
				$subid = $db->insertid();
				
				$q = "INSERT INTO #__acymailing_listsub (listid, subid, subdate, status) VALUES (1, ".$subid.", '".time()."', 1)";
				$db->setQuery($q);
				$db->execute();
			}
		}
		
		$this->sendEmail(1, $orderId);
		$this->setRedirect("index.php?option=com_booking&view=home&layout=finish_booking&orderid=".$orderId);
	}
	
	function paymentSuccess(){
		$orderId = JRequest::getVar('orderid');
		$db = JFactory::getDBO();
		$q = "SELECT * FROM #__booking WHERE id = ".$orderId;
		$db->setQuery($q);
		$order = $db->loadObject();
		
		$db->setQuery("UPDATE #__booking SET status = 2 WHERE id = ".$orderId);
		$db->execute();
		
		$this->sendEmail(2, $orderId);
		$this->setRedirect("index.php?option=com_booking&view=home&layout=success&orderid=".$orderId);
	}
	
	function sendEmail($type, $orderId){
		$db = JFactory::getDBO();
		$q = "SELECT * FROM #__booking WHERE id = ".$orderId;
		$db->setQuery($q);
		$order = $db->loadObject();
		
		if($type == 1){
			$text = '<h3>Tak for din bestilling! Din bestilling vil blive behandlet inden for 24 timer</h3>';
			$subject = 'Booking nr. '.sprintf("%05d", $orderId).': ' . $order->house_id;
		}
		if($type == 2){
			$text = '<h3>Betalt total: kr. '.number_format($order->total_da, 0, ',', '.').'</h3>';
			$subject = 'Bekræftelse for orden nr. '.sprintf("%05d", $orderId).': ' . $order->house_id;
		}
		$body = '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Domusholidays.com</title>
	<style>
		body {
			padding: 0;
			margin: 0;
			font-family: Helvetica, Arial,sans-serif;
			background: #edf2f5;
			color: #464646;
			font-size: 14px;
			line-height: 1.5em;
		}
		h2 {
			font-size: 18px;
		}
		a {
			color: #464646;
			text-decoration: none;
		}
		hr {
			border: 1px solid #f5f5f5 ;
		}
		#page {
			width: 800px;
			margin: 0 auto;
			background: #fff;
			padding: 30px;
			min-height: 600px;
		}
	</style>
</head>
<body>
	<div id="page">
		<h4>Tak for din booking!</h4> 
	 	<h2>Booking-nr. '.sprintf("%05d", $orderId).'</h2>
		<h2>'.$order->house_id.'</h2>
		<hr>
		<p><strong>Kundeoplysninger</strong></p>
		<table class="table">
			<tbody>
				<tr>
					<td>Ankomst dato:</td>
					<td>'.date("d/m/Y", $order->checkin).'</td>
				</tr>
				<tr>
					<td>Udrejse dato:</td>
					<td>'.date("d/m/Y", $order->checkout).'</td>
				</tr>
				<tr>
					<td width="20%">Antal Personer:</td>
					<td>'.$order->number_of_persons.'</td>
				</tr>
				<tr>
					<td>Fornavn:</td>
					<td>'.$order->first_name.'</td>
				</tr>
				<tr>
					<td>Efternavn:</td>
					<td>'.$order->last_name.'</td>
				</tr>
				<tr>
					<td>Adresse:</td>
					<td>'.$order->address.'</td>
				</tr>
				<tr>
					<td>Postnr:</td>
					<td>'.$order->zip.'</td>
				</tr>
				<tr>
					<td>By:</td>
					<td>'.$order->city.'</td>
				</tr>
				<tr>
					<td>E-mail:</td>
					<td>'.$order->email.'</td>
				</tr>
				<tr>
					<td>Telefon:</td>
					<td>'.$order->phone.'</td>
				</tr>
				<tr>
					<td>Besked:</td>
					<td>'.$order->comment.'</td>
				</tr>
			</tbody>
		</table>
		<hr>
		'.$text.'		
		<hr>
		<p style="font-size: 14px;"><b>Domus Holidays ApS</b><br/>
		Idrætsvej 62<br/>
		DK-2650 Hvidovre<br/>
		CVR-nr. 37311774<br>
		<a href="mailto:info@domusholidays.com"> info@domusholidays.com</a><br>
		<a href="www.domusholidays.com">www.domusholidays.com</a></p>
	</div>
</body>
</html>';

		$app = JFactory::getApplication();
		$mailfrom = $app->get('mailfrom');
		$fromname = $app->get('fromname');
		
		$admin = JFactory::getUser(116);
		$admin_email = $admin->email;
		
		$mail = JFactory::getMailer();
		$mail->addRecipient($order->email);
		$mail->addCC($admin_email);
		$mail->IsHTML(true);
		$mail->setSender(array($mailfrom, $fromname));
		$mail->setSubject($subject);
		$mail->setBody($body);
		$sent = $mail->Send();
	}

}
