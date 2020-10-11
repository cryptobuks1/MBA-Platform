{if $LOG_USER_TYPE=='user'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{/if}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('authorize_authentication')} 
            </div>
            <div class="panel-body">
                {form_open($action_url)}
                <input type='hidden' name="x_login" value="{$api_login_id}" />
                <input type='hidden' name="x_fp_hash" value="{$fingerprint}" />
                <input type='hidden' name="x_amount" value="{$payment_amount}" />
                <input type='hidden' name="x_fp_timestamp" value="{$fp_timestamp}" />
                <input type='hidden' name="x_fp_sequence" value="{$fp_sequence}" />
                <input type='hidden' name="x_version" value="3.1">
                <input type='hidden' name="x_show_form" value="payment_form">
                <input type='hidden' name="from_payment" value="authorize">
                <input type='hidden' name="x_method" value="cc">
                <input type='hidden' name="inf_token" value="f6f7369316c4928fdceaaed397356f5b">
                <input type='hidden' name='x_receipt_link_URL' value="{$return_url}" />
                <input type='hidden' name='x_receipt_link_text' value="{lang('click_here_to_continue')}" />
                <input type='hidden' name='x_receipt_link_method' value="POST" />
                <div class="form form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-6 text-right">
                            <button type="submit" name="" id="" value="" class="btn btn-bricky">{lang('click_here_secure_form')}</button>
                        </div>
                    </div>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

{if $LOG_USER_TYPE=='user'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{/if}

{if $LOG_USER_TYPE=='user'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
{/if}