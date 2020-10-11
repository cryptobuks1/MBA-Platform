{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<div class="panel panel-default  ng-scope">
<div class="panel-body">
<div class="table-responsive">
   <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
      {if count($pin_numbers)==0}
      <div class="panel-body">
         <h4>
            <center>{lang('no_epin_found')}</center>
         </h4>
      </div>
      {else}
      <thead>
         <tr>
            <th>{lang('sl_no')}</th>
            <th>{lang('epin')}</th>
            <th>{lang('amount')}</th>
            <th>{lang('balance_amount')}</th>
            <th>{lang('status')}</th>
            <th>{lang('uploaded_date')}</th>
            <th>{lang('expiry_date')}</th>
            <th>{lang('action')}</th>
         </tr>
      </thead>
      <tbody>
         {assign var="i" value=$start_id}
         {assign var="class" value=""}
         {assign var="root" value="{$BASE_URL}user/"}
         {foreach from=$pin_numbers item=v}
         {if $i%2==0}
            {$class='tr1'}
         {else}
            {$class='tr2'}
         {/if}
         {if $v.used_user==""}
            {assign var="used_user" value="0"}
         {else}
             {assign var="used_user" value="{$v.used_user}"}
         {/if}
         {if $v.status=="yes"}
             {assign var="stat" value="{lang('active')}"}
         {else if $v.status=="expired"}
             {assign var="stat" value="{lang('expired')}"}
         {else if $v.status=="no"}
             {assign var="stat" value="{lang('inactive')}"}
         {else}
             {assign var="stat" value="{lang('used')}"}
         {/if}
         {$i=$i+1}
         <tr class="{$class}">
            <td>{$i}</td>
            <td><span class="m-b-xs w-xs bg-light" name="link{$i}" id="link{$i}" value="{$v.pin}" >{$v.pin}</span></td>
            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
            {*
            <td>{$used_user}</td>
            *}
            <td><span class="label bg-success">{$stat}</span></td>
            <td>{$v.pin_uploded_date}</td>
            <td>{$v.pin_expiry_date}</td>
            <td>
              
                    <span onclick="return copyEpinToClipboard(link{$i}, 'link{$i}')" class="btn-link btn_size has-tooltip text-primary" style="cursor: pointer;"><i class="fa fa-clipboard" ></i></span>
                      
                {if $v.status == "yes" && $v.purchase_status =="yes" && ($v.pin_balance_amount > 0)}
                    <!--refund option-->
                        {if DEMO_STATUS == 'yes' && $MODULE_STATUS['basic_demo_status'] == 'yes' && $is_preset_demo}
                        {else} 
                            <a class='btn-link btn_size has-tooltip text-danger' onclick="javascript:refund_pin({$v.pin_id}, '{$root}')"><i class="icon-reload"></i></a>
                        {/if}
                    <!--refund option-->
                {/if}  
            </td>
         </tr>
         {/foreach}
      </tbody>
      {/if}
   </table>
   </div>
   {$page_footer}
   </div>
</div>
{/block}

{block name=script} 
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/validate_epin.js"></script>
    <script src="{$PUBLIC_URL}javascript/misc.js"></script>
{/block}
