{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="error_msg1">Please Enter Username</span>
    <span id="error_msg2">Please Enter Password</span>
</div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default" style="margin-left: 301px; width: 650px; margin-top: 134px;">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                Check Super Admin
            </div>
            <div class="panel-body">
                {form_open('', 'name="check_super_admin" id="check_super_admin" class="smart-wizard form-horizontal" method="post"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>


                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" style="width: 250px;">User Name:<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="super_user_name" id ="super_user_name" placeholder="Username" autocomplete="Off" tabindex="2">{form_error('super_user_name')}
                        </div> 
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" style="width: 250px;">Password :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="password"  name ="super_password" id ="super_password" placeholder="Password" autocomplete="Off" tabindex="2">{form_error('super_password')}

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="imgcaptcha">

                            <div class="col-md-6 col-my" style="padding:0px; text-align:left;">  
                                <img src="{$BASE_URL}captcha/load_captcha/admin" id="captcha" /></div>
                            <div class="col-md-6 col-my" style="padding:0px;">   <div class="Change-text" style="width: 103px; margin-left: 11px; margin-right: 138px;">
                                    <a href="#" onclick="
                                                        document.getElementById('captcha').src = '{$BASE_URL}captcha/load_captcha/admin/' + Math.random();
                                                        document.getElementById('captcha-form').focus();"
                                       id="change-image" class="color">Not readable? Change text.</a></div> 
                                <div class="width-media" style="width: 89%; margin-left: -47px; margin-right: 83px;">	
                                    <input tabindex="3"type="text" style="width:100%;" name="captcha" id="captcha" autocomplete="off" /><br/></div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Login" name="super_login" id="super_login" style="width: 230px; margin-left: 171px;">Login</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  