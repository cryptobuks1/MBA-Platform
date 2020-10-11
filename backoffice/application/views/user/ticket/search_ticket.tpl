
{form_open_multipart('user/ticket_system', 'role="form" class=""  name="compose" id="view_ticket_form" method="post" action="" enctype="multipart/form-data"')}
<input type="hidden" name="active_tab" id="active_tab" value="tab5" >
<div class="col-sm-3 padding_both">
    <div class="form-group">
        <label>{lang('category')}</label>
        <select name="category" type="text" id="category" class="form-control" >
            <option value="">{lang('select_category')}</option>
            {foreach from=$category_arr item=v}
                <option value="{$v.id}">{$v.category_name}</option>
            {/foreach}
        </select>
    </div>
</div>
<div class="col-sm-3 padding_both_small">
    <div class="form-group">
        <label>{lang('priority')} </label>
        <select name="priority" id="priority" type="text" class="form-control" tabindex="2"> 
            <option value="">{lang('select_priority')}</option>
            {foreach from=$ticket_priority item=v}
                <option value="{$v.id}">{$v.priority}</option>
            {/foreach}
        </select>  
    </div>
</div>
<div class="col-sm-3 padding_both_small">
    <div class="form-group">
        <label>{lang('status')} </label>
        <select name="status" id="status" type="text" class="form-control" tabindex="3"> 
            <option value="">{lang('select_status')}</option>
            {foreach from=$status_arr item=v}
                <option value="{$v.id}">{$v.status}</option>
            {/foreach}

        </select> 
    </div>
</div>
<div class="col-sm-3 padding_both_small">
    <div class="form-group  mark_paid">
        <button class="btn btn-primary" type="submit" id="view2" value="search" name="search" tabindex="4">{lang('search')}</button>
    </div>
</div>
{form_close()}

{if $search_flag}
    <legend><span class="fieldset-legend">{lang('tickets')}</span></legend>
    <div class="panel panel-default table-responsive">
        <div id="span_js_messages" style="display:none;">
            <span id="confirm_msg1">{lang('sure_you_want_to_reopen_ticket')}</span>
            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
        </div>
        <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped" id="sample-table-1">
            <thead>
                <tr class="th">            
                    <th>{lang('sl_no')}</th> 
                    <th>{lang('ticket_id')}</th>
                    <th>{lang('subject')}</th>
                    <th>{lang('category')}</th>
                    <th>{lang('status')}</th>
                    <th>{lang('last_replier')}</th>
                    <th>{lang('priority')}</th>
                    <th>{lang('reopen')}</th>
                    <th>{lang('time_line')}</th>

                </tr>
            </thead>
            <tbody>
                {assign var=i value=1}
                {assign var=clr value=""}
                {assign var=id value=""}
                {assign var=msg_id value=""}
                {assign var=user_name value=""}
                {if $searched_ticket_count > 0}
                    {foreach from=$searched_tickets item=v}
                        {$id = $v.id}  
                        {$ticket_id = $v.ticket_id}  
                        <tr>
                            <td>
                                {$i}
                            </td>
                            <td>
                                <a href="{$BASE_URL}user/ticket/view_ticket_details/{$v.ticket_id}" style="color:#C48189;"> {$v.ticket_id}</a>
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
                        {if $v.status=="Resolved"}
                            <td>
                                <a href="javascript:reopen_ticket('{$ticket_id}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="Reopen"><i class="fa fa-edit"></i></a>
                            </td>
                        {else}
                            <td></td>
                        {/if}
                        <td><a href="javascript:show_timeline_for_user('{$v.ticket_id}')" onclick=""  class="btn-link h4 text-primary" data-placement="top" title="timeline"><i class="glyphicon glyphicon-fullscreen"></i>
                            </a>
                        </td>
                    </tr>
                    {$i=$i+1}	
                {/foreach}
            {else}
                <tbody><tr><td align="center" colspan="8">
                        <b>{lang('no_ticket_found')}</b></td></tr></tbody>
            {/if}
        </tbody>
    </table>
    {*  {$result_per_page}*}
</div>
{/if}