{extends file=$BASE_TEMPLATE} 
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
            
            <span id="confirm_msg_inactivate">{lang('confirm_msg_inactivate')} </span>
            <span id="confirm_msg_activate">{lang('confirm_msg_activate')} </span>
         
        </div>
<div class="panel panel-default">
        <div class="panel-body">
           {* <legend><span class="fieldset-legend">{lang('payout')}</span>
                <a class="btn m-b-xs btn-sm btn-primary btn-addon pull-right" href="{$BASE_URL}admin/add_new_rank" id="add_rank"><i class="fa fa-plus"></i> {lang('add_new_rank')}</a>
            </legend>*}
            <div>
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')}</th>
                                <th>{lang('payout_method')}</th>
                                <th>{lang('status')}</th>
                                <th>{lang('action')}</th>
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        {assign var="path" value="{$BASE_URL}admin/"}
                        {foreach from=$payout_methods item=v}
                                <tr>
                                    <td>{counter}</td>
                                    <td>{$v.gateway_name}</td>
                                    <td>{$v.payout_status}</td>
                                   
                                    <td class="ipad_button_table">
                                        {if $v.payout_status=="yes"}
                                           
                                            <button class="btn-link btn_size has-tooltip text-info inactivate_membership_package" onclick="inactivate_payout({$v.id}, '{$path}')" title="{lang('inactivate')}"><i class="fa fa-ban"></i></button>
                                        {else}
                                            <button class="has-tooltip btn-link btn_size text-info" onclick="activate_payout({$v.id}, '{$path}')" title="{lang('activate')}"><i class="icon-check"></i></button>
                                        {/if}
                                    </td>
                                </tr>
                        {/foreach}
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>


{/block}
{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_payout_release.js"></script>
{/block}