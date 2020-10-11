{extends file=$BASE_TEMPLATE}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_performance_bonus.js" type="text/javascript" ></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="validate_msg27">{lang('field_must_be_between_0_100')}</span>
    <span id="validate_msg28">{lang('field_must_be_greater_than_0')}</span>
    <span id="validate_msg29">{lang('field_must_be_greater_than_equal_0')}</span>
    <span id="you_must_enter">{lang('you_must_enter')}</span>
    <span id="lang_bonus">{lang('bonus')|strtolower}</span>
    <span id="lang_personal_pv">{lang('personal_pv')|strtolower}</span>
    <span id="lang_group_pv">{lang('group_pv')|strtolower}</span>
    <span id="validate_msg13">{lang('digit_only')}</span>
</div>

<div class="button_back">
    <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
        <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
        <input type="hidden" name="active_tab" id="active_tab" value="">
        <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0" />
        <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
        {include file="layout/error_box.tpl"}
        {if $performance_bonus_status == "yes"}
                <legend>
                    <span class="fieldset-legend">
                        {lang('performance_bonus')}
                    </span>
                </legend>
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr class="th">
                                <th>#</th>
                                <th>{lang('bonus_name')}</th>
                                <th>{lang('personal_pv')}</th>
                                <th>{lang('group_pv')}</th>
                                <th>{lang('bonus_percent')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$i = 0}
                            {foreach from=$performance_bonus_config item=v key=bonus_name}
                                {$i = $i + 1}
                                <tr>
                                    <td>{$i}</td>
                                    <td>{lang($bonus_name)}</td>
                                    <td>
                                        <input type="text" name="performance{$i}_personal_pv" value="{$v.personal_pv}" class="form-control performance_personal_pv">
                                        {form_error("performance{$i}_personal_pv")}
                                    </td>
                                    <td>
                                        <input type="text" name="performance{$i}_group_pv" value="{$v.group_pv}" class="form-control performance_group_pv">
                                        {form_error("performance{$i}_group_pv")}
                                    </td>
                                    <td>
                                        <input type="text" name="performance{$i}_bonus_percent" value="{$v.bonus_percent}" class="form-control performance_bonus_percent">
                                        {form_error("performance{$i}_bonus_percent")}
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="performance_bonus_setting" id="performance_bonus_setting">{lang('update')}</button>
                </div>
            {/if}
        {form_close()}
    </div>
</div>
<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>

{/block}