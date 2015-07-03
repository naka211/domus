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

	function getArticle(){
		if(JRequest::getVar('subzone')){
			$zone = JRequest::getVar('subzone');
		} else {
			$zone = JRequest::getVar('zone', 'ITA');
		}

		$db = JFactory::getDbo();
		 
		$query = $db->getQuery(true);

		$query
			->select($db->quoteName(array('id', 'title', 'alias', 'introtext', 'fulltext', 'images')))
			->from($db->quoteName('#__content'))
			->where($db->quoteName('xreference') . ' LIKE \''.$zone.'\'');
		 
		$db->setQuery($query);
		 
		$result = $db->loadObject();
		
		return $result;
	}
	
	function getFilters(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select($db->quoteName(array('key', 'value')))
			->from($db->quoteName('#__settings'))
			->where($db->quoteName('id') . ' IN (1,2,3,4,5,6,7,8,9)');
		 
		$db->setQuery($query);
		 
		$filters = $db->loadObjectList();
		
		foreach($filters as $key=>$filter){
			$filters[$filter->key] = $filter->value;
			unset($filters[$key]);
		}
		return $filters;
	}

}
