{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display:none;">
        <span id="validate_msg1">{lang('aaa')}</span>
        <span id="validate_msg2">{lang('bbb')}</span>
        <span id="validate_msg3">{lang('ccc')}</span>
        <span id="validate_msg4">{lang('ddd')}</span>
    </div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
            {form_open('','role="form" class="" name="roi_settings" id="roi_settings"')}
                {include file="layout/error_box.tpl"}
                
                <div class="form-group">
                <label class="required">{lang('roi_criteria')}</label>
                    <select name="roi_criteria" id="roi_criteria" class="form-control">
                        <option value="member_pck" {if $obj_arr["roi_criteria"]=='member_pck'} selected="true"{/if}> {lang('roi_based_on_membership_package')}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="required">{lang('calculation_period')}</label>
                    <select class="form-control" onchange="" name="period"  id="period">
                        <option value="daily" {if $obj_arr["roi_period"]=='daily'} selected="true"{/if}>{lang('daily')}</option>
                        <option value="weekly" {if $obj_arr["roi_period"]=='weekly'} selected="true"{/if}>{lang('weekly')}</option>
                        <option value="monthly" {if $obj_arr["roi_period"]=='monthly'} selected="true"{/if}>{lang('monthly')}</option>
                        <option value="yearly" {if $obj_arr["roi_period"]=='yearly'} selected="true"{/if}>{lang('yearly')}</option>
                    </select>
                    {form_error('period')}
                </div>

                <div id="skip_days" style="display:none;">
                    <div class="form-group">
                    <label class="">{lang('days_to_skip')}</label>
                        <div class="checkbox m-b-sm">  <label class="i-checks i-checks-sm"> <input type="checkbox" name="days[]" value="Sun" {if in_array('Sun',$skip_days)}checked="yes"{/if}><i> </i>{lang('sunday')}</label> </div>
                        <div class="checkbox m-b-sm">  <label class="i-checks i-checks-sm"> <input type="checkbox" name="days[]" value="Mon" {if in_array('Mon',$skip_days)}checked="yes"{/if}><i> </i>{lang('monday')}</label> </div>
                        <div class="checkbox m-b-sm">  <label class="i-checks i-checks-sm"> <input type="checkbox" name="days[]" value="Tue" {if in_array('Tue',$skip_days)}checked="yes"{/if}><i> </i>{lang('tuesday')}</label> </div>
                        <div class="checkbox m-b-sm">  <label class="i-checks i-checks-sm"> <input type="checkbox" name="days[]" value="Wed" {if in_array('Wed',$skip_days)}checked="yes"{/if}><i> </i>{lang('wednesday')}</label> </div>
                        <div class="checkbox m-b-sm">  <label class="i-checks i-checks-sm"> <input type="checkbox" name="days[]" value="Thu" {if in_array('Thu',$skip_days)}checked="yes"{/if}><i> </i>{lang('thursday')}</label> </div>
                        <div class="checkbox m-b-sm">  <label class="i-checks i-checks-sm"> <input type="checkbox" name="days[]" value="Fri" {if in_array('Fri',$skip_days)}checked="yes"{/if}><i> </i>{lang('friday')}</label> </div>
                        <div class="checkbox m-b-sm">  <label class="i-checks i-checks-sm"> <input type="checkbox" name="days[]" value="Sat" {if in_array('Sat',$skip_days)}checked="yes"{/if}><i> </i>{lang('saturday')}</label> </div>
                    </div>
                </div>

                <div class="form-group" id="maximum_rank_div">

                     <table class="table">
                        <thead>
                            <tr>
                                <th>{lang('package')}</th>
                                <th>{lang('roi')} (%)</th>
                                <th>{lang('days')}</th>
                                    
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$product_details item=u}
                                <tr>
                                    <td>{$u['product_name']}</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" maxlength="5" class="form-control roi_pck" name="pck_roi{$u['product_id']}" data-lang="{lang('you_must_enter')} {$u['product_name']|lower} {lang('roi')|lower} {lang('value')}" id="pck_roi{$u['product_id']}" min="0" value="{$u['roi']}">
                                            </div>
                                             {form_error("pck_roi{$u['product_id']}")}
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <input type="text" maxlength="5" class="form-control roi_days" name="pck_days{$u['product_id']}" data-lang="{lang('you_must_enter')} {$u['product_name']|lower} {lang('roi')|lower} {lang('days')}" id="pck_days{$u['product_id']}" min="0" value="{$u['days']}">
                                            </div>
                                             {form_error("pck_days{$u['product_id']}")}
                                        </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
                
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="update" id="update">{lang('update')}</button>
                </div>
            {form_close()}
            </div>
        </div>
    </div>
{/block}

{block name=style}
    {$smarty.block.parent}
     <style>
        table.table thead {
         background-color: white;
        }
        table > tbody > tr > td {
            border: none !important;
            text-align: left !important;
            }
     </style>
{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_roi_commission.js" type="text/javascript" ></script>
{/block}