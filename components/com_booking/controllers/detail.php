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
		$db = JFactory::getDBO();
		$db->setQuery("SELECT value FROM #__settings WHERE id = 10");
		$rate = $db->loadResult();
		
		$start_date = JRequest::getVar('start_date');
		$end_date = JRequest::getVar('end_date');
		
		$start_tmp = explode("-", $start_date);
		$start_time = mktime(0, 0, 0, $start_tmp[1], $start_tmp[0], $start_tmp[2]);
		$end_tmp = explode("-", $end_date);
		$end_time = mktime(0, 0, 0, $end_tmp[1], $end_tmp[0], $end_tmp[2]);
		
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);

		$prices = simplexml_load_string(file_get_contents('https://www.vacavilla.com/en/webservices/v1/service/viewhouse/data/prices:1/house/'.JRequest::getVar('id').'/api.xml', false, stream_context_create($arrContextOptions)));

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
			$amount = $amount;
		} else {
			$amount1 = $amount2 = $amount3 = 0;
			for($i=$start_key; $i<=$end_key; $i++){
				if($start_key == $i){
					$end_price_tmp = explode("/", $prices->prices->price[$i]['endtime']);
					$end_price_time = mktime(0, 0, 0, $end_price_tmp[1], $end_price_tmp[0], $end_price_tmp[2]);
					
					$number_of_days_time = $end_price_time - $start_time;
					$number_of_days = floor($number_of_days_time/(60*60*24)) + 1;
					$amount1 = $number_of_days * $prices->prices->price[$i]->value;
				}
				
				if($end_key == $i){
					$start_price_tmp = explode("/", $prices->prices->price[$i]['starttime']);
					$start_price_time = mktime(0, 0, 0, $start_price_tmp[1], $start_price_tmp[0], $start_price_tmp[2]);
					
					$number_of_days_time = $end_time - $start_price_time;
					$number_of_days = floor($number_of_days_time/(60*60*24));
					$amount2 = $number_of_days * $prices->prices->price[$i]->value;
				}
				
				if($start_key != $i && $end_key != $i){
					$start_price_tmp = explode("/", $prices->prices->price[$i]['starttime']);
					$start_price_time = mktime(0, 0, 0, $start_price_tmp[1], $start_price_tmp[0], $start_price_tmp[2]);
					$end_price_tmp = explode("/", $prices->prices->price[$i]['endtime']);
					$end_price_time = mktime(0, 0, 0, $end_price_tmp[1], $end_price_tmp[0], $end_price_tmp[2]);
					
					$number_of_days_time = $end_price_time - $start_price_time;
					$number_of_days = floor($number_of_days_time/(60*60*24));
					$amount3 = $number_of_days * $prices->prices->price[$i]->value;
				}
			}
			$amount = $amount1 + $amount2 + $amount3;
		}

		$tmp_arr['text'] ='from '.number_format($amount, 0, '', '.').' EUR/WEEK ('.number_format($amount*$rate, 2, ',', '.').' DKK/UGE)';
		$tmp_arr['amounteu'] = $amount;
		$tmp_arr['amountda'] = $amount*$rate;
		
		$ouput = json_encode($tmp_arr);
		die($ouput);
	}
	
	function getPrice1(){
		
		$start_date = JRequest::getVar('start_date');
		$end_date = JRequest::getVar('end_date');
		
		$start_tmp = explode("-", $start_date);
		$start_time = mktime(0, 0, 0, $start_tmp[1], $start_tmp[0], $start_tmp[2]);
		$end_tmp = explode("-", $end_date);
		$end_time = mktime(0, 0, 0, $end_tmp[1], $end_tmp[0], $end_tmp[2]);
		
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);

		$prices = simplexml_load_string(file_get_contents('https://www.vacavilla.com/en/webservices/v1/service/viewhouse/data/prices:1/house/'.JRequest::getVar('id').'/api.xml', false, stream_context_create($arrContextOptions)));
		$prices = file_get_contents('http://go-to-italy.dk/demo/index.php?option=com_houses&task=house.getPrices&id='.JRequest::getVar('id'), false, stream_context_create($arrContextOptions));
		//$prices = file_get_contents('http://localhost/gotoitaly/index.php?option=com_houses&task=house.getPrices&id='.JRequest::getVar('id'), false, stream_context_create($arrContextOptions));
		$prices = json_decode($prices);

		foreach($prices as $price){
			if($start_time >= $price->from_time && $start_time <= $price->to_time){
				$number_of_days_time = $end_time - $start_time;
				$number_of_days = floor($number_of_days_time/(60*60*24));
				$amount = $number_of_days * $price->price;
				break;
			}
		}

		$tmp_arr['text'] =number_format($amount, 2, ',', '.').' DKK';
		$tmp_arr['amount'] = $amount;
		
		$ouput = json_encode($tmp_arr);
		die($ouput);
	}
}