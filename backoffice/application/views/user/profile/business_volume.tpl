
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"}

<div id="span_js_messages" style="display:none">
    <span id="error_msg">{lang('select_user_id')}</span>
</div>

<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o"></i>
                {lang('business_volume')}
            </div>
            <div class="panel-body" >
                <table class="table table-striped table-hover table-full-width table-bordered" id="">
                    <thead class="table-bordered">
                        <tr class="th">
                            <th>{lang('slno')}</th>
                            {if !$user_id}
                            <th>{lang('user_name')}</th>
                            {/if}
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
                        {else if $amount_type == "user_renewal"} 
                            {$type ="{lang('volume_added_from_member')}  {$v.from_name} {lang('renewal')} "} 
                            {$sign="+"}
                        {else if $action == "deducted_without_pair"} 
                        {$type="{lang('volume_deducted')}"}
                        {$sign="-"}

                        {else} 
                        {$type=" {$v.amount_type}"} 
                        {/if}

                        {if $i%2 == 0}
                        {$class="tr2"}
                        {else}
                        {$class="tr1"}
                        {/if}       

                        {$i = $i+1}
                        <tr class="{$class}">
                            <td>{$i+$page_id}</td>
                            {if !$user_id}
                            <td>{$v.user_name}</td> 
                            {/if}
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
                    <tbody><tr><td align="center" colspan="8"><b>{lang('no_details')}</b></td></tr></tbody> 
                    {/if}
                </table>
                {$result_per_page} 
                {include file="common/notes.tpl" notes=lang('note_business_volume')}
            </div>
        </div>
    </div>
</div> 

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}