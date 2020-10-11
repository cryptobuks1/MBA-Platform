{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div class="button_back">
    <a href=""><button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i>Create Excel</button></a>    
     <button class="btn m-b-xs btn-sm btn-primary btn-addon hidden-xs hidden-sm hidden-md"><i class="icon-printer"></i>Print</button>
     <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i>Create Csv</button>
     </div>
  
    <div  id="print_area">
        <div class="panel panel-default  ng-scope">
        
        <div class="panel-body">
          {assign var="report_name" value="{lang('roi_report')}"}
    {assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_roi_report"}
    {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_roi_report"}
    {include file="admin/report/header.tpl" name=""}
   
        <div class="table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                {if $count >=1}
                    <tbody>
                    <thead>
                        <tr>
                            <th>{lang('slno')}</th>
                            <th>{lang('user_name')}</th>
                            <th>{lang('package')}</th>
                            <th>{lang('date_submission')}</th>
                            <th>{lang('total_amount')}</th>
                        </tr>
                        </thead>
                        {assign var="i" value=0}
                        {assign var="total_quantity" value=0}
                        {assign var="total_amount" value=0}

                        {foreach from=$roi_details item=v}
                            {if $i%2==0}
                                {assign var="class" value="tr1"}
                            {else}
                                {assign var="class" value="tr2"}
                            {/if}
                            {$i=$i+1}
                            <tr {$class} >
                                <td>{counter}</td>

                                <td>{$v.from_id}</td>
                                <td>{$v.package}</td>
                                <td>{date('Y/m/d', strtotime($v.date_of_submission))}</td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                {$total_amount = $total_amount + $v.amount_payable}
                            </tr>
                        {/foreach}
                        <tr> 
                            <td colspan="4" style="text-align: right;"> <b>{lang('total_amount')}</b></td>
                            <td style="text-align: center;"><b>{$DEFAULT_SYMBOL_LEFT}{number_format($total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                        </tr>
                    </tbody>
                {else}
                    <h4 align="center">{lang('no_data')}</h4>
                {/if}
            </table>
            </div>
            </div>
        </div>
    </div>
{/block}