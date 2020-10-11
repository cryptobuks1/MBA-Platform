{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="confirm_msg1">{lang('sure_you_want_to_assign_ticket_to_another_person')}</span>
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
    </div>
    {if $flag}
        <div class="panel panel-default">
            <div class="panel-body">
                <legend><span class="fieldset-legend"> {lang('assign_ticket')}</span></legend>
                {form_open('','role="form" class="" method="post" name="ticket_assign_form" id="ticket_assign_form"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>
                <div class="col-sm-3 padding_both">
                    <div class="form-group">
                        <label class="control-label" for="ticket_id">{lang('ticket_id')}<font color="#ff0000" >*</font> </label>
                        <input type="text" readonly name="ticket_id" id="ticket_id" size="20" value="{$ticket_id}" class="form-control" readonly/>
                    </div> 
                </div>

                <div class="col-sm-3 padding_both_small">
                    <div class="form-group">
                        <label class="control-label" for="employee">{lang('select_employee')}<font color="#ff0000" >*</font></label>
                        <input placeholder="Type employee name here" class="form-control" type="text" id="employee" name="employee" onKeyUp="ajax_showOptions(this, 'getCountriesByLetters', 'no', event)" autocomplete="Off" />
                        <span class="help-block" for="user_name"></span>
                    </div>
                </div>
                <div class="col-sm-3 padding_both_small">
                    <div class="form-group credit_debit_button">
                        <button class="btn btn-primary" type="submit" id="assign_employee" value="assign_employee" name="assign_employee">{lang('assign')}
                        </button>
                    </div>
                </div>
                {form_close()}   
            </div>
        </div>
    {/if}
    <div class="panel panel-default ">
    <div class="panel-body">
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
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
                    {assign var="class" value=""}
                    {foreach from=$open_tickets item=v}
                        {if $i%2==0}
                            {$class='tr1'}
                        {else}
                            {$class='tr2'}
                        {/if}
                        <tr class="{$class}" {*align="center"*} >
                            <td>{$i + $page + 1}</td>
                            <td><a href="{$BASE_URL}admin/ticket/{$v.ticket_id}" ><span class="btn-light-gray w-xs btn-light-grey m-b-xs">{$v.ticket_id}</span></a></td>
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
    </div>{$result_per_page}
{/block} 