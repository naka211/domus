<?php

/**
 * @version     1.0.0
 * @package     com_booking
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Nguyen Thanh Trung <nttrung211@yahoo.com> - 
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Booking records.
 */
class BookingModelSearch extends JModelList
{

	function getCategory(){
		$zone = JRequest::getVar('zone');
		
		$db = JFactory::getDbo();
		 
		$query = $db->getQuery(true);

		$query
			->select($db->quoteName(array('id', 'title', 'description', 'params')))
			->from($db->quoteName('#__categories'))
			->where($db->quoteName('note') . ' LIKE \''.$zone.'\'');
		 
		$db->setQuery($query);
		 
		$result = $db->loadObject();
		
		return $result;
	}

}
