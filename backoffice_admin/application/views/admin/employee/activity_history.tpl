{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_enter_user_name')}</span>
</div> 
    
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open({$SHORT_URL},'role="form" class="" name="search_form" id="search_form"
            action="" method="post"')}
            <input type="hidden" id="search_member_error" value="{lang('search_member_error')}" />
            <input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}" />
            {* {include file="layout/error_box.tpl"} *}

            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="required" for="user_name">{lang('user_name')}</label>
                    <input class="form-control employee_autolist" type="text" id="user_name" name="user_name" autocomplete="Off">
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit"
                        name="search_member_submit">
                        {lang('search')}
                    </button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>
    
    {if $user_name}
        
            <div class="panel panel-default table-responsive ng-scope">
            <div class="panel-body">
            <legend><span class="fieldset-legend">{lang('activity_history')} : {$user_name}</span></legend>
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped" id="sample_1">
                        <thead>
                            <tr class="th">
                                <th>{lang('sl_no')}</th>
                                <th>{lang('username')}</th>
                                <th>{lang('activity')}</th>
                                <th>{lang('date')}</th>
                            </tr>
                        </thead>
                        {if $count>0}
                            <tbody>
                                {$i = 1}
                                {foreach from=$activity_details item=v}
                                    <tr>
                                        <td>{$i + $page_no}</td>
                                        <td>
                                            {if $v.user_name}
                                                {$v.user_name}
                                            {else}
                                                NA
                                            {/if}
                                        </td>
                                        <td>{$v.description}</td>
                                        <td>{$v.date}</td>
                                    </tr>
                                    {$i = $i + 1}
                                {/foreach}
                            </tbody>    
                        {else}
                            <tbody>
                                <tr><td colspan="13" align="center" ><h4 align="center">{lang('no_details_found')}</h4></td></tr>
                            </tbody>
                        {/if}
                </table>
                </div>
               
            </div>
        {$result_per_page}
    {/if}
{/block}