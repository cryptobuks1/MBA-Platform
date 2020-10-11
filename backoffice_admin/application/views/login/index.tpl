{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;"> <span id="error_msg1">{lang('please_enter_username')}</span> <span id="error_msg2">{lang('please_enter_password')}</span> <span id="error_msg3">{lang('please_enter_captcha')}</span> </div>
<div class=" app-header-fixed"></div>
<div class="container w-xxl">
    <div class="navbar-brand_login block m-t"> <img src="{$SITE_URL}/uploads/images/logos/{$site_info['logo']}" /> </div>
    
    <div class="m-b-lg">
        {form_open('login/verifylogin','class="" id="login_form" name="login_form" autocomplete="off"')}
        {include file="layout/alert_box.tpl"}
        <input type="password" style="display:none">
        <input type="text" style="display:none">
        <div class="text-danger wrapper text-center" ng-show="authError"> </div>
        
        <div class="list-group form-group">
            <div class="list-group-item">
                <input type="text" name="user_username" id="user_username" autocomplete="Off" size="32" maxlength="128" placeholder="{lang('user_name')}" value="{$url_user_name}" class="form-control no-border">
            </div>
            <div class="list-group-item form-group">
                <input type="password" name="user_password" id="user_password" size="32" maxlength="32" placeholder="{lang('password')}" class="form-control no-border password">
            </div>
            {if $CAPTCHA_STATUS=='yes'}
            <div class="list-group-item forget_pass">
                <img src="{$BASE_URL}captcha/load_captcha/user" id="captcha" />
                <a class="pull-right" href="#" onclick="document.getElementById('captcha').src = '{$BASE_URL}captcha/load_captcha/user/' + Math.random();document.getElementById('captcha_user').focus();" id="change-image"> {lang('not_readable_change_text')}</a>
            </div>
            <div class="list-group-item">
                <input type="text" placeholder="{lang('enter_cpacha')}" class="form-control no-border" name="captcha_user" id="captcha_user" autocomplete="off" /> {form_error('captcha')}
            </div>
            {/if}
        </div>
        <div class="m-t-xxl">
            <input type="submit" id="user_login" name="user_login" value="{lang('login')}" class="btn btn-lg btn-primary btn-block" /><span id="loginmsg" style="display:none"></span>
        </div>
        {form_close()}
        <div class="text-center m-t-md"><a href="{$BASE_URL}login/forgot_password">{lang('forgot_password')}?</a></div>
        <div class="line line-dashed"></div>
       <!-- <p class="text-center"><small>{lang('dont_have_an_account')}? </small></p>
        <a class="btn btn-lg btn-default btn-block" href="{$BASE_URL}register/user_register" class="register">
                                {lang('sign_up_now')}
                            </a>--></div>
    <div class="text-center"></div>
</div>
<div class="col-sm-12 text-center"> <small class="text-muted ">{include file="layout/login_footer.tpl"}</small> </div>
{/block}