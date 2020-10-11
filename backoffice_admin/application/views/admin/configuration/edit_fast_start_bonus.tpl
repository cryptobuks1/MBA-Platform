{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1">{lang('you_must_enter_your_product_identifying_number')}</span>
        <span id="error_msg">{lang('you_must_enter_your_product_name')}</span>
        <span id="error_msg3">{lang('you_must_enter_your_product_amount')}</span>
       
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
        <span id="validate_msg19">{lang('week_age_validity_should_be_a_positive_number')}</span>
        <span id="validate_msg20">{lang('digit_limit_is_five')}</span>
        <span id="validate_msg21">{lang('greater_than_zero')}</span>
        <span id="validate_msg22">{lang('required')}</span> 
    </div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/configuration/fast_start_bonus_config" class="btn m-b-xs btn-sm btn-success btn-addon" ><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('','role="form" class="" name="rank_form" id="rank_form"')}

            {include file="layout/error_box.tpl" id="err_edit_membership"} 
            <div class="form-group">
                <input type='hidden' name='id' value = '{$id}'>

            </div>

            <div class="form-group">
                <label class="control-label" for="rank_id">{lang('rank')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="rank_id" id="rank_id"  value="{$rank_id}" autocomplete="off" readonly/>
                    <input type="text" class="form-control" name="rank_name" id="rank_name"  value="{$rank_name}" autocomplete="off" readonly/>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label required" for="level_1">{lang('level_1')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_1" id="level_1"  value="{$level_1}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_1')}
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label required" for="level_2">{lang('level_2')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_2" id="level_2"  value="{$level_2}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_2')}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label required" for="level_3">{lang('level_3')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_3" id="level_3"  value="{$level_3}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_3')}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label required" for="level_4">{lang('level_4')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_4" id="level_4"  value="{$level_4}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_4')}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label required" for="level_5">{lang('level_5')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_5" id="level_5"  value="{$level_5}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_5')}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label required" for="level_6">{lang('level_6')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_6" id="level_6"  value="{$level_6}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_6')}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label required" for="level_7">{lang('level_7')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_7" id="level_7"  value="{$level_7}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_7')}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label required" for="level_8">{lang('level_8')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_8" id="level_8"  value="{$level_8}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_8')}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label required" for="level_9">{lang('level_9')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_9" id="level_9"  value="{$level_9}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_9')}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label required" for="level_10">{lang('level_10')}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="level_10" id="level_10"  value="{$level_10}" autocomplete="off"/>
                    <span id="errmsg3"></span>
                    {form_error('level_10')}
                </div>
            </div>
            
            <div class="form-group">
                <button class="btn btn-sm btn-primary" type="submit" name="update_fast_bonus" id="update_rank_bonus" value="update_rank_bonus">{lang('update')}</button>  
            </div>

            {form_close()}
        </div>
    </div>
{/block}
{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_fast_start_bonus.js"></script>
{/block}
