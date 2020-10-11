<span style="display: none;">
	<span id="ewallet_message1">{lang('invalid_ewallet_details')}</span>
	<span id="ewallet_message2">{lang('low_ewallet_balance')}</span>
	<span id="ewallet_message3">{lang('valid_ewallet_details')}</span>
	<span id="ewallet_message4">{lang('user_name_required')}</span>
	<span id="ewallet_message5">{lang('transaction_password_required')}</span>
</span>
<div class="row col-sm-12">
    <div class="form-group col-sm-4 padding_both">
        <label>{lang('user_name')}</label>
        <input type="text" name="ewallet_username" id="ewallet_username" class="form-control" autocomplete="off">
        <span id="err_ewallet_username" style="display: none;"></span>
	{form_error('ewallet_username')}
    </div>
    <div class="form-group col-sm-4 padding_both_small" >
        <label>{lang('transaction_password')}</label>
        <input type="password" name="transaction_password" id="transaction_password" class="form-control" autocomplete="off">
        <span id="err_ewallet_password" style="display: none;"></span>
        {form_error('transaction_password')}
        <span id="msg_div" style="display: none;"></span>
    </div>
    <div class="form-group mark_paid col-sm-4 padding_both_small">
        <button type="button" name="check_ewallet" id="check_ewallet" class="btn btn-sm btn-primary">{lang('check_availability')}</button>
        <button type="submit" name="ewallet_submit" id="ewallet_submit" value="ewallet_submit" class="btn btn-sm btn-primary"  disabled="">{lang('submit')}</button>
    </div>
</div>