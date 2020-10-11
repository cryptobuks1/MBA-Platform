{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div class="panel">
       <div class="panel-body">
       
       <legend><span class="fieldset-legend">{$ticket_type}</span></legend>
    <div class="panel panel-default table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped" id="sample_1">
            {if $count>0}
                <thead>
                    <tr>
                       <th>{lang('sl_no')}</th>
                        <th>{lang('ticket_id')}</th>
                        <th>{lang('updated')}</th>
                        <th>{lang('user_id')}</th>
                        <th>{lang('subject')}</th>
                        <th>{lang('status')}</th>
                        <th>{lang('category')}</th>
                        <th>{lang('last_replier')}</th>
                        <th>{lang('assigned_to')}</th>
                    </tr>
                </thead>
                <tbody>
                {assign var="i" value="0"}
                {foreach from=$open_tickets item=v}
                        <tr>
                            <td>{$i + $page + 1}</td>
                            <td><a href="{$BASE_URL}admin/ticket_system/ticket/{$v.ticket_id}" ><span class="btn-light-gray w-xs btn-light-grey m-b-xs">{$v.ticket_id}</span></a></td>
                            <td>{$v.updated}</td>
                            <td>{$v.name}</td>
                            <td> {$v.subject}</td>
                            <td>{$v.status}</td>
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
    </div>
    {$result_per_page}    
{/block} 