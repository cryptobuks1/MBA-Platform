{extends file=$BASE_TEMPLATE} {block name=script} {$smarty.block.parent}
<script src="{$PUBLIC_URL}javascript/copy_to_clip_board.js" type="text/javascript"></script>
{/block} {block name=$CONTENT_BLOCK}

<div class="panel panel-default">
    <div class="panel-body">
    
    {form_open('admin/epin_management', 'role="form"')}
    <button type="submit" class="btn m-b-xs   {if $status_pin=='active'} btn-info {else} btn-default{/if}" value="{lang('view_epin')}" name="view_pin_active" id="view_pin">{lang('active')}</button>
    <button type="submit" class="btn m-b-xs  {if $status_pin=='inactive'} btn-info {else} btn-default{/if}" value="{lang('view_epin')}" name="view_pin_inactive" id="view_pin">{lang('inactive')}</button>
    <a href="{$BASE_URL}admin/add_new_epin"><button type="button" class="btn btn-sm btn-primary pull-right btn-addon"><i class="fa fa-plus"></i>
            {lang('add_new_epin')}</button></a>{form_close()}
 
        <div class="table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{lang('sl_no')}</th>
                        <th>{lang('epin')}</th>
                        <th>{lang('amount')}</th>
                        <th>{lang('bal_amount')}</th>
                        <th>{lang('allocated_user')}</th>
                        <th>{lang('status')}</th>
                        <th>{lang('uploaded_date')}</th>
                        <th>{lang('expiry_date')}</th>
                        <th>{lang('action')}</th>
                    </tr>
                </thead>
                {if $count != 0}
                <tbody>
                    {assign var="root" value="{$BASE_URL}admin/"} 
                    {assign var="i" value=0} 
                    {assign var="pin" value=""} 
                    {assign var="pin_status" value="ACTIVE"} 
                    {foreach from=$pin_numbers item=v} 
                        {assign var="id" value="{$v.pin_id}"} 
                        {if $v.status == "yes"} 
                            {if $v.pin_bal_amount == 0} 
                                {$pin_status = "NO BALANCE"} 
                                {$status_pin = lang('no_balance')} 
                            {elseif $v.used_user} 
                                {$pin_status = "USED"} 
                                {$status_pin = lang('used')} 
                            {elseif $smarty.now|date_format:'%Y-%m-%d' > $v.pin_expiry_date|date_format:'%Y-%m-%d'}                    
                                {$pin_status = "EXPIRED"} 
                                {$status_pin = lang('expired')} 
                            {else} 
                                {$pin_status = "ACTIVE"} 
                                {$status_pin = lang('active')} 
                            {/if} 
                        {elseif $v.pin_bal_amount == 0} 
                            {$pin_status = "NO BALANCE"} 
                            {$status_pin = lang('no_balance')} 
                        {elseif $smarty.now|date_format:'%Y-%m-%d' > $v.pin_expiry_date|date_format:'%Y-%m-%d'} 
                            {$pin_status = "EXPIRED"} 
                            {$status_pin = lang('expired')} 
                        {elseif $v.used_user==""} 
                            {$pin_status = "BLOCKED"} 
                            {$status_pin = lang('blocked')} 
                        {elseif $v.status=="no"} 
                            {$pin_status = "INACTIVE"} 
                            {$status_pin = lang('inactive')} 
                        {else} 
                            {$pin_status = "USED"} 
                            {$status_pin = lang('used')} 
                        {/if} 

                        {$i=$i+1}
                        <tr>
                            <td>{$i+$page}</td>
                        <td><span name="link{$i}" id="link{$i}" type="text" value="{$v.pin}" class="btn-light-gray m-b-xs w-xs">{$v.pin}</span></td>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_bal_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        {if {$v.allocated_user}==""}
                        <td align="center">NA</td>
                        {else}
                        <td align="center">{$v.allocated_user}</td>
                        {/if}
                        <td><span class="label bg-success">{$status_pin}</span></td>
                        <td>{$v.pin_uploded_date}</td>
                        <td>{$v.pin_expiry_date}</td>
                        <td class="ipad_button_table">
                             
                                <button class='btn-link has-tooltip text-primary' title="Copy" onclick="return copyEpinToClipboard(link{$i}, 'link{$i}')"><i class="fa fa-clipboard"></i></button>
                                 
                            {if $pin_status == "ACTIVE" || $pin_status == "USED"}
                            <span style="display:none" id="error_msg_block">{lang('Sure_you_want_to_block_this_Passcode_There_is_NO_undo')}</span>
                            
                                <button class='btn-link has-tooltip text-info' title="Inactive" onclick="block_pin({$id}, '{$root}')"><i class="icon-ban"></i></button>
                                 
                            {if {$v.allocated_user}==""}
                             
                                <button class='btn-link has-tooltip text-primary' title="Allocate" onclick="allocate_user({$id}, '{$root}')"><i class="icon-user-follow"></i></button>
                                 
                            {/if} {else} {if $smarty.now|date_format:'%Y-%m-%d'
                            <= $v.pin_expiry_date|date_format: '%Y-%m-%d'&& $v.pin_bal_amount>0}

                                
                                    <button class=' btn-link btn_size text-info' title="Active" onclick="activate_pin({$id}, '{$root}')"><i class=" icon-check"></i></button>
                                    
                                    <span style="display:none" id="error_msg_activate">{lang('sure_you_want_to_activate_this_passcode_there_is_no_undo')}</span>
                                 
                                {/if} {/if}
                                
                                    <button class='btn-link has-tooltip text-danger' title="Delete" onclick="delete_pin({$id}, '{$root}')"><i class="fa fa-trash-o"></i></button>
                                    
            <span style="display:none" id="error_msg_delete">{lang('sure_you_want_to_delete_this_passcode_there_is_no_undo')}</span>
                                    
                                 
                        </td>

                    </tr>
                    {/foreach}
                </tbody>
                {else}
                <tbody>
                    <tr>
                        <td colspan="9" align="center">
                            <h4 align="center"> {$empty_msg}</h4>
                        </td>
                    </tr>
                </tbody>
                {/if}
            </table>
        </div>
        <div class="pull-right">
            {$result_per_page}
        </div>
        {if count($pin_numbers)>0}
        <div class="">
            <div id="error_msg_delete_all" style="display:none;">{lang("do_you_want_to_delete_all_epins")}</div>
            <button class="btn btn-primary" type="button" name="delete_all_pin" id="delete_all_pin" value="Delete All E-pin" title="Delete All E-pin" onclick="delete_all_epin('{$root}', '{$status_pin}', '{$page}');">{lang('delete_all_epin')}</button>
        </div>
        {/if}
    </div>
</div>
{/block}