
<div class="panel panel-default table-responsive">
    <div id="span_js_messages" style="display:none;">
        <span id="confirm_msg">{lang('Sure_you_want_to_Delete_There_is_NO_undo')}</span>
    </div>
    <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />
    <table  st-table="rowCollectionBasic" class="table table-bordered table-striped" id="sample-table-1">
        <thead class="table-bordered">
            <tr class="th">            
                <th>{lang('sl_no')}</th> 
                <th>{lang('ticket_id')}</th>
                <th>{lang('subject')}</th>
                <th>{lang('category')}</th>
                <th>{lang('status')}</th>
                <th>{lang('last_replier')}</th>
                <th>{lang('priority')}</th>
                <th>{lang('time_line')}</th>
            </tr>
        </thead>
        <tbody>
            {assign var=i value=$inbox_page}
            {assign var=id value=""}
            {if count($ticket_arr) > 0}
                {foreach from=$ticket_arr item=v}
                    {$id = $v.id}  
                    <tr>
                        <td>{$i+1}</td>
                        <td>
                            <a href="{$BASE_URL}user/ticket/view_ticket_details/{$v.ticket_id}" {if $v.read=='0'}style='color:#007AFF'{else}style='color:#C48189;'{/if}> {$v.ticket_id}</a>
                        </td>
                        <td>{$v.subject}</td>
                        <td>{$v.category}</td>
                        <td>{lang("`$v.status`")}</td>
                        <td>
                            {if $v.lastreplier}{$v.lastreplier}{else}NA{/if}
                        </td>
                        <td>{$v.priority_name}</td>
                        <td>
                            <a href="javascript:show_timeline_for_user('{$v.ticket_id}')" onclick=""  class="btn-link text-primary tooltips" data-placement="top" title="timeline"><i class="glyphicon glyphicon-fullscreen"></i>
                            </a>
                        </td>
                    </tr>
                    {$i=$i+1}	
                {/foreach}
            {else}
                <tbody><tr><td align="center" colspan="8"><b>{lang('you_have_no_mails_in_inbox')}</b></td></tr></tbody>
            {/if}
        </tbody>
    </table>
    {$result_per_page}
</div>

