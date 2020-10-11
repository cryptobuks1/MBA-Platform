{if $LOG_USER_TYPE=='admin'}﻿
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{else}
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
{/if}


<div class="main-login col-sm-4 col-sm-offset-4" style="margin-top: 0px;">

    <div class="logo">
        <img src="{$SITE_URL}/uploads/images/logos/{$site_info['logo']}"/>
    </div>
    <!-- start: LOGIN BOX -->
    <div class="box-login">
        <p>
            {if $LOG_USER_TYPE=='admin'}﻿
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/error_box.tpl" title="" name=""}
{else}
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/error_box.tpl"  name=""}
{/if}
        </p>

        <ul class="topoptions">
            {if $HELP_STATUS == "yes"}
                <li style="padding: 0px 0px 0px 0px">
                    <a href="https://infinitemlmsoftware.com/help/{$help_link}" target="_blank">{lang('help')}</a>
                </li>
            {/if}

            {if $LANG_STATUS=="yes"}
                <li class="dropdown language">
                    <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
                        {foreach from=$LANG_ARR item=v}
                            {if $LANG_ID == $v.lang_id}
                                <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> 
                            {/if}
                        {/foreach}
                        <span class="badge"></span>
                    </a>
                    <ul class="dropdown-menu posts">
                        {foreach from=$LANG_ARR item=v}
                            <li onclick="getSwitchLanguage('{$v.lang_code}');" >
                                <span class="dropdown-menu-title">
                                    <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> {$v.lang_name}
                                </span>
                            </li>
                        {/foreach}
                    </ul>
                </li>
            {/if}
        </ul>

        <div id="profileTabData" class="both">

            <div id="user" class="tab_content">
                <section>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                        <left>
                            <h3>
                                {lang('enter_otp')}
                            </h3>
                        </left>
                        </td>
                        <td>
                        <right>
                            <img class="secure_login_icon" src="{$PUBLIC_URL}images/1358434827_gnome-keyring-manager.png" width="50" />
                        </right>
                        </td>
                        </tr>
                    </table>
                    {form_open('login/verify_one_time_password','id="" name="" class="form-login" onload=""')}
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-remove-sign"></i> {lang('errors_check')}.
                    </div>
                   
                    <fieldset>
                        {if $goc_status!='verified'}
                             <div style="padding-left: 112px;">{lang('scan_qr_to_get_otp')}</div>
                        <div class="form-group col-sm-4 col-sm-offset-2">
                           
                            <div>
                                <img src="{$qr_code}"/>
                            </div>                           
                        </div> 
                            <label style="padding-left: 45px;">{lang('authentication_key')} : {$secret_key}</label>
                            <label style="padding-left: 100px;"><h6 style="margin: 0px;">{lang('store_your_secret_code_safely')}</h6></label>
                        {/if}
                        
                        <div class="form-group form-actions" style="margin-top: 0px;padding-top: 0px;margin-bottom: 0px;">
                            <label class="col-md-2">{lang('otp')}</label>
                            <div class="col-md-10">
                            <span class="input-icon">
                                <input type="password" autocomplete="off" class="form-control password" name="one_time_password" id="one_time_password" placeholder="{lang('enter_otp')}" tabindex="1" maxlength="32"/>
                                <i class="fa fa-lock"></i>
                            </span>
                                </div>
                        </div>
                        <div class="form-actions" style="margin-top: 0px;">
                            <input type ="submit"  tabindex="3"  class="btn btn-primary pull-center" id="" name="verify" value = "{lang('verify')}" /> 
                        </div>
                        {if $goc_status=='verified'}
                        <div class="form-actions">
                            <a href ="{$BASE_URL}login/backup_authentication">{lang('more_options')}</a>
                        </div>
                        {/if}
                    </fieldset>
                        
                    {form_close()}
                </section>
            </div>
        </div>
    </div>
    <div class="" style=" text-align: center; float: none; margin-top: 10px; ">
        {date('Y')} &copy; {$COMPANY_NAME}
    </div>
</div>

{if $LOG_USER_TYPE=='admin'}﻿
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/login_footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/login_footer.tpl" title="Example Smarty Page" name=""}
{/if}
<script src="{$PUBLIC_URL}javascript/login_user.js" type="text/javascript"></script>

{if $LOG_USER_TYPE=='admin'}﻿
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
{/if}