{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="confirm_msg1">{lang('sure_you_want_to_assign_ticket_to_another_person')}</span>
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
    </div>
    <div class="panel panel-default table-responsive">
    <div class="panel-body">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            {if $count>0}
                <thead>
                    <tr>
                        <th>{lang('sl_no')}</th>
                        <th>{lang('ticket_id')}</th>
                        <th>{lang('updated')}</th>
                        <th>{lang('user_id')}</th>
                        <th>{lang('subject')}</th>
                        <th>{lang('category')}</th>
                        <th>{lang('last_replier')}</th>
                        <th>{lang('assigned_to')}</th>
                    </tr>
                </thead>
                <tbody>
                    {assign var="i" value="0"}
                    {assign var="class" value=""}
                    {foreach from=$open_tickets item=v}
                        {if $i%2==0}
                            {$class='tr1'}
                        {else}
                            {$class='tr2'}
                        {/if}
                        <tr class="{$class}">
                            <td>{$i + 1 + $page}</td>
                            <td><a href="{$BASE_URL}admin/ticket/{$v.ticket_id}" ><span class="m-b-xs w-xs btn-warning">{$v.ticket_id}</span></a></td>
                            <td>{$v.updated}</td>
                            <td>{$v.name}</td>
                            <td> {$v.subject}</td>                                   
                            <td>{$v.category_name}</td>
                            <td>{$v.last_replier}</td>
                            <td>{$v.assignee_name}</td>
                        </tr>
                        {$i=$i+1}
                    {/foreach}
                {else} 
                <div style="text-align: center"><h3>{lang('no_open_tickets_found')}</h3></div>
                    {/if}
            </tbody>
        </table>
        </div>
    </div>
{$result_per_page}
{/block} 