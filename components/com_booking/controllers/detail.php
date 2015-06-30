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
		
		$prices = simplexml_load_file('https://www.vacavilla.com/en/webservices/v1/service/viewhouse/data/prices:1/house/'.JRequest::getVar('id').'/api.xml');

		print_r($prices);exit;
	}
}