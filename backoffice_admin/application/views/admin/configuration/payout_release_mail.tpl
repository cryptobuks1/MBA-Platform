
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_mail_content">{lang('you_must_enter_mail_content')}</span>
    <span id="validate_subject">{lang('you_must_enter_subject')}</span>
</div>
            <div class="content">
                    {form_open('','role="form" class="" name="payout_mail_settings" id="payout_mail_settings"')}
                    {include file="layout/error_box.tpl"} 
                        <div class="form-group">
                            <label class="control-label required" >{lang('mail_status')}</label>
                                <select class="form-control" name="mail_status" id="mail_status">
                                    <option value="yes" {if $payout_release['mail_status']=='yes'}selected{/if}>{lang('yes')}</option>
                                    <option value="no" {if $payout_release['mail_status']=='no'}selected{/if}>{lang('no')}</option>
                                </select>
                        </div>
                            
                        <div class="form-group">
                            <label class=" control-label required" >{lang('subject')}</label>
                                <input class="form-control"  type="text"  name ="subject1" id ="subject1" value="{$payout_release['subject']}" autocomplete="Off">
                                <span>{form_error('subject1')}</span>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label required" for="mail_content1">
                                {lang('mail_content')}
                            </label>
                            <textarea id="mail_content1"  name="mail_content1" class="ckeditor form-control" rows='10'>
                                {$payout_release['content']}
                            </textarea>
                            <span>{form_error('mail_content1')}</span>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label"></label>
                            <label> <span class="symbol required"></span>{lang('mail_msg')}</label> 
                        </div>
                        
                        <div class="form-group">
                            <label class=" control-label"></label>
                            <p class="m-b">
                                <label>{lang('other_variables_that_you_can_use')}</label> <br>
                                    <code>A</code>{literal}{fullname}{/literal}<br>
                                    <code>B</code>{literal}{company_name}{/literal}<br>
                                    <code>C</code>{literal}{company_address}{/literal}<br>
                            </p>
                        </div>

                        <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit"  value="Update" name="payout_release" id="payout_release" >{lang('update')}</button>
                        </div>  
                    {form_close()}
            </div>