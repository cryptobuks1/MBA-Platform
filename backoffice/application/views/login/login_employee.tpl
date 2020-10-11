{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg4">{lang('please_enter_password')}</span>
    <span id="error_msg3">{lang('please_enter_captcha')}</span>
</div>
<div class="app app-header-fixed ">


    <div class="container w-xxl w-auto-xs">
        <div class=" app-header-fixed "></div>
        <div class="navbar-brand_login block m-t"> <img src="{$SITE_URL}/uploads/images/logos/{$site_info['logo']}" /> </div>
        <div class="m-b-lg">
            {form_open('login/verify_employee_login', 'id="login_form" name="login_form" class="form-validation" ')}
            <div class="text-danger wrapper text-center" ng-show="authError">
            </div>
            {include file="layout/alert_box.tpl"}
            <div class="list-group">
                <div class="list-group-item">
                    <input type="text" name="user_username" id="employee_username" placeholder="{lang('privileged_user_name')}" class="form-control no-border" value="{$employee_username}" />
                </div>
                <div class="list-group-item">
                    <input type="password" name="user_password" id="employee_password" placeholder="{lang('password')}" class="form-control no-border">
                </div>
            </div>
            <input type="submit" class="btn btn-lg btn-primary btn-block" id="user_login" name="user_login" value="{lang('login')}" />
            <div class="line line-dashed"></div> {form_close()}
        </div>
        <div class="text-center" ng-include="'tpl/blocks/page_footer.html'">

        </div>
    </div>

</div>
<div class="col-sm-12 text-center"> <small class="text-muted "> {include file="layout/login_footer.tpl"}</small> </div>

{/block}