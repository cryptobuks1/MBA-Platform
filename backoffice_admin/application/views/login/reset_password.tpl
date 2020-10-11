{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="validate_msg15">{lang('you_must_enter_password')}</span>
    <span id="validate_msg18">{lang('password_miss_match')}</span>
    <span id="validate_msg16">{lang('minimum_six_characters_required')}</span>
    <span id="validate_msg17">{lang('you_must_enter_your_password_again')}</span>

</div>
<div class="app app-header-fixed ">


    <div class="container w-xxl w-auto-xs">
        {include file="layout/alert_box.tpl"}
        <div class=" app-header-fixed "></div>
        <div class="navbar-brand_login block m-t"> <img src="{$SITE_URL}/uploads/images/logos/{$site_info['logo']}" /> </div>
        <div class="m-b-lg">
            {include file="layout/alert_box.tpl"} {form_open('', 'id="reset_password_form" class="form-validation" name="reset_password_form" method="post"')}
            <input type="hidden" id="key" name="key" value="{$key}">
            <input type="hidden" name="user_name" id="user_name" value="{$user_name}">
            <div class="text-danger wrapper text-center" ng-show="authError">
            </div>
            {include file="layout/error_box.tpl"}
            <div class="list-group">
                <div class="list-group-item">
                    <input type="password" class="form-control no-border" id="pass" name="pass" placeholder="{lang('new_password')}">{form_error('pass')}
                </div>

                <div class="list-group-item">
                    <input type="password" class="form-control no-border" id="confirm_pass" name="confirm_pass" placeholder="{lang('confirm_password')}">{form_error('confirm_pass')}
                </div>
                <div class="list-group-item forget_pass">
                    <img src="{$BASE_URL}captcha/load_captcha/admin" id="captcha" />
                    <a href="#" onclick="
                                                document.getElementById('captcha').src = '{$BASE_URL}captcha/load_captcha/admin/' + Math.random();
                                                document.getElementById('captcha-form').focus();" id="change-image" class="pull-right">{lang('not_readable_change_text')}</a>
                </div>
                <div class="list-group-item">
                    <input type="text" placeholder="{lang('enter_cpacha')}" name="captcha" id="captcha-form" autocomplete="off" class="form-control no-border" />
                </div>
            </div>
            <input type="submit" id="reset_password_submit" class="btn btn-lg btn-primary btn-block" name="reset_password_submit" value="{lang('reset_password')}" /> {form_close()}
        </div>
        <div class="text-center" ng-include="'tpl/blocks/page_footer.html'">

        </div>
    </div>

</div>
<div class="col-sm-12 text-center"> <small class="text-muted ">{include file="layout/login_footer.tpl"}</small> </div>

{/block}