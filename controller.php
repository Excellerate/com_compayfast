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
 * Hello World Component Controller
 *
 * @since  0.0.1
 */
class CompayfastController extends JControllerLegacy
{
    /**
     * 
     */
    public $session = false;

    /**
     * 
     */
    public function __construct()
    {
        // Open session
        $this->session = \JSession::getInstance('_compayfast_', array());

        //$this->session->restart();

        // Check for "Add to cart" in post data
        if( $item = JRequest::getVar('checkout') or $item = JRequest::getVar('cart') ){

            // Create a new cart
            if( ! $cart = $this->session->get('cart', false)){
                $this->session->set('cart', array($item));
            }

            // Update cart
            else{
                
                $currentCart = $this->session->get('cart');
                $updatedCart = array_merge(
                    array($item),
                    $currentCart
                );
                
                $this->session->set('cart', $updatedCart);
            }

            // If checkout, go streight to checkout
            if( JRequest::getVar('checkout') ){
                JRequest::setVar('view', 'checkout');
            }
        }

        parent::__construct();
    }

    /**
     * Remove an item from the cart
     */
    public function remove()
    {
        if($oid = JRequest::getVar('remove')){

            $currentCart = $this->session->get('cart');
            $updatedCart = [];

            foreach($currentCart as $option){
                if($option != $oid){
                    $updatedCart[] = $option;
                }
            }

            $this->session->set('cart', $updatedCart);
        }

        // Done
        $this->display();
    }

    /**
     * Empty the cart
     */
    public function clear()
    {
        // Find session
        $this->session = \JSession::getInstance('_compayfast_', array());
        $this->session->set('cart', array());

        // Done
        $this->display();
    }

    /**
     * Notify of sale
     */
    public function notify()
    {
        // Process payfast
        $data = $_POST;

        // Update everything
        if($data['payment_status'] == 'COMPLETE'){

            // Find token
            $token = JRequest::getVar('custom_str1');

            // Update database
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $fields = $db->quoteName('success') . ' = "1"';
            $conditions = $db->quoteName('token') . ' = "'.$token.'"';
            $query->update($db->quoteName('#__compayfast_orders'))->set($fields)->where($conditions);
            $db->setQuery($query);
            $r = $db->execute();

            // Pull order from database
            $query = $db->getQuery(true);
            $query->select(array('O.*'));
            $query->from('`#__compayfast_orders` O');
            $query->where('`token`="'.$token.'"');
            $db->setQuery($query);
            $order = $db->loadObject();

            // Find products / services requested
            $options = json_decode($order->products);
            $options = implode(",", $options);
            $query = $db->getQuery(true);
            $query->select(array('O.*', 'I.*'));
            $query->from('`#__compayfast_options` O');
            $query->join('RIGHT', '`#__compayfast_items` I ON (I.id = O.item_id)');
            $query->where('O.`id`IN ('.$options.')');
            $db->setQuery($query);
            $services = $db->loadObjectList();
            foreach($services as $service){
                $s[] = $service->title . ' - ' . $service->option;
            }

            //print "<pre>"; print_r($services); print "</pre>"; die();

            // Prepare email
            $tos = array('dewald.steyn@epsgroup.co.za');
            //$tos = array('hello@codechap.com');
            $ccs = array();
            $bccs = array('hello@codechap.com');
            // Clean up
            $tos = array_filter($tos);
            $ccs = array_filter($ccs);
            $bccs = array_filter($bccs);
            // Build Client
            $client_name = (isset($order->name_first) ? $order->name_first : false) ." ". (isset($order->name_last) ? $order->name_last : false);
            $client_email = (isset($order->email_address) ? $order->email_address : false);
            // Build up body
            $body = array(
                "<p>New order created via Payfast</p>",
                "<u>Client</u>: " . $client_name, 
                "<u>Email</u>: " . $client_email,
                "<u>Number</u>: " . (isset($order->number) ? $order->number : false),
                "<u>IP Address</u>: " . $_SERVER['REMOTE_ADDR'] . '<br>',
                "<u>Address</u>:<blockquote>" . (
                    implode('<br>',
                        array_filter(
                            array(
                                isset($order->address_line_a) ? $order->address_line_a : false,
                                isset($order->address_line_b) ? $order->address_line_b : false,
                                isset($order->address_line_c) ? $order->address_line_c : false,
                                isset($order->address_line_d) ? $order->address_line_d : false,
                                isset($order->address_line_e) ? $order->address_line_e : false,
                                isset($order->address_line_f) ? $order->address_line_f : false
                            )
                        )
                    )
                ) . '</blockquote>',
                "<u>Services</u>:<blockquote>" . implode("<br>", array_filter($s)) . '</blockquote>'
            );
            // App
            $app        = JFactory::getApplication();
            $mailfrom   = $app->getCfg('mailfrom');
            $fromname   = $app->getCfg('fromname');
            $sitename   = $app->getCfg('sitename');
            // Mail it
            $mail = JFactory::getMailer();
            $mail->isHTML(true);
            $mail->addReplyTo($client_email, $client_name);
            $mail->addRecipient($tos);
            $mail->AddCC($ccs);
            $mail->AddBCC($bccs);
            $mail->setSender(array($mailfrom, $fromname));
            $mail->setSubject($sitename.' Order');
            $mail->setBody(implode('<br>', $body));
            // Send it
            if( ! $mail->Send() ){
                return false;
            }
            else{
                return true;
            }
        }
    }
} 

// Check for post data
if( ! empty($_POST)){
    //print "<pre>"; print_r($_POST); print "</pre>";
}