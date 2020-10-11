{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
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

        {*<div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="user_name">{lang('user_name')}</label>
                <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off">
            </div>
        </div>*}
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required" for="week_date1">{lang('from_date')}</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value="">{* {if $error_count_weekly && isset($error_array_weekly['week_date1'])}{$error_array_weekly['week_date1']}{/if}*}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required">{lang('to_date')}</label>
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
        
   {if $count>=1}
           
            <div class="panel panel-default table-responsive">
            <div class="panel-body">
             <legend><span class="fieldset-legend">{lang('monthly_payment_report')}</span></legend>
                {assign var=i value="1"} 
                 
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead>
                    <th>{lang('slno')}</th>
                    <th>{lang('username')}</th>
                    <th>{lang('fullname')}</th>
                    <th>{lang('amount_paid')}</th>
                    <th>{lang('paid_date')}</th>
                   <!-- <th>{lang('previous_end_date')}</th>-->
                   
                    <th>{lang('payment_method')}</th>
                     <th>{lang('Subscription Mode')}</th>
                    </thead>
                    <tbody>
                        {assign var="i" value=1}
                    {foreach from=$details item=v}
               <tr>
                <td>{$i}</td>
                <td>{$v.username}</td>
                <td>{$v.fullname}</td>
                <td> {$v.amount_paid}</td>
                <td>{date('Y-m-d', strtotime($v.paid_date))}</td>
                <!--<td>{date('Y-m-d', strtotime($v.previous_subscription_end_date))}</td>-->
                <td>{$v.paid_type}</td>
                <td>
                    {if $v.payment_method == "stripe"}
                    {if $v.paid_type =='Stripe Recurring'}
                        {lang('Automatic')}{else}{lang('Skipped')}{/if}
                 {/if}
                </td>
                
                   </tr>
            {$i=$i+1}
   {/foreach}
                    </tbody>
                </table>  
                </div>
            </div>
        
   {else}
         <div style="text-align: center">  <h3>{lang('no_data')}</h3></div>
    {/if}
        
{/block}
{block name=script}
     {$smarty.block.parent}
     
     <script src="{$SHORT_URL}javascript/main.js" type="text/javascript" ></script>
{/block}