<div id="reg_details">
    <legend><?php echo $ewallet_text_title; ?></legend>
    <form id="payment" name="ewallet_form" class="ewallet">
        <input type="hidden" name="username_verified" value="<?php echo $username_verified; ?>" id="username_verified"/>
        <input type="hidden" name="invalid_username" value="<?php echo $invalid_username; ?>" id="invalid_username"/>
        <input type="hidden" name="verifying_username" value="<?php echo $verifying_username; ?>" id="verifying_username"/>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="input-email"><?php echo $entry_username; ?></label>
                    <input type="text" name="username" value="<?php echo $logged_user_name; ?>" placeholder="<?php echo $entry_username; ?>" id="username" class="form-control" />
                    <span id="errormsg2"></span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="input-password"><?php echo $entry_tran_password; ?></label>
                    <input type="password" name="tran_pswd" value="" placeholder="<?php echo $entry_tran_password; ?>" id="tran_pswd" class="form-control" />
                </div>
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-6">
                <div class="form-group">
                    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary pull-right" />
                </div>
            </div>
        </div>
    </form>
    
</div>


<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
        $.ajax({
            type: 'post',
            url: 'index.php?route=extension/payment/ewallet/confirm/',
            data: $('#payment :input'),
            dataType: 'json',
            cache: false,
            beforeSend: function() {
                $('#button-confirm').button('loading');
            },
            complete: function() {
                $('#button-confirm').button('reset');
            },
            success: function(json) {
                if (json['error']) {                    
                    alert(json['error']);
                }
                if (json['success']) {
                    location = json['success'];
                }
                if (json['warning']) {
                    $('.alert-warning').remove();
                    $('#payment').prepend('<div class="alert alert-warning" id="warning_div">' + json['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            }
        });
    });

    $("#username").blur(function()
    {
        if ($("#username").val() != '')
        {
            var user_name_availability = $('base').attr('href') + "index.php?route=extension/payment/ewallet/validateUsername";
            var msg;
            msg = $("#verifying_username").val();
            $("#errormsg2").removeClass();
            $("#errormsg2").addClass('messagebox');
            $("#errormsg2").html(msg).show().fadeTo(500, 1);
            //check the username exists or not from ajax
            $.post(user_name_availability, { user_name: $('#username').val() }, function(data)
            {
                if (!data) //if username not avaiable
                {
                    $("#errormsg2").fadeTo(200, 0.1, function() //start fading the messagebox
                    {
                        $("#errormsg2").fadeTo(200, 0.1, function() //start fading the messagebox
                        {
                            var msg;
                            msg = $("#invalid_username").val();
                            $(this).removeClass();
                            $(this).addClass('text-danger');
                            $(this).html(msg).show().fadeTo(2200, 1);
                            $('#button-confirm').attr('disabled', true);
                        });
                    });
                }
                else
                {
                    $("#errormsg2").fadeTo(200, 0.1, function() //start fading the messagebox
                    {
                        $("#errormsg2").fadeTo(200, 0.1, function() //start fading the messagebox
                        {
                            var msg;
                            msg1 = $("#username_verified").val();
                            //add message and change the class of the box and start fading
                            $(this).removeClass();
                            $(this).addClass('text-success');
                            $(this).html(msg1).show().fadeTo(1900, 1);
                            $('#button-confirm').removeAttr('disabled');
                        });
                    });
                }
            });
        }
    });

//--></script> 