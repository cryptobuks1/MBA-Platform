{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<main>
   <div class="tabsy">
      <input type="radio" id="tab1" name="tab" {$tab1}>
      <label class="tabButton" for="tab1">{lang('active_requests')}</label>
      <div class="tab">
         <div class="content">
            <div class="panel panel-default ng-scope">
               {if count($active_requests)>0}
               <input type="hidden" name="current_tab" id="current_tab" value="tab1" >
               <div class="table-responsive ">
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                  <thead class="table-bordered">
                     <tr class="th">
                        <th>{lang('sl_no')}</th>
                        <th>{lang('requested_date')}</th>
                        <th>{lang('requested_amount')}</th>
                        <th>{lang('payout_method')}</th>
                        <th>{lang('balance_amount')}</th>
                     </tr>
                  </thead>
                  {assign var="i" value=0}
                  {assign var="class" value=""}
                  {assign var="path" value="{$BASE_URL}user/"}
                  <tbody>
                     {foreach from=$active_requests item="v"}
                     {if $i%2==0}
                     {$class='tr1'}
                     {else}
                     {$class='tr2'}
                     {/if}
                     <tr class="{$class}">
                        <td>
                           {$page1+$i+1}
                        </td>
                        <td>{$v.requested_date}</td>
                        <td>
                           {$DEFAULT_SYMBOL_LEFT}{number_format($v.payout_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        <td>{if $v.payout_type eq 'bank'}
                           Bank
                           {elseif $v.payout_type eq 'Bitcoin'}
                           Blocktrail
                           {else}      
                           {$v.payout_type}
                           {/if}
                        </td>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                     </tr>
                     {$i=$i+1}
                     {/foreach}   
                  </tbody>
               </table>
               </div>
               {$result_per_page1}
               {else}
               <h4 align="center">{lang('no_payout_found')}</h4>
               {/if}
            </div>
         </div>
      </div>
      <input type="radio" id="tab2" name="tab" {$tab2}>
      <label class="tabButton" for="tab2">{lang('approved_waiting_for_transfer')}</label>
      <div class="tab">
         <div class="content">
            <div class="panel panel-default ng-scope">
               {if count($waiting_requests)>0}
               <input type="hidden" name="current_tab" id="current_tab" value="tab2" >
               <div class="table-responsive ">
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                  <thead class="table-bordered">
                     <tr class="th">
                        <th>{lang('sl_no')}</th>
                        <th>{lang('approved_date')}</th>
                        <th>{lang('Payout_Amount')}</th>
                        <th>{lang('payout_method')}</th>
                     </tr>
                  </thead>
                  {assign var="i" value=0}
                  {assign var="class" value=""}
                  {assign var="path" value="{$BASE_URL}user/"}
                  <tbody>
                     {foreach from=$waiting_requests item="v"}
                     {if $i%2==0}
                     {$class='tr1'}
                     {else}
                     {$class='tr2'}
                     {/if}
                     <tr class="{$class}">
                        <td>{$page2+$i+1}</td>
                        <td>{$v.paid_date}</td>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.paid_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        <td>
                           {if $v.payment_method eq 'bank'}
                           Bank
                           {elseif $v.payment_method eq 'Bitcoin'}
                           Blocktrail
                           {else}      
                           {$v.payment_method}
                           {/if}
                        </td>
                     </tr>
                     {$i=$i+1}
                     {/foreach}       
                  </tbody>
               </table>
               </div>
               {$result_per_page2}
               {else}
               <h4 align="center">{lang('no_payout_found')}</h4>
               {/if}
            </div>
         </div>
      </div>
      <input type="radio" id="tab3" name="tab" {$tab3}>
      <label class="tabButton" for="tab3">{lang('approved_paid')}</label>
      <div class="tab">
         <div class="content">
            <div class="panel panel-default ng-scope">
               {if count($paid_requests)>0}
               <input type="hidden" name="current_tab" id="current_tab" value="tab3" >
               <div class="table-responsive">
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                  <thead class="table-bordered">
                     <tr class="th">
                        <th>{lang('sl_no')}</th>
                        <th>{lang('paid_date')}</th>
                        <th>{lang('Payout_Amount')}</th>
                        <th>{lang('payout_method')}</th>
                     </tr>
                  </thead>
                  {assign var="i" value=0}
                  {assign var="class" value=""}
                  {assign var="path" value="{$BASE_URL}user/"}
                  <tbody>
                     {foreach from=$paid_requests item="v"}
                     {if $i%2==0}
                     {$class='tr1'}
                     {else}
                     {$class='tr2'}
                     {/if}
                     <tr class="{$class}">
                        <td>{$page3+$i+1}</td>
                        <td>{$v.paid_date}</td>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.paid_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        <td>
                           {if $v.payment_method eq 'bank'}
                           Bank
                           {elseif $v.payment_method eq 'Bitcoin'}
                           Blocktrail
                           {else}      
                           {$v.payment_method}
                           {/if}
                        </td>
                     </tr>
                     {$i=$i+1}
                     {/foreach}                
                  </tbody>
               </table>
               </div>
               {$result_per_page3}
               {else}
               <h4 align="center">{lang('no_payout_found')}</h4>
               {/if}
            </div>
         </div>
      </div>
      <input type="radio" id="tab4" name="tab" {$tab4}>
      <label class="tabButton" for="tab4">{lang('rejected_requests')}</label>
      <div class="tab">
         <div class="content">
            <div class="panel panel-default  ng-scope">
               {if count($rejected_requests)>0}
               <input type="hidden" name="current_tab" id="current_tab" value="tab1" >
               <div class="table-responsive">
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                  <thead class="table-bordered">
                     <tr class="th">
                        <th>{lang('sl_no')}</th>
                        <th>{lang('requested_date')}</th>
                        <th>{lang('rejected_date')}</th>
                        <th>{lang('requested_amount')}</th>
                        <th>{lang('payout_method')}</th>
                     </tr>
                  </thead>
                  {assign var="i" value=0}
                  {assign var="class" value=""}
                  {assign var="path" value="{$BASE_URL}user/"}
                  <tbody>
                     {foreach from=$rejected_requests item="v"}
                     {if $i%2==0}
                     {$class='tr1'}
                     {else}
                     {$class='tr2'}
                     {/if}
                     <tr class="{$class}">
                        <td>
                           {$page4+$i+1}
                        </td>
                        <td>{$v.requested_date}</td>
                        <td>{$v.updated_date}</td>
                        <td>
                           {$DEFAULT_SYMBOL_LEFT}{number_format($v.payout_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        <td>
                           {if $v.payout_type eq 'bank'}
                           Bank
                           {elseif $v.payout_type eq 'Bitcoin'}
                           Blocktrail
                           {else}      
                           {$v.payout_type}
                           {/if}
                        </td>
                     </tr>
                     {$i=$i+1}
                     {/foreach}                
                  </tbody>
               </table>
               </div>
               {$result_per_page4}
               {else}
               <h4 align="center">{lang('no_payout_found')}</h4>
               {/if}
            </div>
         </div>
      </div>
   </div>
</main>
{/block}