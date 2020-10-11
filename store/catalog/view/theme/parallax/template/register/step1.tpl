<style>
    .required label.control-label:after {
        content: "*";
        color: red;
    }
</style>  
<form class="form">
    <div id="hidden_fields">
        <input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type; ?>"/> 
        <input type="hidden" name="reg_from_tree" id="reg_from_tree" value="<?php echo $reg_from_tree; ?>"/>         
        <input type="hidden" name="placement_full_name" id="placement_full_name" value="<?php echo $placement_full_name; ?>"/>
    </div>

    <div class="form-group required">
        <label class="control-label" for="input-step1-sponsor_user_name"><?php echo $entry_sponsor_user_name; ?></label>
        <input type="text" name="sponsor_user_name" value="<?php echo $sponsor_user_name; ?>" placeholder="<?php echo $entry_sponsor_user_name; ?>" id="input-step1-sponsor_user_name" class="form-control" <?php if($read_only) { echo 'readonly=""'; }?>  />
        <p><?php echo $text_sponsor_description; ?></p>
        <p style="color:red;">WARNING!!! WARNING!!! PLEASE CHECK TO MAKE SURE THE SPONSOR IS CORRECT BEFORE CLICKING VERIFY SPONSOR. THIS CANNOT BE CHANGED</p>
        <span id="errormsg_sponsor_username"></span>
    </div>
    <?php if($reg_from_tree) { ?>
    <div class="form-group required">
        <label class="control-label" for="input-step1-placement_user_name"><?php echo $entry_placement_username; ?></label>
        <input type="text" name="placement_user_name" value="<?php echo $placement_user_name; ?>" placeholder="<?php echo $entry_placement_username; ?>" id="input-step1-placement_user_name" class="form-control" readonly=""  />
    </div>
    <?php }else { ?>
    <input type="hidden" name="placement_user_name" id="input-step1-placement_user_name" value="<?php echo $placement_user_name; ?>"/> 
    <?php }?>

    <?php if($mlm_plan=="Binary") { ?>
    <div class="form-group  required" style="display:none;">
        <label class="control-label" for="input-position"><?php echo $entry_position; ?></label>
        <select name="position" id="input-step1-position" value="" class="form-control" >
            <?php if($reg_from_tree) { ?>
            <?php if ($position=="L") { ?>
            <option value="L"selected="selected"><?php echo $entry_left; ?></option>
            <?php } else if ($position=="R") { ?>
            <option value="R" selected="selected"><?php echo $entry_right; ?></option>
            <?php } ?> 
            <?php }else { ?>
            <?php if ($binary_leg == 'any') { ?>
            <option value="" ><?php echo $entry_select_position; ?></option>
            <?php } ?> 
            <?php if ($binary_leg == 'any' || $binary_leg == 'L') { ?>
            <option value="L" <?php if ($position=="L") { ?>selected="selected"<?php } ?> ><?php echo $entry_left; ?></option>
            <?php } ?>
            <?php if ($binary_leg == 'any' || $binary_leg == 'R') { ?>
            <option value="R" <?php if ($position=="R") { ?>selected="selected"<?php } ?> ><?php echo $entry_right; ?></option>
            <?php } ?>
            <?php }?>         
        </select>
    </div>   
    <?php } else { ?>
    <input type="hidden" name="position" id="position" value="<?php echo $position; ?>"/> 
    <?php } ?>

    <div class="buttons">
        <div class="pull-right">
            <input type="button" value="<?php echo $button_verify_sponsor; ?>" id="button-step1" data-loading-text="" class="btn btn-primary" />
        </div>
    </div>
    
</form>

<div id="div_pos" style="display: none;">
    <option value="">Select Position</option>
    <option value="L">Left</option>
    <option value="R">Right</option>
</div>

<script type="text/javascript">
    function trim(a)
    {
        return a.replace(/^\s+|\s+$/, '');
    }

    $(function () {
        $('#input-step1-sponsor_user_name').on('blur', function () {
            if ($('#reg_from_tree').val() == "1") {
                return;
            }
            $.ajax({
                url: 'index.php?route=register/user/get_available_leg',
                type: 'GET',
                data: {
                    user_name: $('#input-step1-sponsor_user_name').val()
                },
                dataType: 'text',
                success: function (data) {
                    $('#input-step1-position').empty();
                    if (data == 'any') {
                        $('#input-step1-position').append($('#div_pos').contents().clone());
                    }
                    else if (data == 'L') {
                        $('#input-step1-position').append($('#div_pos').contents('option[value="L"]').clone());
                    }
                    else if (data == 'R') {
                        $('#input-step1-position').append($('#div_pos').contents('option[value="R"]').clone());
                    }
                }
            });
        });
    });

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