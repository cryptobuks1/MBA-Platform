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
                            <img class="secure_login_icon" src="{$PUBLIC_URL}images/1358434827_gnome-keyring-manager.png"
                                width="50" />
                        </right>
                    </td>
                </tr>
            </table>
            {form_open('','id="otp_form" name="otp_form" class="form-login"')}
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-remove-sign"></i> {lang('errors_check')}.
            </div>
            <input type="hidden" name="submit_form">
            <fieldset>
                <div class="form-group form-actions" style="margin-top: 0px;padding-top: 0px;margin-bottom: 0px;">
                    <label class="col-md-2">{lang('otp')}</label>
                    <div class="col-md-10">
                        <span class="input-icon">
                            <input type="password" autocomplete="off" class="form-control password" name="one_time_password"
                                id="one_time_password" placeholder="{lang('enter_otp')}" tabindex="1" maxlength="32" />
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                </div>
                <div class="form-actions" style="margin-top: 0px;">
                    <input type="submit" tabindex="3" class="btn btn-primary pull-center" id="verify" name="verify" value="{lang('verify')}" />
                </div>
            </fieldset>
            {form_close()}
        </section>
    </div>
</div>