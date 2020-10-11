{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg1">{lang('you_must_enter_username')}</span>
</div>
<legend><span class="fieldset-legend">{lang('search_member')}</span></legend>
{include file="layout/search_member.tpl"} {if $flag == "true"}
<div class="panel panel-default table-responsive ng-scope">
    <div class="panel-body">
        <legend><span class="fieldset-legend">{lang('member_details')}</span></legend>
        <div class="table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr class="th">
                        {if !isset($user_name)}
                        <th>{lang('slno')}</th>
                        {/if}
                        <th>{lang('user_name')}</th>
                        <th>{lang('name')}</th>
                        <th>{lang('sponser_name')}</th>
                        <th>{lang('mobile_no')}</th>
                        <th>{lang('action')}</th>
                    </tr>
                </thead>
                <tbody>
                    {if count($user_details) > 0} {$i = 0} {foreach from=$user_details item=v}
                    <tr>
                        {if !isset($user_name)}
                        <td>{$page_id + $i + 1}</td>
                        {/if}
                        <td>{$v['user_name']} {if ($v['active']) == 'yes'}
                            <b class="badge label-primary-1">{lang('active')}</b> {else}
                            <b class="badge label-primary-2">{lang('inactive')}</b> {/if}
                        </td>
                        <td>{$v['full_name']}</td>
                        <td>{$v['sponsor_full_name']}</td>
                        <td>{$v['mobile_no']}</td>
                        <td>
                            {if $v.active == "yes"} {assign var = "action_url" value = "admin/activate/deactivate_user"} {else} {assign var = "action_url" value = "admin/activate/activate_user"} {/if} {form_open($action_url,'method="post"')}
                            <div class="">
                                <button class="btn btn-sm btn-primary" type="submit" name="user_name" id="user_name" value="{$v.user_name}" tabindex="3" onclick="$(this).button('loading');">{if $v.active == "yes"} {lang('block')}{else}{lang('unblock')}{/if} </button>
                            </div>
                            {form_close()}

                        </td>
                    </tr>
                    {$i = $i + 1} {/foreach} {else}
                    <tr>
                        <td colspan="6">
                            <h4 align="center">{lang('No_Details_Found')}</h4>
                        </td>
                    </tr>
                    {/if}
                </tbody>
            </table>
            {if !isset($user_name)} {$result_per_page} {/if}

        </div>
    </div>
</div>
{else}
<legend><span class="fieldset-legend">{lang('member_details')}</span></legend>
<div class="tabsy">
    <input type="radio" id="tab1" name="tab" {if $tab1}checked{/if}>
    <label class="tabButton" for="tab1">{lang('active_users')}</label>
    <div class="tab">
        <div class="content table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr class="th">
                        <th>{lang('slno')}</th>
                        <th>{lang('user_name')}</th>
                        <th>{lang('name')}</th>
                        <th>{lang('sponser_name')}</th>
                        <th>{lang('mobile_no')}</th>
                        <th>{lang('action')}</th>
                    </tr>
                </thead>
                <tbody>
                    {if count($user_details1) > 0} {$i = 0} {foreach from=$user_details1 item=v}
                    <tr>
                        <td>{$start1++}</td>
                        <td>{$v['user_name']} {if ($v['active']) == 'yes'}
                            <b class="badge label-primary-1">{lang('active')}</b> {else}
                            <b class="badge label-primary-2">{lang('inactive')}</b> {/if}
                        </td>
                        <td>{$v['full_name']}</td>
                        <td>{$v['sponsor_full_name']}</td>
                        <td>{$v['mobile_no']}</td>
                        <td>
                            {if $v.active == "yes"} {assign var = "action_url" value = "admin/activate/deactivate_user"} {else} {assign var = "action_url" value = "admin/activate/activate_user"} {/if} {form_open($action_url,'method="post"')}
                            <div class="">
                                <button class="btn btn-sm btn-primary" type="submit" name="user_name" id="user_name" value="{$v.user_name}" tabindex="3" onclick="$(this).button('loading');">{if $v.active == "yes"} {lang('block')}{else}{lang('unblock')}{/if} </button>
                            </div>
                            {form_close()}

                        </td>
                    </tr>
                    {$i = $i + 1} {/foreach} {else}
                    <tr>
                        <td colspan="6">
                            <h4 align="center">{lang('no_data')}</h4>
                        </td>
                    </tr>
                    {/if}
                </tbody>
            </table>
            {$result_per_page1}
        </div>
    </div>
    <input type="radio" id="tab2" name="tab" {if $tab2}checked{/if}>
    <label class="tabButton" for="tab2">{lang('block_users')}</label>
    <div class="tab">
        <div class="content table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr class="th">
                        <th>{lang('slno')}</th>
                        <th>{lang('user_name')}</th>
                        <th>{lang('name')}</th>
                        <th>{lang('sponser_name')}</th>
                        <th>{lang('mobile_no')}</th>
                        <th>{lang('action')}</th>
                    </tr>
                </thead>
                <tbody>
                    {if count($user_details2) > 0} {$i = 0} {foreach from=$user_details2 item=v}
                    <tr>
                        <td>{$start2++}</td>
                        <td>{$v['user_name']} {if ($v['active']) == 'yes'}
                            <b class="badge label-primary-1">{lang('active')}</b> {else}
                            <b class="badge label-primary-2">{lang('inactive')}</b> {/if}
                        </td>
                        <td>{$v['full_name']}</td>
                        <td>{$v['sponsor_full_name']}</td>
                        <td>{$v['mobile_no']}</td>
                        <td>
                            {if $v.active == "yes"} {assign var = "action_url" value = "admin/activate/deactivate_user"} {else} {assign var = "action_url" value = "admin/activate/activate_user"} {/if} {form_open($action_url,'method="post"')}
                            <div class="">
                                <button class="btn btn-sm btn-primary" type="submit" name="user_name" id="user_name" value="{$v.user_name}" tabindex="3" onclick="$(this).button('loading');">{if $v.active == "yes"} {lang('block')}{else}{lang('unblock')}{/if} </button>
                            </div>
                            {form_close()}

                        </td>
                    </tr>
                    {$i = $i + 1} {/foreach} {else}
                    <tr>
                        <td colspan="6">
                            <h4 align="center">{lang('no_data')}</h4>
                        </td>
                    </tr>
                    {/if}
                </tbody>
            </table>
            {$result_per_page2}
        </div>
    </div>
</div>
{/if} {/block} {block name='script'}
<script>
    jQuery(document).ready(function() {
        ValidateSearchMember.init();
    });
</script>
{/block}