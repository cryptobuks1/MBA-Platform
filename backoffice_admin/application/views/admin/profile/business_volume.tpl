{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" class="no-display">
    <span id="error_msg">{lang('select_user_id')}</span>
    <span id="errmsg1">{lang('you_must_enter_username')}</span>
</div>

<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>

{include file="layout/search_member.tpl"}

{assign var="u" value=$u_name}
{if $u_name}
    <div id="user_account"></div>
    <div id="username_val" style="display:none;">{$u}</div>

    

    <div class="panel panel-default">
    <div class="panel-body">
    <legend>
        <span class="fieldset-legend">{lang('business_volume')}: {$u_name}</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th>{lang('slno')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('left_leg')}</th>
                    <th>{lang('left_leg_carry')}</th>
                    <th>{lang('right_leg')}</th>
                    <th>{lang('right_leg_carry')}</th>
                    <th>{lang('description')}</th>
                    <th>{lang('date')}</th>
                </tr>
            </thead>
            {if count($details)>0}
                <tbody>
                    {assign var=i value="0"}
                    {foreach from=$details item=v}
                        {$i = $i+1}
                        {$amount_type = $v.amount_type}
                        {$action = $v.action}

                        {if $amount_type == "user_join"} 
                            {$type ="{lang('volume_added_from_member')}  {$v.from_name} {lang('join')} "} 
                            {$sign="+"}
                        {else if $amount_type == "user_repurchase"} 
                            {$type ="{lang('volume_added_from_member')}  {$v.from_name} {lang('repurchase')} "} 
                            {$sign="+"}
                        {else if $amount_type == "leg" && $action != "deducted_without_pair"}
                            {$type="{lang('volume_taken_for_commission')}"}
                            {$sign="-"}
                        {else if $amount_type == "repurchase_leg" && $action != "deducted_without_pair"}
                            {$type="{lang('volume_taken_for_commission_repurchase')}"}
                            {$sign="-"}
                        {else if $action == "deducted_without_pair"} 
                            {$type="{lang('volume_deducted')}"}
                            {$sign="-"}
                        {else if $amount_type == "user_renewal"} 
                            {$type ="{lang('volume_added_from_member')}  {$v.from_name} {lang('renewal')} "} 
                            {$sign="+"}
                        {else} 
                            {$type=" {$v.amount_type}"} 
                        {/if}
                        <tr>
                            <td>{$i+$page_id}</td>
                            <td>{$v.user_name}</td>
                            <td>{if $v.left_leg_carry == '0'}{$v.left_leg_carry}{else}{$sign}{$v.left_leg_carry}{/if}</td>
                            <td>{$v.left_leg}</td>
                            <td>{if $v.right_leg_carry == '0'}{$v.right_leg_carry}{else}{$sign}{$v.right_leg_carry}{/if}</td>
                            <td>{$v.right_leg}</td>
                            <td>{$type}</td>
                            <td>{$v.date}</td>
                        </tr>
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr>
                        <td colspan="8">
                            <h4>{lang('no_details')}</h4>
                        </td>
                    </tr>
                </tbody>
            {/if}
        </table>
        </div>
         {$result_per_page}
        </div>
    </div>
   
{/if}


{/block}