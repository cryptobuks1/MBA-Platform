{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="button_back">
        <a href="{BASE_URL}/admin/genology_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open_multipart('', 'role="form" class="" name="searchform" id="searchform" method="post"')}
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i> {lang('errors_check')}
            </div>
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label>{lang('select_user_name')}</label>
                    <input class="form-control user_autolist" name="user_name" id="user_name" type="text" autocomplete="off" {if isset($username)} value="{$username}" {/if} >
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('select_level')}</label>

                    <select name="level" id="level" class="form-control">
                        <option value="all">{lang('all')}</option>
                        {for $level=1 to $level_arr}
                            <option value="{$level}" {if $binary_level==$level}selected=""{/if}>{$level}</option>
                        {/for}
                    </select>

                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('select_type')}</label>
                    <select name="type" id="type" class="form-control">
                        <option value="all"{if $type == 'all'}selected = ""{/if}>{lang('all')}</option>
                        <option value="affiliate"{if $type == 'affiliate'}selected = ""{/if}>{lang('affiliate')}</option>
                        <option value="customer"{if $type == 'customer'}selected = ""{/if}>{lang('customer')}</option>
                    </select>

                </div>
            </div>
             <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('select_rank_name')}</label>
                    <input class="form-control rank_autolist" name="rank_name" id="rank_name" type="text" autocomplete="off"  >
                </div>
            </div>
            
            
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary m-t-t-t" id="user_details" value="{lang('search')}" name="user_details">{lang('search')}</button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>

    <div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">[{lang('downline_list')}: {$username}]</span> 
    {if $rank_name}
    <span class="fieldset-legend">[{lang('rank_name')}: {$rank_name}]</span>
    {/if}
    </legend>
    <div class=" table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th" align="center">
                    <th>{lang('slno')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('name')}</th>
                    <th>{lang('enrollment_date')}</th>
                    <th>{lang('level')}</th>
                    <th>{lang('state')}</th>
                    <th>{lang('country')}</th>
                    {if $MODULE_STATUS['rank_status'] == 'yes'}
                        <th>{lang('Rank')}</th>
                    {/if}
                    <th>{lang('genealogy')}</th>
                </tr>
            </thead>
            {if count($binary)>0}
                {assign var=i value="{$start}"}
                {assign var=class value=""}
                <tbody>
                    {foreach from=$binary item=v}
                        {$i=$i+1}
                        <tr>
                            <td>{$i}</td>
                            <td>{$v.username}<b class="badge label-primary-1">{if $v.active == 'yes'}{lang('active')}{else}{lang('inactive')}{/if}</b></td>
                            <td>{$v.name}</td>
                            <td>{$v.date_of_joining}</td>
                            <td>{$v.level}</td>
                            <td>{$v.state}</td>
                            <td>{$v.country}</td>
                            {if $MODULE_STATUS['rank_status'] == 'yes'}
                                {if $v.rank}
                                    <td><span class="rank_color_code" style="background-color:{$v.rank_color}">{$v.rank}</td>
                                {else}
                                    <td><span class="rank_color_code">{lang('na')}</td>
                                {/if}
                            {/if}
                            <td><a tabindex="{$i+3}" href={$BASE_URL}admin/tree/genology_tree?user_name={$v.username} target="_blank" style="color: #20afa6;"><i class="clip-tree" ></i>&nbsp;{lang('view_genealogy')}</a></td>
                        </tr>
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr><td colspan="9" align="center"><h4 align="center">{lang('no_details_found')}</h4></td></tr>
                </tbody>
            {/if}
        </table>
        </div>
        </div>
    </div>
                    {$result_per_page}
{/block}