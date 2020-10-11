{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    {if $ticket_count>0}
        {form_open_multipart('', 'role="form" class=""  name="reply_user" id="reply_user" method="post" action="" enctype="multipart/form-data"')} 
        <div id="span_js_messages" style="display:none;">
            <span id="error_msg4">{lang('message_is_required')}</span>      
        </div>
        <input type="hidden" name="ticket_id" id="ticket_id" value="{$ticket_arr['ticket_id']}">
        <input type="hidden" name="row_id" id="row_id" value="{$ticket_arr['id']}">
        <p>
        <div class="button_back">
            <a class="btn m-b-xs btn-sm btn-info btn-addon" href="{$BASE_URL}user/ticket/ticket_system"><i class="fa fa-backward"></i>{lang('go_to_support_center')}</a>
            </div>
         
       
        <div class="panel panel-default">
         
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td>{lang('ticket_tracking_id')}</td>
                        <td>{$ticket_arr['ticket_id']}</td>
                    </tr>
                    <tr>
                        <td>{lang('ticket_status')}</td>
                        <td>
                            {if $ticket_arr['status_no']=='0'}<font color="#ff0000">{lang('new')}</font> [<a class="btn btn-xs btn-link panel-refresh" href="../markResolved/{$ticket_arr['id']}">{lang('marked_as_resolved')}</a>]
                            {else}
                                {$ticket_arr['status']}
                            {/if}
                        </td>
                    </tr>
                    <tr>
                        <td>{lang('created_on')}</td>
                        <td>{$ticket_arr['created_date']}</td>
                    </tr>
                    <tr>
                        <td>{lang('updated_date')}</td>
                        <td>{$ticket_arr['updated_date']}</td>
                    </tr>
                    <tr>
                        <td>{lang('last_replier')}</td>
                        <td>{$ticket_arr['lastreplier']}</td>
                    </tr>
                    <tr>
                        <td>{lang('category')}</td>
                        <td>{$ticket_arr['category']}</td>
                    </tr>
                    <tr>
                        <td>{lang('priority')}</td>
                        <td>{$ticket_arr['priority']}</td>
                    </tr>
                    {if $ticket_arr['attachments']!=''}
                        <tr>
                            <td>{lang('attachment')}</td>
                            <td class="ticket_img"><a href="{$SITE_URL}/uploads/images/ticket_system/{$ticket_arr['attachments']}" target="_blank"><img width="100" src="{$SITE_URL}/uploads/images/ticket_system/{$ticket_arr['attachments']}"></a></td>
                        </tr>
                    {/if}
                    {assign var=i value=1}
                    {assign var=clr value=""}
                    {assign var=id value=""}
                    {assign var=msg_id value=""}
                    {assign var=user_name value=""}
                </tbody>

            </table>
           

        </div>
        <div class="panel panel-default m-t">
            <div class="panel-body">
            <div class="row">            
            <div class="col-xs-6 col-md-6">
                <div class="msg_container_base">
                    {foreach from=$ticket_reply item=v}
                        {if $ticket_arr['user_id']== $v.user_id}
                            <div class="row msg_container base_receive ">
                                <div class="col-md-1 col-xs-1 avatar ">
                                    <img src='{$SITE_URL}/uploads/images/profile_picture/{$v.profile_pic}' class="img-responsive message-avatar">
                                </div>
                                <div class="col-md-10 col-xs-10">
                                    <div class="messages  msg_receive">
                                        <p>{$v.message}</p>
                                        {if $v.attachments }
                                            <a href="{$SITE_URL}/uploads/images/ticket_system/{$v.attachments}" target="_blank"><img src='{$SITE_URL}/uploads/images/ticket_system/{$v.attachments}' alt='' style="width: 35%;"></a>  
                                        {/if}
                                    </div>
                                </div>

                            </div>

                        {else}
                            <div class="row msg_container base_sent">
                                <div class="col-md-10 col-xs-10">
                                    <div class="messages  msg_sent">
                                        <p>{$v.message}</p>               
                                        {if $v.attachments }
                                            <a href="{$SITE_URL}/uploads/images/ticket_system/{$v.attachments}" target="_blank"><img src='{$SITE_URL}/uploads/images/ticket_system/{$v.attachments}' alt='' style="width: 35%;"></a>                                
                                            {/if}
                                    </div>
                                </div>
                                <div class="col-md-1 col-xs-1 avatar ">
                                    <img src='{$SITE_URL}/uploads/images/profile_picture/{$v.profile_pic}' class="img-responsive  message-avatar">
                                </div>
                            </div>
                        {/if}
                    {/foreach}
                </div>


            </div>
            <div class="col-xs-6 col-md-6">
                <form role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <textarea   type="text" class="form-control input-sm chat_input textfixed" name='message' id='message' placeholder="Message"></textarea>
                    </div>

                    <div class="form-group">
                        <div data-provides="fileupload" class="fileupload fileupload-new" style="margin-top: 1em;">
                            <span class="btn btn-file btn-light-grey" ><i class="fa fa-paperclip"></i>
                                <span class="fileupload-new">{lang('Attach file')} </span>
                                <span class="fileupload-exists">{lang('change')}</span>
                                <input type="file" id="upload_doc" name="upload_doc"  >
                            </span>
                            <span class="fileupload-preview"></span>
                            <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#"> ×
                            </a>
                        </div>
                        <p class="help-block m-b-none">
                            <font>{lang('kb')}({lang('allowed_types_are_gif_jpg_png_jpeg_jpg')})</font>
                        </p>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary" name="reply"  id="reply" value='reply'>{lang('submit_reply')}</button>
                </form>
                </div>
                </div>
            </div>
        </div>
        {form_close()}
    {/if}
{/block}