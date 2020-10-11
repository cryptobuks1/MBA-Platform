<form class="form-horizontal">
    <div id="hidden_fields">
        <input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type; ?>"/> 
        <input type="hidden" name="reg_from_tree" id="reg_from_tree" value="<?php echo $reg_from_tree; ?>"/>         
        <input type="hidden" name="placement_full_name" id="placement_full_name" value="<?php echo $placement_full_name; ?>"/>
    </div>

    <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-step1-sponsor_user_name"><?php echo $entry_sponsor_user_name; ?></label>
        <div class="col-sm-10">
            <input type="text" name="sponsor_user_name" value="<?php echo $sponsor_user_name; ?>" placeholder="<?php echo $entry_sponsor_user_name; ?>" id="input-step1-sponsor_user_name" class="form-control" <?php if($read_only) { echo 'readonly=""'; }?>  />
                   <p><?php echo $text_sponsor_description; ?></p>
        </div>
        <span id="errormsg_sponsor_username"></span>
    </div>
    <?php if($reg_from_tree) { ?>
    <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-step1-placement_user_name"><?php echo $entry_placement_username; ?></label>
        <div class="col-sm-10">
            <input type="text" name="placement_user_name" value="<?php echo $placement_user_name; ?>" placeholder="<?php echo $entry_placement_username; ?>" id="input-step1-placement_user_name" class="form-control" readonly=""  />
        </div>
    </div>
    <?php }else { ?>
    <input type="hidden" name="placement_user_name" id="input-step1-placement_user_name" value="<?php echo $placement_user_name; ?>"/> 
    <?php }?>

    <?php if($mlm_plan=="Binary") { ?>
    <div class="form-group  required">
        <label class="col-sm-2 control-label" for="input-position"><?php echo $entry_position; ?></label>
        <div class="col-sm-10">
            <select name="position" id="input-step1-position" value="" class="form-control" >
                <?php if($reg_from_tree) { ?>
                <?php if ($position=="L") { ?>
                <option value="L"selected="selected"><?php echo $entry_left; ?></option>
                <?php } else if ($position=="R") { ?>
                <option value="R" selected="selected"><?php echo $entry_right; ?></option>
                <?php } ?> 
                <?php }else { ?>
                <option value="" ><?php echo $entry_select_position; ?></option>
                <option value="L" <?php if ($position=="L") { ?>selected="selected"<?php } ?> ><?php echo $entry_left; ?></option>
                <option value="R" <?php if ($position=="R") { ?>selected="selected"<?php } ?> ><?php echo $entry_right; ?></option>
                <?php }?>         
            </select>                
        </div>
    </div>   
    <?php } else { ?>
    <input type="hidden" name="position" id="position" value="<?php echo $position; ?>"/> 
    <?php } ?>

    <div class="buttons clearfix">
        <div class="pull-right">
            <button id="button-step1" class="btn btn-primary" type="button"><?php echo $button_verify_sponsor; ?></button>
        </div>
    </div>
    
</form>
<script type="text/javascript">
    function trim(a)
    {
        return a.replace(/^\s+|\s+$/, '');
    }

  $("#input-step1-sponsor_user_name").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        var msg = '<?php echo $error_only_alphanumerals; ?>'; 
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {
            //display error message            
            $("#errormsg_sponsor_username").html(msg).show().fadeOut(2200, 0); 
            return false;
        }

    });
 
</script>