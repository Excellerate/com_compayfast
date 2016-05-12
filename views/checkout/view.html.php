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
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class CompayfastViewCheckout extends JViewLegacy
{
    /**
     * Default Display option
     */
    function display($tpl = null)
    {
        // Find results
        $results = $this->get('Cart');

        if(count($results)){
            $this->items = $results['newResults'];
            $this->total = $results['total'];
        }
 
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
 
            return false;
        }
 
        // Display the view
        parent::display($tpl);
    }
}