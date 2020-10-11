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
            {form_open('admin/repurchase_package', 'role="form" class="smart-wizard inline"')}
                <input type="hidden" value="yes" name="pro_status" >
                <button type="submit" class="btn m-b-xs   {if $pro_status=='yes'} btn-info {else} btn-default {/if}" value="add_product" name="refine">{lang('active')}</button>
            {form_close()}
            {form_open('admin/repurchase_package', 'role="form" class="smart-wizard inline"')}
                <input type="hidden" value="no" name="pro_status" >
                <button type="submit" class="btn m-b-xs   {if $pro_status=='no'} btn-info {else} btn-default {/if}" value="add_product" name="refine">{lang('inactive')}</button>
           {form_close()}
            <a href="{$BASE_URL}admin/add_repurchase_package" class="btn btn-sm btn-primary btn-addon pull-right" name="add_prod" id="add_prod" value="add product" ><i class="fa fa-plus"></i>{lang('add_new_product')}</a>
            <a href="{$BASE_URL}admin/repurchase_category" class="btn btn-sm btn-primary btn-addon pull-right m-r-xs" name="category" id="category" value="category" ><i class="fa fa-plus"></i>{lang('manage_category')}</a>
           <div class="mobile_bottum_1">
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>{lang('sl_no')}</th>
                            <th>{lang('id')}</th>
                            <th>{lang('Product_img')}</th>
                            <th>{lang('name')}</th>
                            <th>{lang('category')}</th>
                            <th>{lang('amount')}</th>
                                {if $pv_visible == 'yes'}
                                <th>{lang('product_pv')}</th>
                                {/if}
                                {if $bv_visible == 'yes'}
                                <th>{lang('bv_value')}</th>
                                {/if}
                            <th>{lang('status')}</th>
                            <th>{lang('action')}</th>
                                </tr>
                        </thead>
                        {if count($product_details) > 0}
                            <tbody>
                            {$i = 0}
                            {foreach from=$product_details item=v}
                                {assign var="id" value="{$v.product_id}"}
                                {assign var="name" value="{$v.product_name}"}
                                {assign var="category" value="{$v.category_name}"}
                                {assign var="active" value="{$v.active}"}
                                {assign var="date" value="{$v.date_of_insertion}"}
                                {assign var="prod_value" value="{$v.product_value}"}
                                {assign var="bv_value" value="{$v.bv_value}"}
                                {assign var="pair_value" value="{$v.pair_value}"}
                                {assign var="type_of_package" value="{$v.type_of_package}"}
                                {assign var="package_id" value="{$v.prod_id}"}
                                {if $active=='yes'}
                                    {$status=lang('active')}
                                {else}
                                    {$status=lang('inactive')}
                                {/if}

                                <tr>
                                    <td>{$i + $page + 1}</td>
                                    <td>{$package_id}</td>
                                    <td>
                                        <div class="checkout-image">
                                            {if $v['prod_img'] != '' && $v['prod_img']!="no"}
                                            <img src="{$SITE_URL}/uploads/images/product_img/{$v.prod_img}"   alt="a"   /> {else}
                                            <img src="{$SITE_URL}/uploads/images/product_img/cart.jpg"  /> {/if}
                                        </div>
                                    </td>
                                    <td>{$name}</td>
                                    <td>{$category}</td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($prod_value*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    {if $pv_visible == 'yes'}
                                        <td>{$pair_value}</td>
                                    {/if}
                                    {if $bv_visible == 'yes'}
                                        <td>{$bv_value}</td>
                                    {/if}
                                    <td>{$status}</td>
                                    <td>
                                    {if $active=='yes'}

                                            <a href="javascript:edit_repurchase_package({$id})" title="{lang('edit')}"  class="btn-link btn_size has-tooltip text-info" data-placement="top" data-original-title="{lang('edit')}"><i class="fa fa-edit"></i></a>

                                        {form_open('admin/inactivate_repurchase_package', 'role="form" class="smart-wizard inline"')}
                                        <input type="hidden" name="product_id" value="{$id}">

                                        <a href="#" class="btn-link btn_size has-tooltip text-info inactivate_repurchase_package" title="{lang('inactivate')}" data-placement="top" ><i class="icon-ban"></i></a>

                                        {form_close()}
                                    {else}
                                        {form_open('admin/activate_repurchase_package', 'role="form" class="smart-wizard inline"')}
                                        <input type="hidden" name="product_id" value="{$id}">

                                            <a href="#" class="has-tooltip btn-link btn_size text-info activate_repurchase_package" title="{lang('activate')}" data-placement="top" data-original-title="{lang('activate')}"><i class="icon-check"></i></a>

                                        {form_close()}
                                    {/if}
                                     {*   {form_open('admin/product/delete_repurchase_package', 'role="form" class="smart-wizard inline"')}
                                        <input type="hidden" name="product_id" value="{$id}">

                                               <a href="#" class="btn-link btn_size has-tooltip text-danger delete_repurchase_package" title="{lang('delete')}" data-placement="top" data-original-title="{lang('delete')}"><i class="fa fa-trash-o"></i></a>

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