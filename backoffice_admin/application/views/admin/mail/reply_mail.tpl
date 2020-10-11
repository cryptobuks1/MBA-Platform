{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_message_here')}   </span>        
    <span id="error_msg3">{lang('you_must_select_user')}</span>        
    <span id="error_msg2">{lang('you_must_enter_subject_here')}</span>                  
</div>  

    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
        {include file="admin/mail/mail_header.tpl"  name=""}
            <div class="col">
                <div>
                    <ul class="list-group list-group-lg no-radius m-b-none m-t-n-xxs">
                      <li class="list-group-item clearfix b-l-3x b-l-info">
                          <div class="tab">
                              <div class="content">
                                  {form_open('','name="compose_reply" id="compose_reply" class="smart-wizard" method="post"')}
                                    {include file="layout/error_box.tpl"} 
                                  <div class="form-group">
                                      <input type="text" class="form-control" id="user_id1" name="user_id1" readonly value="{$reply_user}"/>  
                                  </div>

                                  <div class="form-group">
                                      <input type="text" class="form-control" name="subject" id="subject" value=" Rep:{$reply_msg}" />{form_error('subject')}
                                  </div>
                                                                    
                                  <div class="form-group">
                                    <label class="required">{lang('mail_content')}</label>
                                        <div class="form-group">
                                            <textarea class="textarea text  fixed" name='message' id='message' placeholder="{lang('message_to_send')}" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                        </div>  
                                        <span class='val-error' id="err_mail_content">{form_error('message')}</span>
                                  </div>

                                  <div class="form-group">
                                      <button type="submit" class="btn btn-sm btn-primary" id="send" value="{lang('send_message')}" name="send">{lang('send_message')}</button>
                                  </div>
                                  {form_close()}
                              </div>
                          </div>     
                      </li>
                    </ul>
                </div>
            </div>
    </div>
{/block}

{block name=script}
  {$smarty.block.parent}
    <script>
        jQuery(document).ready(function() {
            ValidateUser.init();
            $(".textarea").wysihtml5();
        });
    </script>
    <script src="{$PUBLIC_URL}javascript/validate_mail_management.js" type="text/javascript" ></script>
{/block}
