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
class CompayfastModelItems extends JModelItem
{
    /**
     * @var array messages
     */
    protected $items = array();
 
    /**
     * Get the message
     *
     * @param   integer  $id  Greeting Id
     *
     * @return  string        Fetched String from Table for relevant Id
     */
    public function getItems($id = 1)
    {
        // Get a db connection.
        $db = JFactory::getDbo();
         
        // Create a new query object.
        $query = $db->getQuery(true);
         
        // Select all records
        $query->select(array('I.*', 'O.id AS oid', 'O.option', 'O.price'));
        $query->from('`#__compayfast_items` I');
        $query->join('RIGHT', '`#__compayfast_options` O ON (I.id = O.item_id)');
        $query->where('`published`=1');
        $query->order('title ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);
         
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        // Sort and attach URI
        foreach($results as $key => $value){

            // Append URL
            $value->uri = JRoute::_('index.php?option=com_compayfast&view=item&slug='.$value->slug);

            // Regroup results
            $newResults[$value->slug][] = $value;
        }

        //print "<pre>"; print_r($newResults); print "</pre>";
 
        // Return new results
        return $newResults;
    }
}