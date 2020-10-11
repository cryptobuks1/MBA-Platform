{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="button_back">
        <a href="{BASE_URL}/admin/index"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
    </div>
    <div class="panel panel-default table-responsive">
    <div class="panel-body">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('package')}</th> 
                    <th>{lang('date_of_submission')}</th> 
                    <th>{lang('Hyip')}</th>   
                </tr>
            </thead>
            {if $details_count>0}
                <tbody>
                    {assign var=color value=['progress-bar-aqua','progress-bar-red','progress-bar-green','progress-bar-yellow']}
                    {$i = 0}
                    {foreach from=$roi_details item=v}
                        {assign var="package" value="{$v.package}"}
                        {$total= $v.tot_amount}
                        <tr>
                            <td>{$i + $page_id + 1}</td>    
                            <td>{$v.from_id}</td>
                            <td>{$v.package}</td>
                            <td>{date('Y/m/d', strtotime($v.date_of_submission))}</td>
                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        </tr>
                        {$i = $i + 1}
                    {/foreach}
                    <tr>
                        <td colspan="4" class="text-right" ><b>{lang('available_amount')}</b></td>
                        <td style="font-size: initial;">{$DEFAULT_SYMBOL_LEFT}{number_format($total*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                    </tr>
                </tbody>
            {else}
                <tbody>
                    <tr id="tr-empty"><td align="center" colspan="5"><h4 align="center">{lang('no_data_found')}</h4></td></tr>
                </tbody>
            {/if}
        </table>
        </div>
        
    </div>
    {$result_per_page} 
{/block}