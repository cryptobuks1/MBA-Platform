<form class="form">
    <div class="form-group required">
        <label class="control-label" for="input-step2-sponsor_name"><?php echo $entry_sponsor_name; ?></label>
        <input type="text" name="sponsor_name" value="<?php echo $sponsor_name; ?>" placeholder="<?php echo $entry_sponsor_name; ?>" id="input-step2-sponsor_name" class="form-control" readonly="" />
        <p><?php echo  $text_sponsor_name_description; ?></p>
    </div>
    <div class="buttons">
        <div class="pull-right">
            <input type="button" value="<?php echo $button_back; ?>" id="button-step2-back" class="btn btn-primary" />
            <input type="button" value="<?php echo $button_continue; ?>" id="button-step2-continue" data-loading-text="" class="btn btn-primary" />
        </div>
    </div>
</form>