{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg_activate_category">{lang('Sure_you_want_to_Activate_this_category')}</span>
    <span id="confirm_msg_inactivate_category">{lang('Sure_you_want_to_Inactivate_this_category')}</span>
    <span id="confirm_msg_delete_category">{lang('Sure_you_want_to_delete_this_category')}</span>
</div>
    <div class="button_back">
        <a href="{BASE_URL}/admin/repurchase_package" class="btn m-b-xs btn-sm btn-info btn-addon" ><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>
    
<div class="panel panel-default">
    <div class="panel-body">
        {form_open('admin/repurchase_category', 'role="form" class="smart-wizard inline"')}
          <input type="hidden" value="yes" name="pro_status" >
          <button type="submit" class="btn m-b-xs {if $sub_status=='yes'} btn-info {else} btn-default {/if}" value="add_product" name="refine">{lang('active')}</button>
        {form_close()}

        {form_open('admin/repurchase_category', 'role="form" class="smart-wizard inline"')}
          <input type="hidden" value="no" name="pro_status" >
          <button type="submit" class="btn m-b-xs {if $sub_status=='no'} btn-info {else} btn-default {/if}" value="add_product" name="refine">{lang('inactive')}</button>
        {form_close()}
        <a href="{$BASE_URL}admin/add_repurchase_category" class="btn btn-sm btn-primary btn-addon pull-right" name="add_prod" id="add_prod" value="add product" ><i class="fa fa-plus"></i>{lang('add_new_category')}</a>

        <div class="">
            <div class="panel panel-default table-responsive">
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{lang('sl_no')}</th>
                            <th>{lang('category_name')}</th>
                            <th>{lang('status')}</th>
                            <th>{lang('action')}</th>
                        </tr>
                    </thead>
                    {if count($categories) > 0}
                      <tbody>
                        {$i = 0}
                        {foreach from=$categories item=v}
                            {assign var="id" value="{$v.category_id}"}
                            {assign var="name" value="{$v.category_name}"}
                            {assign var="active" value="{$v.status}"}
                            {if $active=='yes'}
                                {$status=lang('active')}
                            {else}
                                {$status=lang('inactive')}
                            {/if}

                            <tr>
                                <td>{$i + $page + 1}</td>
                                <td>{$name}</td>
                                <td>{$status}</td>
                                <td>
                                {if $active=='yes'}
                                        <a href="javascript:edit_repurchase_category({$id})" title="{lang('edit')}" class="btn-link btn_size has-tooltip text-info" data-placement="top" data-original-title="{lang('edit')}"><i class="fa fa-edit"></i></a>
                                        
                                    {form_open('admin/inactivate_repurchase_category', 'role="form" class="smart-wizard inline"')}
                                        <input type="hidden" name="category_id" value="{$id}">
                                        <a href="#" class="btn-link btn_size has-tooltip text-info inactivate_repurchase_category" title="{lang('inactivate')}" data-placement="top" ><i class="icon-ban"></i></a>
                                    {form_close()}
                                {else}  
                                    {form_open('admin/product/activate_repurchase_category', 'role="form" class="smart-wizard inline"')}
                                        <input type="hidden" name="category_id" value="{$id}">
                                        <a href="#" class="has-tooltip btn-link btn_size text-info activate_repurchase_category" title="{lang('activate')}" data-placement="top" data-original-title="{lang('activate')}"><i class="icon-check"></i></a>
                                    {form_close()}   
                                {/if}
                                   {*{form_open('admin/product/delete_repurchase_category', '')}
                                        <input type="hidden" name="category_id" value="{$id}">
                                            <a href="#" class="has-tooltip btn btn_size btn-danger delete_repurchase_category delete_repurchase_category-width" title="{lang('delete')}" data-placement="top" data-original-title="{lang('activate')}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    {form_close()}*}
                            </tr>
                            {$i = $i + 1}
                        {/foreach}
                      </tbody>
                    {else}
                        <tbody>
                            <tr id="tr-empty"><td align="center"><h4 align="center">{lang('no_category_found')}</h4></td></tr>
                        </tbody>
                    {/if}
                </table>
                {$result_per_page}
            </div>
        </div>
    </div>
</div>
{/block}

