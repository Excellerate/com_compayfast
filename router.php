<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Routing class
 *
 * @since  3.3
 */
class CompayfastRouter extends JComponentRouterBase
{
    /**
     * Build the route for this component
     *
     * @param   array  &$query  An array of URL arguments
     *
     * @return  array  The URL arguments to use to assemble the subsequent URL.
     *
     * @since   3.3
     */
    public function build(&$query)
    {
        $segments = array();

        if (isset($query['view']))
        {
            $segments[] = $query['view'];
            unset($query['view']);
        }

        if (isset($query['task']))
        {
            $segments[] = $query['task'];
            unset($query['task']);
        }

        if (isset($query['slug']))
        {
            $segments[] = $query['slug'];
            unset($query['slug']);
        }

        /*
        if (isset($query['item']))
        {
            $segments[] = $query['item'];
            unset($query['item']);
        }
        */

        return $segments;
    }

    /**
     * Parse the segments of a URL.
     *
     * @param   array  &$segments  The segments of the URL to parse.
     *
     * @return  array  The URL attributes to be used by the application.
     *
     * @since   3.3
     */
    public function parse(&$segments)
    {
        $vars = array();

        switch($segments[0])
        {
            case 'checkout' :
                $vars['view'] = 'checkout';
            break;

            case 'remove' :
                $vars['task'] = 'remove';
                $vars['remove'] = $segments[1];
                $vars['view'] = 'checkout';
            break;


            case 'process' :
                $vars['task'] = 'process';
                $vars['view'] = 'process';
            break;

            case 'thankyou' :
            case 'canceled' :
                $vars['view'] = 'process';
                $vars['task'] = 'clear';
                $vars['layout'] = 'default_'.$segments[0];
            break;

            case 'notify' :
                $vars['task'] = 'notify';
            break;
        }
        
        return $vars;
    }
}