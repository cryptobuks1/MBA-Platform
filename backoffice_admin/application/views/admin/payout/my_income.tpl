{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" class="no-display">
    <span id="error_msg">{lang('you_must_enter_user_name')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>

<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>

{include file="layout/search_member.tpl"}

{if $valid_user}
    <div id="user_account"></div>
    <div id="username_val" style="display:none;">{$user_name}</div>

   

    <div class="panel panel-default">
    <div class="panel-body">
     <legend>
        <span class="fieldset-legend">{lang('released_income')}: {$user_name}</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('paid_date')}</th>
                    <th>{lang('paid_amount')}</th>
                    <th>{lang('status')}</th>
                </tr>
            </thead>
            {if count($income_statement)>0}
                <tbody>
                    {assign var=i value="0"}
                    {foreach from=$income_statement item=v}
                        {$i = $i+1}
                        <tr>
                            <td>{$i+$page_id}</td>
                            <td>{$v.paid_date}</td>
                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.paid_amount*$DEFAULT_CURRENCY_VALUE, $PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                            <td>{lang(ucfirst($v.paid_type))}</td>
                        </tr>
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr>
                        <td colspan="8">
                            <h4>{lang('no_income_found')}</h4>
                        </td>
                    </tr>
                </tbody>
            {/if}
        </table>
        </div>
        </div>
    </div>
    {$result_per_page}
{/if}


{/block}