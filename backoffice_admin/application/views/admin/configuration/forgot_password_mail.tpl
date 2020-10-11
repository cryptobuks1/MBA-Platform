<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('forgot_password_mail')}
            </div>
            <div class="panel-body">
                {form_open('', 'role="form" class="" method="post"  name="mai_settings" id="mail_settings"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> 
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('mail_status')} :<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <select name="mail_status" id="mail_status">
                                <option value="yes" {if $forgot_password['mail_status']=='yes'}selected{/if}>{lang('yes')}</option>
                                <option value="no" {if $forgot_password['mail_status']=='no'}selected{/if}>{lang('no')}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('subject')} :<span class="symbol required"></span></label>
                        <div class="col-sm-9">
                            <input class="form-control"  type="text"  name ="subject" id ="subject" value="{$forgot_password['subject']}" maxlength="" autocomplete="Off" tabindex="2">
                            <span>{form_error('subject')}</span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="mail_content">
                            {lang('mail_content')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-9">
                            <textarea id="mail_content"  name="mail_content" class="tinymce form-control textfixed" rows='10' tabindex="3">
                                {$forgot_password['content']}
                            </textarea>
                            <span>{form_error('mail_content')}</span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">

                        </label>
                        <div class="col-sm-9">
                            <label> <span class="symbol required"></span>{lang('mail_msg')}</label> 
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="3"   type="submit"  value="Update" name="forgot_pswd" id="payout_release" >{lang('update')}</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>