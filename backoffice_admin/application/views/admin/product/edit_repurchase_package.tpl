{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_your_product_identifying_number')}</span>
    <span id="error_msg">{lang('you_must_enter_your_product_name')}</span>
    <span id="error_msg3">{lang('you_must_enter_your_product_amount')}</span>
    {if $mlm_plan == "Stair_Step"}
        <span id="error_msg4">{lang('you_must_enter_your_product_pv_value')}</span>
    {else}
        <span id="error_msg4">{lang('you_must_enter_your_product_pair_value')}</span>
    {/if}
    <span id="validate_msg">{lang('enter_digits_only')}</span>
    <span id="error_msg5">{lang('you_must_enter_package_id')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="validate_msg1">{lang('digits_only')}</span>
    <span id="validate_msg_img1">{lang('you_must_select_a_product_name')}</span>
    <span id="validate_msg_img2">{lang('you_must_select_a_product_image')}</span>
    <span id="validate_msg7">{lang('you_must_select_a_type_of_package')}</span>
    <span id="validate_msg8">{lang('you_must_enter_package_validity')}</span>
    <span id="validate_msg9">{lang('digits_only')}</span>
    <span id="validate_msg11">{lang('you_must_enter_your_product_pair_price')}</span>
    <span id="validate_msg12">{lang('you_must_enter_product_referral_commission')}</span>
    <span id="validate_msg13">{lang('product_referral_commission_must_be_number_between')}</span>
    <span id="validate_msg14">{lang('alphanumeric_chars_only')}</span>
    <span id="validate_msg19">{lang('package_validity_should_be_a_positive_number')}</span>
    <span id="validate_msg20">{lang('digit_limit_is_five')}</span>
    <span id="validate_msg25">{lang('you_must_select_category')}</span>
    <span id="validate_msg26">{lang('you_must_enter_description')}</span>
    <span id="amount_greater_than_zero">{sprintf(lang('field_greater_than_zero'), ucfirst(strtolower(lang('product_amount'))))}</span>
</div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/repurchase_package" class="btn m-b-xs btn-sm btn-info btn-addon" ><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open_multipart('admin/edit_repurchase_package','class="" role="form" id="form"')}
            <input type="hidden" name="product_id" value="{$package_details.product_id}">
                {include file="layout/error_box.tpl" id="err_edit_repurchase"}
                <div class="form-group">
                    <label class="control-label" for="package_id">{lang('id')}</label>
                        <input type="text" class="form-control" readonly="true" name="package_id" id="package_id" value="{set_value('package_id', $package_details['prod_id'])}" autocomplete="off"/>
                        <span id="errmsg1"></span>
                        <span name ='form_err'>{form_error('package_id')}</span>
                </div>
                
                <div class="form-group">
                    <label class="control-label required" for="prod_name">{lang('name')}</label>
                        <input class="form-control" type="text" name="prod_name" id="prod_name"  value="{set_value('prod_name', $package_details['product_name'])}" autocomplete="off"/>
                        <span name ='form_err'>{form_error('prod_name')}</span>
                </div>
                
                <div class="form-group">
                    <label class="control-label required" for="category">{lang('category')}</label>
                        <select name="category" id="category" class="form-control" >
                            {assign var=i value=0}
                            {foreach from=$categories item=v}
                                <option value="{$v.category_id}" {if $v.category_id == $package_details['category_id']} selected {/if} >{$v.category_name}</option>
                                {$i = $i+1}
                            {/foreach}
                        </select>
                        {form_error('category')}
                </div>
                    
                <div class="form-group">
                    <label class="control-label required" for="product_amount">{lang('amount')}</label>
                        <div class="input-group {$input_group_hide}">
                            {$left_symbol}
                            <input class="form-control" type="text" name="product_amount" id="product_amount" value="{set_value('product_amount', round($package_details['product_value']*$DEFAULT_CURRENCY_VALUE,$PRECISION))}" autocomplete="off" />
                            {$right_symbol}
                            <span id="errmsg1"></span>
                        </div>
                        <span name ='form_err'>{form_error('product_amount')}</span>
                </div> 
                     
                {if $pv_visible == 'yes'}
                    <div class="form-group">
                        <label class="control-label required" for="pair_value">{if $mlm_plan == "Stair_Step"}{lang('pv_value')}{else}{lang('product_pv')}{/if}</label>
                            <input type="text" class="form-control" name="pair_value" id="pair_value" value="{set_value('pair_value', $package_details['pair_value'])}" autocomplete="off"/> 
                            <span id="errmsg2"></span>
                            <span name ='form_err'>{form_error('pair_value')}</span>
                    </div>
                {/if}
                
                {if $bv_visible == 'yes'}
                    <div class="form-group">
                        <label class="control-label required" for="bv_value">{lang('bv_value')}</label>
                            <input type="text" class="form-control" name="bv_value" id="bv_value" value="{set_value('bv_value', $package_details['pair_value'])}" autocomplete="off"/> 
                            <span id="errmsg2"></span>
                            <span name ='form_err'>{form_error('bv_value')}</span>
                    </div>
                {/if}
                
                <div class="form-group">
                    <label class="control-label required" for="description">{lang("description")}</label>
                    <input type="textarea" class="form-control"  id="description" name="description" value="{set_value('description', $package_details['description'])}" autocomplete="Off">
                    {form_error('description')}
                </div>

                {*product image*}
                <div class="form-group">
                    <div id="profile_image">
                        <label class="control-label" for="product_id"> {lang('Product_img')}</label>
                        <div class="fileupload fileupload-new bg_file_upload" data-provides="fileupload">
                            <div class="user-image" id="user_image">                                       
                                <div class="fileupload-new thumbnail imgpre">
                                    {if $package_details['prod_img'] != '' && $package_details['prod_img'] != 'no'}
                                        <img id="updated_image" src="{$SITE_URL}/uploads/images/product_img/{$package_details['prod_img']}" width="130" alt="Product Image" style="max-height:200px;"> 
                                    {else}
                                        <img id="updated_image" src="{$SITE_URL}/uploads/images/product_img/cart.jpg" width="130" alt="Profile Picture" style="max-height:200px;"> 
                                    {/if} 
                                </div>                                       
                                <div class="fileupload-preview fileupload-exists thumbnail imgpre"></div>
                                <div class="user-edit-image-buttons">
                                    <span class="btn btn-light-grey btn-file">
                                        <span class="fileupload-new">{lang('change')}</span>
                                        <span class="fileupload-exists"><i class="fa fa-picture"></i> {lang('change')}</span>
                                        <input type="file" id="upload_doc" name="upload_doc">
                                    </span>
                                    <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                        <i class="fa fa-times"></i>{lang('remove')}
                                    </a>
                                </div>
                                <div class="user-image-buttons">
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                                        
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" name="update_prod" id="update_prod" value="update_prod">{lang('update_Product')}</button>
                </div>
                
            {form_close()}
        </div>
    </div>

 {/block}