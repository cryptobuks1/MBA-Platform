 {extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

{include file="admin/configuration/system_setting_common.tpl"}
  <div id="span_js_messages" style="display:none;"> 
    <span id="user_name_length">{lang('user_name_length_required')}</span>
    <span id="user_name_prefix">{lang('user_name_prefix_required')}</span>
    <span id="digit_only">{lang('digit_only')}</span> 
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
    <span id="lang_age">{lang('age')|strtolower}</span>
  </div>

<div class="panel panel-default table-responsive">
  <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('signup_settings')}</span></legend>
    {form_open('','role="form" class="" name="signup_form" id="signup_form"')}
        <div class="form-group">
            <div class="checkbox">
                <label class="i-checks">
                <input type="checkbox" name="registration_allowed" {if $signup_config['general_signup_config']['registration_allowed'] == 'no'} checked {/if}><i></i> {lang('block_user_registration')}
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label class="i-checks">
                <input type="checkbox" name="sponsor_required" {if $signup_config['general_signup_config']['sponsor_required'] == 'no'} checked {/if}><i></i> {lang('always_set_admin_as_sponsor')}
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label class="i-checks">
                <input type="checkbox" name="mail_notification" {if $signup_config['general_signup_config']['mail_notification'] == 'yes'} checked {/if}><i></i> {lang('enable_mail_notification')}
                </label>
            </div>
        </div>
        {if $MLM_PLAN == 'Binary'}
            <div class="form-group">
                <div class="checkbox">
                    <label class="i-checks">
                    <input type="checkbox" value="yes" name="binary_leg_status" {if $signup_config['general_signup_config']['binary_leg'] != 'any'} checked {/if}><i></i> {lang('enable_binary_locking')}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="required">{lang('position_to_lock')}</label>
                <select class="form-control" name="binary_leg">
                    <option value="left" {if $signup_config['general_signup_config']['binary_leg'] == 'left'} selected {/if}>{lang('left_leg')}</option>
                    <option value="right" {if $signup_config['general_signup_config']['binary_leg'] == 'right'} selected {/if}>{lang('right_leg')}</option>
              </select>
            </div>
        {/if}
        <div class="form-group">
            <div class="checkbox">
                <label class="i-checks">
                <input type="checkbox" value="yes" name="age_limit_status" {if $signup_config['general_signup_config']['age_limit']} checked {/if} {set_checkbox('age_limit_status', 'yes')}><i></i> {lang('enable_age_restriction')}
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="required">{lang('min_age_required')}</label>
            <input type="text" class="form-control" name="age_limit" maxlength="3" value="{$signup_config['general_signup_config']['age_limit']}">
            {form_error('age_limit')}
        </div>
        {if $country_status =='yes'}
            <div class="form-group">
                <label class="required">{lang('default_country')}</label>
                <select name="country" id="country" class="form-control">{$countries}</select>
            </div>
        {/if}
        
        <button type="submit" id="update_signup" value="update" name="update_signup" class="btn btn-sm btn-primary m-b-new">{lang('update')}</button>
    {form_close()}
    {* <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>{lang('sl_no')}</th>
          <th>{lang('option')}</th>
          <th>{lang('action')}</th>
        </tr>
      </thead>
      <tbody>
        <tr> {$i = 1}
          <td>{$i}</td>
          <td>{lang('registration_allowed')}</td>
          <td><div class="form-group-button">
              <label class="i-switch bg-primary">
                <input type="checkbox" name="registration_allowed" {if $signup_config['general_signup_config']['registration_allowed'] == 'yes'} checked {/if}>
                <i></i> </label>
            </div></td>
        </tr>
        <tr> {$i = $i + 1}
          <td>{$i}</td>
          <td>{lang('sponsor_required')}</td>
          <td><div class="form-group-button">
              <label class="i-switch bg-primary">
                <input type="checkbox" name="sponsor_required" {if $signup_config['general_signup_config']['sponsor_required'] == 'yes'} checked {/if}>
                <i></i> </label>
            </div></td>
        </tr>
        <tr> {$i = $i + 1}
          <td>{$i}</td>
          <td>{lang('mail_notification')}</td>
          <td><div class="form-group-button">
              <label class="i-switch bg-primary">
                <input type="checkbox" name="mail_notification" {if $signup_config['general_signup_config']['mail_notification'] == 'yes'} checked {/if}>
                <i></i> </label>
            </div></td>
        </tr>
      {if $MLM_PLAN == 'Binary'}
      <tr> {$i = $i + 1}
        <td>{$i}</td>
        <td>{lang('binary_leg')}</td>
        <td  class="signup_settings_input"><form class="form-inline">
            <div class="form-group">
              <select class="form-control" name="binary_leg">
                <option value="any" {if $signup_config['general_signup_config']['binary_leg'] == 'any'} selected="" {/if}>{lang('any')}</option>
                <option value="left" {if $signup_config['general_signup_config']['binary_leg'] == 'left'} selected="" {/if}>{lang('left')}</option>
                <option value="right" {if $signup_config['general_signup_config']['binary_leg'] == 'right'} selected="" {/if}>{lang('right')}</option>
              </select>
            </div>
            <button type="button"  class="btn btn-primary btn_left" id="update_binary_leg">{lang('update')}</button>
          </form></td>
      </tr>
      {/if}
        <tr> {$i = $i + 1}
          <td>{$i}</td>
          <td>{lang('age_limit')}</td>
          <td class="signup_settings_input"><form class="form-inline">
              <div class="form-group">
                <input class="form-control size_input update_age_limit" name="age_limit" type="number" value="{$signup_config['general_signup_config']['age_limit']}">
              </div>
              <button type="button" class="btn btn-primary btn_left" id="update_age_limit">{lang('update')}</button>
            </form></td>
        </tr>

        {if $country_status =='yes'}
        <tr> {$i = $i + 1}
        <td>{$i}</td>
        <td>{lang('default_country')}</td>
        <td class="signup_settings_input"><form class="form-inline">
            <div class="form-group">
              <select name="country" id="country" class="form-control">{$countries}</select>
              <button type="button" class="btn btn-primary btn_left" id="update_country">{lang('update')}</button>
            </div>
          </form></td>
      </tr>
      {/if}
        </tbody>

    </table> *}
  </div>
</div>

<div class="panel panel-default table-responsive">
  <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('pending_registrations')}</span></legend>
    <div class="m-b-sm">
    {include file="common/notes.tpl" notes=lang('note_pending_signup_payment_method')}
    </div>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>{lang('sl_no')}</th>
          <th>{lang('payment_method')}</th>
          <th>{lang('status')}</th>
        </tr>
      </thead>
      <tbody>

      {foreach from = $signup_config['pending_signup_config'] item = v}
      {if $MODULE_STATUS['opencart_status'] == "yes" && $v.payment_method=="Free Joining"}
        {continue}
      {/if}
      <tr>
        <td>{counter}</td>
        <td>{if $v.payment_method=="Bitcoin"}{lang("blocktrail")}{else}{$v.payment_method}{/if}</td>
        <td  class="payment_width_td"><div class="form-group-button">
            <label class="i-switch bg-primary">
              <input type="checkbox" {if $v.status} checked {/if} data-id="{$v.id}" data-status="{$v.status}" name="pending_status"
                                    id="set_paypal_status" class="switch-input pending_status">
              <i></i> </label>
          </div></td>
      </tr>
      {/foreach}
        </tbody>

    </table>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('username_setting')}</span></legend>
    {form_open('admin/signup_settings', 'role="form" class="form" method="post"  name="signup_settings_form" id="signup_settings_form"')}
    <div class="form-group">
      <label class="required">{lang('username_type')}</label>
      <select class="form-control" name="user_name_type">
        <option value="static" {if $username_config["type"]=='static'} selected {/if}>{lang('Static')}</option>
        <option value="dynamic" {if $username_config["type"]=='dynamic'} selected {/if}>{lang('Dynamic')}</option>
      </select>
      {* <div class="radio radio-inline">
        <label class="i-checks i-checks-sm">
          <input type="radio" name="user_name_type" id="static" value="static" {if $username_config["type"]=='static'} checked {/if}>
          <i></i> {lang('Static')} </label>
        <label class="i-checks i-checks-sm">
          <input type="radio" name="user_name_type" id="dynamic" value="dynamic" {if $username_config["type"]=='dynamic'} checked {/if}>
          <i></i> {lang('Dynamic')} </label>
      </div> *}
      {form_error('user_name_type')} </div>
    <div class="form-group" id="length_div" {if $username_config["type"] == "static"} style="display: none;" {/if}>
      <label class="required">{lang('user_name_length')}</label>
      <input type="text" class="form-control" name="length" id="length" value="{$username_config["length"]}" maxlength="1">
      {form_error('length')} </div>
    <div class="form-group" id="prefix_status_div" {if $username_config["type"] == "static"} style="display: none;" {/if}>
      <div class="checkbox">
        <label class="i-checks">
        <input type="checkbox" name="prefix_status" {if $username_config["prefix_status"] == 'yes'} checked {/if}><i></i> {lang('enable_username_prefix')}
        </label>
    </div>
      {* <label class="required">{lang('do_you_want_user_name_prefix')}</label>
      <select class="form-control" name="prefix_status">
        <option value="yes" {if $username_config["prefix_status"]=='yes'} selected {/if}>{lang('yes')}</option>
        <option value="no" {if $username_config["prefix_status"]=='no'} selected {/if}>{lang('no')}</option>
      </select>
      <div class="radio radio-inline">
        <label class="i-checks i-checks-sm">
          <input type="radio" name="prefix_status" id="static" value="yes" {if $username_config["prefix_status"]=='yes'} checked {/if}>
          <i></i> {lang('yes')} </label>
        <label class="i-checks i-checks-sm">
          <input type="radio" name="prefix_status" id="dynamic" value="no" {if $username_config["prefix_status"]=='no'} checked {/if}>
          <i></i> {lang('no')} </label>
      </div> 
      {form_error('prefix_status')}*} </div>
    <div class="form-group" id="prefix_div" {if $username_config["type"] == "static" || $username_config["prefix_status"] == "no"} style="display: none;" {/if}>
    <label class="required">{lang('username_prefix')}</label>
    <input type="text" class="form-control" name="prefix" id="prefix" value="{$username_config["prefix"]}" maxlength="8">
    {form_error('prefix')} </div>
  <div class="form-group">
    <button type="submit" class="btn btn-sm btn-primary" value="update" name="update" id="update">{lang('update')}</button>
  </div>
  {form_close()} </div>
</div>

{if $MODULE_STATUS['opencart_status'] != "yes"}
  {form_open('', 'name="signup_field_form" id="signup_field_form" method="post"')}
    <div class="panel panel-default table-responsive">
      <div class="panel-body">
        <legend><span class="fieldset-legend">{lang('custom_sign_up_form_field')}</span></legend>
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>{lang('sl_no')}</th>
              <th>{lang('name')}</th>
              <th>{lang('sort_order')}</th>
              <th>{lang('enabled')}</th>
              <th>{lang('required')}</th>
            </tr>
          </thead>

        <tbody>
        {assign var="i" value=0}
        {foreach from=$signup_fields item=v}
          {if $v.field_name=="first_name" ||$v.field_name=="email" ||$v.field_name=="mobile" }
            {continue}
          {/if} 
          <tr>
            <td>{assign var="i" value=$i+1}{$i}</td>
            <td>{lang($v.field_name)}</td>
            <td><input class="form-control sort_order" type="text" id="sort_order{$i}" name="sort_order{$i}" value="{$v.sort_order}"><span id="errmsg{$i}" style="color:red;"></span>
                <input type="hidden" id="id" name="id{$i}" value="{$v.id}">
            </td>
            <td> <div class="form-group-button">
                  <label class="i-switch bg-primary">
                  <input type="checkbox" {if $v.status == 'yes'} checked {/if} data-id="{$v.id}" data-status="{$v.status}" name="status" class="switch-input signup_field">
                    <i></i>
                </label>
              </div>
            </td> 
            <td> 
            <div class="form-group-button">
             {if $v.field_name=='country'}
                <font color="#ff0000">{lang('default_data_enabled')}</font> 
             {else}
                    <label class="i-switch bg-primary">
                    <input type="checkbox" {if $v.required == 'yes'} checked {/if} data-id="{$v.id}" data-status="{$v.required}" name="required" class="switch-input signup_field">
                      <i></i>
                    </label> 
                  {/if}</div>  </td>
            <input type="hidden" id="number" name="number" value="{$i}">
          </tr> 
        {/foreach}
        </tbody>
      </table>
       <button type="submit" id="save" value="save" name="save" class="btn btn-sm btn-primary m-b-new update_config">Update</button>
    </div>
  </div>
      {form_close()}

  {/if}      

<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>
<input type="hidden" id="base_url" value="{$BASE_URL}">
{/block}
