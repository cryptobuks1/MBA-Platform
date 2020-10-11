<script type="text/javascript" src="catalog/view/javascript/epin_validation.js"></script>
<div id="reg_details">
    <legend><?php echo $text_checkout_epin_details; ?></legend>    

    <input type="hidden" name="epinno" value="" id="input-epinno"/>
    <input type="hidden" name="cart_total" value="<?php echo $cart_total;?>" id="input-cart_total"/>
    <input type="hidden" name="link_confirm" value="<?php echo $link_confirm;?>" id="link_confirm"/>
    <input type="hidden" name="continue" value="<?php echo $continue;?>" id="continue"/>
    <input type="hidden" name="link_pass_availability" value="<?php echo $link_pass_availability;?>" id="link_pass_availability"/>
    <input type="hidden" name="text_duplicate_epin_entry" value="<?php echo $text_duplicate_epin_entry;?>" id="text_duplicate_epin_entry"/>
    <input type="hidden" name="text_please_enter_epin" value="<?php echo $text_please_enter_epin;?>" id="text_please_enter_epin"/>
    <input type="hidden" name="text_invalid_epin" value="<?php echo $text_invalid_epin;?>" id="text_invalid_epin"/>
    <input type="hidden" name="text_epin_validated" value="<?php echo $text_epin_validated;?>" id="text_epin_validated"/>
    <input type="hidden" name="text_insufficient_amount" value="<?php echo $text_insufficient_amount;?>" id="text_insufficient_amount"/>
    <div class="table-responsive">
        <table class="table table-bordered" id="p_scents">
            <thead>
                <tr>
                    <td class="text-center"><?php echo $text_no; ?></td>
                    <td class="text-left"><?php echo $text_epin; ?></td>
                    <td class="text-left"><?php echo $text_epin_amount; ?></td>
                    <td class="text-right"><?php echo $text_epin_balance; ?></td>
                    <td class="text-right"><?php echo $text_required_amount; ?></td>
                </tr>
            </thead>
            <tbody>
                <tr   align="center" id=""epin_raw1>

                    <td>1</td>  
                    <td><div class="col-md-12">
                            <p>
                                <input tabindex="55" type="text" name="epin1" id="epin1" size="20"   autocomplete="Off"   class="form-control" onblur="hideConfirmButton();"/>  
                                <span id="pin_box_1" style="display:none;"></span>
                            </p>
                        </div>
                    </td>

                    <td> <div class="col-md-12">
                            <input tabindex="56" type="text" name="pin_amount1" id="pin_amount1" size="20"   autocomplete="Off"   class="form-control" readonly/>  
                            <span id="pin_amount_span" style="display:none;"></span>

                        </div>
                    </td>                    
                    <td><div class="col-md-12">
                            <input tabindex="58" type="text" name="remaining_amount1" id="remaining_amount1" size="19"   autocomplete="Off"   class="form-control" readonly/>  
                            <span id="balance_amount_span" style="display:none;"></span>
                        </div>
                    </td>
                    <td><div class="col-md-12">
                            <input tabindex="57" type="text" name="balance_amount1" id="balance_amount1" size="20"   autocomplete="Off"   class="form-control" readonly/>  
                            <span id="remain_amount_span" style="display:none;"></span>

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <table class="table table-bordered">            
                <tr>
                    <td class="text-right"><strong><?php echo $text_epin_amount; ?>:</strong>  </td>
                    <td class="text-right"><font color="red"><span id="ecard_amount" name="ecard_amount">0</span></font><span id="ecard_div1" style="display:none;"></span></td>
                </tr>           
            </table>
        </div>
    </div>
    <div class="buttons">
        <div class="pull-left">
            <input type="button" name="validate" id="validate" class="btn btn-primary" onclick="validate_cards()" value="Validate E-PIN"><span id="amountbox" style="display:none;"></span>
        </div>

        <div class="pull-right" id="epin-submit-btn" style="display: none;">
            <input type="button" id="epin_submit" class="btn btn-primary"  value="<?php echo $button_confirm; ?>">
        </div>
    </div>
</div>

<script type="text/javascript"><!--
$('#epin_submit').bind('click', function() {

    var limit = $('#p_scents p').size();
    var pass_arr = new Array();
    var pass_id = "";

    for (var i = 1; i <= limit; i++)
    {
        pass_id = '#epin' + i;
        var epin_value = $(pass_id).val();
        var pass_str = { 'pin': epin_value, 'amount': 0 };
        pass_arr.push(pass_str);
    }

    $.ajax({
        url: $('#link_confirm').val(),
        type: 'POST',
        cache: false,
        data: JSON.stringify({
            pin_array: pass_arr,
            total_amount: $('#input-cart_total').val()
        }),
        dataType: 'json',
        contentType: "application/json",
        beforeSend: function() {
            $('#epin_submit').attr('disabled', true);
        },
        complete: function() {
            $('#epin_submit').attr('disabled', false);
            $('.attention').remove();
        },
        success: function(data) {
            if (data['error']) {
                    validate_cards();
                }
                if (data['success']) {
                    location = data['success'];
                }
        }
    });
});
//--></script>