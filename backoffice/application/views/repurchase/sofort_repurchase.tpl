{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    {form_open('repurchase/sofort_response', 'method="post" class="" name="form" id="form" role="form"')}
    
    <div class="panel panel-default table-responsive ng-scope">
        <table st-table="rowCollectionBasic" class="table">

            <input type="hidden" name="reason_1" value="1" />
            <input type="hidden" name="reason_2" value="{$comment}" />
            <input type="hidden" name="amount" value="{$amount}" />
            <input name="user_variable_0" type="hidden" value="1"/>
            <input type="hidden" name="success_url" id="success_url" value="{$PATH_TO_ROOT_DOMAIN}repurchase/sofort_payment_success">
            <input type="hidden" name="abort_url"  id="abort_url" value="{$PATH_TO_ROOT_DOMAIN}repurchase/repurchase_product">
       <tr>
        {if $DEMO_STATUS == 'yes'}
            <td colspan="2" ><input class="btn btn-primary" type="button"  value="{lang('sofort_only_in_live')}"/></td>
        {else}
            <td colspan="2" ><input class="btn btn-primary" type="submit" value="{lang('click_here_for_the_secure_payment_form')}"/></td>
        {/if} 
       </tr>
       </table>
   </div>
    {form_close()}

{/block}

