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

// Document style sheets and js
//$doc = JFactory::getDocument();
//$doc->addStyleSheet(JUri::base().'components/com_compayfast/assets/css/compayfast.css', $type = 'text/css');
 
/**
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class CompayfastModelItem extends JModelItem
{
    /**
     * @var array messages
     */
    protected $item = array();

    /**
     * Get the item entry
     */
    public function getItem($id = 1)
    {
        if ( empty($this->item) ){

            // Get item id
            $jinput = JFactory::getApplication()->input;
            $slug = $jinput->get('id', 1, 'STRING');

            // Get a db connection.
            $db = JFactory::getDbo();
             
            // Create a new query object.
            $query = $db->getQuery(true);
             
            // Select all records from the user profile table where key begins with "custom.".
            $query->select(array('id', 'title', 'description', 'slug'));
            $query->from('`#__compayfast_items`');
            $query->where('`published`=1');
            $query->where('`slug`="'.$slug.'"');
         
            // Reset the query using our newly populated query object.
            $db->setQuery($query);
             
            // Load the results as a list of stdClass objects (see later for more options on retrieving data).
            $result = $db->loadObject();

        }
 
        return $result;
    }
}