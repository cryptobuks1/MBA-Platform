<style>
    .required label.control-label:after {
        content: "*";
        color: red;
    }
    .combodate {
        display: flex;
    }
    .combodate > div {
        width: -webkit-fill-available;
    }
    .combodate .year.form-control {
        width: 100% !important;
    }
    .combodate .month.form-control {
        width: 100% !important;
    }
    .combodate .day.form-control {
        width: 100% !important;
    }
</style>    
<div class="row">
        <div class="col-sm-6">
            <input type="hidden" name="newsletter" value="0"  />
            <fieldset class="password">
                <legend><?php echo $text_your_password; ?></legend>
                <?php if($USERNAME_TYPE=='static') { ?>
                <div class="form-group required">
                    <label class="control-label" for="input-step4-username"><?php echo $entry_username; ?></label>
                    <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-step4-username" class="form-control" />
                    <span id="errormsg_username"></span>
                </div>
                <?php } ?>

                <div class="form-group required">
                    <label class="control-label" for="input-step4-password"><?php echo $entry_password; ?></label>
                    <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-step4-password" class="form-control" />
                    <span id="errmsg_password"></span>
                </div>
                <div class="form-group required">
                    <label class="control-label" for="input-step4-confirm"><?php echo $entry_confirm; ?></label>
                    <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" id="input-step4-confirm" class="form-control" />
                    <span id="errormsg_confirm"></span>
                </div>
            </fieldset>
            <fieldset id="account">
                <legend><?php echo $text_your_details; ?></legend>
                <div class="form-group required">
                    <label class="control-label" for="input-step4-firstname"><?php echo $entry_firstname; ?></label>
                    <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-step4-firstname" class="form-control" />
                    <span id="errmsg_firstname"></span>
                </div>
                <div class="form-group required">
                    <label class="control-label" for="input-step4-lastname"><?php echo $entry_lastname; ?></label>
                    <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-step4-lastname" class="form-control" />
                    <span id="errmsg_lastname"></span>
                </div>
                <div class="form-group required">
                    <label class="control-label" for="input-step4-date_of_birth"><?php echo $entry_dob; ?></label>
                    <input type="text" name="date_of_birth" id="input-step4-date_of_birth">
                </div>
                <div class="form-group required">
                    <label class="control-label" for="input-step4-gender"><?php echo $entry_gender; ?></label>
                    <select name="gender" id="input-step4-gender"  class="form-control">
                        <option value=""><?php echo $entry_select_gender; ?></option>
                        <option <?php if ($gender=="M") { ?>selected="selected"<?php } ?> value='M' ><?php echo $entry_male; ?></option>
                        <option <?php if ($gender=="F") { ?>selected="selected"<?php } ?> value='F'><?php echo $entry_female; ?></option> 
                    </select>

                </div>
                <div class="form-group required">
                    <label class="control-label" for="input-step4-email"><?php echo $entry_email; ?></label>
                    <input type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-step4-email" class="form-control" />

                    <span id="errmsg_email"></span>
                </div>

                <div class="form-group required">
                    <label class="control-label" for="input-step4-telephone"><?php echo $entry_telephone; ?></label>
                    <input type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-step4-telephone" class="form-control" />
                    <span id="errmsg_mobile"></span>
                </div>
                <!--<div class="form-group">
                    <label class="control-label" for="input-step4-fax"><?php echo $entry_fax; ?></label>
                    <input type="text" name="fax" value="<?php echo $fax; ?>" placeholder="<?php echo $entry_fax; ?>" id="input-step4-fax" class="form-control" />

                </div>-->
            </fieldset>
        </div>
        <div class="col-sm-6">
            <fieldset id="address">
                <legend><?php echo $text_your_address; ?></legend>
                    <!--<div class="form-group">
                        <label class="control-label" for="input-step4-company"><?php echo $entry_company; ?></label>
                        <input type="text" name="company" value="<?php echo $company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-step4-company" class="form-control" />
                    </div>-->
                    <div class="form-group required">
                        <label class="control-label" for="input-step4-address-1"><?php echo $entry_address_1; ?></label>
                        <input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-step4-address_1" class="form-control" />
                        <span id="errmsg_address1"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="input-step4-address-2"><?php echo $entry_address_2; ?></label>
                        <input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-step4-address_2" class="form-control" />

                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="input-step4-city"><?php echo $entry_city; ?></label>
                        <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-step4-city" class="form-control" />
                        <span id="errmsg_city"></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="input-step4-postcode"><?php echo $entry_postcode; ?></label>
                        <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-step4-postcode" class="form-control" />
                        <span id="errmsg_zip"></span>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="input-step4-country"><?php echo $entry_country; ?></label>
                        <select name="country_id" id="input-step4-country" class="form-control">
                            <option value=""><?php echo $text_select; ?></option>
                            <?php foreach ($countries as $country) { ?>
                            <?php if ($country['country_id'] == $country_id) { ?>
                            <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="input-step4-zone"><?php echo $entry_zone; ?></label>
                        <select name="zone_id" id="input-step4-zone" class="form-control">
                        </select>
                    </div>
                </div>
            </fieldset>
        </div>
    <div class="row">
        <?php if ($text_agree) { ?>
            <div class="form-group required pull-left">
                <div id="div-agree" class="checkbox">
                    <?php if ($agree) { ?>
                    <input type="checkbox" style="margin-left: 0;" name="agree" value="1" checked="checked" id="input-step4-agree" />
                    <?php } else { ?>
                    <input type="checkbox" style="margin-left: 0;" name="agree" value="1" id="input-step4-agree" />
                    <?php } ?>
                    &nbsp;<label for="input-step4-agree"><?php echo $text_agree; ?></label>
                </div>                         
            </div>                    
        <?php } ?>
    </div>
    <div class="buttons">
        <div class=" pull-right">
            <button id="button-step4-back" class="btn btn-default" type="button"><?php echo $button_back; ?></button>
            <button id="button-step4-continue" class="btn btn-primary" type="button"><?php echo $button_continue; ?></button>
        </div>

    </div>
<script type="text/javascript">
   
        $(function(){
            $('#input-step4-date_of_birth').combodate({
                format: 'YYYY-MM-DD',
                template: 'YYYY MM DD',
                smartDays: true,
                minYear: 1900,
                maxYear: (new Date()).getFullYear(),
                yearDescending: false,
                firstItem: 'name',
                customClass: 'form-control',
                errorClass: 'none'
            });
            $('.year.form-control').wrap('<div></div>');
            $('.year.form-control').attr('name', 'year');
            $('.year.form-control').attr('id', 'input-step4-year');
            $('.month.form-control').wrap('<div></div>');
            $('.month.form-control').attr('name', 'month');
            $('.month.form-control').attr('id', 'input-step4-month');
            $('.day.form-control').wrap('<div></div>');
            $('.day.form-control').attr('name', 'day');
            $('.day.form-control').attr('id', 'input-step4-day');

            var year = '<?php  echo $year; ?>';
            var month = '<?php  echo $month; ?>';
            var day = '<?php  echo $day; ?>';
            $('#input-step4-year').val(year);
            $('#input-step4-month').val(month);
            $('#input-step4-day').val(day);
            $('#input-step4-date_of_birth').val(year + '-' + month + '-' + day);
        });
    
            $('select[name=\'country_id\']').on('change', function() {
        $.ajax({
            url: 'index.php?route=account/account/country&country_id=' + this.value,
            dataType: 'json',
            beforeSend: function() {
                $('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
            },
            complete: function() {
                $('.fa-spin').remove();
            },
            success: function(json) {
               
                html = '<option value=""><?php echo $text_select; ?></option>';

                if (json['zone'] != '') {
                    for (i = 0; i < json['zone'].length; i++) {
                        html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                        if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                            html += ' selected="selected"';
                        }

                        html += '>' + json['zone'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
                }

                $('select[name=\'zone_id\']').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('select[name=\'country_id\']').trigger('change');  

   function trim(a)
    {
        return a.replace(/^\s+|\s+$/, '');
    }

    $(document).delegate('#input-step4-username', 'blur', function() {

        var username_type = '<?php echo $user_name_type; ?>';

        var path_temp = '<?php echo $load_image_path; ?>';

        if (username_type == "static") {

            var error = 0;
            var msg;

            if ($("#input-step4-username").val() == '') {
                error = 1;

                $("#errormsg_username").fadeTo(2200, 0.1, function() //start fading the messagebox

                {
                    msg = '<?php echo $error_user_name_cannot_be_null; ?>';

                    //add message and change the class of the box and start fading

                    $(this).removeClass();

                    $(this).addClass('messageboxerror');

                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);

                });
            }

            if (error != 1)

            {
                var length = $('#input-step4-username').val().length;

                if (length >= 6 && length < 13)
                {
                    var user_name_availability = "index.php?route=register/step4/check_username_availability"

                    msg = '<?php echo $text_checking_username_availability; ?>';

                    //remove all the class add the messagebox classes and start fading

                    $("#errormsg_username").removeClass();

                    $("#errormsg_username").addClass('messagebox');

                    $("#errormsg_username").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" /> ' + msg).show().fadeTo(2200, 1);

                    //check the username exists or not from ajax

                    $.post(user_name_availability, {user_name: $('#input-step4-username').val()}, function(data)

                    {
                        if (trim(data) == 'no') //if username not avaiable

                        {
                            $("#errormsg_username").fadeTo(2200, 0.1, function() //start fading the messagebox

                            {
                                msg = '<?php echo $error_user_name_not_available; ?>';

                                //add message and change the class of the box and start fading

                                $(this).removeClass();

                                $(this).addClass('messageboxerror');

                                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);

                            });

                        }

                        else

                        {

                            $("#errormsg_username").fadeTo(2200, 0.1, function()  //start fading the messagebox

                            {
                                msg = '<?php echo $text_user_name_available; ?>';


                                $(this).removeClass();

                                $(this).addClass('messageboxok');

                                $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + msg).show().fadeTo(2200, 1);

                            });

                        }

                    });
                }
                else if(length > 12){
                    $("#errormsg_username").fadeTo(200, 0.1, function()  //start fading the messagebox

                    {
                        msg = '<?php echo $error_username_less_than_twelve; ?>';

                        $(this).removeClass();

                        $(this).addClass('messageboxerror');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);


                    });
                }
                else {
                    $("#errormsg_username").fadeTo(2200, 0.1, function()  //start fading the messagebox

                    {
                        msg = '<?php echo $error_username_more_than_6_charactors; ?>';

                        $(this).removeClass();

                        $(this).addClass('messageboxerror');

                        $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" />' + msg).show().fadeTo(2200, 1);


                    });
                }
            }
        }
    });
    $("#input-step4-username").keypress(function(e)
    {
        //if the letter is not alphabets then display error and don't type anything
        var msg = '<?php echo $error_only_alphanumerals; ?>';
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {
            //display error message            

            $("#errormsg_username").html(msg).show().fadeOut(1200, 0);

            return false;
        }

    });
    $("#input-step4-postcode").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        var msg = '<?php echo $error_digit_only; ?>';
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

        {
            //display error message

            $("#errmsg_zip").html(msg).show().fadeOut(1200, 0);

            return false;

        }

    });

    $("#input-step4-password").keypress(function(e)
    {
        //if the letters is not a digit,alphabet or some special charecter then display error and don't type anything
        var msg = '<?php echo $error_only_char_num_some_specialchars; ?>';
        var re = /[0-9]/;
        if (e.which != 33 && e.which != 35 && e.which != 36 && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40 && e.which != 41 && e.which != 45    && e.which != 42 && e.which != 64 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122)&& e.which != 61 && e.which != 60 && e.which != 62 && e.which != 63   && e.which != 46 && e.which != 44 && e.which != 43 && e.which != 95 )

        {
            //display error message

            $("#errmsg_password").html(msg).show().fadeOut(1200, 0);

            return false;

        }

    });
    $("#input-step4-confirm").keypress(function(e)
    {
        //if the letters are not a digit,alphabet or some special charecter then display error and don't type anything
        var msg = '<?php echo $error_only_char_num_some_specialchars; ?>';
        var re = /[0-9]/;
        if (e.which != 33 && e.which != 35 && e.which != 36 && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40 && e.which != 41 && e.which != 45    && e.which != 42 && e.which != 64 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122)&& e.which != 61 && e.which != 60 && e.which != 62 && e.which != 63   && e.which != 46 && e.which != 44 && e.which != 43 && e.which != 95 )

        {
            //display error message

            $("#errormsg_confirm").html(msg).show().fadeOut(1200, 0);

            return false;

        }

    });
    $("#input-step4-confirm").blur(function(e)
    {
        //if the passwords are not matches then display error
        var msg = '<?php echo $error_password_mismatch; ?>';
        var re = /[0-9]/;
        if ($("#input-step4-password").val() != $("#input-step4-confirm").val())

        {
            //display error message

            $("#errormsg_confirm").html(msg).show().fadeOut(1200, 0);

            return false;

        }

    });
    // $("#input-step4-telephone").keypress(function(e)
    // {
    //     var msg = '<?php echo $error_digit_only; ?>';

    //     //if the letter is not digit then display error and don't type anything

    //     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))

    //     {

    //         //display error message

    //         $("#errmsg_mobile").html(msg).show().fadeOut(1200, 0);

    //         return false;

    //     }

    // });
    $("#input-step4-firstname").keypress(function(e)
    {
        var msg = '<?php echo $error_only_chars; ?>';

        //if the letter is not alphabet then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {

            //display error message

            $("#errmsg_firstname").html(msg).show().fadeOut(1200, 0);

            return false;

        }

    });
    $("#input-step4-lastname").keypress(function(e)
    {
        var msg = '<?php echo $error_only_chars; ?>';

        //if the letter is not an alphabet then display error and don't type anything

        if (e.which != 8 && e.which != 0 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))

        {

            //display error message

            $("#errmsg_lastname").html(msg).show().fadeOut(1200, 0);

            return false;

        }

    });
    /*$("#input-step4-address_1").keypress(function(e)
    {
        var msg = '<?php echo $error_only_chars_num_period_space; ?>';

        //if the letter is not chars,digits,period or space then display error and don't type anything

        if (e.which != 8 && e.which != 0 && e.which != 46 && e.which != 32 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122) && (e.which < 48 || e.which > 57))

        {

            //display error message

            $("#errmsg_address1").html(msg).show().fadeOut(1200, 0);

            return false;

        }

    });*/
    $("#input-step4-city").keypress(function(e)
    {
        var msg = "<?php echo $error_only_chars_num_period_space_coma; ?>";

        //if the letters are not chars,digits,period,comas or spaces then display error and don't type anything

        if (e.which != 8 && e.which != 0 && e.which == 46 && e.which != 32 && e.which != 44 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122) && (e.which < 48 || e.which > 57))

        {
            $("#errmsg_city").html(msg).show().fadeOut(1200, 0);
            return false;

        }

    });

    /*$("#input-step4-email").blur(function(e)
    {
        var email = $("#input-step4-email").val();

       var pattern = /^([a-zA-Z0-9\+_\-]+)(\.[a-zA-Z0-9\+_\-]+)*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/;

        if (!email.match(pattern)) {

            var msg = '<?php echo $error_mail_format; ?>';

            //display error message
            $("#errmsg_email").html(msg).show().fadeOut(1200, 0);

            document.getElementById("input-step4-email").focus();

            return false;
        }

    });*/
</script>