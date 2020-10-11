{extends file=$BASE_TEMPLATE}

{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/validate_hyip.js"></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg1">{lang('you_must_select_the_date')}</span>
    <span id="validate_msg2">{lang('you_must_enter_reason')}</span>
    <span id="validate_msg3">{lang('atleast_3_required')}</span>
    <span id="validate_msg4">{lang('max_20_characters_allowed')}</span>
    <span id="err_msg10">{lang('error')}</span>
    <span id="errormsg4">{lang('date_available')}</span>
    <span id="validate_msg72">{lang('date_cannot_be_null')}</span>
    <span id="validate_msg27">{lang('date_not_availablity')}</span>
    <span id="validate_msg28">{lang('date_not_available')}</span>
    <span id="validate_msg5">{lang('date_available')}</span>
    <span id="validate_msg10">{lang('select_future_date')}</span>
</div>

{include file="admin/configuration/system_setting_common.tpl"}


<div class="panel panel-default">
    <div class="panel-body">
    
<legend>
    <span class="fieldset-legend">
        {lang('holidays_settings')}
    </span>
</legend>
        {form_open('', 'role="form" class="" method="post" name="holiday_form" id="holiday_form"')}
            {include file="layout/error_box.tpl"}
            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"/>
            <div class="form-group">
                <label class="required">{lang('hday')}</label>
                <input   class="form-control date-picker-custom" name="week_date2" id="week_date2" type="text">
                <span id="checkmsg" class="error-img"></span>
                {form_error('currency_title')}
            </div>
            <div class="form-group">
                <label class="required">{lang('reason')}</label>
                <textarea class="form-control" name="reason" id="reason"></textarea>
                {form_error('reason')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="holiday" id="holiday" type="submit" value="Submit">{lang('submit')}</button>
            </div>
        {form_close()}
    </div>
</div>


<div class="panel panel-default table-responsive">
<div class="panel-body">
<legend>
    <span class="fieldset-legend">
        {lang('holiday')}
    </span>
</legend>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{lang('sl_no')}</th>
                <th>{lang('date')}</th>
                <th>{lang('reason')}</th>
                <th>{lang('action')}</th>
            </tr>
        </thead>
        {if count($holidays_array)>0}
            <tbody>
                {assign var="root" value="{$BASE_URL}admin/"}
                {assign var="i" value=0}
                {foreach from=$holidays_array item=v}
                    {$i=$i+1}
                    <tr>
                        <td>{$i}</td>
                        <td>{$v.date}</td>
                        <td>{$v.reason}</td>
                        <td class="ipad_button_table">
                            <div class="field">
                                <button class='has-tooltip btn btn_size text-danger btn-link' onclick="deleteconfig('{$v.id}')"><i class="fa fa-trash-o"></i>
                                </button>
                                <span class='tooltip green'>
                                    <p>{lang('delete')}</p>
                                </span>
                            </div>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        {else}
            <tbody>
                <tr>
                    <td colspan="4" align="center">
                        <h4 align="center"> {lang('no_holidays_found')}</h4>
                    </td>
                </tr>
            </tbody>
        {/if}
    </table>
    </div>
</div>

{/block}