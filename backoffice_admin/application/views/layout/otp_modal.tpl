<div class="modal fade" id="otp-modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" modal-transclude="">
                <div class="ng-scope">
                    <div class="modal-body wrapper-lg ng-scope">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="m-t-none m-b font-thin">{lang('enter_otp')}</h3>
                                {form_open('','id="otp_form"  name="otp_form" class="form-login"')}
                                <div class="errorHandler alert alert-danger" style="display: none">
                                    <i class="fa fa-remove-sign"></i> {lang('errors_check')}.
                                </div>
                                <input type="hidden" name="submit_form">
                                <div class="form-group">
                                    <label>{lang('otp')}</label>
                                    <input type="password" id="one_time_password" name="one_time_password" autocomplete="off" class="form-control" placeholder="{lang('enter_otp')} ">
                                </div>
                                <div class="m-t-lg">
                                    <input type="submit" class="btn btn-sm btn-success pull-right text-uc m-t-n-xs" id="verify" name="verify" value="{lang('verify')}" />
                                    <i class="fa fa-refresh"></i> Resend
                                </div>
                                {form_close()}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>