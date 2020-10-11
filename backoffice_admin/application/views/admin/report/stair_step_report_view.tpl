{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    {assign var="report_name" value="{lang('stair_step_report')}"}
    {assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_stairstep_report"}
    {assign var="csv_url" value=""}
    {include file="admin/report/header.tpl" name=""}
    <div  id="print_area" class="panel-body" style="overflow: auto; max-height:1000px;">
        <div class="panel panel-default ng-scope">
        <div class="table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                {if $count >=1}
                    <tbody>
                        <tr>
                            <th>{lang('slno')}</th> 
                            <th>{lang('user_name')}</th>
                            <th>{lang('full_name')}</th>
                            <th>{lang('date_submission')}</th> 
                            <th>{lang('paid_step')}</th> 
                            <th>{lang('personal_volume')}</th> 
                            <th>{lang('total_amount')} ({$DEFAULT_SYMBOL_LEFT}{$DEFAULT_SYMBOL_RIGHT})</th>
                        </tr>
                        {assign var="i" value=0}
                        {assign var="total_amount" value=0}

                        {foreach from=$purcahse_details item=v}
                            {if $i%2==0}
                                {assign var="class" value="tr1"}
                            {else}
                                {assign var="class" value="tr2"}
                            {/if}
                            {$i=$i+1}
                            <tr {$class} >
                                <td>{counter}</td> 
                                <td>{$v.user_name}</td>
                                <td>{$v.full_name}</td>
                                <td>{$v.date_of_submission}</td> 
                                <td>{$v.paid_step}</td> 
                                <td>{$v.personal_volume}</td> 
                                <td> {$v.amount}</td>
                                {$total_amount = $total_amount + $v.amount}
                            </tr>
                        {/foreach}
                        <tr> 
                            <td colspan="6" style="text-align: center;"> <b>{lang('total_amount')}</b></td>
                            <td style="text-align: center;"><b>{$DEFAULT_SYMBOL_LEFT} {$total_amount} {$DEFAULT_SYMBOL_RIGHT}</b></td>
                        </tr>
                    </tbody>
                {else}
                    <h4 align="center">{lang('no_data')}</h4>
                {/if}
            </table>
            </div>
        </div>
    </div>
{/block}