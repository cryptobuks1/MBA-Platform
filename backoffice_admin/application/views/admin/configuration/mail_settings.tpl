{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg1">{lang('you_must_enter_from_name')}</span>
    <span id="validate_msg2">{lang('you_must_enter_from_email')}</span>
    <span id="validate_msg3">{lang('you_must_enter_smtp_host')}</span>
    <span id="validate_msg4">{lang('you_must_enter_smtp_username')}</span>
    <span id="validate_msg5">{lang('you_must_enter_smtp_password')}</span>
    <span id="validate_msg6">{lang('you_must_enter_smtp_port')}</span>
    <span id="validate_msg7">{lang('you_must_enter_smtp_timeout')}</span>
    <span id="validate_msg71">{lang('digits_only')}</span>
    <span id="validate_msg8">{lang('select_mail_status')}</span>
    <span id="validate_msg9">{lang('smtp_authentication_status_cannot_be_null')}</span>
    <span id="validate_msg10">{lang('you_must_select_a_prefix')}</span>
    <span id="validate_msg11">{lang('you_must_enter_reply_to')}</span>
    <span id="validate_msg12">{lang('you_must_enter_domain')}</span>
    <span id="validate_msg13">{lang('you_must_enter_api_key')}</span>
    <span id="validate_msg14">{lang('your_email_address_must_be_in_the_format_of_name@domain.com')}</span>
    <span id="validate_msg15">{lang('min_3')}</span>
    <span id="validate_msg16">{lang('max_32')}</span>
</div>

{* {include file="admin/configuration/system_setting_common.tpl"} *}



<div class="panel panel-default">
    <div class="panel-body">
    <legend>
    <span class="fieldset-legend">
        {lang('mail_settings')}
    </span>
</legend>
        {form_open('', 'role="form" class="" method="post" name="mail_settings" id="mail_settings"')}
            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('mail_type')}</label>
                <select class="form-control" name="reg_mail_type" onchange="showSmtp(this);">
                    <option value="normal" {if $mail_details["reg_mail_type"] == "normal"} selected {/if}>{lang('normal')}</option>
                    <option value="smtp" {if $mail_details["reg_mail_type"] == "smtp"} selected {/if}>{lang('SMTP')}</option>
                </select>
                {* <div class="radio radio-inline">
                    <label class="i-checks i-checks-sm">
                        <input type="radio" onclick="showSmtp(false);" name="reg_mail_type" id="reg_mail_normal" value="normal" {if $mail_details["reg_mail_type"] == "normal"} checked {/if}>
                        <i></i>
                        {lang('normal')}
                    </label>
                    <label class="i-checks i-checks-sm">
                        <input type="radio" onclick="showSmtp(true);" name="reg_mail_type" id="reg_mail_smtp" value="smtp" {if $mail_details["reg_mail_type"] == "smtp"} checked {/if}>
                        <i></i>
                        {lang('SMTP')}
                    </label>
                </div> *}
                {form_error('reg_mail_type')}
            </div>
            <div id="pair" style="display:{if $mail_details["reg_mail_type"] == "smtp"} block {else} none {/if}">
                <div class="form-group">
                    <label class="required">{lang('smtp_authentiction')}</label>
                    <select class="form-control" name="smtp_auth_type">
                        <option value="1" {if $mail_details['smtp_authentication'] eq '1'} selected {/if}>{lang('enabled')}</option>
                        <option value="0" {if $mail_details['smtp_authentication'] eq '0'} selected {/if}>{lang('disabled')}</option>
                    </select>
                    {* <div class="radio radio-inline">
                        <label class="i-checks i-checks-sm">
                            <input type="radio" name="smtp_auth_type" id="smtp_auth_type" value="1" {if $mail_details['smtp_authentication'] eq '1'} checked {/if}>
                            <i></i>
                            {lang('true')}
                        </label>
                        <label class="i-checks i-checks-sm">
                            <input type="radio" name="smtp_auth_type" id="smtp_auth_type" value="0" {if $mail_details['smtp_authentication'] eq '0'} checked {/if}>
                            <i></i>
                            {lang('false')}
                        </label>
                    </div> *}
                    {form_error('smtp_auth_type')}
                </div>
                <div class="form-group">
                    <label class="required">{lang('prefix_for_secure_protocol_to_connect_to_server')}</label>
                    <select class="form-control" name="smtp_protocol">
                        <option value="tls" {if $mail_details['smtp_protocol'] eq 'tls'} selected {/if}>{lang('tls')}</option>
                        <option value="ssl" {if $mail_details['smtp_protocol'] eq 'ssl'} selected {/if}>{lang('ssl')}</option>
                        <option value="none" {if $mail_details['smtp_protocol'] eq 'none'} selected {/if}>{lang('none')}</option>
                    </select>
                    {* <div class="radio radio-inline">
                        <label class="i-checks i-checks-sm">
                            <input type="radio" name="smtp_protocol" id="smtp_protocol" value="tls" {if $mail_details['smtp_protocol'] eq 'tls'} checked {/if}>
                            <i></i>
                            {lang('tls')}
                        </label>
                        <label class="i-checks i-checks-sm">
                            <input type="radio" name="smtp_protocol" id="smtp_protocol" value="ssl" {if $mail_details['smtp_protocol'] eq 'ssl'} checked {/if}>
                            <i></i>
                            {lang('ssl')}
                        </label>
                        <label class="i-checks i-checks-sm">
                            <input type="radio" name="smtp_protocol" id="smtp_protocol" value="none" {if $mail_details['smtp_protocol'] eq 'none'} checked {/if}>
                            <i></i>
                            {lang('none')}
                        </label>
                    </div> *}
                    {form_error('smtp_auth_type')}
                </div>
                <div class="form-group">
                    <label class="required">{lang('smtp_host')}</label>
                    <input type="text" class="form-control" name="smtp_host" id="smtp_host" value="{$mail_details["smtp_host"]}">
                    {form_error('smtp_host')}
                </div>
                <div class="form-group">
                    <label class="required">{lang('smtp_username')}</label>
                    <input type="text" class="form-control" name="smtp_username" id="smtp_username" value="{$mail_details["smtp_username"]}">
                    {form_error('smtp_username')}
                </div>
                <div class="form-group">
                    <label class="required">{lang('smtp_password')}</label>
                    <input type="password" class="form-control" name="smtp_password" id="smtp_password" value="{$mail_details["smtp_password"]}">
                    {form_error('smtp_password')}
                </div>
                <div class="form-group">
                    <label class="required">{lang('smtp_port')}</label>
                    <input type="text" class="form-control" name="smtp_port" id="smtp_port" value="{$mail_details["smtp_port"]}" maxlength="5">
                    {form_error('smtp_port')}
                </div>
                <div class="form-group">
                    <label class="required">{lang('smtp_timeout')}</label>
                    <input type="text" class="form-control" name="smtp_timeout" id="smtp_timeout" value="{$mail_details["smtp_timeout"]}" maxlength="5">
                    {form_error('smtp_timeout')}
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update" type="submit" value="update">{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>

        {if $MODULE_STATUS['mail_gun_status'] == "yes"}     
         {form_open('', 'role="form" class="" method="post" name="mail_gun_settings" id="mail_gun_settings"')}
            <div class="panel panel-default"> 
                <div class="panel-body">
                    <legend><span class="fieldset-legend">{lang('mail_gun_settings')}</span></legend>
                    <div class="form-group">
                        <label class="required">{lang('from_name')}</label>
                        <input type="text" class="form-control" name="from_name" id="from_name" value="{$mailgun_details["from_name"]}">
                        {form_error('from_name')}
                    </div>
                    <div class="form-group">
                        <label class="required">{lang('from_email')}</label>
                        <input type="text" class="form-control" name="from_email" id="from_email" value="{$mailgun_details["from_email"]}">
                        {form_error('from_email')}
                    </div>
                    <div class="form-group">
                        <label class="required">{lang('reply_to')}</label>
                        <input type="text" class="form-control" name="reply_to" id="reply_to" value="{$mailgun_details["reply_to"]}">
                        {form_error('reply_to')}
                    </div>
                    <div class="form-group">
                        <label class="required">{lang('domain')}</label>
                        <input type="text" class="form-control" name="domain" id="domain" value="{$mailgun_details["domain"]}">
                        {form_error('domain')}
                    </div>
                    <div class="form-group">
                        <label class="required">{lang('api_key')}</label>
                        <input type="password" class="form-control" name="api_key" id="api_key" value="{$mailgun_details["api_key"]}">
                        {form_error('api_key')}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" name="mail_gun" type="mail_gun" value="mail_gun">{lang('update')}</button>
                    </div>
                </div>
            </div>
          {form_close()}
        {/if}
        
{/block}