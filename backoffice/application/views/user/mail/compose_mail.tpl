{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_message_here')}   </span>        
    <span id="error_msg3">{lang('you_must_select_user')}</span>        
    <span id="error_msg2">{lang('you_must_enter_subject_here')}</span>                  
    <span id="error_msg10">{lang('you_email_address_must_be_in_the_format_name@domain')}</span>                  
    <span id="error_msg11">{lang('you_must_select_one_member')}</span>                  
    <span id="error_msg12">{lang('you_must_enter_TO_mail_id')}</span>                  
</div>  

    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
      {include file="user/mail/mail_header.tpl"  name=""}
        <div class="col">
            <div class="m-l-sm">
                {include file="layout/alert_box.tpl"}
                </div>
          <div>
            <ul class="list-group list-group-lg no-radius m-b-none m-t-n-xxs">
              <li class="list-group-item clearfix b-l-3x b-l-info">
                <div class="tab">
                  <div class="content">
                    {form_open('user/compose_mail','role="form" name="compose2" id="compose2" method="post" action=""')}
                      {include file="layout/error_box.tpl"} 

                        <div class="form-group">
                            <label class="required">{lang('subject')}</label>
                            <input type="text" class="form-control" id="subject" name="subject"/>
                            {form_error('subject')}
                        </div> 

                        <div class="form-group">
                          <label for="user_name">{lang('type')}</label>
                            <div class="radio radio-inline">
                              {{!--<label class="i-checks i-checks-sm">--}}
                              {{!--      <input type="radio" name="user" id="admin" checked="" value="admin"  onclick="document.getElementById('select_user_div').style.display = 'none';document.getElementById('ext_mail_div').style.display = 'none';"/>--}}
                              {{!--      <i></i>Admin--}}
                              {{!--</label>--}}
                              <label class="i-checks i-checks-sm">
                                    <input type="radio" name="user" id="all_user" value="all" onclick="document.getElementById('select_user_div').style.display = 'none';document.getElementById('ext_mail_div').style.display = 'none';"/>
                                    <i></i>{lang('my_team')}
                              </label>
                              <label class="i-checks i-checks-sm">
                                    <input type="radio" name="user" id="individual" value="individual"  onclick="document.getElementById('select_user_div').style.display = '';document.getElementById('ext_mail_div').style.display = 'none';"/>  
                                    <i></i>{lang('individual')}
                              </label>          
                              {{!--<label class="i-checks i-checks-sm">--}}
                              {{!--      <input type="radio" name="user" id="ext_mail" value="ext_mail" onclick="document.getElementById('ext_mail_div').style.display = '';document.getElementById('select_user_div').style.display = 'none';"/>  --}}
                              {{!--      <i></i>{lang('ext_mail')}--}}
                              {{!--</label>    --}}
                            </div>
                            {$tabindexvalue = 3}
                        </div>

                        <div class="form-group" id="select_user_div" style="display: none;">
                            <select name="username" id="username" class="form-control m-b">
                                    <option selected="selected" value="" >{lang('select_one_member')}</option>
                                    {foreach from = $user_downlines  item=levels}
                                        {foreach from = $levels  item=users}
                                            <option value="{$users.user_id}">{$users.user_name}</option>
                                        {/foreach}
                                    {/foreach}
                            </select>
                        </div>
                    
                        <div class="form-group" id="ext_mail_div" style="display: none;">
                            <div class="form-group">
                                <input type='email' class='form-control' name='ext_mail_from' id='ext_mail_from' placeholder='{lang('From')}' autocomplete="Off" value="{$sender_email}" readonly=""/>
                            </div>
                            <div class="form-group">
                                <input type='email' class='form-control' name='ext_mail_to' id='ext_mail_to' placeholder='{lang('To')}' autocomplete="Off" />
                            </div>    
                            {$tabindexvalue = 5}
                        </div>

                        <div class="form-group">
                          <label class="required">{lang('mail_content')}</label>  
                            <div class="form-group">
                                <textarea class="textarea textfixed" class="textarea_style" name='message' id='message' placeholder="{lang('messagetoadmin')}" style="width: 100%; height: 125px;font-size: 14px;line-height: 18px;border: 1px solid #dddddd; padding: 10px;" ></textarea>
                            </div>
                            <span class='val-error' id="err_mail_content">{form_error('message')}</span>
                        </div>                     
                           
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit"id="usersend" value="{lang('send_message')}" name="usersend">{lang('send_message')}</button>
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