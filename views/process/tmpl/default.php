<div class="compayfast">
  <h2>Payment</h2>
  <p>Your order is ready for payment. Payfast enable easy, secure and instant transfer of money from online buyers to sellers and we use them to process our online orders.</p>
  <form action="<?= $this->post_url; ?>" method="post" class="checkout">
    <?php
        foreach($this->inputs as $key => $value){
          print '<input type="hidden" name="'.$key.'" value="'.trim($value).'" >';
        }
    ?>
    <div class="short buttons">
      <button class="button" type="submit">Pay R<?= $this->amount; ?> via Payfast</button>
    </div>
  </form>
</div>