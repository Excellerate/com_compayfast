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
class CompayfastModelCheckout extends JModelItem
{
    /**
     * @var array messages
     */
    protected $item = array();

    /**
     * Get the item entry
     */
    public function getCart()
    {

        // Check of cart session
        $this->session = \JSession::getInstance('_compayfast_', array());
        $this->cart = $this->session->get('cart', false);

        if ( $this->cart ){
            
            foreach($this->cart as $key => $value){
                $select[] = $value;
            }

            // Get a db connection.
            $db = JFactory::getDbo();
             
            // Create a new query object.
            $query = $db->getQuery(true);
             
            // Select all records
            $query->select(array('I.*', 'O.id AS oid', 'O.option', 'O.price'));
            $query->from('`#__compayfast_items` I');
            $query->join('RIGHT', '`#__compayfast_options` O ON (I.id = O.item_id)');
            $query->where('O.id IN ('.(implode($select, ',')).')');
            $query->order('title ASC');
             
            // Reset the query using our newly populated query object.
            $db->setQuery($query);
             
            // Load the results as a list of stdClass objects (see later for more options on retrieving data).
            $results = $db->loadObjectList();

            // Sort
            foreach($results as $key => $value){

                // Regroup results
                $newResults[$value->slug][] = $value;

                // Find total
                $total[] = $value->price;
            }

            $return['newResults'] = $newResults;
            $return['total'] = array_sum($total);

            //print "<pre>"; print_r($newResults); print "</pre>";
        }

        else{
            $return = array();
        }

        // Return new results
        return $return;
    }
}