<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($shipping_methods) { ?>
<p><?php echo $text_shipping_method; ?></p>
<?php foreach ($shipping_methods as $shipping_method) { ?>
<p><strong><?php echo $shipping_method['title']; ?></strong></p>
<?php if (!$shipping_method['error']) { ?>
<?php foreach ($shipping_method['quote'] as $quote) { ?>
<div class="radio">
    <label>
        <?php if ($quote['code'] == $code || !$code) { ?>
        <?php $code = $quote['code']; ?>
        <input tabindex="1" type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" checked="checked" />
        <?php } else { ?>
        <input tabindex="2" type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" />
        <?php } ?>
        <?php echo $quote['title']; ?> - <?php echo $quote['text']; ?></label>
</div>
<?php } ?>
<?php } else { ?>
<div class="alert alert-danger"><?php echo $shipping_method['error']; ?></div>
<?php } ?>
<?php } ?>
<?php } ?>
<p><strong><?php echo $text_comments; ?></strong></p>
<p>
    <textarea tabindex="3" name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
</p>
<div class="clearfix button">
<div class=" pull-right">
    <button tabindex="4" id="button-step6-back" class="btn btn-default" type="button"><?php echo $button_back; ?></button>
    <button tabindex="5" id="button-step6-continue" class="btn btn-primary" type="button"><?php echo $button_continue; ?></button>
</div>
</div>