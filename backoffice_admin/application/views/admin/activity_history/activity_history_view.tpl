{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('admin/activity_history_view','role="form" class="" method="post" name="date_range" id="date_range" onsubmit= "return dateValidation()"')}
            <div class="form-group">
                <label>{lang('from_date')}</label>
                <input  autocomplete="off"  class="form-control date-picker" name="week_date1" id="week_date1" type="text" value="{$from}">
            </div>
            <div class="form-group">
                <label>{lang('to_date')}</label>
                <input  autocomplete="off"  class="form-control date-picker" name="week_date2" id="week_date2" type="text" value="{$to}">
            </div>
            <div class="form-group">
                <label>{lang('user_name')}</label>
                <input type="text" class="form-control user_autolist" autocomplete="Off" id="user_name" name="user_name" value="{$user_name}">
                <div id="uname_err" style="display: none; color: #b94a48;">{lang('invalid_user_name')}</div>
            </div>
            <div class="form-group">
                <label> {lang('ip_address')}</label>
                <input type="text" class="form-control" id="ip_address" name="ip_address" value="{$ipaddress}">
                <div id="ip_err" style="display: none; color: #b94a48;">{lang('Invalid_ip')}</div>
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="weekdate" type="submit" value="{lang('submit')}"> {lang('submit')}</button>
            </div>
            {form_close()}
        </div>
    </div>
    <div class="panel panel-default ng-scope">
    <div class="panel-body">
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('date')}</th>
                    <th>{lang('username')}</th>
                    <th>{lang('ip_address')}</th>
                    <th>{lang('activity')}</th>
                </tr>
            </thead>
            {if $details_count>0}
                <tbody>
                    {assign var="root" value="{$BASE_URL}admin/"}
                    {$i = 0}
                    {foreach from=$activity_details item=v}
                        <tr>
                            <td>{$i + $page_id + 1}</td>                                  
                            <td>{$v.date}</td> 
                            {if $v.activity == 'new user registered'}
                                <td>{$v.username}</td> 
                            {else}
                                <td>{$v.username_done}</td> 
                            {/if}
                            <td>{$v.ip}</td> 
                            {if lang($v.activity)}
                                <td>{lang($v.activity)}</td>
                            {else}
                                <td>{$v.activity}</td>  
                            {/if}
                        </tr>
                        {$i = $i + 1}
                    {/foreach}
                </tbody>

            </table>
            </div>
          
        {else}
            <tbody>
                <tr><td colspan="13" align="center" ><h4 align="center">{lang('no_data')}</h4></td></tr>
            </tbody>
        </table> 
            
    {/if}
</table>
{$result_per_page} 
</div>

</div>
 
{/block}