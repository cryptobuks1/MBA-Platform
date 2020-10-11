{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1">{lang('You_must_enter_amount')}</span>
        <span id="error_msg2">{lang('You_must_enter_description')}</span>
        <span id="error_msg3">{lang('digits_only')}</span>
        <span id="error_msg4">{lang('Please_select_month')}</span> 
        <span id="error_msg5">{lang('Please enter no more than 10 digits')}</span> 
    </div> 
   
    <div class="panel panel-default">
        <div class="panel-body">
         <legend><span class="fieldset-legend">{lang('add_new_expense')}</span></legend>
            {form_open('','role="form" class="" name="form" id="form" action="" method="post"')}
            
            <div class="form-group">
                <label class="required">{lang('amount')}</label>

                <input type="text" class="form-control" name='amount' id='amount'>
                {form_error('amount')}
            </div>
            
            
            <div class="form-group">
                <label class="required" >{lang('description')}</label>

                <textarea class="form-control" name='description' id='description'> </textarea>

            </div>  
            
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name='new_expense' id='new_expense' value='submit'>{lang('add')}</button>
            </div>
             
            {form_close()}
        </div>
    </div>
   
    <div class="panel panel-default">
        <div class="panel-body">
         <legend><span class="fieldset-legend">{lang('select_month')}</span></legend>
            {form_open('','role="form" class="" name="dateform" id="dateform" method="post"')}
            <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('date')}</label>
                <input  autocomplete="off"  class="form-control date-picker" type="text"  size="70" maxlength="10" name='weekdate' id='weekdate' data-zdp_format='Y-m'>
                <span>{form_error('weekdate')}</span>
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group m-t-t-t">
                <button type="submit" class="btn btn-primary"  id="submit" value="submit" name="submit" >{lang('submit')}</button>
            </div>
            
            </div>
            {form_close()}
        </div>
    </div>
    {if $details['nodata'] != "yes"}
        
        <div class="panel panel-default table-responsive">
        <div class="panel-body">
        <legend><span class="fieldset-legend">{lang('monthly_revenue_report')}</span></legend>
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                <th>{lang('income')}</th>
                <th>{lang('expense')}</th>
                <th>{lang('other_expenses')}</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($details["amount_credit"]*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($details["amount_debit"]*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($details["total_other_exp"]*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                    </tr>
                    <tr>
                        <td  class="text-right" colspan='2'><b>{lang('total_profit')}</b></td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($details["profit"]*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                    </tr>
                </tbody>
            </table>  
            </div>
        </div> 
        {if count($details['other_expenses']) > 0}
           
            <div class="panel panel-default table-responsive">
            <div class="panel-body">
             <legend><span class="fieldset-legend">{lang('other_expense_details')}</span></legend>
                {assign var=i value="1"} 
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead>
                    <th>{lang('slno')}</th>
                    <th>{lang('amount')}</th>
                    <th>{lang('description')}</th>
                    <th>{lang('date_added')}</th>
                    </thead>
                    <tbody>
                        {foreach $details["other_expenses"] as $v}
                            <tr>
                                <td>{$i}</td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                <td>{$v.description}</td>
                                <td>{$v.date}</td>
                            </tr>
                            {$i = $i+1 }
                        {/foreach}
                        <tr>
                            <td colspan='3' class="text-right"><b>{lang('total_expenses')}</b></td>
                            <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($details["total_other_exp"]*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                        </tr>
                    </tbody>
                </table>  
                </div>
            </div>
        {/if}
        {else}
         <div style="text-align: center">  <h3>{lang('no_data')}</h3></div>
    {/if}
{/block}
{block name=script}{$smarty.block.parent} 
    <script>
        jQuery(document).ready(function () {
            ValidateExpense.init();
        });
    </script>
{/block}


