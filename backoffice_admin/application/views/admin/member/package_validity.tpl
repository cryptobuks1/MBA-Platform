{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display: none;">
        <span id="errmsg1">{lang('please_enter_a_username')}</span>
        <span id="row_msg">{lang('rows')}</span>
        <span id="show_msg">{lang('shows')}</span>
    </div>
    <legend><span class="fieldset-legend">{lang('search_member')}</span></legend>
    {include file="layout/search_member.tpl"}
    <div class="panel panel-default ng-scope">
    <div class="panel-body">
    <div class="table-responsive">
    
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped over_flw_btn">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('sponser_name')}</th>
                    <th>{lang('product_validity')}</th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            {if count($expired_users)>0}
                {assign var="i" value=$page_num}
                {assign var="class" value=""}
                <tbody>
                    {foreach from=$expired_users item=v}
                        {$i=$i+1}

                        {assign var="id" value="{$v.user_id}"}
                        {assign var="user_name" value="{$v.user_name}"}
                        {assign var="product_validity" value="{$v.product_validity}"}
                        {assign var="sponsor_name" value="{$v.sponsor_name}"}
                        {assign var="encrypt_id" value="{$v.encrypt_id}"}
                        <tr>      
                            <td>{$i}</td>
                            <td>{$user_name}</td>
                            <td>{$sponsor_name}</td>
                            <td>{$product_validity}</td>
                            <td>
                                <center> 
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/member/upgrade_package_validity/{$encrypt_id}" data-original-title="{lang('upgrade_package_validity')}" data-content="{$v.user_name} - {$product_validity}" data-placement="left" data-trigger="hover" class="btn-link text-primary popovers new_btn">
                                        <i class="fa fa-level-up"></i> 
                                    </a>
                                </center>
                            </td>
                        </tr>
                {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr><td colspan="8" align="center"><h4 align="center"> {lang('Product_validity_is_not_expired')}</h4></td></tr>
                </tbody>
            {/if}
        </table>
        </div>
         {$result_per_page}
        </div>
        
    </div>
   
{/block} 
{block name='script'}
<script>
    jQuery(document).ready(function () {
        ValidateSearchMember.init();
    });
</script>
{/block}