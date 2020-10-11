{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" class="no-display">
    <span id="error_msg1">{lang('you_must_enter_count')}</span>        
    <span id="error_msg2">{lang('you_must_enter_user_name')}</span>        
    <span id="error_msg3">{lang('you_must_select_a_product_name')}</span>        
    <span id="error_msg4">{lang('please_type_your_time_to_call')}</span>                  
    <span id="error_msg5">{lang('please_type_your_e_mail_id')}</span>
    <span id="error_msg">{lang('please_enter_your_company_name')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>

{include file="layout/search_member.tpl"}

{if isset($user_name) && $is_valid_username}
    <div id="user_account"></div>
    <div id="username_val" style="display:none;">{$user_name}</div>
    
   

    <div class="panel panel-default">
    <div class="panel-body">
     <legend>
        <span class="fieldset-legend">{lang('user_wise_epin')}: {$user_name}</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('epin')}</th>
                    <th>{lang('amount')}</th>
                    <th>{lang('balance_amount')}</th>
                    <th>{lang('status')}</th>
                    <th>{lang('uploaded_date')}</th>
                    <th>{lang('expiry_date')}</th>
                    <th>{lang('delete')}</th>
                </tr>
            </thead>
            {assign var="root" value="{$root}"}
            {if count($pin_arr)>0}
                <tbody>
                    {assign var=i value="0"}
                    {foreach from=$pin_arr item=v}
                        {$i = $i+1}
                        <tr>
                            <td>{$i+$page_id}</td>
                            <td>{$v.pin_numbers}</td>
                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                            <td>{$status}</td>
                            <td>{$v.pin_uploded_date}</td>
                            <td>{$v.expiry_date}</td>
                            <td class="ipad_button_table">
                                <div class="field">
                                    <button class="has-tooltip btn btn_size text-danger btn-link" onclick="delete_pin_admin({$v.id},'{$root}')">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    <span class="tooltip green">
                                        <p>{lang('delete')}</p>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr>
                        <td colspan="8">
                            <h4>{lang('no_data')}</h4>
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

<span class="no-display" id="error_msg6">{lang('sure_you_want_to_delete_this_passcode_there_is_no_undo')}</span>

{/block}