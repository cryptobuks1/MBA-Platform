{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
    
    {if $MODULE_STATUS['mlm_plan'] == "Unilevel"}
        {$path = 'admin/genology_tree'}
    {else}
        {$path = 'admin/sponsor_tree'}
    {/if}
    
<div class="button_back">
        <a href="{BASE_URL}/{$path}"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
</div>
    <div id="span_js_messages" style="display:none;">
        <span id="error_msg">{lang('you_must_enter_user_name')}</span>
        <span id="row_msg">{lang('rows')}</span>
        <span id="show_msg">{lang('shows')}</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open_multipart('', 'role="form" class="" name="searchform" id="searchform" method="post"')}
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i> {lang('errors_check')}
            </div>
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label> {lang('user_name')}</label>
                    <input  name="user_name" class="form-control user_autolist" id="user_name" type="text" autocomplete="off" {if isset($username)} value="{$username}" {/if}>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('level')}</label>
                    <select name="level" id="level" class="form-control">
                        <option value="all">{lang('all')}</option>
                        {foreach from=$level_arr item=v}
                            <option value="{$v}" {if $unilevel_histroy_level==$v}selected=""{/if}>{$v}</option>
                        {/foreach}
                    </select>
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
     <legend><span class="fieldset-legend">{lang('unilevel_history')} : {$username}</span></legend>
     <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>

                <tr class="th">
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
                    <th>{lang('referal')}</th>
                </tr>
            </thead>
            {if count($unievel)>0}
                {assign var=i value="$start"}
                {assign var=class value=""}
                <tbody>
                    {foreach from=$unievel item=v}
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
                            <td>
                                <a tabindex="{$i+3}" href="{$BASE_URL}{$path}/{$v.username_enc}" target="_blank"  style="color: #20afa6;">
                                    <i class="clip-tree" ></i>&nbsp;{lang('view_referal')}
                                </a>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr><td colspan="9" align="center"><h4 align="center"> {lang('no_details_found')}</h4></td></tr>
                </tbody>
            {/if}
        </table>
        </div>
        </div>

    </div>        {$result_per_page}
{/block}