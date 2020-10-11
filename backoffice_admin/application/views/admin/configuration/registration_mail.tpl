



        <div class="content">
            {form_open('','role="form" class="" name="reg_mail_settings" id="reg_mail_settings"')}
                {include file="layout/error_box.tpl"} 
                    {*<div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('mail_status')}<span class="symbol required"></span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="mail_status" id="mail_status" >
                                <option value="yes" {if $reg_mail['mail_status']=='yes'}selected{/if}>{lang('yes')}</option>
                                <option value="no" {if $reg_mail['mail_status']=='no'}selected{/if}>{lang('no')}</option>
                            </select>
                        </div>
                    </div>*}
                    <input type="hidden" name="mail_status" value="yes">
                    <div class="form-group">
                        <label class="control-label required" >{lang('subject')}</label>
                            <input class="form-control"  type="text"  name ="subject" id ="subject" value="{$reg_mail['subject']}"  maxlength="" autocomplete="Off" >
                            <span>{form_error('subject')}</span>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label required" for="mail_content">{lang('mail_content')}</label>
                            <textarea id="mail_content"  name="mail_content" class="ckeditor form-control" rows='10' >
                                {$reg_mail['content']}
                            </textarea>
                            <span>{form_error('mail_content')}</span>
                    </div>
                    <div class="form-group">
                        <label class="required">{lang('mail_msg')}</label> 
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label"></label>
                        <p class="m-b">
                            <label>{lang('other_variables_that_you_can_use')}</label> <br>
                            <code>A</code> {literal}{fullname}{/literal} <br>
                            <code>B</code> {literal}{username}{/literal} <br>
                            <code>C</code> {literal}{company_name}{/literal}<br>
                            <code>D</code> {literal}{company_address}{/literal}<br>
                            <code>E</code> {literal}{sponsor_username}{/literal} <br>
                            <code>F</code> {literal}{payment_type}{/literal} </p>
                        </p>
                    </div>
                        
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" type="submit"  value="Update" name="reg_update" id="reg_update" >{lang('update')}</button>
                    </div>
                    
            {form_close()}
        </div>    