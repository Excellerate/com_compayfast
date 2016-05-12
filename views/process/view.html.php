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
class CompayfastViewProcess extends JViewLegacy
{
    /**
     * Set Payfast Mode to live if true
     */
    var $payfast = true;

    /**
     * Default Display option
     *
     */
    function display($tpl = null)
    {
        // Save to database
        $token = $this->order = $this->get('setOrder');

        // Build array
        $data = array_filter(
            array(
                'merchant_id'       => $this->payfast ? '10396687' : '10000100',
                'merchant_key'      => $this->payfast ? '8ia9hoalcjbu0' : '46f0cd694581a',
                'return_url'        => JUri::base() . 'store/thankyou',
                'cancel_url'        => JUri::base() . 'store/canceled',
                'notify_url'        => JUri::base() . 'store/notify',
                'name_first'        => JRequest::getVar('name_first'),
                'name_last'         => JRequest::getVar('name_last'),
                'email_address'     => JRequest::getVar('email_address'),
                'amount'            => JRequest::getVar('amount'),
                'item_name'         => 'Eradico',
                'item_description'  => 'Eradico products and services',
                'custom_str1'       => $token
            )
        );

        // Set amount to pay
        $this->amount = JRequest::getVar('amount');

        // Build signature
        foreach( $data as $key => $val ){
            $out[] = $key.'='.urlencode(trim($val));
        }

        // Join into single string
        $out = implode("&", array_filter($out));

        // Check for passphrase and append if need be
        /*
        if($passphrase = \Config::get('payfast.passphrase')){
            $out .= '&passphrase='.$passphrase;
        }
        */

        // Append signature
        $data['signature'] = md5($out);

        // Set data
        switch($this->payfast){
            case true :
             $this->post_url = 'https://www.payfast.co.za/eng/process';
            break;
            default :
            $this->post_url = 'https://sandbox.payfast.co.za/eng/process';
        }
       
        // Set params
        $this->inputs = $data;

        // Display the view
        parent::display($tpl);
    }
}