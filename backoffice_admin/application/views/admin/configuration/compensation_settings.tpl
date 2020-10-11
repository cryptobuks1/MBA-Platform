
{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="pnt_val">{lang('point_value')}</span>
    <span id="pr_val">{lang('pair_value')}</span>
    <span id="fl_lmt">{lang('flush_out_limit')}</span>
</div>
{include file="admin/configuration/system_setting_common.tpl"}

<div class="panel panel-default">
    <div class="panel-body">
        <legend><span class="fieldset-legend">{lang('compensation_settings')}</span></legend>
        <div class="table-responsive">
            <table class="table borderless table" id="compensation_page">
                <thead>
                    <tr>
                        <th>{lang('type_of_compensation')}</th>
                        <th>{lang('status')}</th>
                        <th>{lang('configuration')}</th>
                    </tr>
                </thead>
                <tbody>
                    {if $MLM_PLAN != 'Unilevel' && $MLM_PLAN != 'Matrix' && $MLM_PLAN != 'Party' && $MLM_PLAN != 'Stair_Step' && $MLM_PLAN != 'Donation'}

                    {$commission_link = ""}
                    {if $MLM_PLAN  eq 'Binary'}
                        {$commission_link = "binary_bonus_config"}
                    {* {elseif $MLM_PLAN eq 'Stair_Step'}
                        {$commission_link = "stairstep_configuration"} *}
                    {elseif $MLM_PLAN eq 'Board'}
                        {$commission_link = "board_bonus_config"}
                    {* {elseif $MLM_PLAN eq 'Donation'}
                        {$commission_link = "donation_configuration"} *}
                    {/if}

                  <!--  <tr>
                        <td> {if $MLM_PLAN  eq 'Binary'}
                                {lang('binary_commission')}
                            {* {elseif $MLM_PLAN eq 'Stair_Step'}
                                {lang('stair_step_commission')} *}
                            {elseif $MLM_PLAN eq 'Board'}
                                {if $MODULE_STATUS['table_status'] eq 'no'}
                                    {lang('board_commission')}
                                {else}
                                    {lang('table_commission')}
                                {/if}
                            {* {elseif $MLM_PLAN eq 'Donation'}
                                {lang('donation')} *}
                            {/if}
                        </td>
                        <td>
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="plan_commission_status" name="plan_commission_status" {if $plan_commission == 'yes'} checked {/if}>
                                    <i></i>
                                </label>
                            </div>
                        </td>
                        <td><a href="{if $plan_commission == 'yes'} {$BASE_URL}admin/{$commission_link} {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $plan_commission == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted{/if}"> <i class="fa fa-cog"></i></a></td>
                    </tr>-->
                    {/if}

                    {if ($MLM_PLAN =="Party" && $MODULE_STATUS['sponsor_commission_status'] == "yes" ) || ($MLM_PLAN !="Party")}
                       <!-- <tr>
                            <td>{if $MODULE_STATUS['xup_status'] == 'yes'} {lang('xup_commission')} {else} {lang('level_commission')} {/if}</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="sponsor_commission_status" name="sponsor_commission_status" {if $sponsor_commission == 'yes'} checked {/if}>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="{if $sponsor_commission == 'yes'} {$BASE_URL}admin/level_commissions {else} javascript:void(0); {/if}" class="btn btn-sm btn-icon{if $sponsor_commission == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted{/if}" data-name="level_commission" name="level_commission"> <i class="fa fa-cog"></i></span></td>
                        </tr>-->
                    {/if}

                    {if $MODULE_STATUS['rank_status']=='yes'}
                        <tr>
                            <td>{lang('rank_commission')}</td>
                            <td>
                                <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="rank_commission_status" name="rank_commission_status" {if $rank_commission == 'yes'} checked {/if}>
                                    <i></i>
                                </label>
                            </div>
                            </td>
                            <td><a href="{if $rank_commission == 'yes'} {$BASE_URL}admin/rank_configuration {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $rank_commission == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted{/if}"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    {/if}

                   <!-- <tr>
                        <td>{lang('referal_commission')}</td>
                        <td>
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="referal_commission_status" name="referal_commission_status" {if $referal_commission == 'yes'} checked {/if}>
                                    <i></i>
                                </label>
                            </div>
                        </td>
                        <td><a href="{if $referal_commission == 'yes'} {$BASE_URL}admin/configuration/referal_commissions {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $referal_commission == 'yes'} btn-rounded btn-default{else} btn-disabled btn-muted{/if}"> <i class="fa fa-cog"></i></a></td>
                    </tr>-->

                    {if $MODULE_STATUS['roi_status'] == 'yes'}
                        <tr>
                            <td>{lang('hyip_commission')}</td>
                            <td>
                                <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="roi_commission_status" name="roi_commission_status" {if $roi_commission == 'yes'} checked {/if}>
                                    <i></i>
                                </label>
                            </div>
                            </td>
                            <td><a href="{if $roi_commission == 'yes'} {$BASE_URL}admin/configuration/roi_commission {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $roi_commission == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted{/if}"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    {/if}

                    {if $bonus['matching_bonus'] == 'yes'}
                        <tr>
                            <td>{lang('matching_bonus')}</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="matching_bonus" name="matching_bonus_status" {if $matching_bonus_status == 'yes'} checked {/if}>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="{if $matching_bonus_status == 'yes'} {$BASE_URL}admin/configuration/matching_bonus {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $matching_bonus_status == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted{/if}"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    {/if}

                    {if $MODULE_STATUS['rank_status']=='yes' && $bonus['pool_bonus'] == 'yes'}
                        <tr>
                            <td>{lang('pool_bonus')}</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="pool_bonus" name="pool_bonus_status" {if $pool_bonus_status == 'yes'} checked {/if}>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="{if $pool_bonus_status == 'yes'} {$BASE_URL}admin/pool_bonus_config {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $pool_bonus_status == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted{/if}"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    {/if}

                    {if $bonus['fast_start_bonus'] == 'yes'}
                        <tr>
                            <td>{lang('fast_start_bonus')}</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="fast_start_bonus" name="fast_start_bonus_status" {if $fast_start_bonus_status == 'yes'} checked {/if}>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="{if $fast_start_bonus_status == 'yes'} {$BASE_URL}admin/fast_start_bonus_config {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $fast_start_bonus_status == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted{/if}"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    {/if}

                    {if $bonus['performance_bonus'] == 'yes'}
                        <tr>
                            <td>{lang('performance_bonus')}</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="performance_bonus" name="performance_bonus_status" {if $performance_bonus_status == 'yes'} checked {/if}>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="{if $performance_bonus_status == 'yes'} {$BASE_URL}admin/configuration/performance_bonus {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $performance_bonus_status == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted{/if}"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    {/if}

                    {if $MODULE_STATUS['repurchase_status']=='yes' || ($MODULE_STATUS['opencart_status'] == "yes" && $MODULE_STATUS['opencart_status_demo'] == "yes")}
                       <!-- <tr>
                            <td>{lang('sales_commission')}</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="sales_commission" name="sales_commission" {if $sales_commission_status == 'yes'} checked {/if}>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="{if $sales_commission_status == 'yes'} {$BASE_URL}admin/configuration/sales_commission {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $sales_commission_status == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted{/if}"> <i class="fa fa-cog"></i></a></td>
                        </tr>-->
                    {/if}
                    
                    <tr>
                        <td>{lang('car_bonus_config')}</td>
                        <td>
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="car_bonus" name="car_bonus" {if $car_bonus_status == 'yes'} checked {/if}>
                                    <i></i>
                                </label>
                            </div>
                        </td>
                        <td><a href="{if $car_bonus_status == 'yes'} {$BASE_URL}admin/configuration/car_bonus_config {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $car_bonus_status == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted {/if}"> <i class="fa fa-cog"></i></a></td>
                    </tr>
                     <tr>
                        <td>{lang('global_bonus_config')}</td>
                        <td>
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="global_bonus" name="global_bonus" {if $global_bonus_status == 'yes'} checked {/if}>
                                    <i></i>
                                </label>
                            </div>
                        </td>
                        <td><a href="{if $global_bonus_status == 'yes'} {$BASE_URL}admin/configuration/global_bonus_config {else} javascript:void(0); {/if}"class="btn btn-sm btn-icon {if $global_bonus_status == 'yes'} btn-rounded btn-default {else} btn-disabled btn-muted {/if}"> <i class="fa fa-cog"></i></a></td>
                    </tr>

                </tbody>
            </table>

            <div id='compensation_div'> </div>

        </div>
    </div>
</div>

<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>

{/block}

{block name='style'}
     {$smarty.block.parent}
<style>
    .table>tbody>tr>td {
        text-align: left;
        border-bottom:0;
        border-top: 0;
    }

    table.table thead {
        background-color: white;
    }
     </style>
{/block}

{block name='script'}
     {$smarty.block.parent}
         <script src="{$PUBLIC_URL}javascript/plan_settings.js"></script>
{/block}