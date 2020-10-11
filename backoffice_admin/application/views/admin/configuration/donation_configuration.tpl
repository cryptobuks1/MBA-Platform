{extends file=$BASE_TEMPLATE}

{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/donation_config.js"></script>
{/block}
{block name=style}{$smarty.block.parent}
    <style>
        .error{
            color:#a94442
        }
        </style>
{/block}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="error_msg7">{lang('digits_only')}</span>
    <span id="error_msg9">{lang('level_name_required')}</span>
    <span id="error_msg10">{lang('rate_required')}</span>
    <span id="error_msg11">{lang('count_required')}</span>
    <span id="error_msg13">{lang('please_enter_max_count')}</span>
    <span id="error_msg12">{lang('enter_unique_level')}</span>
    <span id="error_msg14">{lang('please_enter_max_rate')}</span>
    <span id="error_msg14">{lang('please_enter_max_ref')}</span>
</div>

{include file="admin/configuration/system_setting_common.tpl"}



{form_open('', 'role="form" class="" method="post" name="donation_form" id="donation_form"')}

    <div class="panel panel-default">
    <div class="panel-body">
    <legend> <span class="fieldset-legend"> {lang('donation_settings')}</span></legend>
        {include file="layout/error_box.tpl"}
        {assign var=i value="0"}
        <div class=" table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('level')}</th>
                    <th>{lang('rate')}({lang('donation_money')})</th>
                    <th>{lang('referral_count')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var="path" value="{$BASE_URL}admin/"}
                {assign var="i" value=0}
                {foreach from=$donation_array item=k}
                    {$i=$i+1}
                    <tr>
                        <td>{counter}</td>
                        <td>
                            <input type="text" name="level_name{$k.id}" id="level_name{$k.id}" value="{$k.level_name}" class="level_name form-control">
                            <span id="errmsgg10"></span>
                            {form_error("level_name{$k.id}")}
                        </td>
                        <td>
                            <input type="text" name="don_rate_pm{$k.id}" id="don_rate_pm{$k.id}" value="{$k.pm_rate}" class="donation_rate form-control">
                            <span style="color:red" id="errmsgg9"></span>
                            {form_error("don_rate_pm{$k.id}")}
                        </td>
                        <td>
                            <input type="text" name="don_count{$k.id}" id="don_count_{$k.id}" value="{$k.referral_count}" class="donation_count form-control">
                            <span style="color:red" id="errmsgg10"></span>
                            {form_error("don_count{$k.id}")}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
        </div>
        <div class="form-group">
            <label class="required control-label">{lang('donation_type')}</label>
            <select class="form-control" name="donation_type"  id="donation_type">
                <option value="manuel" {if $donation_type=='manuel'}  selected="true"{/if}>{lang('manuel')}</option>
                <option value="automatic" {if $donation_type=='automatic'} selected="true"{/if}>{lang('automatic')}</option>
            </select>
            {form_error("donation_type")}
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-primary" name="donation_submit" type="submit" value="Submit">{lang('submit')}</button>
        </div>
        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
        {form_close()}
        </div>
    </div>


{/block}