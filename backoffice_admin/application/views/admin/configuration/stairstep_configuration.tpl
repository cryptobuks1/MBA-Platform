{extends file=$BASE_TEMPLATE}

{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/validate_stairstep.js"></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="confirm_msg_inactivate">{lang('sure_you_want_to_inactivate_this_stairstep_there_is_no_undo')}</span>
    <span id="confirm_msg_edit">{lang('sure_you_want_to_edit_this_stairstep_there_is_no_undo')}</span>
    <span id="confirm_msg_activate">{lang('sure_you_want_to_activate_this_stairstep_there_is_no_undo')}</span>
    <span id="confirm_msg_delete">{lang('sure_you_want_to_delete_this_stairstep_there_is_no_undo')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg1">{lang('you_must_enter_step_name')}</span>
    <span id="error_msg2">{lang('you_must_enter_pv')}</span>
    <span id="error_msg3">{lang('you_must_enter_gpv')}</span>
    <span id="error_msg4">{lang('you_must_enter_step_commission')}</span>
    <span id="error_msg7">{lang('digits_only')}</span>
    <span id="error_msg8">{lang('you_must_enter_override_commission')}</span>
    <span id="override_required">{lang('override_commission')|strtolower}</span>
    <span id="error_msg5">{sprintf(lang('field_must_be_between_0_100'), ucfirst(strtolower(lang('override_commission'))))}</span>
</div>

{include file="admin/configuration/system_setting_common.tpl"}


<div class="panel panel-default">
    <div class="panel-body">
        <legend>
            <span class="fieldset-legend">
                {lang('stairstep_settings')}
            </span>
        </legend>
        {form_open('', 'role="form" class="" method="post" name="stair_form" id="stair_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('step_name')}</label>
                <input type="text" class="form-control" name="step_name" id="step_name" value="{$step_name}">
                {form_error('step_name')}
            </div>
            <div class="form-group">
                <label class="required">{lang('personal_pv')}</label>
                <input type="text" class="form-control" name="personal_pv" id="personal_pv" value="{$personal_pv}">
                {form_error('personal_pv')}
            </div>
            <div class="form-group">
                <label class="required">{lang('group_pv')}</label>
                <input type="text" class="form-control" name="group_pv" id="group_pv" value="{$group_pv}">
                {form_error('group_pv')}
            </div>
            <div class="form-group">
                <label class="required">{lang('step_commission')}</label>
                <input type="text" class="form-control" name="step_commission" id="step_commission" value="{$step_commission}">
                {form_error('step_commission')}
            </div>
            <div class="form-group">
                {if $edit_id==""}
                    <button class="btn btn-sm btn-primary" name="step_submit" type="submit" value="Submit">{lang('submit')}</button>
                {else}
                    <button class="btn btn-sm btn-primary" name="step_update" type="submit" value="Update">{lang('update')}</button>
                    <input name="step_id" id="step_id" type="hidden" value="{$edit_id}"/>
                {/if}
            </div>
            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
        {form_close()}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <legend>
            <span class="fieldset-legend">
                {lang('stairstep_settings')}
            </span>
        </legend>
        <div class="panel panel-defualt table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{lang('sl_no')}</th>
                        <th>{lang('step_name')}</th>
                        <th>{lang('personal_pv')}</th>
                        <th>{lang('group_pv')}</th>
                        <th>{lang('step_commission')}</th>
                        <th>{lang('status')}</th>
                        <th>{lang('action')}</th>
                    </tr>
                </thead>
                {if $count>0}
                    <tbody>
                        {assign var="path" value="{$BASE_URL}admin/"}
                        {assign var="i" value=0}
                        {foreach from=$step_details item=v}
                            {assign var="step_id" value="{$v.step_id}"}
                            {$i=$i+1}
                            <tr>
                                <td>{counter}</td>
                                <td>{$v.step_name}</td>
                                <td>{$v.personal_pv}</td>
                                <td>{$v.group_pv}</td>
                                <td>{$v.step_commission}</td>
                                <td>{ucfirst($v.status)}</td>
                                <td class="ipad_button_table">
                                    <div class="field">
                                        <button class='has-tooltip btn btn_size text-danger btn-link' onclick="edit_stairstep({$v.step_id},'{$path}')"><i class="fa fa-edit"></i>
                                        </button>
                                        <span class='tooltip green'>
                                            <p>{lang('edit')}</p>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                {else}
                    <tbody>
                        <tr>
                            <td colspan="9" align="center">
                                <h4 align="center"> {lang('No_step_Details_Found')}</h4>
                            </td>
                        </tr>
                    </tbody>
                {/if}
            </table>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <legend>
            <span class="fieldset-legend">
                {lang('override_commission')}
            </span>
        </legend>
        {form_open('', 'role="form" class="" method="post" name="stair_form1" id="stair_form1"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('override_commission')} (%)</label>
                <input class="form-control" type="text" name="override_commission" id="override_commission" value="{round($override_commission,$PRECISION)}">
                {form_error('override_commission')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="step_commission" id="step_commission" >{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>

{/block}