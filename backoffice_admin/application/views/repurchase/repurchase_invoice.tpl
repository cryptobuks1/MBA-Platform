{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div class="button_back">
    <a onClick="print_report(); return false;"><button class="btn m-b-xs btn-sm btn-primary btn-addon hidden-xs hidden-sm hidden-md"><i class="icon-printer"></i>{lang('click_here_to_print')}</button>
    </a>
</div>
<div class=" panel">
<div class="panel-body" id="print_area">
<div class="img"> <img src="{$SITE_URL}/uploads/images/logos/{$site_info["logo"]}" /> </div>
<div class="row">
    <div class="col-xs-6">
        <h4>{$site_info["company_name"]}</h4>
        <p>{$site_info["company_address"]}</p>
        <p> {lang('phone')}: {$site_info["phone"]}<br> {lang('email')}:{$site_info["email"]} </p>
    </div>
    <div class="col-xs-6 text-right">
        <p class="h4"># {$invoice_details['invoice_no']}</p>
        <h5>{date("j F, Y",strtotime($invoice_details['order_date']))}</h5>
    </div>
</div>
 
<h3 class="text-center">{$report_name}</h3>
{if $report_date}
<p class="text-center">{$report_date}</p>
{/if}
<br>
<div class="row">
    <div class="col-sm-6">
        <h4>{lang('company')} :</h4>
        <div class="well">
            <address>
            <strong>{$site_info['company_name']}.</strong>
            <br>{$site_info['company_address']}
            <br>
            <abbr title="Phone">Phone:</abbr>{$site_info['phone']}
        </address>
            <address>
            <strong>{lang('email')}</strong>
            <br>
            <a href="javascript:void()">{$site_info['email']}
            </a>
        </address>
        </div>
    </div>
    <div class="col-sm-6">
        <h4>{lang('user_details')} :</h4>
        <div class="well"><address>
            <strong>{$invoice_details['address']['name']}</strong>
            <br>{$invoice_details['address']['address']}
            {$invoice_details['address']['pin']}
            {$invoice_details['address']['town']}
            <br>
            <abbr title="Phone">Phone:</abbr>{$invoice_details['address']['mobile']}
    </address>
            <address>
            <strong>{lang('email')}</strong>
            <br>
            <a href="javascript:void()">NA
            </a>
        </address>
        </div>
    </div>
    <br></div>

<div class="panel panel-default table-responsive ng-scope">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <tbody>
            <thead>
                <tr>
                    <th>{(lang('sl_no'))}</th>
                    <th> {lang('item')} </th>
                    <th class="hidden-480"> {lang('Quantity')} </th>
                    <th class="hidden-480"> {lang('unit_cost')} </th>
                    <th> {lang('Total')} </th>
                </tr>
            </thead>
            <tbody>
                {assign var="total_amount" value=0} {foreach from=$invoice_details['product_details'] item=v name=name}
                <tr>
                    <td> {counter} </td>
                    <td> {$v.product_name} </td>
                    <td class="hidden-480"> {$v.quantity} </td>
                    <td class="hidden-480">{$DEFAULT_SYMBOL_LEFT} {number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}
                    </td>
                    <td>{$DEFAULT_SYMBOL_LEFT} {number_format($v.amount*$v.quantity*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}
                    </td>
                </tr>
                {$total_amount = $total_amount + ($v.amount * $v.quantity)} {/foreach}
                <tr>
                  <td class="text-right" colspan="4" class="bold-text-center">
                   <b>{lang('Total')}</b>
                  </td>
                 <td colspan="2"><b>{$DEFAULT_SYMBOL_LEFT}
                   {number_format($total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}
                 {$DEFAULT_SYMBOL_RIGHT}</b></td>
                </tr>
            </tbody>
    </table>
</div>
</div>
</div>
{/block}