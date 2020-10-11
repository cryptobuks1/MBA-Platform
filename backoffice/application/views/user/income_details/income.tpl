{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    
<input type="hidden" id="filter_submit_url" value="{$BASE_URL}user/income_details/income">    
<div class="panel panel-default">
<div class="panel-body">
    <div class = "panel-tools-filter" style="text-align: right;margin: 5px;">
         {$date_text = lang('overall')}
         {if $date == 'month'}
            {$date_text = lang('this_month')}
        {elseif $date == 'year'}
            {$date_text = lang('this_year')}
        {/if}
         <div class="btn-group dropdown filter_date" style = "display: inline-block;vertical-align: middle;">
            <button class="btn btn-sm btn-default" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-calendar"></i>
                <b>{$date_text} ({lang('date')})</b>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li class="{if !$date}active{/if}">
                    <a class="" data-value="">
                        <span class="">{lang('overall')}</span>
                    </a>
                </li>
                <li class="{if $date == 'month'}active{/if}">
                    <a class="" data-value="month">
                        <span class="">{lang('this_month')}</span>
                    </a>
                </li>
                <li class="{if $date == 'year'}active{/if}">
                    <a class="" data-value="year">
                        <span class="">{lang('this_year')}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="btn-group dropdown filter_clear">
            <button class="btn btn-sm btn-default" aria-expanded="false">
                <i class="fa fa-circle-o-notch"></i>
                <b>{lang('clear')}</b>
            </button>
        </div>
            
     </div> 
    {assign var=i value="0"} 
    {assign var=total value="0"} 
    {assign var=class value=""}
    <div class=" table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead class="table-bordered">
            <tr class="th">
                <th>{lang('sl_no')}</th>
                <th>{lang('user_name')}</th>
                <th>{lang('level')}</th>
                <th>{lang('amount_type')}</th>
                <th>{lang('amount')}</th>
            </tr>
        </thead>
        {if count($amount)>0}
        <tbody>
            {foreach from=$amount item=v} 
                {if $i%2 == 0} 
                    {$class="tr2"} 
                {else} 
                    {$class="tr1"} 
                {/if}
                
                {$i = $i+1} 
                {$total =$total+ $v.amount_payable}
                
            <tr class="{$class}">
                <td>{$i + $page}</td>
                <td>
                    {if $v.from_user && in_array($v.amount_type, $from_user_amount_types)}
                        {$v.from_user}
                    {else}
                        NA
                    {/if}
                </td>
                <td>
                    {if in_array($v.amount_type, $level_based_amount_type)}
                        {$v.user_level}
                    {else}
                        NA
                    {/if}
                </td>
                <td>
                    {if $v.amount_type == 'board_commission' && $MODULE_STATUS['table_status'] == 'yes'}
                        {lang('table_commission')}
                    {else}
                        {lang($v.amount_type)}
                    {/if}
                </td>

                <td>{$DEFAULT_SYMBOL_LEFT} {number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
            </tr>
            {/foreach}
            <td colspan="4" class="text-right"><b>{lang('amount_total')}</b></td>
            <td>{$DEFAULT_SYMBOL_LEFT} {number_format($total*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
            </tr>
        </tbody>
        {else}
        <tbody>
            <tr>
                <td colspan="12" align="center">
                    <h4>{lang('no_income_details_were_found')}</h4></td>
            </tr>
        </tbody>
        {/if}

    </table>
    </div>
       </div>
</div>
 {$result_per_page}
{/block}
{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/income_details_filter.js" type="text/javascript" ></script>
{/block}