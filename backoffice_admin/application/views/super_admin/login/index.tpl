{include file="super_admin/layout/header.tpl"  name=""}
<style type="text/css">
    .imgcaptcha{
        width: 100%;
        margin: 0 auto;
    }
    .font16{
        font-size: 16px !important;
    }
    .imgcaptcha div, .imgcaptcha div{
        text-align: center;
    }
    .val-error {
        color:rgba(249, 6, 6, 1);
        opacity:1;
    }
</style>
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('please_enter_username')}</span>
    <span id="error_msg2">{lang('please_enter_password')}</span>
    <span id="error_msg3">{lang('please_enter_captcha')}</span>
</div>

<div class="main-login col-sm-4 col-sm-offset-4">

    <div class="logo">
        <img src="{$SITE_URL}/uploads/images/logos/logo.png"/>
    </div>
    <!-- start: LOGIN BOX -->
    <div class="box-login">
        <p>
            {include file="super_admin/layout/error_box.tpl" title="" name=""}
        </p>

        <div id="profileTabData" class="both">

            <div id="user" class="tab_content">
                <section>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                        <left>
                            <h3>
                                {lang('user_login')}
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
                    {form_open('super_admin/login','id="super_login_form" name="login_form" class="form-login" onload="document.getElementById(\'captcha-form\').focus()"')}
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-remove-sign"></i> {lang('errors_check')}.
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <span class="input-icon">
                                <input tabindex="1" type="text" name="super_user_name"  id="super_user_name" autocomplete="Off"size="32" maxlength="32" border="0" value="{if isset($super_login_post['super_user_name'])}{$super_login_post['super_user_name']}{/if}" placeholder="{lang('user_name')}" class="form-control"  />
                                <i class="fa fa-user"></i> </span>
                            {if isset($super_login_error['super_user_name'])}<span class='val-error' >{$super_login_error['super_user_name']} </span>{/if}
                        </div>
                        <div class="form-group form-actions">
                            <span class="input-icon">
                                <input type="password" class="form-control password" name="super_password" id="super_password" placeholder="Password" tabindex="2" maxlength="32"/>
                                <i class="fa fa-lock"></i>
                                {if isset($super_login_error['super_password'])}<span class='val-error' >{$super_login_error['super_password']} </span>{/if}
                                
                                {if $CAPTCHA_STATUS}
                                    <div class="imgcaptcha">
                                        <div class="col-md-6 col-my" style="padding:0px; text-align:left;">  
                                            <img src="{$BASE_URL}captcha/load_captcha/admin" id="captcha" />
                                        </div>
                                        <div class="col-md-6 col-my" style="padding:0px;">   <div class="Change-text">
                                                <a href="#" onclick="
                                                        document.getElementById('captcha').src = '{$BASE_URL}captcha/load_captcha/user/' + Math.random();
                                                        document.getElementById('captcha_text').focus();"
                                                   id="change-image" class="color">{lang('not_readable_change_text')}</a></div> 
                                            <div class="width-media">
                                                <input tabindex="3" style=" width:100%;" type="text" name="captcha_text" id="captcha_text" autocomplete="off" /><br/>
                                            </div> 
                                        </div>
                                    </div>
                                {/if}
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="form-actions">
                            <input type="hidden" name="flag" id="flag">
                            <input type ="submit"  tabindex="3"  class="btn btn-bricky pull-center" id="user_login" name="user_login" value = "{lang('login')}" /> <span id="loginmsg" style="display:none"></span>
                        </div>
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

{include file="super_admin/layout/login_footer.tpl" title="Example Smarty Page" name=""}

<script src="{$PUBLIC_URL}javascript/login_user.js" type="text/javascript"></script>

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}