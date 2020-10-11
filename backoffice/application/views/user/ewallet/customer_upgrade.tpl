{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
<span id="confirm_msg">{lang('sure_you_want_to_upgrade')}</span>
 <span id="terms_req">{lang('terms_req')}</span>
</div>

    

    <div class="panel panel-default">
        <div class="panel-body">
            {if $join_type == 'customer'}
        <legend><span class="fieldset-legend">{lang('customer_upgrade')}</span></legend>
            <div class="table-responsive">
            {form_open('user/ewallet/upgrade_customer','role="form" class="" name="rank_form" id="rank_form"')}
                {include file="layout/error_box.tpl"}
               {assign var="path" value="{$BASE_URL}user/"}
               
               
               <div class="form-group">
                   <label>{lang('user_bal')}</label>
                   <input type="text" class="form-control" name="user_bal" id="user_bal"  value="{$user_bal}" autocomplete="off" readonly/>
                    {form_error('user_bal')}
                </div>
                <div class="form-group">
                   <label>{lang('upgrade_fee')}</label>
                   <input type="text" class="form-control" name="upgrade_fee" id="upgrade_fee" value="{$upgrade_details['upgrade_amount']}"  autocomplete="off" readonly />
                    {form_error('upgrade_fee')}
                </div>
                 
                <div class="form-group">
                   <label>{lang('transaction_fee')}</label>
                   <input type="text" class="form-control" name="transaction_fee" id="transaction_fee"  value="{$upgrade_details['trans_fee']}" autocomplete="off" readonly/>
                    {form_error('transaction_fee')}
                </div>
                 <div class="form-group">
                   <label > </label>
                    <div class="checkbox" align="left">
                  <label class="i-checks">
                      <input name="agree" id="agree"  type="checkbox">
                       <i></i> <a class="" data-toggle="modal" href ="#panel-config"  style="text-decoration: none" >
                          {lang('I_ACCEPT_TERMS_AND_CONDITIONS')}
                      </a>
                      <font color="#ff0000">*</font>
                      {if isset($error['agree'])}<span class='val-error' >{$error['agree']} </span>{/if}
                  </label>
              </div>
          </div>
        
                
               
                <div class="form-group">
             {*<button class="btn btn-sm btn-primary" onclick="upgrade_customer({$user_id}, '{$path}')"name= 'upgrade' type="button">{lang('upgrade_customer')}</button>*}
              <button type="submit" class="btn btn-sm btn-primary" name="upgrade" id="upgrade" >{lang('upgrade_customer')}</button>
                </div>

            {form_close()}
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
