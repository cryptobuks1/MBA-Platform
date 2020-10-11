{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" class="no-display">
    <span id="error_msg">{lang('you_must_enter_user_name')}</span>
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
        <span class="fieldset-legend">{lang('binary_details')}: {$user_name}</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('userid_fullname')}</th>
                    <th>{lang('left_point')}</th>
                    <th>{lang('right_point')}</th>
                    <th>{lang('left_carry')}</th>
                    <th>{lang('right_carry')}</th>
                    <th>{lang('total_pair')}</th>
                    <th>{lang('amount')}</th>
                </tr>
            </thead>
            {if count($user_leg_detail)>0}
                <tbody>
                    {assign var="left_leg_tot" value ="0"}
                    {assign var="right_leg_tot" value ="0"}
                    {assign var="left_carry_tot" value ="0"}
                    {assign var="right_carry_tot" value ="0"}
                    {assign var="total_leg_tot" value ="0"}
                    {assign var="total_leg_tot" value ="0"}
                    {assign var="total_amount_tot" value ="0"}
                    {assign var=i value="0"}
                    {foreach from=$user_leg_detail item=v}
                        {assign var="left" value ="{$v.left}"}
                        {assign var="right" value ="{$v.right}"}
                        {assign var="left_carry" value ="{$v.left_carry}"}
                        {assign var="right_carry" value ="{$v.right_carry}"}
                        {assign var="tot_leg" value ="{$v.total_leg}"}
                        {assign var="tot_amt" value ="{$v.total_amount}"}
                        {$left_leg_tot = $left_leg_tot+$left}
                        {$right_leg_tot = $right_leg_tot+$right}
                        {$left_carry_tot = $left_carry_tot+$left_carry}
                        {$right_carry_tot = $right_carry_tot+$right_carry}
                        {$total_leg_tot = $total_leg_tot+$tot_leg}
                        {$total_amount_tot =$total_amount_tot+ $tot_amt}
                        {$i = $i+1}
                        <tr>
                            <td>{$i+$page_id}</td>
                            <td>{$v.user}-{$v.detail}</td>
                            <td>{$left}</td>
                            <td>{$right}</td>
                            <td>{$left_carry}</td>
                            <td>{$right_carry}</td>
                            <td>{$tot_leg}</td>
                            <td>{$DEFAULT_SYMBOL_LEFT}{round($tot_amt*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        </tr>
                    {/foreach}
                    
                    <td colspan="2" class="text-right"><b>{lang('total')}</b></td>
                    <td><b>{$left_leg_tot}</b></td>
                    <td><b>{$right_leg_tot}</b></td>
                    <td><b>{$left_carry_tot}</b></td>
                    <td><b>{$right_carry_tot}</b></td>
                    <td><b>{$total_leg_tot}</b></td>
                    <td><b>{$DEFAULT_SYMBOL_LEFT}{round($total_amount_tot*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                </tbody>
            {else}
                {if $is_valid_username}
                    <tbody>
                        <tr>
                            <td colspan="8">
                                <h4>{lang('no_referels')}</h4>
                            </td>
                        </tr>
                    </tbody>
                {else}
                    <tbody>
                        <tr>
                            <td colspan="8">
                                <h4>{lang('Username_not_Exists')}</h4>
                            </td>
                        </tr>
                    </tbody>
                {/if}
            {/if}
        </table>
        </div>
        </div>
    </div>
    {$result_per_page}
{/if}

{/block}