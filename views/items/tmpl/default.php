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

?>

<?php if (isset($this->cart) and ! empty($this->cart)) : ?>
<div class='checkout'><a href="<?= JRoute::_('index.php?option=com_compayfast&view=checkout'); ?>" class="checkout">You have <?= count($this->cart); ?> item<?= count($this->cart) > 1 ? 's' : null; ?>  in your cart, click here to checkout</a></div>
<br>
<?php endif; ?>

<div class="compayfast">

    <?php foreach($this->items as $slug => $item) : ?>
        <div class="box">
            <div class="bordered item">
                <?php if( isset($item[0]->img) and ! empty($item[0]->img) ) : ?>
                    <img class="image" src="<?= JRoute::_($item[0]->img); ?>" />
                <?php endif; ?>
                <div class="details">
                    <h2 class="title"><?= $item[0]->title; ?></h2>
                    <div class="<?= $slug; ?> price">R<span><?= $item[0]->price; ?></span></div>

                    <p class="description"><?= $item[0]->description; ?></p>

                    <div>
                        <select class="options">
                            <?php foreach($item as $option) : ?>
                                <option value="<?= $option->oid; ?>" data-slug="<?= $slug; ?>" data-price="<?= $option->price; ?>"><?= $option->option; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                <div class="buttons">
                    <form action="<?= JUri::current(); ?>" method="post"><input id="<?= $slug; ?>_checkoutNow" type="hidden" name="checkout" value="<?= $item[0]->oid; ?>"/><button class="now button">Buy Now</button></form>
                    <form action="<?= JUri::current(); ?>" method="post"><input id="<?= $slug; ?>_addToCart" type="hidden" name="cart" value="<?= $item[0]->oid; ?>"/><button class="add button">Add to cart</button></form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<?php if (isset($this->cart) and ! empty($this->cart)) : ?>
<div class='checkout'><a href="<?= JRoute::_('index.php?option=com_compayfast&view=checkout'); ?>" class="checkout">You have <?= count($this->cart); ?> item<?= count($this->cart) > 1 ? 's' : null; ?>  in your cart, click here to checkout</a></div>
<?php endif; ?>



<script>

    $(document).ready(function(){

        $(".options").change(function(){

            // Find the selected option
            var Selected  = $(this).find(":selected");

            // Update the price
            $('.'+Selected.data('slug')+'.price span').html( Selected.data('price') );

            // Update the checkout option
            $('#'+Selected.data('slug')+'_checkoutNow').val(Selected.val());

            // Update the add to cart option
            $('#'+Selected.data('slug')+'_addToCart').val(Selected.val());

        });

    });

</script>