<?php if (isset($this->items) and ! empty($this->items)) : ?>
<div class="compayfast">
    <h2>Checkout</h2>
    <table class="bordered cart">
        <tr>
            <th>Item</th>
            <th>Option</th>
            <th>Price</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach($this->items as $item) : ?>
            <?php foreach($item as $option) : ?>
                <tr>
                    <td><?= $option->title; ?></td>
                    <td><?= $option->option; ?></td>
                    <td>R<?= $option->price; ?></td>
                    <td><a href="<?= JUri::base(); ?>store/remove/<?= $option->oid; ?>" class="remove">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>R<?=$this->total; ?></strong></td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <div class='checkout'>
        <form action="<?= JUri::base(); ?>store/process" method="post" class="ui checkout form">
            <table class="bordered checkout">
                <tr>
                    <td>
                        <div class="required field">
                            <label>First name:</label>
                            <input type="text" tabindex="1" name="name_first" value="" placeholder="Your first name..." />
                        </div>
                    </td>
                    <td>
                        <div class="required field">
                            <label>Last name:</label>
                            <input type="text" tabindex="2" name="name_last" value="" placeholder="Your last name..." />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="required field">
                            <label>Email address:</label>
                            <input type="text" tabindex="3" name="email_address" value="" placeholder="Your email address..." />
                        </div>
                    </td>
                    <td>
                        <div class="required field">
                            <label>Contact Number:</label>
                            <input type="text" tabindex="4" name="number" value="" placeholder="Your contact number..." />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="required field">
                        <label>Property to be serviced:</label>
                            <input type="text" tabindex="5" name="address_line_a" value="" placeholder="Street number..." />
                            <input type="text" tabindex="7" name="address_line_c" value="" placeholder="Suburb..." />
                            <input type="text" tabindex="9" name="address_line_e" value="" placeholder="Town / City..." />
                        </div>
                    </td>
                    <td>
                        <label>&nbsp;</label>
                        <div class="required field">
                            <input type="text" tabindex="6" name="address_line_b" value="" placeholder="Street name..." />
                            <input type="text" tabindex="8" name="address_line_d" value="" placeholder="Province..." />
                            <input type="text" tabindex="10" name="address_line_f" value="" placeholder="Postal code..." />
                        </div>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="token" value="<?= md5(uniqid()); ?>" />
            <input type="hidden" name="amount" value="<?= $this->total; ?>" />
            <?php foreach($this->items as $item) : ?>
                <?php foreach($item as $option) : ?>
                    <input type="hidden" name="products[]" value="<?= $option->oid; ?>" />
                <?php endforeach; ?>
            <?php endforeach; ?>
            <div class="short buttons">
                <button class="button">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php else : ?>
<p>Your cart is empty.</p>
<?php endif; ?>

<script>

    // Form Validation
    $('.ui.checkout.form').form({
        fields: {
            namefirst: {
                identifier : 'name_first',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter your first name'
                }]
            },
            namelast: {
                identifier : 'name_last',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter your last name'
                }]
            },
            email: {
                identifier : 'email_address',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter your email address'
                },{
                    type   : 'email',
                    prompt : 'Please enter a valid email address'
                }]
            },
            number: {
                identifier : 'number',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter a contact number'
                }]
            },
            addresslineA: {
                identifier : 'address_line_a',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter a street number'
                }]
            },
            addresslineB: {
                identifier : 'address_line_b',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter a street name'
                }]
            },
            addresslineC: {
                identifier : 'address_line_c',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter a suburb'
                }]
            },
            addresslineD: {
                identifier : 'address_line_d',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter a province'
                }]
            },
            addresslineE: {
                identifier : 'address_line_e',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter a city'
                }]
            },
            addresslineF: {
                identifier : 'address_line_f',
                rules: [{
                    type   : 'empty',
                    prompt : 'Please enter a postal code'
                }]
            },
        }
    });

</script>