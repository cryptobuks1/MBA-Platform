<div class="panel panel-default table-responsive">

    <div id="span_js_messages" style="display:none;">
        <span id="confirm_msg1">{lang('sure_you_want_to_reopen_ticket')}</span>
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
    </div>
    <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />

    <table  cst-table="rowCollectionBasic" class="table table-bordered table-striped" id="sample-table-1">

        <thead class="table-bordered">
            <tr class="th">            
                <th>{lang('sl_no')}</th> 
                <th>{lang('ticket_id')}</th>
                <th>{lang('subject')}</th>
                <th>{lang('category')}</th>
                <th>{lang('ticket_status')}</th>
                <th>{lang('last_replier')}</th>
                <th>{lang('priority')}</th>
                <th>{lang('time_line')}</th>
            </tr>
        </thead>
        <tbody>
            {assign var=i value=1}
            {assign var=clr value=""}
            {assign var=id value=""}
            {assign var=msg_id value=""}
            {assign var=user_name value=""}
            {if count($resolved_tickets) > 0}

                {foreach from=$resolved_tickets item=v}

                    {$id = $v.id}  
                    {$ticket_id = $v.ticket_id}  

                    <tr>
                        <td>{$i} </td>
                        {*                                    <td>{$i + $resolved_page} </td>*}
                        <td>
                            <a href="{$BASE_URL}user/ticket/view_ticket_details/{$v.ticket_id}" {if $v.read=='0'}style='color:#007AFF'{else}style='color:#C48189;'{/if}> {$v.ticket_id}</a>
                        </td>
                        <td>
                            {$v.subject}
                        </td>
                        <td>
                            {$v.category}
                        </td>
                        <td>
                            {$v.status}
                        </td>

                        <td>
                            {if $v.lastreplier}{$v.lastreplier}{else}NA{/if}
                        </td>
                        <td>
                            {$v.priority_name}
                        </td>
                        <td><a href="javascript:show_timeline_for_user('{$v.ticket_id}')" onclick=""  class="btn btn-primary tooltips" data-placement="top" title="timeline"><i class="glyphicon glyphicon-fullscreen"></i></a></td>
                </tr>

                {$i=$i+1}	
            {/foreach}
            {else}
            <tbody><tr><td align="center" colspan="8">{lang('no_resolved_tickets_found')}</td></tr></tbody>
            {/if}
        </tbody>
    </table>
</div>
