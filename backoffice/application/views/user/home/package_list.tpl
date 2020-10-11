{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="confirm_msg_inactivate">{lang('Sure_you_want_to_inactivate_this_Product_There_is_NO_undo')}</span>
        <span id="confirm_msg_edit">{lang('Sure_you_want_to_edit_this_Product_There_is_NO_undo')}</span>
        <span id="confirm_msg_delete">{lang('Sure_you_want_to_Delete_this_Product_There_is_NO_undo')}</span>
        <span id="confirm_msg_activate">{lang('Sure_you_want_to_Activate_this_Product_There_is_NO_undo')}</span>
    </div>
    <div class="button_back"> <a href="{BASE_URL}/user/home/index">
            <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button>
        </a> </div>
    <div class="panel panel-default table-responsive ng-scope">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('id')}</th> 
                    <th>{lang('name')}</th>                                       
                        {if $MODULE_STATUS['product_validity']=="yes"} 
                        <th>{lang('validity')}({lang('in_months')})</th>
                        {/if}
                    <th>{lang('joining_progress_bar')}</th>
                </tr>
            </thead>
            {if count($product_details) > 0}
                <tbody>
                    {assign var=color value=['progress-bar-aqua','progress-bar-red','progress-bar-green','progress-bar-yellow']}
                    {$j=0}
                    {$i = 0}
                    {foreach from=$product_details item=v}
                        {assign var="id" value="{$v.product_id}"}
                        {assign var="name" value="{$v.product_name}"}
                        {assign var="active" value="{$v.active}"}
                        {assign var="type_of_package" value="{$v.type_of_package}"}
                        {assign var="package_validity" value="{$v.package_validity}"}
                        {assign var="package_id" value="{$v.prod_id}"}
                        {if $active=='yes'}
                            {$status=lang('active')}
                        {else}
                            {$status=lang('inactive')}
                        {/if}

                        {if $active =="deleted" && $v.perc == 0}
                        {else}
                            <tr>
                                <td>{$i + $page + 1}</td>
                                <td>{$package_id}</td>
                                <td>{$name}</td>
                                {if $MODULE_STATUS['product_validity']=="yes"} 
                                    <td>{$package_validity}</td>
                                {/if}
                                <td>
                                    {$j= $i%4}
                                    
                                    <div class="progress">
                                      <div class="progress-bar progress-bar-primary progress-bar-striped active" style="width:{$v.perc}%;"></div>
                                      <div class="progress-value">{round($v.perc,2)}%</div>
                                    </div>
                                    
                                </td>
                            </tr>
                            {$i = $i + 1}
                        {/if}
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr id="tr-empty"><td align="center"><h4 align="center">{lang('no_product_found')}</h4></td></tr>
                </tbody>
            {/if}
        </table>
        {$result_per_page}
    </div>
{/block}