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
class BookingControllerHome extends BookingController
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
	
	function set_session(){
		$session = JFactory::getSession();
        $session->set('notify', 1);
        die(true);
	}
	
	function getSubzone(){
		$zone = JRequest::getVar('zone');
		
		$subzones = simplexml_load_file('https://www.vacavilla.com/webservices/v1/service/searchformhelper/helperservice/subzones_in_zone/zone/'.$zone.'/depth/1/api.xml');
		
		$html = '';
		foreach($subzones as $subzone){
			$html .= '<option value="'.$subzone['code'].'">'.$subzone->name.'</option>';
		}
		die($html);
	}
}