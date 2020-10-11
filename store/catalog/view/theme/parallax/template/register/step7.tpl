<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<?php foreach ($payment_methods as $payment_method) { ?>
<div class="radio">
    <label>
        <?php if ($payment_method['code'] == $code || !$code) { ?>
        <?php $code = $payment_method['code']; ?>
        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" />
        <?php } else { ?>
        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" />
        <?php } ?>
        <?php echo $payment_method['title']; ?>
        <?php if ($payment_method['terms']) { ?>
        (<?php echo $payment_method['terms']; ?>)
        <?php } ?>
    </label>
</div>
<?php } ?>
<?php } ?>
<p><strong><?php echo $text_comments; ?></strong></p>
<p>
    <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
</p>
<?php if ($text_agree) { ?>
<div class="col-sm-12">
    <div class="form-group required pull-left">
        <div id="div-same-as" class="checkbox">
            <?php if ($agree) { ?>
            <input style="margin-left: -10px;" type="checkbox" name="agree" value="1" checked="checked" id="input-step7-agree" />
            <?php } else { ?>
            <input style="margin-left: -10px;" type="checkbox" name="agree" value="1" id="input-step7-agree" />
            <?php } ?>
            &nbsp;<label for="input-step7-agree"><?php echo $text_agree; ?></label>
        </div>                         
    </div>
</div>
<?php } ?>

<div class="clearfix button">
<div class=" pull-right">
    <button id="button-step7-back" class="btn btn-default" type="button"><?php echo $button_back; ?></button>
    <button id="button-step7-continue" class="btn btn-primary" type="button"><?php echo $button_continue; ?></button>
</div>
</div>