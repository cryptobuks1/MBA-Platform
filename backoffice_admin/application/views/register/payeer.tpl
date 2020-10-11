{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    {lang('payeer_authentication')} 
                </div>
                <div class="panel-body">
                    <table align="center" width="50%">
                        <tr>
                            <td>
                                {form_open('https://payeer.com/merchant/', 'method="post"')}
                                <input type="hidden" name="m_shop" value="{$m_shop}">
                                <input type="hidden" name="m_orderid" value="{$m_orderid}">
                                <input type="hidden" name="m_amount" value="{$m_amount}">
                                <input type="hidden" name="m_curr" value="{$m_curr}">
                                <input type="hidden" name="m_desc" value="{$m_desc}">
                                <input type="hidden" name="m_sign" value="{$sign}">
                                {form_close()}
                            </td>
                        </tr>
                        <tr>
                            {if $DEMO_STATUS == 'yes'}
                                <td colspan="2" ><input class="btn btn-primary" type="button"  value="{lang('payeer_only_in_live')}"/></td>
                            {else}
                                <td colspan="2" ><input class="btn btn-primary" type="submit" name="m_process" value="{lang('click_here_for_the_secure_payment_form')}"/></td>
                            {/if}
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

{/block}

