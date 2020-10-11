{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

    {form_open('https://payeer.com/merchant/', 'method="post"')}
    
    <div class="panel panel-default table-responsive ng-scope">
        <table st-table="rowCollectionBasic" class="table">
            
            <input type="hidden" name="m_shop" value="{$m_shop}">
            <input type="hidden" name="m_orderid" value="{$m_orderid}">
            <input type="hidden" name="m_amount" value="{$m_amount}">
            <input type="hidden" name="m_curr" value="{$m_curr}">
            <input type="hidden" name="m_desc" value="{$m_desc}">
            <input type="hidden" name="m_sign" value="{$sign}">
            <input type="hidden" name="success_url" id="success_url" value="{$PATH_TO_ROOT_DOMAIN}admin/member/payeer_success">
            <input type="hidden" name="abort_url"  id="abort_url" value="{$PATH_TO_ROOT_DOMAIN}admin/member/upgrade_package_validity">
            <tr>
                {if $DEMO_STATUS == 'yes'}
                    <td colspan="2" ><input class="btn btn-primary" type="button"  value="{lang('payeer_only_in_live')}"/></td>
                {else}
                    <td colspan="2" ><input class="btn btn-primary" type="submit" name="m_process" value="{lang('click_here_for_the_secure_payment_form')}"/></td>
                {/if}
            </tr>
       </table>
       <br>
    </div>
    {form_close()}

{/block}

