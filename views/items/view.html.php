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
class CompayfastViewItems extends JViewLegacy
{
    /**
     * 
     */
    function display($tpl = null)
    {
        // Assign data to the view
        $this->msg = $this->get('Msg');
        $this->items = $this->get('Items');

        // Check of cart session
        $this->session = \JSession::getInstance('_compayfast_', array());
        $this->cart = $this->session->get('cart', false);
 
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