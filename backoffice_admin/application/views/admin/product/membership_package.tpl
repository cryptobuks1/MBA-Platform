{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg_inactivate">{lang('Sure_you_want_to_inactivate_this_Product')}</span>
    <span id="confirm_msg_edit">{lang('Sure_you_want_to_edit_this_Product_There_is_NO_undo')}</span>
    <span id="confirm_msg_delete">{lang('Sure_you_want_to_Delete_this_Product_There_is_NO_undo')}</span>
    <span id="confirm_msg_activate">{lang('Sure_you_want_to_Activate_this_Product')}</span>
</div>



    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('admin/membership_package', 'role="form" class="smart-wizard inline"')}
               <input type="hidden" value="yes" name="pro_status" >
               <button type="submit" class="btn m-b-xs   {if $sub_status=='yes'} btn-info {else} btn-default {/if}" value="add_product" name="refine">{lang('active')}</button>
            {form_close()}

            {form_open('admin/membership_package', 'role="form" class="smart-wizard inline"')}
                <input type="hidden" value="no" name="pro_status" >
                <button type="submit" class="btn m-b-xs  {if $sub_status=='no'} btn-info {else} btn-default {/if}" value="add_product" name="refine">{lang('inactive')}</button>
           {form_close()}
                 <a href="{$BASE_URL}admin/add_membership_package" class="btn btn-sm btn-primary btn-addon pull-right" name="add_prod" id="add_prod" value="add product" ><i class="fa fa-plus"></i>{lang('add_new_product')}</a>
            <div class="">
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')}</th>
                                <th>{lang('id')}</th>
                                <th  class="width_action">{lang('name')}</th>
                                <th>{lang('amount')}</th>
                                {if $pv_visible == 'yes'}
                                <th>{lang('product_pv')}</th>
                                {/if}
                                {if $bv_visible == 'yes'}
                                <th>{lang('bv_value')}</th>
                                {/if}
                                {if $MODULE_STATUS['product_validity']=="yes"}
                                <th>{lang('validity')}({lang('in_months')})</th>
                                {/if}
                                {* {if $MODULE_STATUS['roi_status']=="yes"}
                                <th>{lang('Hyip')}</th>
                                <th>{lang('days')}</th>
                                {/if} *}
                                <th>{lang('status')}</th>
                                <th class="width_action">{lang('action')}</th>
                            </tr>
                        </thead>
                        {if count($product_details) > 0}
                        <tbody>
                            {$i = 0}
                            {foreach from=$product_details item=v}
                                {assign var="id" value="{$v.product_id}"}
                                {assign var="name" value="{$v.product_name}"}
                                {assign var="active" value="{$v.active}"}
                                {assign var="date" value="{$v.date_of_insertion}"}
                                {assign var="prod_value" value="{$v.product_value}"}
                                {assign var="bv_value" value="{$v.bv_value}"}
                                {assign var="pair_value" value="{$v.pair_value}"}
                                {assign var="type_of_package" value="{$v.type_of_package}"}
                                {assign var="package_validity" value="{$v.package_validity}"}
                                {assign var="package_id" value="{$v.prod_id}"}
                                {assign var="roi" value="{$v.roi}"}
                                {assign var="days" value="{$v.days}"}
                                {if $active=='yes'}
                                    {$status=lang('active')}
                                {else}
                                    {$status=lang('inactive')}
                                {/if}

                                <tr>
                                    <td>{$i + $page + 1}</td>
                                    <td>{$package_id}</td>
                                    <td>{$name}</td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($prod_value*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    {if $pv_visible == 'yes'}
                                        <td>{$pair_value}</td>
                                    {/if}
                                    {if $bv_visible == 'yes'}
                                        <td>{$bv_value}</td>
                                    {/if}
                                    {if $MODULE_STATUS['product_validity']=="yes"}
                                    <td>{$package_validity}</td>
                                    {/if}
                                     {* {if $MODULE_STATUS['roi_status']=="yes"}
                                     <td>{$roi}</td>
                                     <td>{$days}</td>
                                    {/if} *}
                                    <td>{$status}</td>
                                    <td class="ipad_button_table">
                                    {if $active=='yes'}

                                            <a href="javascript:edit_membership_package({$id})" title="Edit" class="btn-link btn_size has-tooltip text-info" data-placement="top" data-original-title="{lang('edit')}"><i class="fa fa-edit"></i></a>

                                        {form_open('admin/inactivate_membership_package', 'role="form" class="smart-wizard inline"')}
                                            <input type="hidden" name="product_id" value="{$id}">

                                                <a href="#" title="Inactive" class="btn-link btn_size has-tooltip text-info inactivate_membership_package" data-placement="top" data-original-title="{lang('inactivate')}"><i class="icon-ban"></i></a>

                                        {form_close()}
                                    {else}
                                        {form_open('admin/activate_membership_package', 'role="form" class="smart-wizard inline"')}
                                            <input type="hidden" name="product_id" value="{$id}">

                                                <a href="#" title="Active" class="has-tooltip btn-link btn_size text-info activate_membership_package" data-placement="top" data-original-title="{lang('activate')}"><i class="icon-check"></i></a>

                                        {form_close()}
                                    {/if}

                                      {*{form_open('admin/product/delete_membership_package', 'role="form" class="smart-wizard inline"')}
                                        <input type="hidden" name="product_id" value="{$id}">

                                            <a href="#" title="Delete" class="btn-link btn_size has-tooltip text-danger delete_membership_package" data-placement="top" data-original-title="{lang('delete')}"><i class="fa fa-trash-o"></i></a>

                                      {form_close()}*}
                                </tr>

                                {$i = $i + 1}
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
            </div>
        </div>
    </div>
{/block}