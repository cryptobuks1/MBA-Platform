{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;"> 
        <span id="error_msg1">{lang('you_must_enter_search_query')}</span>   
        <span id="error_msg2">{lang('please_provide_either_category_tags')}</span>   
    </div>
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend">{lang('view_tickets')}</span></legend>
                {form_open_multipart('admin/view_ticket', 'role="form" class="" name="show_ticket" id="show_ticket" enctype="multipart/form-data"')}
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label>{lang('category')}</label>
                    <select name="category_name" id="category_name" class="form-control">
                        <option value="">{lang('select_category')}</option>
                        {foreach from=$category item=v}

                            <option value="{$v.id}">{$v.category_name}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('tags')}</label>
                    <select name="tag-name" id="tag_name" class="form-control ">
                        <option value="">{lang('select_tag')}</option>
                        {foreach from=$tags item=v}
                            <option value="{$v.tag}">{$v.tag}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <input name="submit_category" type="submit" id="submit_category" value="{lang('show')}" class="btn btn-sm btn-primary"  />
                </div>
            </div>
            {form_close()}
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend">{lang('find_ticket')}</span></legend>
                {form_open('admin/view_ticket','role="form" class="" method="post" name="search_ticket_form" id="search_ticket_form" enctype="multipart/form-data"')}
            <div class="col-md-12">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-times-sign"></i> {lang('errors_check')}
                </div>
            </div>
            <div class="form-group">
                <label>{lang('search_for')}</label>
                <input type="text" name="search_text" id="search_text" class="form-control">
            </div>
            <div class="form-group">
                <label>{lang('search_in')}  </label>
                <select name="search_item" id="search_item" class="form-control">
                    <option value="ticket_id">{lang('ticket_id')}</option>
                    <option value="name">{lang('user_id')}</option>
                    <option value="assignee_name">{lang('assignee')}</option>
                    <option value="subject">{lang('subject')}</option>
                </select>
            </div>
            <div class="form-group">
            <a style="color:#1c486d;" role="menuitem" name="more_option" id="more_option" href="javascript:show_more()" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> More</a> 
            <a role="menuitem"  href="javascript:show_less()" name="less_option" id="less_option" style="display: none;" class="btn btn-sm btn-info"><i class="fa fa-minus"></i> Less </a>
            </div>
            <div id="more_search_type" style="display:none;">
                <div class="form-group">
                    <label>{lang('category_name')}</label>
                    <select name="tckt_category" id="tckt_category" class="form-control">
                        <option value="">{lang('select_category')}</option>
                        {foreach from=$category item=v}

                            <option value="{$v.id}">{$v.category_name}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="form-group">
                    <label>{lang('date')}</label>
                    <div class="input-group">
                        <input autocomplete="off" class="form-control date-picker"  name="week_date" id="week_date" type="text" size="20" maxlength="10"  value="" autocomplete="off"></div>
                </div>
                <div class="form-group">
                    <label class=" control-label">{lang('search_within')} :</label>
                    <label class="checkbox-inline i-checks">
                        <div class="radio">
                            <label class="i-checks i-checks-sm">
                                <input type="checkbox"  value="1" name="s_my" id="s_my">
                                <i></i> {lang('assigned_to_me')} </label>
                        </div>
                    </label>
                    <label class="checkbox-inline i-checks">
                        <div class="radio">
                            <label class="i-checks i-checks-sm">
                                <input type="checkbox"  value="1" name="s_ot" id="s_ot">
                                <i></i>{lang('assigned_to_others')}</label>
                        </div>
                    </label>
                    <label class="checkbox-inline i-checks">
                        <div class="radio">
                            <label class="i-checks i-checks-sm">
                                <input type="checkbox"  value="1" name="s_un" id="s_un">
                                <i></i> {lang('unassingned_tickets')}  </label>
                        </div>
                    </label>
                    <label class="checkbox-inline i-checks">
                        <div class="radio">
                            <label class="i-checks i-checks-sm">
                                <input type="checkbox" value="1" name="archive" id="archive">
                                <i></i>{lang('only_tagged_tickets')}</label>
                        </div>
                    </label>
                </div>
            </div>
            <div class="form-group mark_paid">
                <button type="submit" class="btn btn-sm btn-primary"  name="search_tickets" type="submit" id="search_tickets"  value="{lang('search')}" >{lang('search')}</button>
            </div>         
            {form_close()}
        </div>
    </div>
    
    <div class="panel panel-default table-responsive">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{if isset($panel_title)} {$panel_title}{else}{lang('open_tickets')}{/if}</span></legend>
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            {if ($count > 0)}
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
                <tbody>
                    {assign var="i" value="0"}
                    {assign var="class" value=""}
                    {foreach from=$tickets item=v}
                        {if $i%2==0}
                            {$class='tr1'}
                        {else}
                            {$class='tr2'}
                        {/if}
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
                            <td><a href="javascript:show_timeline('{$v.ticket_id}')" onclick=""  class="btn-link text-primary tooltips" data-placement="top" title="{lang('timeline')}"><i class="glyphicon glyphicon-fullscreen"></i>
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
{block name=script}{$smarty.block.parent} 
    <script src="{$PUBLIC_URL}/javascript/misc.js" type="text/javascript"></script>
{/block}