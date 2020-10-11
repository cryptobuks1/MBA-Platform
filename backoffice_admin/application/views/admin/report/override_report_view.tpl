{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    {assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_repurchase_report"} 
    {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_repurchase_report"}
    {assign var="report_name" value="{lang('override_report')}"}
    {$total_amount=0}
    <input type="hidden" name="{$CSRF_TOKEN_NAME}" value="{$CSRF_TOKEN_VALUE}" />
    {include file="admin/report/report_nav.tpl" name=""}
    <div id="print_area" class="img panel-body panel">
        {include file="admin/report/header.tpl" name=""}
        <div class="panel panel-default ng-scope">
            <div class=" table-responsive">
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >=1}
                    <tbody>
                    <thead>
                        <tr class="th" align="center">
                            <th>{lang('slno')}</th> 
                            <th>{lang('user_name')}</th>
                            <th>{lang('full_name')}</th>
                            <th>{lang('date_submission')}</th> 
                            <th>{lang('paid_step')}</th> 
                            <th>{lang('personal_volume')}</th> 
                            <th>{lang('total_amount')} ({$DEFAULT_SYMBOL_LEFT}{$DEFAULT_SYMBOL_RIGHT})</th>
                        </tr>
                    </thead>
                    {assign var="i" value=0}
                    {assign var="total_amount" value=0}

                    {foreach from=$purcahse_details item=v}
                        {if $i%2==0}
                            {assign var="class" value="tr1"}
                        {else}
                            {assign var="class" value="tr2"}
                        {/if}
                        {$i=$i+1}
                        <tr>
                            <td>{counter}</td> 
                            <td>{$v.user_name}</td>
                            <td>{$v.full_name}</td>
                            <td>{$v.date_of_submission}</td> 
                            <td>{$v.paid_step}</td> 
                            <td>{$v.personal_volume}</td> 
                            <td>{$v.amount}</td>
                            {$total_amount = $total_amount + $v.amount}
                        </tr>
                    {/foreach}
                    <tr>
                        <td colspan="6" class="text-right"> <b>{lang('total_amount')}</b></td>
                        <td style="text-align: center;"><b>{$DEFAULT_SYMBOL_LEFT} {$total_amount} {$DEFAULT_SYMBOL_RIGHT}</b></td>
                    </tr>
                    </tbody>
                    {else}
                        <h4><center>{lang('no_data')}</center></h4>
                                {/if}
                        </table>
                    </div>
                </div>
            </div>
            {/block}