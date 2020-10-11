{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="button_back">
        {if $MODULE_STATUS['mlm_plan'] != "Unilevel"}
            <a href="{BASE_URL}/user/sponsor_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
                {else}
            <a href="{BASE_URL}/user/genology_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
                {/if}

    </div>
    <div class="panel panel-default table-responsive">
    <div class="panel-body">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('full_name')}</th>
                    <th>{lang('joinig_date')}</th>
                    <th> {lang('email')}</th>
                    <th>{lang('country')}</th>
                </tr>
            </thead>
            {if $count>0}
                <tbody>
                    {assign var="i" value="0"}
                    {assign var="class" value=""}
                    {foreach from=$arr item=v}
                        {if $i%2==0}
                            {$class='tr1'}
                        {else}
                            {$class='tr2'}
                        {/if}
                        <tr class="{$class}">
                            <td>{$i + 1 + $page}</td>
                            <td>{$v.user_name}</td>
                            <td>{$v.name}</td>
                            <td>{$v.join_date}</td>
                            <td> {$v.email}</td>
                            <td>{$v.country}</td>
                        </tr>
                        {$i=$i+1}
                    {/foreach}                        
                </tbody>
            {else}                   
                <tbody>
                    <tr><td colspan="12" align="center"><h4>{lang('no_referels')}</h4></td></tr>
                </tbody> 
            {/if}
        </table>
        </div>
    </div>
    {$result_per_page}
{/block}