{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="excel_url" value="{$BASE_URL}user/excel/create_excel_repurchase_report"} {assign var="csv_url" value=""} {assign var="report_name" value="{lang('repurchase_report')}"}{include file="user/report/report_nav.tpl"
name=""}
<div id="print_area" class="img panel-body panel">
    {include file="user/report/header.tpl" name=""}
    <div class="panel panel-default table-responsive ng-scope">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >=1}
            <tbody>
                <thead>
                <tr class="th" align="center">
                    <th>{lang('slno')}</th>
                    <th>{lang('invoice_no')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('full_name')}</th>
                    <th>{lang('date_submission')}</th>
                    <th>{lang('Products')}</th>
                    <th>{lang("payment_method")}</th>
                    <th>{lang('total_amount')}</th>
                </tr>
          </thead>
                {assign var="i" value=0} {assign var="total_quantity" value=0} {assign var="total_amount" value=0} {foreach from=$purcahse_details item=v}
                <tr>
                    <td>{counter}</td>
                    <td>
                        <a href="../repurchase/repurchase_invoice/{$v.encrypt_order_id}" target="_blank">
                            {$v.invoice_no}
                        </a>
                    </td>
                    <td>{$v.user_name}</td>
                    <td>{$v.full_name}</td>
                    <td>{$v.order_date}</td>
                    <td>
                   
                 <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                  <tbody>
                   <thead>
                    <tr class="th" align="center">
                     <th>{lang('prod_name')}</th>
                     <th>{lang('Unit price')}</th>
                     <th>{lang('quantity')}</th>
                     <th>{lang('total')}</th>
                    </tr> 
                   </thead> 
                    
                    {foreach from = $v.product_details item =n}
                     <tr>
                      <td>{$n.prod_id}</td>
                      <td>{$DEFAULT_SYMBOL_LEFT} {number_format($n.unite_price*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
                      <td>{$n.quantity}</td>  
                      <td>{$DEFAULT_SYMBOL_LEFT} {number_format($n.total*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td> 
                     </tr>
                    {/foreach}        
                  </tbody>
                </table>


                </td>
                    <td>{lang($v.payment_method)}</td>
                    <td style="text-align: center;">{$DEFAULT_SYMBOL_LEFT} {number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
                    {$total_amount = $total_amount + $v.amount}
                </tr>
                {/foreach}
                <tr>
                    <td colspan="7" class="text-right"><b>{lang('total_amount')}</b></td>
                    <td><b>{$DEFAULT_SYMBOL_LEFT} {number_format($total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</b></td>
                </tr>
            </tbody>
            {else}
            <h4>
                <center>{lang('no_data')}</center>
            </h4>
            {/if}
        </table>
    </div>
</div>
{/block}