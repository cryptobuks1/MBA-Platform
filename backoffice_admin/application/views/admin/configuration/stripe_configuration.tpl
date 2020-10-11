{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display: none;"> 
        <span id="err_msg1">{lang('you_must_enter_merchant_id')}</span>
        <span id="err_msg2">{lang('you_must_enter_merchant_key')}</span>
        <span id="err_msg3">{lang('you_must_enter_encryption_key')}</span>
        <span id="err_msg4">{lang('you_must_enter_account')}</span>
        <span id="err_msg5">{lang('only_alpha_numric')}</span>
        <span id="err_msg6">{lang('you_must_enter_secret_id')}</span>
        <span id="err_msg7">{lang('only_numbers')}</span>
        <span id="err_msg8">{lang('you_must_enter_secret_key')}</span>
        <span id="err_msg9">{lang('you_must_enter_tran_pass')}</span>
    </div>



    <div class="panel panel-default">
        <div class="panel-body">
            <legend>
                <span class="fieldset-legend">{lang('stripe_configuration')}</span>
              
                <a href="{$BASE_URL}admin/configuration/payment_view" class="btn btn-addon btn-sm btn-info pull-right">
                    <i class="fa fa-backward"></i>
                    {lang('back')}
                </a>
            </legend>
            {form_open('', 'role="form" class="" method="post" name="payeer_configuration_form" id="payeer_configuration_form"')}
            {include file="layout/error_box.tpl"}
          
            
            
            <div class="form-group">
                <label class="required">{lang('stripe_key')}</label>
                <input type="text" class="form-control" name="stripe_key" id="stripe_key" value="{$stripe_details['stripe_key']}" maxlength="100" autocomplete="off">
                {form_error('stripe_key')}
            </div>
             <div class="form-group">
                <label class="required">{lang('stripe_secret')}</label>
                <input type="text" class="form-control" name="stripe_secret" id="stripe_secret" value="{$stripe_details['stripe_secret']}" maxlength="100" autocomplete="off">
                {form_error('stripe_secret')}
            </div>
            <div class="form-group">
                    <label class="required">{lang('transaction_password')}</label>
                    <input class="form-control" type="password" id="pswd1" name="pswd1" />
                    {form_error('pswd1')}
             </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update_stripe" type="submit" value="update">{lang('update')}</button>
            </div>
            {form_close()}
        </div>
    </div>

{/block}
{block name='script'}
    <script src="{$PUBLIC_URL}javascript/validate_paypal_config.js" type="text/javascript" ></script>
{/block}