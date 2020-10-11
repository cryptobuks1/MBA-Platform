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
            <!-- list -->
            <div ui-view="" class="ng-scope" style="">
            <div ng-controller="MailDetailCtrl" class="ng-scope">
            <!-- header -->
            <div class="wrapper bg-light lter b-b"> 
                <a ui-sref="app.mail.list" class="btn btn-sm btn-default w-xxs m-r-sm" tooltip="Back to Inbox" href="{BASE_URL}/admin/mail/mail_sent"><i class="fa fa-long-arrow-left"></i></a>
            </div>
 
          <!-- / header -->
        <div class="wrapper b-b">
            <h2 class="font-thin m-n ng-binding">{$mail_details[0]['mailtoussub']}</h2>
        </div>
            {foreach from=$mail_details item=v}
                <div class="wrapper b-b ng-binding">
                    <img class="thumb-xs m-r-sm" src="{$SITE_URL}/uploads/images/profile_picture/mail_pro.png">
                    {lang('to')} <span class="ng-binding">{$mail_details[0]['to']}</span> {lang('on')} {$v.mailtousdate}
                </div>

                <div class="wrapper ng-binding">
                    <div class="more">{if preg_match('/(<img[^>]+>)/i', $v.msg)}{$v.msg}{elseif preg_match('/(<a[^>]+>)/i', $v.msg)}{$v.msg}{else}{$v.msg|truncate:50} &nbsp; {if strlen($v.msg) > 50}<a href="javascript:void(0);">{lang('more')}</a>{/if}{/if}</div>
                        <div class="less" style="display:none;">{$v.msg}&nbsp; <a href="javascript:void(0);">{lang('less')}</a></div>
                </div>

                <div class="wrapper">
                  <!-- ngRepeat: attach in mail.attach -->
                </div>
           {/foreach} 
        </div>
    </div>
      <!-- / list --> 
    </div>
  </div>
</div>
{/block}

{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/MailBox.js" type="text/javascript" ></script>
{/block}