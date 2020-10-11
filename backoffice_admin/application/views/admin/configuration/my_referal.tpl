{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" class="no-display">
    <span id="errmsg1">{lang('you_must_enter_user_name')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg">{lang('you_must_enter_user_name')}</span>
</div>

<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>

{include file="layout/search_member.tpl"}

{if isset($user_name) && $is_valid_username}
    <div id="user_account"></div>
    <div id="username_val" style="display:none;">{$user_name}</div>

 

    <div class="panel panel-default">
 
    <div class="panel-body">
       <legend>
        <span class="fieldset-legend">{lang('referal_details')}: {$user_name}</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('full_name')}</th>
                    <th>{lang('joinig_date')}</th>
                    <th>{lang('email')}</th>
                    <th>{lang('country')}</th>
                </tr>
            </thead>
            {if count($arr)>0}
                <tbody>
                    {assign var=i value="0"}
                    {foreach from=$arr item=v}
                        {$i = $i+1}
                        <tr>
                            <td>{$i+$page_id}</td>
                            <td>{$v.user_name}</td>
                            <td>{$v.name}</td>
                            <td>{$v.join_date}</td>
                            <td> {$v.email}</td>
                            <td>{$v.country}</td>
                        </tr>
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr>
                        <td colspan="8">
                            <h4>{lang('no_referels')}</h4>
                        </td>
                    </tr>
                </tbody>
            {/if}
        </table>
        </div>
        </div>
    </div>
    {$result_per_page}
{/if}


{/block}