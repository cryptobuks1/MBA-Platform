{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="button_back"> <a href="{$BASE_URL}user/index">
            <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button>
        </a> </div>
    <div class="panel panel-default table-responsive ng-scope">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('package')}</th> 
                    <th>{lang('expiry_date')}</th> 
                    <th>{lang('Hyip')}</th>   
                </tr>
            </thead>
            {if $details_count>0}
                {assign var=color value=['progress-bar-aqua','progress-bar-red','progress-bar-green','progress-bar-yellow']}
                {$i = 0}
                {foreach from=$matured_deposit item=v}
                    {assign var="package" value="{$v.package}"}
                    <tbody>
                        <tr>
                            <td>{$i + 1}</td>    
                            <td>{$v.package}</td>
                            <td>{date('Y/m/d', strtotime($v.date_of_submission))}</td>
                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        </tr>
                        {$i = $i + 1}
                    {/foreach}
                    <tr>
                        <td colspan="3" style="font-size: initial; text-align:right" class="" ><span style="margin-right: 10px;">{lang('available_amount')}</span></td>
                        <td style="font-size: initial;">{$DEFAULT_SYMBOL_LEFT}{number_format($matured_deposit[$i-1]['tot_amount']*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                    </tr>
                </tbody>
            {else}
                <tbody>
                    <tr id="tr-empty"><td align="center" colspan="4"><h4 align="center">{lang('no_data_found')}</h4></td></tr>
                </tbody>
            {/if}
        </table>
    </div>
{/block}