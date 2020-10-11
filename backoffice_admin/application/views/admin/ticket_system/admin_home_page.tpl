{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="row">
        <div class="col-sm-3">
            <a href="{$BASE_URL}admin/tickets/all" target="_blank">
                <div class="card mb-4 bg-primary">
                    <div class="card-body">
                        <div class="media d-flex align-items-center ">
                            <div class="mr-4 rounded-circle bg-white sr-icon-box text-purple"> <i class="fa fa-ticket"></i> </div>
                            <div class="text-light">
                                <h4 class="text-uppercase mb-0 weight500">{lang('total_tickets')}</h4>
                                <span>{$total_ticket}</span> </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class=" col-sm-3">
            <a href="{$BASE_URL}admin/tickets/progress" target="_blank">
                <div class="card mb-4 bg-info">
                    <div class="card-body">
                        <div class="media d-flex align-items-center">
                            <div class="mr-4 rounded-circle bg-white  sr-icon-box text-primary"> <i class="fa fa-file-excel-o"></i> </div>
                            <div class=" text-white">
                                <h4 class="text-uppercase mb-0 weight500">{lang('in_progress')}</h4>
                                <span>{$inprogress_ticket}</span> </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class=" col-sm-3">
            <a href="{$BASE_URL}admin/tickets/critical" target="_blank">
                <div class="card mb-4 bg-primary">
                    <div class="card-body">
                        <div class="media d-flex align-items-center">
                            <div class="mr-4 rounded-circle bg-white sr-icon-box text-danger"> <i class="fa fa-file-o"></i> </div>
                            <div class="text-white">
                                <h4 class="text-uppercase mb-0 weight500">{lang('critical')}</h4>
                                <span>{$critical_ticket}</span> </div>
                        </div>
                    </div>
                </div>
           </a>
        </div>
        <div class="col-sm-3">
           <a href="{$BASE_URL}admin/tickets/new" target="_blank">
                <div class="card mb-4 bg-info">
                    <div class="card-body">
                        <div class="media d-flex align-items-center">
                            <div class="mr-4 rounded-circle bg-white sr-icon-box text-success"> <i class="fa fa-file-text-o"></i> </div>
                            <div class="text-white">
                                <h4 class="text-uppercase mb-0 weight500">{lang('new_ticket')}</h4>
                                <span>{$new_ticket}</span> </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">

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
                        <th>{lang('status')}</th>
                        <th>{lang('category')}</th>
                        <th>{lang('last_replier')}</th>
                        <th>{lang('priority')}</th>
                        <th>{lang('timeline')}</th>
                    </tr>
                </thead>
                {assign var="i" value="0"}
                {assign var="class" value=""}
                {foreach from=$tickets item=v}
                    {if $i%2==0}
                        {$class='tr1'}
                    {else}
                        {$class='tr2'}
                    {/if}
                    <tbody>
                        <tr class="{$class}"  >
                            <td>{$i + $page + 1}</td>

                            <td><a href="ticket/{$v.ticket_id}" {if $v.read=='0'}style='color:#007AFF'{else}style='color:#C48189;'{/if}> {$v.ticket_id}</a></td>
                            <td>{$v.updated}</td>
                            <td>{$v.name}</td>
                            <td>{$v.subject}</td>
                            <td>{$v.status}</td>
                            <td>{$v.category_name}</td>
                            <td>{$v.last_replier}</td>
                            <td>
                                {$v.priority_name} 
                            </td>
                            <td><a href="javascript:show_timeline('{$v.ticket_id}')" onclick=""  class="btn-link text-primary" data-placement="top" title="{lang('timeline')}"><i class="glyphicon glyphicon-fullscreen"></i>
                                </a></td>
                        </tr>
                        {$i=$i+1}
                    {/foreach}
                {else} 
                <div style="text-align: center">  <h3>{lang('no_ticket_found')}</h3></div>
            {/if}
            </tbody>
        </table>
        </div>
    </div>
    {$result_per_page}
{/block}