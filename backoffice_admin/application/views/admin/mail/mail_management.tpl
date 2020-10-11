{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg">{lang('Sure_you_want_to_Delete_There_is_NO_undo')}</span>
</div>

    <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />
    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
        {include file="admin/mail/mail_header.tpl"  name=""}
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
            <ul class="list-group list-group-lg no-radius   m-t-n-xxs">
              {assign var=i value=0}
              {assign var=clr value=""}
              {assign var=id value=""}
              {assign var=msg_id value=""}
              {assign var=user_name value=""}
              {assign var=msg_tid value=""}
              {if $cnt_adminmsgs > 0}
              {foreach from=$adminmsgs item=v}
                      {if $v.type == 'contact'}
                          {$msg_tid = $v.id}
                      {else}
                          {$msg_tid = $v.thread}
                      {/if}
                      {if $v.read_msg=='yes'}
                          {$id = $v.id}     
                          {$user_name = $v.user_name}  

                      <li class="list-group-item clearfix b-l-3x b-l-info">
                          <span class="avatar thumb pull-left m-r"> 
                            <img src="{$SITE_URL}/uploads/images/profile_picture/mail_pro.png">
                          </span>
                          {$msg_id=$v.id}
                          <div class="pull-right text-sm text-muted">
                            <span class="hidden-xs ">{$v.mailadiddate}</span>
                            <button type="button" class="btn-link text-danger" onclick="javascript:deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}admin')"><i class="fa fa-trash-o" ></i></button>
                          </div>
                          <div class="clear">
                            <div><span  class="text-md ">{$user_name}</span></div>
                            <div class="text-ellipsis m-t-xs ">
                                <a href="{$BASE_URL}admin/mail/read_mail/{$v.mail_enc_id}/{$v.mail_enc_type}">{$v.mailadsubject}</a></div>
                          </div>      
                      </li>

                      {else}
                      {$id=$v.id} 
                      {$user_name = $v.user_name}

                      <li class="list-group-item clearfix b-l-3x b-l-info">
                          <span class="avatar thumb pull-left m-r">
                            <img src="{$SITE_URL}/uploads/images/profile_picture/mail_pro.png">
                          </span>
                          {$msg_id=$v.id}
                          <div class="pull-right text-sm text-muted">
                            <span class="hidden-xs "> {$v.mailadiddate}</span>
                            <button type="button" class="btn-link  text-danger" onclick="javascript:deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}admin')" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                          </div>
                          <div class="clear">
                              <div><span  class="text-md ">{$user_name}</span><span class="label bg-primary m-l-sm ">{lang('new')}</span></div>
                            <div class="text-ellipsis m-t-xs "><a href="{$BASE_URL}admin/mail/read_mail/{$v.mail_enc_id}/{$v.mail_enc_type}">{$v.mailadsubject}</a></div>
                          </div>      
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
            <!-- / list -->
          {$result_per_page}
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