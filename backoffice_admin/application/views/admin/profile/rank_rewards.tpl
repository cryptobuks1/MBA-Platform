{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" class="no-display">
    <span id="error_msg">{lang('select_user_id')}</span>
    <span id="errmsg1">{lang('you_must_enter_username')}</span>
</div>

<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>

{include file="layout/search_member.tpl"}

{assign var="u" value=$u_name}
{if $u_name}
    <div id="user_account"></div>
    <div id="username_val" style="display:none;">{$u}</div>
    
  {*  <div class="form-group form-group-right">
        <span class="h4">{lang('current_rank')} : {$rank_name}</span>
        
    </div>*}

    

    <div class="panel panel-default">
    <div class="panel-body">
    <legend>
        <span class="fieldset-legend">{lang('reward_details')}: {$u_name}</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th>{lang('slno')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('rank')}</th>
                   
                    <th>{lang('reward')}</th>
                    
                    <th>{lang('date')}</th>
                </tr>
            </thead>
            {if count($details)>0}
                <tbody>
                    {assign var=i value="0"}
                    {foreach from=$details item=v}
                        {$i = $i+1}
                        
                        <tr>
                            <td>{$i+$page_id}</td>
                            <td>{$v.user_name}</td>
                            
                            <td>{$v.rank_name}</td>
                            
                            <td>{$v.reward}</td>
                           
                            <td>{$v.date}</td>
                        </tr>
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr>
                        <td colspan="8">
                            <h4>{lang('no_details')}</h4>
                        </td>
                    </tr>
                </tbody>
            {/if}
        </table>
        </div>
         {$result_per_page}
        </div>
    </div>
   
{/if}


{/block}
{block name='script'}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/user_summary_header.js" type="text/javascript" ></script>
{/block}