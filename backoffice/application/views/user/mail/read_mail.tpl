{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    
<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg">{lang('Sure_you_want_to_Delete_There_is_NO_undo')}</span>
    <span id="error_msg1">{lang('you_must_enter_message_here')}   </span>        
    <span id="error_msg3">{lang('you_must_select_user')}</span>        
    <span id="error_msg2">{lang('you_must_enter_subject_here')}</span>                  
</div> 
    
    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
      {include file="user/mail/mail_header.tpl"  name=""}
        <div class="col">
          <div>
            <div ui-view="" class="ng-scope" style="">
              <div ng-controller="MailDetailCtrl" class="ng-scope">
                <div class="wrapper bg-light lter b-b">
                  <a ui-sref="app.mail.list" class="btn btn-sm btn-default w-xxs m-r-sm" tooltip="Back to Inbox" href="{BASE_URL}/user/mail/mail_management"><i class="fa fa-long-arrow-left"></i></a>
                </div>

                {if $mail_type == 'user'}
                    <div class="wrapper b-b">
                      <h2 class="font-thin m-n ng-binding">{$mail_details[0]['subject']}</h2>
                    </div>
                    {$i = 0}
                    {$id = ""}
                    {$user_name = ""}
                    {$subject = ""}
                    {foreach from=$mail_details item=v}
                      {if $v.from != {$LOG_USER_ID} }
                        <div class="wrapper b-b ng-binding">
                          <img class="thumb-xs m-r-sm" src="{$SITE_URL}/uploads/images/profile_picture/mail_pro.png">
                          <span class="ng-binding">{$v.user_name}</span> {lang('on')} {$v.date}
                        </div>
                        <div class="wrapper ng-binding">
                            <div class="more">{if preg_match('/(<img[^>]+>)/i', $v.msg)}{$v.msg}{elseif preg_match('/(<a[^>]+>)/i', $v.msg)}{$v.msg}{else}{$v.msg|truncate:50} &nbsp; {if strlen($v.msg) > 50}<a href="javascript:void(0);"><u>{lang('more')}</u></a>{/if}{/if}</div>
                            <div class="less" style="display:none;">{$v.msg}&nbsp; <a href="javascript:void(0);"><u>{lang('less')}</u></a></div>
                        </div>
                        <div class="wrapper">
                          <!-- ngRepeat: attach in mail.attach -->
                        </div>
                      {else}
                        <div class="wrapper b-b ng-binding">
                          <img class="thumb-xs m-r-sm" src="{$SITE_URL}/uploads/images/profile_picture/mail_pro.png">
                          from <a href="" class="ng-binding">{$v.user_name}</a> on {$v.date}
                        </div>
                        <div class="wrapper ng-binding">
                            <div class="more">{if preg_match('/(<img[^>]+>)/i', $v.msg)}{$v.msg}{elseif preg_match('/(<a[^>]+>)/i', $v.msg)}{$v.msg}{else}{$v.msg|truncate:50} &nbsp; {if strlen($v.msg) > 50}<a href="javascript:void(0);">{lang('more')}</a>{/if}{/if}</div>
                            <div class="less" style="display:none;">{$v.msg}&nbsp; <a href="javascript:void(0);">{lang('less')}</a></div>
                        </div>
                        <div class="wrapper">
                          <!-- ngRepeat: attach in mail.attach -->
                        </div>
                      {/if}

                    {if $v.from != {$LOG_USER_ID} }
                       {$id = $v.id}
                       {$user_name = $v.user_name}
                    {/if}
                    {$subject = $v.message}
                    {$i = $i + 1}
                    {/foreach}
                {else}
                    <div class="wrapper b-b">
                       <h2 class="font-thin m-n ng-binding">{$mail_details['contact_name']} Contacted You</h2>
                    </div>
                    <div class="wrapper ng-binding">
                        <h5>{lang('from')}: {$mail_details['contact_email']}
                            <span class="mailbox-read-time pull-right">{$mail_details['date']}</span></h5>
                        <h5>{lang('Address')}: {$mail_details['contact_address']}</h5>
                        <h5>{lang('Phone')}: {$mail_details['contact_phone']}</h5>
                        <div class="mailbox-read-message" style="word-wrap: break-word;">
                            {$mail_details['contact_info']}
                        </div>
                    </div>
                {/if}

                {if $mail_type == 'user'}
                    <div class="wrapper">
                      <div class="panel b-a">
                        <div class="panel-heading ng-show" ng-hide="reply" aria-hidden="false">
                          <div class="m-b-lg">
                          Click here to<a href="{$BASE_URL}user/mail/reply_mail/{$id}" class="text-u-l" ng-click="reply=!reply"><span onclick="getUsername('{$user_name}', '{$subject}');" > {lang('reply')}</span></a>
                          </div>
                        </div>
                      </div>
                    </div>
               {/if}
            </div>
        </div>
      </div>
    </div>
 </div>
{/block}

{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/MailBox.js"></script>
{/block}
