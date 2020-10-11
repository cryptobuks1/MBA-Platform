{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
<span id="confirm_msg">{lang('sure_you_want_to_upgrade')}</span>
 <span id="terms_req">{lang('terms_req')}</span>
</div>
{if $upgrade_note}
    <blockquote class="lavander">
                      
                            <p>
                                {$upgrade_note}
                    
                            </p>
                            
     </blockquote>
   {/if} 



    <div class="panel panel-default">
        <div class="panel-body">
            {if $join_type == 'customer'}
        <legend><span class="fieldset-legend">{lang('customer_upgrade')}</span></legend>
            <div class="table-responsive">
            <div class="col-sm-12 bhoechie-tab-container">
  <div class=" col-sm-3 bhoechie-tab-menu">
    <div class="list-group">
            <a href="{BASE_URL}/user/customer_upgrade" class="list-group-item text-center active" onclick="changeActiveTab('ewallet_tab');">
                <h4 class="tabs_h4"><i class="icon-wallet"></i></h4>
                    E-wallet 
            </a> 
    </div>
    
  </div> 
  <div class=" col-sm-3 bhoechie-tab-menu">
    <div class="list-group">
             <a href="{BASE_URL}/user/strip_payment" class="list-group-item text-center" onclick="changeActiveTab('bank_transfer');">
                <h4 class="tabs_h4"> <i class="fa fa-cc-stripe" aria-hidden="true"></i></h4>
                    Stripe
            </a> 
    </div>
  </div>

<div class="col-sm-9 bhoechie-tab">
    <input type="hidden" name="active_tab" id="active_tab" value="ewallet_tab">
    <input type="hidden" name="free_join_status" id="free_join_status" value="yes">
    <div class="bhoechie-tab-content active">
    </div>
</div>
</div>
            </div>
            {else}
    <blockquote class="lavander">
                      
                            <h1>
                                {lang('Already_upgraded')}
                            </h1>
                           
                    </blockquote>
    {/if}
        </div>
    </div>
<div class="modal terms" id="panel-config" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >
                  &times;
              </button>
              <h4 class="modal-title" style="font-size: 16px;">{lang('terms_conditions')}</h4>
          </div>
          <div class="modal-body">
              <table cellpadding="0" cellspacing="0" align="center">
                  <tr>
                      <td width="80%">
                          {$termsconditions}
                      </td>
                  </tr>
              </table>
          </div>

      </div>
  </div>
</div> 

{/block}
{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_rank.js" type="text/javascript" ></script>
     <script src="{$PUBLIC_URL}javascript/form-wizard.js" type="text/javascript" ></script>
{/block}
