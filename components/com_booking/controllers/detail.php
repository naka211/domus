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
class BookingControllerDetail extends BookingController
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
	
	function getPrice(){
		$start_date = JRequest::getVar('start_date');
		$end_date = JRequest::getVar('end_date');
		
		$start_tmp = explode("-", $start_date);
		$start_time = mktime(0, 0, 0, $start_tmp[1], $start_tmp[0], $start_tmp[2]);
		$end_tmp = explode("-", $end_date);
		$end_time = mktime(0, 0, 0, $end_tmp[1], $end_tmp[0], $end_tmp[2]);
		
		$prices = simplexml_load_file('https://www.vacavilla.com/en/webservices/v1/service/viewhouse/data/prices:1/house/'.JRequest::getVar('id').'/api.xml');

		$i = 0;
		foreach($prices->prices->price as $price){
			$start_price_tmp = explode("/", $price['starttime']);
			$start_price_time = mktime(0, 0, 0, $start_price_tmp[1], $start_price_tmp[0], $start_price_tmp[2]);
			$end_price_tmp = explode("/", $price['endtime']);
			$end_price_time = mktime(0, 0, 0, $end_price_tmp[1], $end_price_tmp[0], $end_price_tmp[2]);
			if($start_time >= $start_price_time && $start_time <= $end_price_time){
				$start_key = $i;
			}
			if($end_time >= $start_price_time && $end_time <= $end_price_time){
				$end_key = $i;
			}
			$i++;
		}
		
		if($start_key == $end_key){
			$number_of_days_time = $end_time - $start_time;
			$number_of_days = floor($number_of_days_time/(60*60*24));
			$amount = $number_of_days * $prices->prices->price[$start_key]->value;
		}
		print_r($amount);exit; 
	}
}