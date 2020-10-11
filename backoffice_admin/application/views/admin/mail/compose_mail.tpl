{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_mail_content')}   </span>        
    <span id="error_msg3">{lang('you_must_select_user')}</span>        
    <span id="error_msg2">{lang('you_must_enter_subject_here')}</span>                  
    <span id="error_msg7">{lang('you_must_enter_username')}</span>                  
</div>

    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
       {include file="admin/mail/mail_header.tpl"  name=""}
        <div class="col">
            <div class="m-l-sm">
                {include file="layout/alert_box.tpl"}
                </div>
            <div>
                <ul class="list-group list-group-lg no-radius m-b-none m-t-n-xxs">
                <li class="list-group-item clearfix b-l-3x b-l-info">
                    <div class="tab">
                        <div class="content">
                        {form_open('','role="form"  method="post" name="compose" id="compose"')}
                            {include file="layout/error_box.tpl"} 

                            <div class="form-group">
                              <select id="mail_status" name="mail_status" class="form-control m-b" onchange="show_text_send(this.value)">
                                  <option value="single" {if $mail_status=="single"} selected {/if}>{lang('Single_User')}</option>
                                  <option value="all"  {if $mail_status=="all"} selected {/if}>{lang('All_Users')}</option>
                               </select>
                            </div>         
                            {assign var="tabindexvalue" value="4"}

                            {if $mail_status=="single"}
                            <div class="form-group" id="user_div">
                                <label class="required">{lang('Single_User')}</label>
                              <input type='text' class='form-control user_autolist' name='user_id' id='user_id' autocomplete="Off" />
                              {form_error('user_id')}
                            </div>
                            {$tabindexvalue = 5}
                            {/if}         

                            <div class="form-group">
                                <label class="required">{lang('subject')}</label>
                                <input type="text" class="form-control" name="subject" id="subject"/>
                                {form_error('subject')}
                            </div>

                            <div class="form-group">
                                <label class="required">{lang('mail_content')}</label>                                 
                                    <div class="form-group">                                                
                                        <textarea  class="textarea textfixed" name='message1' id='message1' placeholder="{lang('user_message')}" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                    </div>
                                    <span class='val-error' id="err_mail_content">{form_error('message1')}</span>
                             </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary" name="adminsend"  id="adminsend" value="{lang('send_message')}" >{lang('send_message')}</button>
                            </div>

                            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                        {form_close()}
                        </div>     
                    </div>     
                </li>
                </ul>
            </div>
        </div>
    </div>
{/block}