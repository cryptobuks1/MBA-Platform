{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg1">{lang('you_must_enter_sender_id')}</span>
    <span id="validate_msg2">{lang('you_must_enter_user_name')}</span>
    <span id="validate_msg3">{lang('you_must_enter_password')}</span>
</div>

{include file="admin/configuration/system_setting_common.tpl"}



<div class="panel panel-default">
    <div class="panel-body">
    <legend>
    <span class="fieldset-legend">
        {lang('sms_setting')}
    </span>
</legend>
        {form_open('', 'role="form" class="" method="post" name="sms_form" id="sms_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('sender_id')}</label>
                <input type="text" class="form-control" name="sender_id" id="sender_id" value="">
                {form_error('sender_id')}
            </div>
            <div class="form-group">
                <label class="required">{lang('user_name')}</label>
                <input type="text" class="form-control" name="user_name" id="user_name" value="">
                {form_error('user_name')}
            </div>
            <div class="form-group">
                <label class="required">{lang('password')}</label>
                <input type="password" class="form-control" name="password" id="password" value="">
                {form_error('password')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="sms_config" type="submit" value="submit">{lang('submit')}</button>
            </div>
        {form_close()}
    </div>
</div>

{/block}