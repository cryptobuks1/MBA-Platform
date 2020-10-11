l{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="validate_msg1">{lang('enter_subject')}</span>
    <span id="validate_msg2">{lang('enter_message')}</span>
</div>

{* <div class="b wrapper m-b-sm panel">
    <p>{lang('note_invite_banner_config')}</p>
</div> *}

        {form_open('admin/add_text_invite','role="form" class="smart-wizard" method="post"  name="" id=""')}
            <div class="form-group">
                <button class="btn btn-sm btn-primary btn-addon" type="submit"  value="Update" name="" id="" ><i class="fa fa-plus"></i>{lang('add_text_invite')}</button>
            </div>
        {form_close()}

    {if count($mail_data)>0}
    {assign var="i" value="0"}
    {assign var="class" value=""}
    {foreach from=$mail_data item=v}
         <div class="panel panel-default">
            <div class="panel-body">
              <h4 class="text-center">{$v.subject}</h4>
                <hr>
                <div class="col-sm-12 padding_both">
                <div class="form-group">
                     <label><i class="fa fa-calendar"></i> {$v.uploaded_date}</label>
                     <textarea class="form-control textarea_height_fix" disabled="" id="text{$v.id}" name="mail_content">{if $MODULE_STATUS['replicated_site_status'] == "yes"}<a href="{$REPLICATION_URL}/{$LOG_USER_NAME}"> {else} <a href="{$BASE_URL}"> {/if}{$v.content} </a></textarea>
                </div>
                </div>
                <div class="col-sm-8 padding_both_small">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary text_inv" id="{$v.id}">{lang('copy')}</button>
                    </div>
                </div>
                <div class="col-sm-4 text-right">
                    {form_open('admin/member/delete_invite_text', 'method="post" class="smart-wizard inline"')}
                        <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                        <button class="btn btn-danger" type='submit'  id='delete'  name='delete' value="delete"><i class="fa fa-trash-o"></i></button>
                    {form_close()}
                    {form_open('admin/edit_invite_text','method="post" class="smart-wizard inline"')}
                        <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                        <button class="btn btn-info" type='submit' id='edit' name='edit' value="edit"><i class="fa fa-edit"></i></button>
                    {form_close()}
                </div>
            </div>
         </div>
    {/foreach}
    {else}
    <div class="b wrapper m-b-sm panel">
        <h4 align="center">{lang('no_data')}</h4>
    </div>
    {/if}
    {$result_per_page}
{/block}
