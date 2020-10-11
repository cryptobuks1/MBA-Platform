{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg4">{lang('please_enter_any_keyword_like_pin_number_or_pin_id')}</span>
    <span id="err_msg_amount">{lang('you_must_select_an_amount')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        {form_open_multipart('admin/search_epin','role="form" class="smart-wizard" id="search_epin" name="search_epin"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('search_pin')}</label>
                <input class="form-control epin_autolist" type="text" name="keyword" id="keyword" value="" title="" autocomplete="off" />
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group mark_paid">
                <button class="btn btn-sm btn-primary" name="search_pin" id="search_pin" value="{lang('search_pin_numbers')}" type="submit">
            {lang('search')}
        </button>
            </div>
        </div>
        {form_close()}
    </div>
</div>
{if $epin_search_type == 'pin_number' && count($search_pin_details) > 0}
<div class="panel panel-default table-responsive">
 <div class="panel-body">
    {assign var="i" value=1}
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{lang('sl_no')}</th>
                <th>{lang('epin')}</th>
                <th>{lang('amount')}</th>
                <th>{lang('pin_balance_amount')}</th>
                <th>{lang('status')}</th>
                <th>{lang('allocated_user')}</th>
                <th>{lang('uploaded_date')}</th>
                <th>{lang('expiry_date')}</th>
                <th>{lang('action')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$search_pin_details item=v} {assign var="root" value="{$BASE_URL}admin/"} {if $v.status == "yes"} {if $v.pin_balance_amount == 0} {$status = lang('no_balance')} {elseif $v.used_user} {$status = lang('used')} {elseif $smarty.now|date_format:'%Y-%m-%d'
            > $v.pin_expiry_date|date_format:'%Y-%m-%d'} {$status = lang('expired')} {else} {$status = lang('active')} {/if} {elseif $v.pin_balance_amount == 0} {$status = lang('no_balance')} {elseif $smarty.now|date_format:'%Y-%m-%d' > $v.pin_expiry_date|date_format:'%Y-%m-%d'}
            {$status = lang('expired')} {elseif $v.used_user==""} {$status = lang('blocked')} {else} {$status = lang('used')} {/if}
            <tr>
                <td>{$i}</td>
                <td><span name="link{$i}" id="link{$i}" value="{$v.pin_number}">{$v.pin_number}</span></td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td>{$status}</td>
                <td>{if $v.allocated_user_name} {$v.allocated_user_name} {else} {lang('NA')} {/if} </td>
                <td>{$v.pin_uploaded_date}</td>
                <td>{$v.pin_expiry_date}</td>
                <td>
                    
                        <button class='btn-link has-tooltip text-primary' title="Copy" onclick="return copyEpinToClipboard(link{$i}, 'link{$i}')"><i class="fa fa-clipboard"></i></button>
                         
                    {if $v.status == "yes" && $v.purchase_status =="yes" && ($v.pin_balance_amount > 0)}
                    <!--refund option-->
                    {if DEMO_STATUS == 'yes' && $MODULE_STATUS['basic_demo_status'] == 'yes' && $is_preset_demo}
                    {else}
                        <button class='btn-link has-tooltip text-danger' title="Reload" onclick="refund_pin({$v.pin_id}, '{$root}')"><i class="icon-reload"></i></button>
                    {/if}
                    <!--refund option-->
                    {/if}
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
    </div>
</div>
{/if}
<div class="panel panel-default">
    <div class="panel-body">
        {form_open('admin/search_epin','role="form" class="" id="search_pin_amount" name="search_pin_amount" method="post"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('amount')}</label>
                <div>
                    <select class="form-control m-b" name="amount" id="amount">
                    <option value="">{lang('select_bal_amount')}</option>
                    {assign var=i value=0}
                    {foreach from=$amount_details item=v}
                        <option value="{$v.amount}" {if $v.amount == $amount} selected{/if}>{$DEFAULT_SYMBOL_LEFT}{$v.amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</option>
                        {$i = $i+1}
                    {/foreach}
                    <span class="val-error">{form_error('amount')}</span>
                </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group mark_paid">
                <button type="submit" class="btn btn-sm btn-primary" name="search_pin_pro" id="search_pin_pro" value="upload">{lang('search')}</button> {form_close()}
            </div>
        </div>
    </div>
</div>
{if $epin_search_type == 'pin_amount' && count($search_pin_details) > 0}
<div class=" panel panel-default ng-scope table-responsive">
 <div class="panel-body">
    {assign var="i" value=1}
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{lang('sl_no')}</th>
                <th>{lang('epin')}</th>
                <th>{lang('amount')}</th>
                <th>{lang('pin_balance_amount')}
                    <th>{lang('status')}
                        <th>{lang('allocated_user')}</th>
                        <th>{lang('uploaded_date')}</th>
                        <th>{lang('expiry_date')}</th>
                        <th>{lang('action')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$search_pin_details item=v} {assign var="root" value="{$BASE_URL}admin/"} {if $v.status == "yes"} {if $v.pin_balance_amount == 0} {$status = lang('no_balance')} {elseif $v.used_user} {$status = lang('used')} {elseif $smarty.now|date_format:'%Y-%m-%d'
            > $v.pin_expiry_date|date_format:'%Y-%m-%d'} {$status = lang('expired')} {else} {$status = lang('active')} {/if} {elseif $v.pin_balance_amount == 0} {$status = lang('no_balance')} {elseif $smarty.now|date_format:'%Y-%m-%d' > $v.pin_expiry_date|date_format:'%Y-%m-%d'}
            {$status = lang('expired')} {elseif $v.used_user==""} {$status = lang('blocked')} {else} {$status = lang('used')} {/if}
            <tr>
                <td>{$i + $page}</td>
                <td><span name="link{$i}" id="link{$i}" value="{$v.pin_number}">{$v.pin_number}</td>
        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT} </td>
        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT} </td>
        <td>{$status}</td>
        <td>{if $v.allocated_user_id}
            {$v.allocated_user_id}
            {else}
            {lang('NA')}
            {/if} </td>
        <td>{$v.pin_uploaded_date}</td>
        <td>{$v.pin_expiry_date}</td>
        <td>
            <button class='btn-link has-tooltip text-primary' title="Copy" onclick="return copyEpinToClipboard(link{$i}, 'link{$i}')"><i class="fa fa-clipboard"></i></button>
                
            {if $v.status == "yes" && $v.purchase_status =="yes" && ($v.pin_balance_amount > 0)}
            <!--refund option-->
            {if DEMO_STATUS == 'yes' && $MODULE_STATUS['basic_demo_status'] == 'yes' && $is_preset_demo}
            {else} 
                <button class='btn-link has-tooltip text-danger' title="{lang('refund')}" onclick="refund_pin({$v.pin_id}, '{$root}')"><i class="icon-reload"></i></button>
            {/if}
            <!--refund option-->
            {/if}
        </td>
</tr>
{$i = $i + 1} {/foreach}
</tbody>
</table>
</div>
{$result_per_page}</div> {/if} {/block} {block name=script} {$smarty.block.parent}
<script>
    jQuery(document).ready(function() {
        ValidateUser.init();
    });
</script>
<script src="{$PUBLIC_URL}javascript/copy_to_clip_board.js" type="text/javascript"></script>
<script src="{$PUBLIC_URL}javascript/misc.js" type="text/javascript"></script>
{/block}