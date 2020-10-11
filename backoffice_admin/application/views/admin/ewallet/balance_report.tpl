{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
        <span id="errmsg">{lang('You_must_enter_keyword_to_search')}</span>
</div>
<div class="panel panel-default">
    <div class="panel-body ">
        {form_open('admin/balance_report','role="form" class="" method="post"  name="search_mem" id="search_mem"')}
        <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
        <div class="col-sm-6 padding_both">
        <div class="form-group">
            <label>{lang('keyword')}</label>
            <input class="form-control" placeholder="{lang('Username_Name_Sponsor')}.." type="text" name="keyword" id="keyword" autocomplete="Off">
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group mark_paid">
                <button class="btn btn-sm btn-primary " type="submit" name="search_member" id="search_member" value="{lang('search_member')}">{lang('search')}</button>

                <button class="btn btn-sm btn-primary " formnovalidate="formnovalidate" type="submit" name="reset" id="reset" value="{lang('clear')}">{lang('clear')}</button>
            </div>
        </div>
        {form_close()}
    </div>
</div>
<div class="panel panel-default table-responsive">
    <div class="panel-body">
        <input type="hidden" id="search_key" value="{$search_key}">
        <div id="overall" class="table-responsive hide show">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{lang('slno')}</th>
                        <th>{lang('user_name')}</th>
                        <th>{lang('name')}</th>
                        <th>{lang('sponsor_user_name')}</th>
                        <th>{lang('ewallet_balance')}</th>
                    </tr>
                </thead>
                {if count($report_data)>0}
                    {assign var="i" value=0}
                    <tbody>
                        {foreach from=$report_data item=v}

                        <tr>
                        <td>{$i + $page_id + 1}</td>
                        <td>{$v.user_name}</td>
                        <td>{$v.full_name}</td>
                            {if $v.sponsor_name}
                                <td>{$v.sponsor_name}</td>
                            {else}
                                <td>NA</td>
                            {/if}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        </tr>
                        {$i=$i+1}
                        {/foreach}
                    </tbody>
                {else}
                    <tbody>
                        <tr><td colspan="8" align="center"><h4 align="center"> {lang('No_User_Found')}</h4></td></tr>
                    </tbody>
                {/if}
            </table>

        </div>
        {$result_per_page}

    </div>
</div>
{/block}
{block name=script}
{$smarty.block.parent}
<script src="{$PUBLIC_URL}javascript/validate_member.js" type="text/javascript"></script>
<script>
    $(function () {
        ValidateMember.init();
        highlightSearchKey('{$search_key}');
    });
</script>
{/block}