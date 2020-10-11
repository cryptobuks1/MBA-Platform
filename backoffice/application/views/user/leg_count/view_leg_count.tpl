{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="button_back">
        <a href="{$BASE_URL}user/genology_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
    </div>
    <div class="panel panel-default table-responsive ng-scope">
    <div class="panel-body">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th" align="center"> </tr>
                <tr class="th">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('userid_fullname')}</th>
                    <th>{lang('left_point')}</th>
                    <th>{lang('right_point')}</th>
                    <th>{lang('left_carry')}</th>
                    <th>{lang('right_carry')}</th>
                    <th>{lang('total_pair')}</th>
                    <th><b>{lang('amount')}</b></th>
                </tr>
            </thead>
            {if count($user_leg_detail)!=0}
                {assign var="left_leg_tot" value ="0"}
                {assign var="right_leg_tot" value ="0"}
                {assign var="left_carry_tot" value ="0"}
                {assign var="right_carry_tot" value ="0"}
                {assign var="total_leg_tot" value ="0"}
                {assign var="total_leg_tot" value ="0"}
                {assign var="total_amount_tot" value ="0"}
                {assign var="k" value ="0"}
                {assign var="class" value =""}
                <tbody>
                    {foreach from=$user_leg_detail item=v}

                        {assign var="left" value ="{$v.left}"}
                        {assign var="right" value ="{$v.right}"}
                        {assign var="left_carry" value ="{$v.left_carry}"}
                        {assign var="right_carry" value ="{$v.right_carry}"}
                        {assign var="tot_leg" value ="{$v.total_leg}"}
                        {assign var="tot_amt" value ="{$v.total_amount}"}

                        {$left_leg_tot = $left_leg_tot+$left}
                        {$right_leg_tot = $right_leg_tot+$right}
                        {$left_carry_tot = $left_carry_tot+$left_carry}
                        {$right_carry_tot = $right_carry_tot+$right_carry}
                        {$total_leg_tot = $total_leg_tot+$tot_leg}
                        {$total_amount_tot =$total_amount_tot+ $tot_amt}

                        {if $k%2==0}
                            {$class='tr1'}
                        {else}
                            {$class='tr2'}
                        {/if}
                        <tr align="center" >
                            <td>{counter}</td>
                            <td>{$v.user}-{$v.detail}</td>
                            <td>{$left}</td>
                            <td>{$right}</td>
                            <td>{$left_carry}</td>
                            <td>{$right_carry}</td>
                            <td>{$tot_leg}</td>
                            <td>{$DEFAULT_SYMBOL_LEFT}{$tot_amt}{$DEFAULT_SYMBOL_RIGHT}</td>
                        </tr>
                        {$k=$k+1}
                    {/foreach}

                    {$class='total'}

                    <tr class="{$class}" align="center" >
                        <td colspan="2" class="text-right"><b>{lang('total')}</b></td>
                         
                        <td><b>{$left_leg_tot}</b></td>
                        <td><b>{$right_leg_tot}</b></td>
                        <td><b>{$left_carry_tot}</b></td>
                        <td><b>{$right_carry_tot}</b></td>
                        <td><b>{$total_leg_tot}</b></td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{$total_amount_tot}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                    </tr>
                </tbody>
            {else}
                <h3>{lang('no_leg_count_found')}</h3>
            {/if}          
        </table>
        </div>
       
    </div>
     {$result_per_page}
{/block} 