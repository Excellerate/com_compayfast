<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
 
/**
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class CompayfastModelProcess extends JModelItem
{
  /**
   * Save the order to the database
   */
  public function getSetorder()
  {
    // Find unique token
    $token = JRequest::getVar('token');

    // Fire up database
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    // Check for already created entry
    $query->select(array('O.*'));
    $query->from('`#__compayfast_orders` O');
    $query->where('`token`="'.$token.'"');
    $db->setQuery($query);
    $results = $db->loadObjectList();

    if( ! $results ){

      // Insert
      $columns = array(
        'name_first',
        'name_last',
        'email_address',
        'number',
        'address_line_a',
        'address_line_b',
        'address_line_c',
        'address_line_d',
        'address_line_e',
        'address_line_f',
        'products',
        'amount',
        'success',
        'token'
      );
      $values = array(
        JRequest::getVar('name_first'),
        JRequest::getVar('name_last'),
        JRequest::getVar('email_address'),
        JRequest::getVar('number'),
        JRequest::getVar('address_line_a'),
        JRequest::getVar('address_line_b'),
        JRequest::getVar('address_line_c'),
        JRequest::getVar('address_line_d'),
        JRequest::getVar('address_line_e'),
        JRequest::getVar('address_line_f'),
        json_encode(JRequest::getVar('products')),
        JRequest::getVar('amount'),
        '0',
        $token
      );
      $query
          ->insert($db->quoteName('#__compayfast_orders'))
          ->columns($db->quoteName($columns))
          ->values(implode(',', $db->quote($values)));
      $db->setQuery($query);
      $db->execute();
    }

    // Return pretty token
    return $token;
  }
}