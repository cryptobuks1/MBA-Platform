{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <span id="cmnt_msg" style="display:none">{lang('comment_added_successfully')}</span>
    <span id="err_msg" style="display:none">{lang('please_enter_comment')}</span>   
    <div class="panel panel-default table-responsive">
        <table st-table="rowCollectionBasic" class="table table-striped borderless">
            <tbody>
                <tr>
                    <td>Tracking ID</td>
                    <td>{$ticket['ticket_id']}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr >
                    <td>{lang('user_id')}</td>
                    <td>{$ticket['user']}</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr >
                    <td>{lang('subject')}</td>
                    <td>{$ticket['subject']}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>{lang('created_on')}</td>
                    <td>{$ticket['created_date']}</td>
                    <td> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>{lang('updated')}</td>
                    <td>{$ticket['updated_date']}</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>{lang('ticket_status')}</td>
                    <td><span id='status_name'>{$ticket['status']}</span></td>
                    <td style="text-align: right;"><label for="sel3">{lang('change_status_to')} </label></td>
                    <td>
                        <div class="form-group">
                            <select class="form-control btn-xs w-sm " id="sel3" onchange="changeStatus({$ticket['id']});">
                                <option value="" >{lang('click_to_select')}</option>
                                {foreach from=$ticket_status item=v}
                                    <option value="{$v.id}">{$v.status}</option>
                                {/foreach}
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>{lang('category')}</td>
                    <td><span id='category_name'>{$ticket['category']}</span></td>
                    <td style="text-align: right;"><label for="sel2">{lang('change_category_to')} </label></td>
                    <td>

                        <div class="form-group">
                            <select class="form-control btn-xs w-sm " id="sel2" onchange="changeCategory({$ticket['id']});">
                                <option value="">{lang('click_to_select')}</option>
                                {foreach from=$ticket_category item=v}
                                    <option value="{$v.id}">{$v.category_name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>{lang('priority')}</td>
                    <td><span id='priority_name'>{$ticket['priority']}</span></td>
                    <td style="text-align: right;"><label for="sel1">{lang('change_priority_to')} </label></td>
                    <td>
                        <div class="form-group">
                            <select class="form-control btn-xs w-sm" id="sel1" onchange="changePriority({$ticket['id']});">
                                <option value="">{lang('click_to_select')}</option>
                                {foreach from=$ticket_priority item=v}
                                    <option value="{$v.id}">{$v.priority}</option>
                                {/foreach}
                            </select>
                        </div>
                    </td>
                </tr>
                {if $MODULE_STATUS['employee_status'] == 'yes'}
                <tr>
                    <td>{lang('assignee')} </td>
                    <td><span id='assignee_name'> {$ticket['assignee']}</span></td>
                    <td style="text-align: right;"><label for="sel1">{lang('change_assignee_to')}</label></td>
                    <td>
                        <div class="form-group">
                            <select class="form-control btn-xs w-sm" id="sel4" onchange="changeAssignee({$ticket['id']});">
                                <option value="">{lang('click_to_select')}</option>
                                {foreach from=$employee_details item=v}
                                    <option value="{$v.user_id}">{$v.user_name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </td>
                </tr>
                {/if}
            </tbody>
            <tfoot> 
                <tr>
                    <td>{lang('tags')}:</td> 
                    <td colspan="1">
                        <input id="activate_tagator2" type="text" class="tagator form-control" value="{$ticket['tags']}" data-tagator-show-all-options-on-focus="true" data-tagator-autocomplete="{$ticket_tags}">
                    </td>  
                    <td>
                        <button class="btn btn-bricky btn-primary" id="btn-update" onclick='updateTags({$ticket['id']});'>{lang('update')}</button>
                        <span class="input-group-btn">
                        </span>
                    </td> 
                </tr>
            </tfoot>

        </table>
    </div>
    
    <div class="panel panel-default m-t">
        <div class="panel-body">
            <div class="row"> 
                <legend class="col-md-12">
                    <span class="fieldset-legend">
                        {lang('comment')}
                    </span>
                </legend>
            
                <div class="col-xs-6 col-md-6">                       
                    <div class="col-md-12 col-xs-12"  id="comments_box">
                        {foreach from=$ticket_comments item=v}
                            <div class="messages m-t-xs">
                                <p>{$v.comment}</p>
                            </div>
                        {/foreach}
                    </div>
                </div>
                <div class="col-sm-6"> 
                    <div class="input-group col-md-12 col-xs-12">
                        <textarea  id="comments" type="text" class="form-control input-sm chat_input" name='comments'></textarea>
                        <span id="added"></span>
                    </div>
                    <div class="input-group col-md-12 col-xs-12 m-t-sm">
                        <div data-provides="fileupload" class="fileupload fileupload-new">
                            <input type="hidden" id="base_url_id" value="{$BASE_URL}"/>
                            <button class="btn btn-bricky btn-primary pull-right" id="btn-addcomment" onclick='addComments({$ticket['id']});'>{lang('add')}</button>
                        </div>   
                    </div>
                </div>
            </div>
            <hr class="new_line">
            <div class="row"> 
                <legend class="col-md-12">
                    <span class="fieldset-legend">
                        {lang('reply')}
                    </span>
                </legend>
                <div class="col-xs-6 col-md-6">
                    <div class="msg_container_base">
                        {foreach from=$ticket_replies item=v}
                            {if $ticket['user_id']== $v.user_id}
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
                <div class="col-sm-6">
                    {form_open_multipart("admin/ticket_system/ticket/{$ticket['ticket_id']}", 'role="form" class=""  name="message" id="message" method="post" action="" enctype="multipart/form-data"')} 
                    <div class="panel-footer">
                        <div class="input-group col-md-12 col-xs-12">
                            <textarea  id="btn-input" type="text" class="form-control input-sm chat_input textfixed" name='message' id='message'>
                            </textarea>
                        </div>
                        <div class="input-group col-md-12 col-xs-12 m-t-sm">
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <span class="btn btn-file btn-primary ticket-upload-btn"><i class="fa fa-paperclip"></i> <span class="fileupload-new">{lang('attach_file')} </span><span class="fileupload-exists">{lang('change')}</span>
                                    <input type="file" id="upload_doc" name="upload_doc"  >
                                </span>
                                <span class="fileupload-preview"></span>
                                <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#"> ×
                                </a>
                                <button class="btn btn-bricky btn-info btn-right" type="submit" id="btn-chat" name="message_send"  id="message_send" value='ok'> {lang('send')}</button>
                                <span class="input-group-btn ">
                                </span>
                            </div>
                            <p>
                                <font color="#ff0000">{lang('kb')}({lang('allowed_types_are_gif_jpg_png_jpeg_jpg')})</font>
                            </p>    
                        </div>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>

{/block}
{block name=script}{$smarty.block.parent} 
<script>
    $(function () {
        var $input_tagator1 = $('#input_tagator1');
        var $activate_tagator1 = $('#activate_tagator1');
        $activate_tagator1.click(function () {
            if ($input_tagator1.data('tagator') === undefined) {
                $input_tagator1.tagator({
                    autocomplete: ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth'],
                    useDimmer: true
                });
                $activate_tagator1.val('destroy tagator');
            } else {
                $input_tagator1.tagator('destroy');
                $activate_tagator1.val('activate tagator');
            }
        });
        $activate_tagator1.trigger('click');
    });
</script>
{/block}