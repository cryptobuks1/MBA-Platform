{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
 <div id="span_js_messages" style="display:none;">
            <span id="confirm_msg">{lang('Sure_you_want_to_Delete_There_is_NO_undo')}</span>
        </div>


    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
        {include file="user/mail/mail_header.tpl"  name=""}
        
        <div class="col">
       
            <div class="m-l-sm m-t-sm">
                {include file="layout/alert_box.tpl"}
                </div>
            <div>
            <!-- header -->
               <div class="wrapper bg-light lter b-b">
                 <div class="btn-group pull-left">
                       <a href="" class="btn btn-sm btn-bg btn-default panel-refresh" data-toggle="tooltip" data-placement="bottom" data-title="Refresh" data-original-title="" title=""><i class="fa fa-refresh"></i></a>
                 </div>
                 <div class="btn-toolbar">
                 </div>
               </div>  
            <!-- / header -->
            <!-- list -->
             <ul class="list-group list-group-lg no-radius m-t-n-xxs">
              {assign var=i value=1}
              {assign var=clr value=""}
              {assign var=id value=""}
              {assign var=msg_id value=""}
              {assign var=user_name value=""}
              {assign var=msg_tid value=""}

              {if $cnt_mails > 0}
                  {foreach from=$row item=v}
                    {if $v.type == 'contact'}
                        {$msg_tid = $v.mailtousid}
                    {else}
                        {$msg_tid = $v.thread}
                    {/if}
                      {if $v.read_msg=='yes'}
                           {$id = $v.mailtousid}      
                          <li class="list-group-item clearfix b-l-3x b-l-info">
                              <span class="avatar thumb pull-left m-r">
                                <img src="{$SITE_URL}/uploads/images/profile_picture/mail_pro.png">
                              </span>

                              {if $v.type == "user" || $v.type == "admin"}
                                {$thread=$v.thread}
                                {$msg_id=$v.mailtousid}

                              <div class="pull-right text-sm text-muted">
                                <span class="hidden-xs ">{$v.mailtousdate}</span>
                                  {$msg_id=$v.mailtousid}       
                                  <button type="button" class="btn-link text-danger btn-md" onclick="javascript:deleteMessage({$thread}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" data-original-title="Delete"><i class="fa fa-trash-o" ></i></button>
                              </div> 

                              <div class="clear">
                                {if $v.flag}<div><span class="text-md ">{$v.from_user_name}</span></div>{/if}
                                <div class="text-ellipsis m-t-xs "><a href="{$BASE_URL}user/mail/read_mail/{$v.mail_enc_id}/{$v.mail_enc_type}/{$v.mail_enc_thread}">{$v.mailtoussub}</a></div>
                              </div>  
                              {else}
                                {$msg_id=$v.mailtousid}
                                  <div class="pull-right text-sm text-muted">
                                    <span class="hidden-xs ">{$v.mailtousdate}</span>
                                      <button type="button" class="btn-link text-danger btn-md" onclick="javascript:deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" data-original-title="Delete"><i class="fa fa-trash-o" ></i></button>
                                  </div>
                                 <div class="clear">
                                {if $v.flag}<div><span class="text-md " >{$v.from_user_name}</span></div>{/if}
                                <div class="text-ellipsis m-t-xs "><a  href="{$BASE_URL}user/mail/read_mail/{$v.mail_enc_id}/{$v.mail_enc_type}">{$v.mailtoussub}</a></div>
                              </div>  
                              {/if}
                          </li>
                        {$i=$i+1} 
                      {else}
                        {$id=$v.mailtousid} 

                        <li class="list-group-item clearfix b-l-3x b-l-info">
                          <span class="avatar thumb pull-left m-r">
                            <img src="{$SITE_URL}/uploads/images/profile_picture/mail_pro.png">
                          </span>
                          {if $v.type == "user" || $v.type == "admin"}
                            {$thread=$v.thread}
                            {$msg_id=$v.mailtousid}
                              <div class="pull-right text-sm text-muted">
                                <span class="hidden-xs "> {$v.mailtousdate}</span>
                                <button type="button" class="btn-link text-danger btn-md" onclick="javascript:deleteMessage('{$thread}', this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" data-original-title="Delete"><i class="fa fa-trash-o" ></i></button>
                              </div>
                              <div class="clear">
                                  <div><span  class="text-md ">{$v.from_user_name}</span><span class="label bg-primary m-l-sm ">{lang('new')}</span></div>
                                  <div class="text-ellipsis m-t-xs "><a href="{$BASE_URL}user/mail/read_mail/{$v.mail_enc_id}/{$v.mail_enc_type}/{$v.mail_enc_thread}">{$v.mailtoussub}</a></div>
                              </div>
                          {else}
                            {$msg_id=$v.mailtousid}
                              <div class="pull-right text-sm text-muted">
                                <span class="hidden-xs "> {$v.mailtousdate}</span>
                                <button type="button" class="btn-link text-danger btn-md" onclick="javascript:deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" data-original-title="Delete"><i class="fa fa-trash-o" ></i></button>
                              </div>
                              <div class="clear">
                                  <div><span  class="text-md ">{$v.from_user_name}</span><span class="label bg-primary m-l-sm ">{lang('new')}</span></div>
                                  <div class="text-ellipsis m-t-xs "><a href="{$BASE_URL}user/mail/read_mail/{$v.mail_enc_id}/{$v.mail_enc_type}">{$v.mailtoussub}</a></div>
                              </div>
                          {/if}  
                        </li>
                        {$i=$i+1}
                      {/if}
                  {/foreach}
              {else}
                <li class="list-group-item clearfix b-l-3x b-l-info">
                    <center>
                        {lang('You_have_no_mails_in_inbox')}  
                    </center>
                </li>
              {/if}
           </ul>
         {$result_per_page}
         <!-- / list -->
         </div>
        </div>
    </div>
       <style>
 ul.pagination {
    margin-top: 0px;
    float: right !important;
    margin-bottom: 51px;
}
</style>   
{/block}