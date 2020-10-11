{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">

    <span id="confirm_msg_inactivate">{lang('sure_you_want_to_inactivate_this_rank_there_is_no_undo')}</span>
    <span id="confirm_msg_edit">{lang('sure_you_want_to_edit_this_rank_there_is_no_undo')}</span>
    <span id="confirm_msg_activate">{lang('sure_you_want_to_activate_this_rank_there_is_no_undo')}</span>
    <span id="confirm_msg_delete">{lang('sure_you_want_to_delete_this_rank_there_is_no_undo')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg1">{lang('you_must_enter_rank_name')}</span>
    <span id="error_msg2">{lang('you_must_enter_referal_count')}</span>
    <span id="error_msg3">{lang('you_must_enter_rank_achivers_bonus')}</span>
    <span id="error_msg4">{lang('alpha_digit_only')}</span>
    <span id="error_msg5">{lang('digits_only')}</span>
    <span id="error_msg6">{lang('are_you_sure_you_want_to_Delete_There_is_NO_undo')}</span>
    <span id="error_msg7">{lang('are_you_sure_you_want_to_add')}</span>
    <span id="error_msg8">{lang('digit_limit_5')}</span>
    <span id="error_msg9">{lang('field_required')}</span>
    <span id="error_msg10">{lang('rank_name_required')}</span>
    <span id="error_msg11">{lang('referral_count_required')}</span>
    <span id="error_msg12">{lang('personal_pv_required')}</span>
    <span id="error_msg13">{lang('group_pv_required')}</span>
    <span id="error_msg14">{lang('digit_limit_10')}</span>
    <span id="error_msg15">{lang('greater_than_zero')}</span>
    <span id="error_msg16">{lang('rank_name_should_be_unique')}</span>
    <span id="error_msg17">{lang('downline_member_count_required')}</span>
    <span id="error_msg18">{lang('you_must_enter')} {lang('downline_count')|lower}</span>
    <span id="error_msg19">{lang('package_count_required')}</span>
    <span id="error_msg20">{lang('digit_greater_than_0')}</span>
    <span id="error_msg21">{lang('referral_commission_required')}</span>
    <span id="error_msg22">{lang('you_must_enter')} {lang('team_member')|lower}</span>
    <span id="error_msg23">{lang('you_must_enter')} {lang('rank_color')} </span>
    <span id="error_msg24">{lang('you_must_enter_rank_incentive_b')}</span>
    <span id="error_msg25">{lang('you_must_enter_rank_incentive_r')}</span>
    <span id="error_msg26">{lang('greater_than_zero')}</span>
    <span id="error_msg27">{lang('monthly_cap_greater_than_zero')}</span>
    <span id="error_msg28">{lang('bin_bonus_less_tha_equla_100')}</span>
</div>

<legend>
    <span class="fieldset-legend">
        {if $action == 'edit'}{lang('edit_rank')}{else}{lang('add_new_rank')}{/if}
    </span>
    <a href="{$BASE_URL}admin/rank_configuration" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        {form_open('', 'role="form" class="" method="post" name="rank_form" id="rank_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('rank_name')}</label>
                <input type="text" class="form-control" name="rank_name" id="rank_name"  {if $action == 'edit'} value="{$rank_name}" {else} value="{set_value('rank_name')}" {/if}>
                {form_error('rank_name')}
            </div>
            {if $obj_arr['joinee_package']}
                <div class="form-group">
                    <label class="required">{lang('package_name')}</label>
                    <select name="joinee_pck" id="joinee_pck" class="form-control">
                        {foreach from=$package_rank item=v key=k}
                            <option value="{$v.product_id}" {if isset($rank_details[0]['joinee_package'][0]) && $rank_details[0]['joinee_package'][0]['product_id'] == $v.product_id} selected {/if}>{$v.product_name}</option>
                        {/foreach}
                    </select>
                    {form_error('joinee_pck')}
                </div>
            {/if}

            {if $obj_arr['referal_count']}
                <div class="form-group">
                    <label class="required">{lang('referal_count')}</label>
                    <input type="text" class="form-control" maxlength="5" name="ref_count" id="ref_count"  {if $action == 'edit'} value="{$referal_count}" {else} value="{set_value('ref_count')}" {/if}>
                    {form_error('ref_count')}
                </div>
            {/if}

            {if $obj_arr['personal_pv']}
                <div class="form-group">
                    <label class="required">{lang('personal_pv')}</label>
                    <input type="text" class="form-control" name="personal_pv" id="personal_pv"  {if $action == 'edit'} value="{$personal_pv}" {else} value="{set_value('personal_pv')}" {/if}>
                    {form_error('personal_pv')}
                </div>
            {/if}

            {if $obj_arr['group_pv']}
                <div class="form-group">
                    <label class="required">{lang('group_pv')}</label>
                    <input type="text" class="form-control" name="gpv" id="gpv"  {if $action == 'edit'} value="{$gpv}" {else} value="{set_value('gpv')}" {/if}>
                    {form_error('gpv')}
                </div>
            {/if}
                
            {if $MLM_PLAN == 'Matrix' || $MLM_PLAN == 'Binary'}
                {if $obj_arr['downline_member_count']}
                    <div class="form-group">
                        <label class="required">{lang('downline_member_count')}</label>
                        <input type="text" class="form-control" maxlength="5" name="downline_count" id="downline_count"  {if $action == 'edit'} value="{$downline_count}" {else} value="{set_value('downline_count')}" {/if}>
                        {form_error('downline_count')}
                    </div>
                {/if}

                {if $obj_arr['downline_purchase_count']}
                    {foreach $package_rank as $p}
                        <div class="form-group">
                            <label class="required">{lang('minimum_count_dwn_pck')} - {$p['product_name']}</label>
                            <input type="text" class="form-control pkg_count" maxlength="5" name="package_count[{$p['product_id']}]" id="downline_count{$p['product_id']}" {if $action == 'edit'} value="{$p['package_count']}" {else} value="{$p['package_count']}" {/if} data-lang="{lang('you_must_enter')} {lang('member_count')|lower}">
                            {form_error('package_count[]')}
                        </div>
                    {/foreach}
                {/if}

                {if $obj_arr['downline_rank']}
                    {foreach $dow_rank as $dr}
                        <div class="form-group">
                            <label class="required">{lang('minimum_count_dwn_rank')}  - {$dr['rank_name']}</label>
                            <input type="text" class="form-control downline_rank_count" maxlength="5" name="downline_rank_count[{$dr['rank_id']}]" id="downline_rank_count[{$dr['rank_id']}]"  {if $action == 'edit'} value="{$dr['rank_count']}" {else} value="{$dr['rank_count']}" {/if} data-lang="{lang('you_must_enter')} {lang('downline_rank_count')|lower}">
                             {form_error('downline_rank_count[]')}
                        </div>
                    {/foreach}
                {/if}

            {/if}

            {if $MODULE_STATUS['referal_status'] == "yes" && $commission_type == 'rank'}
                <div class="form-group">
                    <label class="required">{lang('referal_commission')}</label>
                    <div class="input-group {$input_group_hide}">
                        {$left_symbol}
                            <input type="text" class="form-control" maxlength="5" name="ref_commission" id="ref_commission"  {if $action == 'edit'} value="{$ref_commission}" {else} value="{set_value('ref_commission')}" {/if}>
                        {$right_symbol}
                    </div>
                    {form_error('ref_commission')}
                </div>
            {/if}

           {* <div class="form-group">
                <label class="required">{lang('rank_achieved_bonus')}</label>
                <div class="input-group {$input_group_hide}">
                    {$left_symbol}
                    <input type="text" class="form-control" maxlength="10" name="rank_achievers_bonus" id="rank_achievers_bonus"  {if $action == 'edit'} value="{$rank_bonus}" {else} value="{set_value('rank_achievers_bonus')}" {/if}>
                    {$right_symbol}
                </div>
                {form_error('rank_achievers_bonus')}
            </div>*}
            <div class="form-group">
                <label class="required">{lang('rank_incentive_bonus')}</label>
                <div class="input-group {$input_group_hide}">
                    {$left_symbol}
                    <input type="text" class="form-control" maxlength="10" name="rank_incentive_bonus" id="rank_incentive_bonus"  {if $action == 'edit'} value="{$rank_incentive_bonus}" {else} value="{set_value('rank_incentive_bonus')}" {/if}>
                    {$right_symbol}
                </div>
                {form_error('rank_incentive_bonus')}
            </div>
            
            <div class="form-group">
                <label class="required">{lang('rank_incentive_reward')}</label>
                <div class="input-group {$input_group_hide}">
                    
                    <input type="text" class="form-control"  name="rank_incentive_reward" id="rank_incentive_reward"  {if $action == 'edit'} value="{$rank_incentive_reward}" {else} value="{set_value('rank_incentive_reward')}" {/if}>
                  
                </div>
                {form_error('rank_incentive_reward')}
            </div>
            
            <!--start binary bonus and cap configuration --- sahla-->
             <div class="form-group">
                <label class="required">{lang('binary_bonus_percentage')}(%)</label>
                <div class="input-group {$input_group_hide}">
                    
                    <input type="text" class="form-control"  name="binary_bonus_percentage" id="binary_bonus_percentage"  {if $action == 'edit'} value="{$binary_bonus_percentage}" {else} value="{set_value('binary_bonus_percentage')}" {/if}>
                  
                </div>
                {form_error('binary_bonus_percentage')}
            </div>
            
             <div class="form-group">
                <label class="required">{lang('binary_monthly_cap')}</label>
                <div class="input-group {$input_group_hide}">
                    
                    <input type="text" class="form-control"  name="binary_monthly_cap" id="binary_monthly_cap"  {if $action == 'edit'} value="{$binary_monthly_cap}" {else} value="{set_value('binary_monthly_cap')}" {/if}>
                  
                </div>
                {form_error('binary_monthly_cap')}
            </div>
                <!-- end binary bonus and cap configuration --- sahla-->

            <div class="form-group">
                <label class="required">{lang('rank_color')}</label>
                <div class="input-group m-b colorpicker-component colorpik">
                <input class="form-control rank_color" type="text"  name="rank_color" id="rank_color" {if $action == 'edit'} value="{$rank_color}" {else} value="{set_value('rank_color')}" {/if} readonly>
                <span class="input-group-addon"><i></i></span>
                </div>  
            </div>

            <div class="form-group">
                {if $edit_id==""}
                    <button class="btn btn-sm btn-primary" name="rank_submit" type="submit" value="Submit">{lang('submit')}</button>
                {else}
                    <button class="btn btn-sm btn-primary" name="rank_update" type="submit" value="Update">{lang('update')}</button>
                    <input name="rank_id" id="rank_id" type="hidden" value="{$rank_id}" />
                {/if}
                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
            </div>
        {form_close()}
    </div>
</div>
{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
     <link href="{$PUBLIC_URL}/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet">
    <script>
        $(function() {
            $('.colorpik').colorpicker();
        });
    </script>
{/block}
