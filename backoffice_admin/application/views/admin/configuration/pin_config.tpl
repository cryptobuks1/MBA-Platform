{extends file=$BASE_TEMPLATE}

{block name=script}
{$smarty.block.parent}
<script src="{$PUBLIC_URL}javascript/validate_epin_configuration.js" type="text/javascript"></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg">{lang('you_must_enter_e_pin_length')}</span>
    <span id="error_msg1">{lang('you_must_enter_maximum_active_epin')}</span>
    <span id="error_msg2">{lang('digits_only')}</span>
    <span id="error_msg3">{lang('you_must_enter_the_epin_amount')}</span>
    <span id="confirm_msg_delete">{lang('sure_you_want_to_delete_this_epin_there_is_no_undo')}</span>
    <span id="error_msg4">{lang('values_greater_than_0')}</span>
    <span id="error_msg5">{lang('max_10_digit_allowed')}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>

{include file="admin/configuration/system_setting_common.tpl"}


<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('e_pin_configuration')}</span></legend>
        {form_open('','role="form" class="" name="pin_config_form" id="pin_config_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('maximun_active_e_pin')}</label>
                <input type="text" class="form-control" name="pin_maxcount" id="pin_maxcount"  value="{$pin_config["pin_maxcount"]}" maxlength="5">
                {form_error('pin_maxcount')}
            </div>
            <div class="form-group">
                <label class="required">{lang('e_pin_character_set')}</label>
                <select class="form-control" name="pin_character" id="pin_character">
                    <option value="alphabet" {if $pin_config["pin_character_set"]=='alphabet'} selected {/if}>{lang('alphabets')}</option>
                    <option value="numeral" {if $pin_config["pin_character_set"]=='numeral'} selected {/if}>{lang('numerals')}</option>
                    <option value="alphanumeric" {if $pin_config["pin_character_set"]=='alphanumeric'} selected {/if}>{lang('alphanumerals')}</option>
                </select>
                {* <div class="radio radio-inline">
                    <label class="i-checks i-checks-sm">
                        <input type="radio" name="pin_character" id="alphabet" value="alphabet" {if $pin_config["pin_character_set"]=='alphabet'} checked {/if}>
                        <i></i>
                        {lang('alphabets')}
                    </label>
                    <label class="i-checks i-checks-sm">
                        <input type="radio" name="pin_character" id="numeral" value="numeral" {if $pin_config["pin_character_set"]=='numeral'} checked {/if}>
                        <i></i>
                        {lang('numerals')}
                    </label>
                    <label class="i-checks i-checks-sm">
                        <input type="radio" name="pin_character" id="alphanumeric" value="alphanumeric" {if $pin_config["pin_character_set"]=='alphanumeric'} checked {/if}>
                        <i></i>
                        {lang('alphanumerals')}
                    </label>
                </div> *}
                {form_error('pin_character')}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary" value="{lang('update')}" name="update" id="update">{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('add_new_epin_amount')}</span></legend>
        {form_open('','role="form" class="" name="epin_amount" id="epin_amount"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('epin_amount')}</label>
                <div class="input-group {$input_group_hide}">
                    {$left_symbol}
                    <input type="text" class="form-control" name="pin_amount" id="reg_amount">
                    {$right_symbol}
                </div>
                {form_error('pin_amount')}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary" value="add_amount" name="add_amount" id="add_amount">{lang('add')}</button>
            </div>
        {form_close()}
    </div>
</div>


<div class="panel panel-default">
<div class="panel-body">
<legend><span class="fieldset-legend">{lang('available_epin_amounts')}</span></legend>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{lang('sl_no')}</th>
                <th>{lang('epin_amount')}</th>
                <th>{lang('action')}</th>
            </tr>
        </thead>
        {if $count>0}
            <tbody>
                {assign var="i" value=0}
                {assign var="pin" value=""}
                {assign var="root" value="{$BASE_URL}admin/"}
                {foreach from=$pin_amounts item=v}
                    {$i=$i+1}
                    <tr>
                        <td>{counter}</td>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        <td class="ipad_button_table payment_width_td">
                            <div class="field">
                                <button class='btn-link h4 text-danger has-tooltip' onclick="delete_epin('{$v.id}')">
                                    <i class="fa fa-trash-o"></i>
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
                <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_epin_found')}</h4></td></tr>
            </tbody>
        {/if}
    </table>
    </div>
    </div>
</div>

{/block}