<form class="form-horizontal">
    <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-step2-sponsor_name"><?php echo $entry_sponsor_name; ?></label>
        <div class="col-sm-10">
            <input type="text" name="sponsor_name" value="<?php echo $sponsor_name; ?>" placeholder="<?php echo $entry_sponsor_name; ?>" id="input-step2-sponsor_name" class="form-control" readonly="" />
            <p><?php echo  $text_sponsor_name_description; ?></p>
        </div>
    </div>
    <div class="button clearfix">
        <div class="pull-right">
            <button id="button-step2-back" class="btn btn-default" type="button"><?php echo $button_back; ?></button>
            <button id="button-step2-continue" class="btn btn-primary" type="button"><?php echo $button_continue; ?></button>
        </div>
    </div>
</form>