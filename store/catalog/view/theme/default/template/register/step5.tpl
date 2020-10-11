
<div class="row">
    <div class="col-sm-12">

        <fieldset class="password">
            <legend><?php echo $text_your_delivery_details; ?></legend>
            <div class="col-sm-12">
                <div class="form-group required pull-left">
                    <div id="div-same-as" class="checkbox">
                        <?php if ($same_as) { ?>
                        <input style="margin-left: 0;" type="checkbox" name="same_as" value="1" checked="checked" id="input-step5-same_as" />
                        <?php } else { ?>
                        <input style="margin-left: 0;" type="checkbox" name="same_as" value="1" id="input-step5-same_as" />
                        <?php } ?>
                        &nbsp;<label for="input-step5-same_as"><?php echo $text_same_as; ?></label>
                    </div>                         
                </div>
            </div>
            <div id="delivery_address">
                <div class="col-sm-6">
                    <div class="form-group required">
                        <label class="control-label" for="input-step5-firstname"><?php echo $entry_firstname; ?></label>
                        <input type="text" name="firstname" <?php if (!$same_as) { ?> value="<?php echo $firstname; ?>" <?php } else { ?>value="" readonly="" <?php } ?>placeholder="<?php echo $entry_firstname; ?>" id="input-step5-firstname" class="form-control" />
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="input-step5-lastname"><?php echo $entry_lastname; ?></label>
                        <input type="text" name="lastname" <?php if (!$same_as) { ?> value="<?php echo $lastname; ?>" <?php } else { ?>value="" readonly="" <?php } ?> placeholder="<?php echo $entry_lastname; ?>" id="input-step5-lastname" class="form-control" />

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="input-step5-company"><?php echo $entry_company; ?></label>
                        <input type="text" name="company" value="<?php echo $company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-step5-company" class="form-control" />
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="input-step5-address_1"><?php echo $entry_address_1; ?></label>
                        <input type="text" name="address_1" <?php if (!$same_as) { ?> value="<?php echo $address_1; ?>" <?php } else { ?>value="" readonly="" <?php } ?>placeholder="<?php echo $entry_address_1; ?>" id="input-step5-address_1" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="input-step5-address_2"><?php echo $entry_address_2; ?></label>
                        <input type="text" name="address_2" <?php if (!$same_as) { ?> value="<?php echo $address_2; ?>" <?php } else { ?>value="" readonly="" <?php } ?> placeholder="<?php echo $entry_address_2; ?>" id="input-step5-address_2" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-6">                                
                    <div class="form-group required">
                        <label class="control-label" for="input-step5-city"><?php echo $entry_city; ?></label>
                        <input type="text" name="city" <?php if (!$same_as) { ?> value="<?php echo $city; ?>" <?php } else { ?>value="" readonly="" <?php } ?> placeholder="<?php echo $entry_city; ?>" id="input-step5-city" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="input-step5-postcode"><?php echo $entry_postcode; ?></label>
                        <input type="text" name="postcode" maxlength="6" <?php if (!$same_as) { ?> value="<?php echo $postcode; ?>" <?php } else { ?>value="" readonly="" <?php } ?> placeholder="<?php echo $entry_postcode; ?>" id="input-step5-postcode" class="form-control" />
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="input-step5-ship_country_id"><?php echo $entry_country; ?></label>
                        <select name="ship_country_id" id="input-step5-ship_country_id" class="form-control" <?php if ($same_as) { ?> disabled="" <?php } ?>>
                                <option value=""><?php echo $text_select; ?></option>
                            <?php foreach ($countries as $country) { ?>
                            <?php if ($country['country_id'] == $ship_country_id) { ?>
                            <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="input-step5-ship_zone_id"><?php echo $entry_zone; ?></label>
                        <select name="ship_zone_id" id="input-step5-ship_zone_id" class="form-control" <?php if ($same_as) { ?> disabled="" <?php } ?>>
                        </select>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<div class="clearfix button">
    <div class=" pull-right">
        <button id="button-step5-back" class="btn btn-default" type="button"><?php echo $button_back; ?></button>
        <button id="button-step5-continue" class="btn btn-primary" type="button"><?php echo $button_continue; ?></button>
    </div>
</div>

<script type="text/javascript"><!--
            $('select[name=\'ship_country_id\']').on('change', function() {
        $.ajax({
            url: 'index.php?route=account/account/country&country_id=' + this.value,
            dataType: 'json',
            beforeSend: function() {
                $('select[name=\'ship_country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
            },
            complete: function() {
                $('.fa-spin').remove();
            },
            success: function(json) {

                html = '<option value=""><?php echo $text_select; ?></option>';

                if (json['zone'] != '') {
                    for (i = 0; i < json['zone'].length; i++) {
                        html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                        if (json['zone'][i]['zone_id'] == '<?php echo $ship_zone_id; ?>') {
                            html += ' selected="selected"';
                        }

                        html += '>' + json['zone'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
                }

                $('select[name=\'ship_zone_id\']').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('select[name=\'ship_country_id\']').trigger('change');

    $("#input-step5-same_as").click(function() {
        if ($("#input-step5-same_as").prop('checked') == true) {
            document.getElementById("delivery_address").style.display = 'none';
            $("#input-step5-firstname").val("");
            $('#input-step5-firstname').attr('readonly', true);
            $("#input-step5-lastname").val("");
            $('#input-step5-lastname').attr('readonly', true);
            $("#input-step5-company").val("");
            $('#input-step5-company').attr('readonly', true);
            $("#input-step5-address_1").val("");
            $('#input-step5-address_1').attr('readonly', true);
            $("#input-step5-address_2").val("");
            $('#input-step5-address_2').attr('readonly', true);
            $("#input-step5-city").val("");
            $('#input-step5-city').attr('readonly', true);
            $("#input-step5-postcode").val("");
            $('#input-step5-postcode').attr('readonly', true);
            $('#input-step5-ship_country_id').attr('disabled', true);
            $('#input-step5-ship_zone_id').attr('disabled', true);
        } else {
            document.getElementById("delivery_address").style.display = 'block';
            $('#input-step5-firstname').attr('readonly', false);
            $('#input-step5-lastname').attr('readonly', false);
            $('#input-step5-company').attr('readonly', false);
            $('#input-step5-address_1').attr('readonly', false);
            $('#input-step5-address_2').attr('readonly', false);
            $('#input-step5-city').attr('readonly', false);
            $('#input-step5-postcode').attr('readonly', false);
            $('#input-step5-ship_country_id').attr('disabled', false);
            $('#input-step5-ship_zone_id').attr('disabled', false);
        }
    });
    // -->
</script>