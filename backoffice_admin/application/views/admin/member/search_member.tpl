{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display: none;">
        <span id="errmsg">{lang('You_must_enter_keyword_to_search')}</span>
        <span id="row_msg">{lang('rows')}</span>
        <span id="show_msg">{lang('shows')}</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body ">
            {form_open('admin/search_member','role="form" class="" method="post"  name="search_mem" id="search_mem"')}
            <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
            <div class="col-sm-6 padding_both">
            <div class="form-group">
                <label>{lang('keyword')}</label>
                <input class="form-control" placeholder="{lang('Username_Name_Address_MobileNo')}.." type="text" name="keyword" id="keyword" autocomplete="Off">
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button class="btn btn-sm btn-primary " type="submit" name="search_member" id="search_member" value="{lang('search_member')}">{lang('search')}</button>
                    
                    <button class="btn btn-sm btn-primary " formnovalidate="formnovalidate" type="submit" name="reset" id="reset" value="{lang('clear')}">{lang('clear')}</button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>
    {if $flag}
        <input type="hidden" id="search_key" value="{$search_key}">
        <div class="panel panel-default ng-scope">
        <div class="panel-body">
        <div class="table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{lang('sl_no')}</th>
                        <th>{lang('user_name')}</th>
                        <th>{lang('name')}</th>
                        <th>{lang('sponser_name')}</th>
                        {if $MODULE_STATUS['rank_status'] == 'yes'}
                            <th>{lang('rank')}</th>
                        {/if}
                        <th>{lang('mobile_no')}</th>
                        <th>{lang('address')}</th>
                        <th>{lang('view_profile')}</th>
                    </tr>
                </thead>
                {if count($mem_arr)>0}
                    {assign var="i" value=0}
                    {assign var="class" value=""}
                    <tbody>
                        {foreach from=$mem_arr item=v}
                            {if $i%2==0}
                                {$class='tr1'}
                            {else}
                                {$class='tr2'}
                            {/if}
                            {assign var="id" value="{$v.user_id}"}
                            {assign var="user_name" value="{$v.user_name}"}
                            {assign var="user_detail_name" value="{$v.user_detail_name}"}
                            {assign var="user_detail_address" value="{$v.user_detail_address}"}
                            {assign var="user_detail_mobile" value="{$v.user_detail_mobile}"}
                            {assign var="user_detail_country" value="{$v.user_detail_country}"}
                            {assign var="encrypt_id" value="{$v.user_id_en}"}
                            {assign var="active" value="{$v.active}"}
                            {assign var="sponser_name" value="{$v.sponser_name}"}
                            {assign var="status" value=""}
                            {if $active=='yes'}
                                {$status="{lang('active')}"}

                                {$title="Block"}
                            {else}
                                {$status="{lang('inactive')}"}
                                {$title="Activate"}
                            {/if}
                            <tr>
                                <td>{$i + $page_id + 1}</td>
                                <td>{$user_name}
                                {if $v.active == 'yes'}
                                    <b  class="badge label-primary-1">{$status}</b>   
                                {else}
                                    <b  class="badge label-primary-2">{$status}</b>    
                                {/if}
                                </td>
                                <td>{$user_detail_name}</td>
                                <td>{$sponser_name}</td>
                                {if $MODULE_STATUS['rank_status'] == 'yes'}
                                    <td>
                                    {if !empty($v.rank)} 
                                        <span class="rank_color_code" style="background-color:{$v.rank_color}">{$v.rank}</span>
                                    {else}
                                        <span class="rank_color_code">{lang('na')}</span>
                                    {/if}
                                    </td>
                                {/if}
                                <td>{$user_detail_mobile}</td>
                                <td>{$user_detail_address}</td>
                                <td>
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/profile/profile_view/{$encrypt_id}" title="View" class="btn-link  text-primary">
                                        <i class="glyphicon glyphicon-camera"></i> 
                                    </a>
                                </td>
                            </tr>
                            {$i=$i+1}
                        {/foreach}
                    </tbody>
                {else}
                    <tbody>
                        <tr><td colspan="8" align="center"><h4 align="center"> {lang('No_User_Found')}</h4></td></tr>
                    </tbody>
                {/if}
            </table>
            </div>
            </div>
        </div>
    {$result_per_page}
    {/if}
{/block} 
{block name=script}
    <script>
        jQuery(document).ready(function () {
            ValidateMember.init();
            highlightSearchKey('{$search_key}');
        });
    </script>
{/block} 