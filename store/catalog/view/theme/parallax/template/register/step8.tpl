<?php if (!isset($redirect)) { ?>
<div class="table-responsive">
<table class="table">
  <thead>
    <tr>
      <td class="text-left"><?php echo $column_name; ?></td>
      <td class="text-left"><?php echo $column_model; ?></td>
      <td class="text-right"><?php echo $column_quantity; ?></td>
      <td class="text-right"><?php echo $column_price; ?></td>
      <td class="text-right"><?php echo $column_total; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $product) { ?>
    <tr>
      <td class="name">
          <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
        <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?>

        <?php if($product['recurring']) { ?>
          <br />
          <span class="label label-info"><?php echo $text_recurring; ?></span>
          <small><?php echo $product['recurring']; ?></small>
        <?php } ?>
      </td>
      <td class="model"><?php echo $product['model']; ?></td>
      <td class="text-right"><?php echo $product['quantity']; ?></td>
      <td class="text-right"><span class="price"><?php echo $product['price']; ?></span></td>
      <td class="text-right"><span class="price"><?php echo $product['total']; ?></span></td>
    </tr>
    <?php } ?>
    <?php foreach ($vouchers as $voucher) { ?>
    <tr>
      <td class="text-left"><?php echo $voucher['description']; ?></td>
      <td class="text-left"></td>
      <td class="text-right">1</td>
      <td class="text-right"><span class="price"><?php echo $voucher['amount']; ?></span></td>
      <td class="text-right"><span class="price"><?php echo $voucher['amount']; ?></span></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <?php foreach ($totals as $total) { ?>
    <tr>
      <td colspan="4" class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
      <td class="text-right"><?php echo $total['text']; ?></td>
    </tr>
    <?php } ?>
  </tfoot>
</table>
</div>
<?php echo $payment; ?>
<?php } else { ?>
<script type="text/javascript"><!--
location = '<?php echo $redirect; ?>';
//--></script>
<?php } ?>
