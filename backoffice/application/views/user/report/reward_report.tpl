{extends file=$BASE_TEMPLATE} 
{block name=$CONTENT_BLOCK}
    
    <div id="span_js_messages" style="display:none;">

        <span id="error_msg">{lang('you_must_select_from_date')}</span>
        <span id="error_msg1">{lang('you_must_select_to_date')}</span>
        <span id="error_msg2">{lang('you_must_select_from_to_date_correctly')}</span>
        <span id="error_msg3">{lang('you_must_select_product')}</span>
        <span id="error_msg4">{lang('you_must_select_a_to_date_greater_than_from_date')}</span>
        <span id="error_msg5">{lang('digits_only')}</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open({$SHORT_URL},'role="form" class="" name="search_member" id="search_member"
        action="" method="post"')}
            <input type="hidden" id="search_member_error" value="{lang('search_member_error')}" />
            <input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}" />
            {* {include file="layout/error_box.tpl"} *}

           
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="" for="week_date1">{lang('from_date')}</label>
                    <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value="">{* {if $error_count_weekly && isset($error_array_weekly['week_date1'])}{$error_array_weekly['week_date1']}{/if}*}
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="">{lang('to_date')}</label>
                    <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> {*{if $error_count_weekly && isset($error_array_weekly['week_date2'])}{$error_array_weekly['week_date2']}{/if}*}
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit"
                            name="search_member_submit">
                        {lang('search')}
                    </button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <legend>
                <span class="fieldset-legend">{lang('reward_report')}</span>
            </legend>
            
            <div class="table-responsive">
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead class="table-bordered">
                        <tr class="th">
                            <th>{lang('slno')}</th>
                            <th>{lang('user_name')}</th>
                            <th>{lang('rank')}</th>

                            <th>{lang('reward')}</th>

                            <th>{lang('date')}</th>
                        </tr>
                    </thead>
                    {if count($details)>0}
                        <div class="button_back">
                            <a href="{$BASE_URL}user/excel/create_excel_reward_report/{$user_name}"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i>{lang('create_excel')}</button></a>
                            <a href="{$BASE_URL}user/excel/create_csv_reward_report/{$user_name}"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i>{lang('create_csv')}</button></a>
                        </div>
                        <tbody>
                            {assign var=i value="0"}
                            {foreach from=$details item=v}
                                {$i = $i+1}

                                <tr>
                                    <td>{$i}</td>
                                    <td>{$v.user_name}</td>

                                    <td>{$v.rank_name}</td>

                                    <td>{$v.reward}</td>

                                    <td>{$v.date}</td>
                                </tr>
                            {/foreach}
                        </tbody>
                    {else}
                        <tbody>
                            <tr>
                                <td colspan="8">
                                    <h4>{lang('no_details')}</h4>
                                </td>
                            </tr>
                        </tbody>
                    {/if}
                </table>
            </div>
            {$result_per_page}

        </div>
    </div>

{/block}