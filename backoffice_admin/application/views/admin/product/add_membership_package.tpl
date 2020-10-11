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
    <span id="validate_msg8">{lang('you_must_select_package_validity')}</span>
    <span id="validate_msg9">{lang('digits_only')}</span>
    <span id="validate_msg11">{lang('you_must_enter_your_product_pair_price')}</span>
    <span id="validate_msg12">{lang('you_must_enter_product_referral_commission')}</span>
    <span id="validate_msg13">{lang('product_referral_commission_must_be_number_between')}</span>
    <span id="validate_msg14">{lang('alphanumeric_chars_only')}</span>
    <span id="validate_msg15">{lang('you_must_enter_product_roi')}</span>
    <span id="validate_msg16">{lang('you_must_enter_product_days')}</span>
    <span id="validate_msg17">{lang('roi_should_be_between_0_to_100')}</span>
    <span id="validate_msg18">{lang('roi_should_be_greater_than_zero')}</span>
    <span id="validate_msg19">{lang('package_validity_should_be_a_positive_number')}</span>
    <span id="validate_msg20">{lang('digit_limit_is_five')}</span>
    <span id="validate_msg21">{lang('you_must_enter_bv_value')}</span>
    <span id="validate_msg22">{lang('you_must_enter_product_referral_commission')}</span>
    <span id="validate_msg24">{lang('product_referral_commission_must_be_number_between')}</span>
    <span id="amount_greater_than_zero">{sprintf(lang('field_greater_than_zero'), ucfirst(strtolower(lang('product_amount'))))}</span>
    
    <span id="validate_msg29">{lang('commission_must_be_between_0_to_100')}</span>
    <span id="validate_msg30">{lang('you_must_enter')} {strtolower(lang('rank_name'))}</span>
    <span id="validate_msg31">{lang('member_count_should_be_greater_than_zero')}</span>
    <span id="validate_msg32">{lang('bonus_must_be_between_0_to_100')}</span>
    <span id="validate_msg33">{lang('sales_commission_must_be_between_0_to_100')}</span>
    <span id="confirm">{lang('submit')}</span>
</div>

    {form_open('admin/add_membership_package','class="" role="form" id="form"')}
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend" id="title">{lang('add_membership_package')}</span>
                <a class="btn m-b-xs btn-sm btn-info btn-addon pull-right" href="{BASE_URL}/admin/membership_package" id="add_rank"><i class="fa fa-backward"></i> {lang('back')}</a>
            </legend>
              {include file="layout/error_box.tpl"}
                <div class="form-group">
                    <label class="control-label required" for="package_id">{lang('id')}</label>
                        <input type="text" class="form-control" name="package_id" id="package_id" value="{set_value('package_id')}" maxlength="6" autocomplete="off"/>
                        <span id="errmsg1"></span>
                        <span name ='form_err'>{form_error('package_id')}</span>
                </div>

                <div class="form-group">
                    <label class="control-label required" for="prod_name">{lang('name')}</label>
                        <input type="text" class="form-control" name="prod_name" id="prod_name" value="{set_value('prod_name')}" maxlength="32" autocomplete="off"/>
                        <span name ='form_err'>{form_error('prod_name')}</span>
                </div>

                <div class="form-group">
                    <label class="control-label required" for="product_amount">{lang('amount')}</label>
                        <div class="input-group {$input_group_hide}">
                            {$left_symbol}
                                <input class="form-control" type="text" name="product_amount" id="product_amount" value="{set_value('product_amount')}" maxlength="5" autocomplete="off" />
                            {$right_symbol}
                                <span id="errmsg1"></span>
                        </div>
                        <span name ='form_err'>{form_error('product_amount')}</span>
                </div>

                {if $pv_visible == 'yes'}
                    <div class="form-group">
                        <label class="control-label required" for="pair_value">{if $mlm_plan == "Stair_Step"}{lang('pv_value')}{else}{lang('product_pv')}{/if}</label>
                            <input class="form-control" type="text" name="pair_value" id="pair_value" value="{set_value('pair_value')}" maxlength="5" autocomplete="off"/>
                            <span id="errmsg2"></span>
                            <span name ='form_err'>{form_error('pair_value')}</span>
                    </div>
                {/if}

                {if $bv_visible == 'yes'}
                    <div class="form-group">
                        <label class=" control-label required" for="bv_value">{lang('bv_value')}</label>
                            <input class="form-control" type="text" name="bv_value" id="bv_value" value="{set_value('bv_value')}" maxlength="5" autocomplete="off"/>
                            <span id="errmsg2"></span>
                            <span name ='form_err'>{form_error('bv_value')}</span>
                    </div>
                {/if}

                {if $MODULE_STATUS['product_validity'] == "yes"}
                    <div class="form-group">
                        <label class="control-label required" for="package_validity">{lang('validity')}({lang('in_months')})</label>
                            <input class="form-control" type="text" name="package_validity" id="package_validity" value="{set_value('package_validity')}" maxlength="5" autocomplete="off"/>
                            <span id="errmsg3"></span>
                            <span name ='form_err'>{form_error('package_validity')}</span>
                    </div>
                {/if}

                <div class="panel-footer">
                    <button type="button" class="btn btn-sm btn-primary next_button pull-right butt">{lang('advanced_configuration')}</button>
                    {* <button type="submit" name="submit_prod" id="submit_prod" value="add_product" class="btn btn-sm btn-primary pull-right">{lang('submit')}</button> *}
                    <ul class="nav">
                    </ul>
                </div>
        </div>
    </div>

    {if $MLM_PLAN == 'Binary' && $compensation_status['plan_commission_status'] =='yes'}    
        <div class="panel panel-default add_prod">
            <div class="panel-body">
                <legend><span class="fieldset-legend">{lang('advanced_configuration')} : {lang('binary_commission')}</span></legend>
                    <div class="form-group">
                        <label class="control-label required" for="pair_price">{lang('pair_price')}</label>
                            <input class="form-control" type="text" name="pair_price" id="pair_price" value="{set_value('pair_price')}" maxlength="5" autocomplete="off"/>
                            <span id="errmsg2"></span>
                            <span name ='form_err'>{form_error('pair_price')}</span>
                    </div>

                    <div class="panel-footer">
                        <button type="button" class="btn btn-sm btn-primary next_button pull-right" name="advanced_package" id="advanced_package" value="advanced_package">{lang('next')}</button>
                        <button type="button" class="btn btn-sm btn-primary previous_button pull-right butt">{lang('previous')}</button>
                        <ul class="nav">
                        </ul>
                    </div>
            </div>
        </div>
    {/if}

    {if $MODULE_STATUS['sponsor_commission_status'] == "yes" && $compensation_status['sponsor_commission_status'] =='yes'}
        <div class="panel panel-default add_prod">
                <div class="panel-body">
                    <legend><span class="fieldset-legend">{lang('advanced_configuration')} : {lang('level_commission')}</span></legend>
                        <input type="hidden" id="level_commission_type" name="level_commission_type" value="{$obj_arr['level_commission_type']}" />
                        {assign var=level value=$obj_arr['commission_upto_level']}
                            {for $i=1 to $level}
                                <div class="form-group">
                                    <label class="control-label required">{lang('level')} - {$i} (%)</label>
                                        <input class="form-control level_com" type="text" name="level{$i}" id="level{$i}" value="{set_value("level{$i}")}" maxlength="5" data-lang="{lang('you_must_enter')} {lang('level')|lower} {$i} {lang('commission')}"/>
                                        <span name ='form_err'>{form_error("level{$i}")}</span>
                                </div>
                            {/for}

                        <div class="panel-footer">
                            <button type="button" class="btn btn-sm btn-primary next_button pull-right" name="advanced_package" id="advanced_package" value="advanced_package">{lang('next')}</button>
                            <button type="button" class="btn btn-sm btn-primary previous_button pull-right butt">{lang('previous')}</button>
                            <ul class="nav">
                            </ul>
                        </div>
                </div>
            </div>
        {/if}

        {if $MODULE_STATUS['rank_status'] == "yes" && $rank_configuration['downline_purchase_count'] || $rank_configuration['joinee_package'] && $compensation_status['rank_commission_status'] =='yes'}
            <div class="panel panel-default add_prod">
                <div class="panel-body">
                    <legend><span class="fieldset-legend">{lang('advanced_configuration')} : {lang('rank_commission')}</span></legend>
                        {if $rank_configuration['joinee_package']}
                            <div class="form-group">
                                <label class=" control-label required">{lang('rank_name')}</label>
                                <select name="rank_name" id="rank_name" class="form-control">
                                    <option value="">{lang('select')}</option>
                                    {foreach from=$rank_details item=v key=k}
                                        <option value="{$v.rank_id}">{$v.rank_name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        {/if}

                        {if $rank_configuration['downline_purchase_count']}
                            {foreach from=$rank_details item=v}
                                <div class="form-group">
                                    <label class=" control-label required">{lang('minimum_count_dwn_pck')} - {$v['rank_name']}</label>
                                        <input class="form-control pkg_count" type="text" maxlength="5" name ="rank_count{$v['rank_id']}" id = "rank_count{$v['rank_id']}" value="{set_value("rank_count{$v['rank_id']}")}" data-lang="{lang('you_must_enter')} {lang('member_count')}">
                                        <span name ='form_err'>{form_error("rank_count{$v['rank_id']}")}</span>
                                </div>
                            {/foreach}
                        {/if}

                        <div class="panel-footer">
                            <button type="button" class="btn btn-sm btn-primary next_button pull-right" name="advanced_package" id="advanced_package" value="advanced_package">{lang('next')}</button>
                            <button type="button" id="prevBtn" class="btn btn-sm btn-primary previous_button pull-right butt">{lang('previous')}</button>
                            <ul class="nav">
                            </ul>
                        </div>
                </div>
            </div>
        {/if}

        {if $MODULE_STATUS['referal_status'] == "yes" && $compensation_status['referal_commission_status'] =='yes'}
            {if $commission_type == 'sponsor_package' || $commission_type == 'joinee_package'}
                <div class="panel panel-default add_prod">
                    <div class="panel-body">
                        <legend><span class="fieldset-legend">{lang('advanced_configuration')} : {lang('referral_commission')}</span></legend>
                        <div class="form-group">
                            <label class="control-label required" for="referral_commission">{lang('referral_commission')}</label>
                                <div class="input-group {$input_group_hide}">
                                    {$left_symbol}
                                        <input class="form-control" type="text" name="referral_commission" id="referral_commission" value="{set_value('referral_commission')}" maxlength="5" autocomplete="off"/>
                                    {$right_symbol}
                                </div>
                        </div>

                        <div class="panel-footer">
                            <button type="button" class="btn btn-sm btn-primary next_button pull-right" name="advanced_package" id="advanced_package" value="advanced_package">{lang('next')}</button>
                            <button type="button" id="prevBtn" class="btn btn-sm btn-primary previous_button pull-right butt">{lang('previous')}</button>
                            <ul class="nav">
                            </ul>
                        </div>

                    </div>
                </div>
            {/if}
        {/if}
        
        {if $MODULE_STATUS['roi_status'] == "yes" && $compensation_status['roi_commission_status'] =='yes'}
            <div class="panel panel-default add_prod">
                <div class="panel-body">
                    <legend><span class="fieldset-legend">{lang('advanced_configuration')} : {lang('roi_commission')}</span></legend>
                        <div class="form-group">
                            <label class=" control-label required" for="roi">{lang('Hyip')}</label>
                                <input class="form-control" type="text" name="roi" id="roi" value="{set_value('roi')}" maxlength="5" autocomplete="off"/>
                                <span id="errmsg2"></span>
                                <span name ='form_err'>{form_error("roi")}</span>
                        </div>

                        <div class="form-group">
                            <label class=" control-label required" for="days">{lang('days')}</label>
                                <input class="form-control" type="text" name="days" id="days" value="{set_value('days')}" maxlength="5" autocomplete="off"/>
                                <span id="errmsg2"></span>
                                <span name ='form_err'>{form_error("days")}</span>
                        </div>

                        <div class="panel-footer">
                            <button type="button" class="btn btn-sm btn-primary next_button pull-right" name="advanced_package" id="advanced_package" value="advanced_package">{lang('next')}</button>
                            <button type="button" class="btn btn-sm btn-primary previous_button pull-right butt">{lang('previous')}</button>
                            <ul class="nav">
                            </ul>
                        </div>
                </div>
            </div>
        {/if}

        {if $compensation_status['matching_bonus'] =='yes'}
            <div class="panel panel-default add_prod">
                <div class="panel-body">
                    <legend><span class="fieldset-legend">{lang('advanced_configuration')} : {lang('matching_bonus')}</span></legend>
                        {assign var=level value=$obj_arr['commission_upto_level']}
                            {for $i=1 to $level}
                                <div class="form-group">
                                    <label class=" control-label required" for="matching_bonus{$i}">{lang('level')} {$i} {lang('bonus')} (%)</label>
                                        <input class="form-control match_bonus" type="text" name="matching_bonus{$i}" id="matching_bonus{$i}" value="{set_value("matching_bonus{$i}")}" maxlength="5" autocomplete="off" data-lang="{lang('you_must_enter')} {lang('level')|lower} {$i} {lang('matching_bonus')|lower}"/>
                                        <span name ='form_err'>{form_error("matching_bonus{$i}")}</span>
                                </div>
                            {/for}

                        <div class="panel-footer">
                            <button type="button" class="btn btn-sm btn-primary next_button pull-right" name="advanced_package" id="advanced_package" value="advanced_package">{lang('next')}</button>
                            <button type="button" class="btn btn-sm btn-primary previous_button pull-right butt">{lang('previous')}</button>
                            <ul class="nav">
                            </ul>
                        </div>
                </div>
            </div>
        {/if}

        {if $compensation_status['sales_commission'] =='yes'}
            <div class="panel panel-default add_prod">
                <div class="panel-body">
                    <legend><span class="fieldset-legend">{lang('advanced_configuration')} : {lang('sales_commission')}</span></legend>
                        {assign var=level value=$obj_arr['sales_level']}
                            {for $j=1 to $level}
                                <div class="form-group">
                                    <label class=" control-label required">{lang('level')} {$j} {lang('sales_commission')} (%)</label>
                                        <input class="form-control sales_commission" type="text" name="sales_commission{$j}" id="sales_commission{$j}" value="{set_value("sales_commission{$j}")}" maxlength="5" autocomplete="off" data-lang="{lang('you_must_enter')} {lang('level')|lower} {$j} {lang('sales_commission')|lower}"/>
                                        <span name ='form_err'>{form_error("sales_commission{$j}")}</span>
                                </div>
                            {/for}

                        <div class="panel-footer">
                            <button type="button" class="btn btn-sm btn-primary next_button pull-right" name="advanced_package" id="advanced_package" value="advanced_package">{lang('next')}</button>
                            <button type="button" class="btn btn-sm btn-primary previous_button pull-right butt">{lang('previous')}</button>
                            <ul class="nav">
                            </ul>
                        </div>
                </div>
            </div>
        {/if}

  {form_close()}

{/block}

{block name=script}
    {$smarty.block.parent}
        <script src="{$PUBLIC_URL}/javascript/product_config.js"></script>
        <script src="{$PUBLIC_URL}/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
        <link href="{$PUBLIC_URL}/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet">
        <script>
            $(function() {
                $('.colorpik').colorpicker();
            });
        </script>
{/block}

{block name=style}
     {$smarty.block.parent}
     <style>
     .butt {
         margin: 0px 10px;
     }
     .add_prod{
         display: none;
     }
     </style>
{/block}