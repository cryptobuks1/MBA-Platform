{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">

    <span id="confirm_msg_inactivate">{lang('sure_you_want_to_inactivate_this_rank')}</span>
    <span id="confirm_msg_edit">{lang('sure_you_want_to_edit_this_rank_there_is_no_undo')}</span>
    <span id="confirm_msg_activate">{lang('sure_you_want_to_activate_this_rank')}</span>
    <span id="confirm_msg_delete">{lang('sure_you_want_to_delete_this_rank_there_is_no_undo')}</span><span id="validate_day_lim">{lang('day_limit')}</span>
    <span id="day_lim_req">{lang('day_lim_req')}</span>
</div>

    {include file="admin/configuration/system_setting_common.tpl"}

    <!-- <div class="panel panel-default">
        <div class="panel-body">
       <legend><span class="fieldset-legend">{lang('rank_settings')}</span></legend>
            <div class="table-responsive">*}
            {form_open('','role="form" class="" name="rank_form" id="rank_form"')}
                {include file="layout/error_box.tpl"}
               {* <div class="form-group">
                    <label class="required">{lang('rank_calculation_period')}</label>
                    <select class="form-control" onchange="" name="rank_expiry"  id="rank_expiry">
                        <option value="daily" {if $obj_arr["rank_expiry"]=='daily'} selected="true"{/if}>{lang('daily')}</option>
                        <option value="weekly" {if $obj_arr["rank_expiry"]=='weekly'} selected="true"{/if}>{lang('weekly')}</option>
                        <option value="monthly" {if $obj_arr["rank_expiry"]=='monthly'} selected="true"{/if}>{lang('monthly')}</option>
                        <option value="yearly" {if $obj_arr["rank_expiry"]=='yearly'} selected="true"{/if}>{lang('yearly')}</option>
                        <option value="fixed" {if $obj_arr["rank_expiry"]=='fixed'} selected="true"{/if}>{lang('instant')}</option>
                    </select>
                    {form_error('rank_expiry')}
                </div>*}
           {*  <div class="form-group">
                    <label class="required">{lang('rank_maintain_month_limit')}</label>
                    <input type="text" class="form-control" name="rank_maintain_month_limit" id="rank_maintain_month_limit" value="{$obj_arr['rank_maintain_month_limit']}"  autocomplete="off"/>
                    {form_error('rank_maintain_month_limit')}
                    
                </div>*}

                {* <div class="form-group">
                    <label class="required">{lang('default_rank')}</label>
                    <select name="default_rank" id="default_rank" class="form-control">
                        <option value="0">NA </option>
                    {foreach from=$active_rank_details item=v}
                        <option value="{$v.rank_id}" {if $obj_arr["default_rank_id"] == $v.rank_id} selected {/if}>{$v.rank_name}</option>
                    {/foreach}
                    </select>
                </div> *}

               {* <div class="form-group">
                    <label class="required">{lang('rank_criteria')}</label>
                    <div id="rank_criteria">
                        <div class="checkbox m">  <label class="i-checks"> <input type="checkbox" name="rank_criteria[]" class="disable_check" value="referal_count" {if $obj_arr['referal_count']}checked="yes"{/if}><i> </i>{lang('referal_count')}</label> </div>
                         {if $MODULE_STATUS['product_status'] == "yes"}
                            <div class="checkbox m">  <label class="i-checks"> <input type="checkbox" name="rank_criteria[]" class="disable_check" value="personal_pv" {if $obj_arr['personal_pv']}checked="yes"{/if}><i> </i>{lang('rank_personalpv')}</label> </div>
                            <div class="checkbox m">  <label class="i-checks"> <input type="checkbox" name="rank_criteria[]" class="disable_check" value="group_pv" {if $obj_arr['group_pv']}checked="yes"{/if}><i> </i>{lang('rank_grouppv')}</label> </div>
                        {/if}
                    </div>
                    {if $MODULE_STATUS['product_status'] == "yes"}
                        <div class="checkbox m">  <label class="i-checks"> <input type="checkbox" name="rank_criteria[]" value="joinee_package" {if $obj_arr['joinee_package']}checked="yes"{/if} id="joinee_pck"><i> </i>{lang('joinee_package')} ({lang('rank_same_as_member_package')})</label> </div>
                    {/if}
                    {if $MLM_PLAN == 'Matrix' || $MLM_PLAN == 'Binary'}
                    <div id="rank_criteria1">
                        <div class="checkbox m">  <label class="i-checks"> <input type="checkbox" name="rank_criteria[]" class="disable_check" value="downline_member_count" {if $obj_arr['downline_member_count']}checked="yes"{/if}><i> </i>{lang('downline_member_count')}</label> </div>
                        {if $MODULE_STATUS['product_status'] == "yes"}
                            <div class="checkbox m">  <label class="i-checks"> <input type="checkbox" name="rank_criteria[]" class="disable_check" value="downline_purchase_count" {if $obj_arr['downline_purchase_count']}checked="yes"{/if}><i> </i>{lang('downline_purchase_count')}</label> </div>
                        {/if}
                        <div class="checkbox m">  <label class="i-checks"> <input type="checkbox" name="rank_criteria[]" class="disable_check" value="downline_rank" {if $obj_arr['downline_rank']}checked="yes"{/if}><i> </i>{lang('downline_rank')}</label> </div>
                    </div>
                    {/if}
                </div>*}

             {*   <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" name="update" id="update">{lang('update')}</button>
                </div>

            {form_close()}
            </div>
        </div>
    </div>*}-->
    
   <div class="panel panel-default">
        <div class="panel-body">
        <legend><span class="fieldset-legend">{lang('binary minimum leg')}</span></legend>
            <div class="table-responsive">
            {form_open('admin/configuration/minimum_leg','role="form" class="" name="minimum_leg" id="minimum_leg"')}
                {include file="layout/error_box.tpl"}
             
              <div class="form-group">
                <label class="required">{lang('minimum leg')}</label>
                <input class="form-control" type="text" name="minimum_leg" id="minimum_leg" value='{$minimum_leg}'>
              </div>
              {form_error('minimum_leg')}

                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" name="update" id="update">{lang('update')}</button>
                </div>

            {form_close()}
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend">{lang('rank_config')}</span>
                <a class="btn m-b-xs btn-sm btn-primary btn-addon pull-right" href="{$BASE_URL}admin/add_new_rank" id="add_rank"><i class="fa fa-plus"></i> {lang('add_new_rank')}</a>
            </legend>
            <div>
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')}</th>
                                <th>{lang('rank_name')}</th>
                                {if $obj_arr['referal_count']}
                                    <th>{lang('referal_count')}</th>
                                {/if}
                                {if $obj_arr['personal_pv']}
                                    <th>{lang('personalpv')}</th>
                                {/if}
                                {if $obj_arr['group_pv']}
                                    <th>{lang('grouppv')}</th>
                                {/if}
                                {if $obj_arr['joinee_package']}
                                    <th>{lang('package_name')}</th>
                                {/if}
                                {if $MLM_PLAN == 'Matrix' || $MLM_PLAN == 'Binary'}
                                    {if $obj_arr['downline_member_count']}
                                        <th>{lang('downline_count')}</th>
                                        {* <th>{lang('team_downline_count')}</th> *}
                                    {/if}
                                {/if}
                                {*<th>{lang('rank_commission')}</th>*}<th>{lang('rank_incentive_bonus')}</th>
                                <th>{lang('rank_incentive_reward')}</th>
                                <th>{lang('binary_bonus')}(%)</th>
                                <th>{lang('binary_monthly_cap')}</th>
                                <th>{lang('rank_color')}</th>
                                <th>{lang('action')}</th>
                               
                            </tr>
                        </thead>
                        {if count($rank_details) > 0}
                        <tbody>
                        {assign var="path" value="{$BASE_URL}admin/"}
                        {foreach from=$rank_details item=v}
                                <tr>
                                    <td>{counter}</td>
                                    <td>{$v.rank_name}</td>
                                    {if $obj_arr['referal_count']}
                                        <td>{$v.referal_count}</td>
                                    {/if}
                                    {if $obj_arr['personal_pv']}
                                        <td>{$v.personal_pv}</td>
                                    {/if}
                                    {if $obj_arr['group_pv']}
                                        <td>{$v.gpv}</td>
                                    {/if}
                                    {if $obj_arr['joinee_package']}
                                        <td>{if isset($v['joinee_package'][0])}{$v['joinee_package'][0]['product_name']}{else}NA{/if}</td>
                                    {/if}
                                    {if $MLM_PLAN == 'Matrix' || $MLM_PLAN == 'Binary'}
                                      {if $obj_arr['downline_member_count']}
                                        <td>{$v.downline_count}</td>
                                      {/if}
                                    {/if}
                                    {*<td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.rank_bonus*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>*}
                                    <td>{$v.rank_incentive_bonus}</td>
                                    <td>{$v.rank_incentive_reward}</td>
                                    <td>{$v.binary_bonus}</td>
                                  <td>{$v.binary_monthly_cap}</td>
                                    <td><span class="rank_col" style="background-color: {$v.rank_color};">{$v.rank_color}</span></td>
                                    <td class="ipad_button_table">
                                        {if $v.rank_status=="active"}
                                            <button class="btn-link btn_size has-tooltip text-info" onclick="edit_rank({$v.rank_id}, '{$path}')" title="{lang('edit')}"> <i class="fa fa-edit"></i></button>
                                            <button class="btn-link btn_size has-tooltip text-info inactivate_membership_package" onclick="inactivate_rank({$v.rank_id}, '{$path}')" title="{lang('inactivate')}"><i class="fa fa-ban"></i></button>
                                        {else}
                                            <button class="has-tooltip btn-link btn_size text-info" onclick="activate_rank({$v.rank_id}, '{$path}')" title="{lang('activate')}"><i class="icon-check"></i></button>
                                        {/if}
                                    </td>
                                </tr>
                        {/foreach}
                        </tbody>
                        {else}
                        <tbody>
                            <tr id="tr-empty"><td align="center"><h4 align="center">{lang('no_product_found')}</h4></td></tr>
                        </tbody>
                        {/if}
                    </table>
                </div>
            </div>
        </div>
    </div>


{/block}

{block name=style}
    {$smarty.block.parent}
    <style>
    .rank_col {
        display: inline;
        padding: .2em .6em .3em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;
    }
    </style>
{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
      <script src="{$PUBLIC_URL}javascript/rank_configuration.js" type="text/javascript" ></script> 
     <link href="{$PUBLIC_URL}/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet">
{/block}