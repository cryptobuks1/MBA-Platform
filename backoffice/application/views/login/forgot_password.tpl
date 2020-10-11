{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('please_enter_username')}</span>
    <span id="error_msg2">{lang('you_must_enter_email')}</span>
    <span id="error_msg3">{lang('please_enter_captcha')}</span>
</div>
<div class="app app-header-fixed ">


<div class="container w-xxl  w-auto-xs">
<div class=" app-header-fixed "></div>
   <div class="navbar-brand_login block m-t"> <img src="{$SITE_URL}/uploads/images/logos/{$site_info['logo']}" /> </div>
  <div class="m-b-lg">
    {form_open('', 'class="login_form form-validation" id="forgot_password" name="forgot_password" method="post" onload="onloadCaptcha();"')}
      {include file="layout/alert_box.tpl"}
      <div class="list-group">
        <div class="list-group-item form-group">
          <input type="text" id="user_name" name="user_name" placeholder="{lang('user_name')}" AUTOCOMPLETE = "OFF" class="form-control no-border" />
            {form_error('user_name')}
        </div>

        <div class="list-group-item form-group">
           <input type="email" id="e_mail" name="e_mail" placeholder="{lang('email')}" class="form-control no-border" />
            {form_error('e_mail')}
        </div>
        <div class="list-group-item forget_pass">
         <img src="{$BASE_URL}captcha/load_captcha/admin" id="captcha">
         <a class="pull-right" href="#" onclick="
                                             document.getElementById('captcha').src = '{$BASE_URL}captcha/load_captcha/admin/' + Math.random();
                                             document.getElementById('captcha-form').focus();"
                                   id="change-image">{lang('not_readable_change_text')}</a>
        </div>
        <div class="list-group-item">
           <input type="text" placeholder="Enter Capcha" class="form-control no-border"  name="captcha" id="captcha-form" autocomplete="off" />
        </div>
      </div>
      <input type="submit" id="forgot_password_submit" name="forgot_password_submit" class="btn btn-lg btn-primary btn-block" value="{lang('send_request')}" />

    {form_close()}

  </div>


  <div class="text-center" ng-include="'tpl/blocks/page_footer.html'">

  </div>
</div>

</div>
<div class="col-sm-12 text-center"> <small class="text-muted ">{include file="layout/login_footer.tpl"}</small> </div>

{/block}