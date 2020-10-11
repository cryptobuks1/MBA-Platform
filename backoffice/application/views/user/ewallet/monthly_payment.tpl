{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK} 
    <div id="span_js_messages" style="display:none;">
     
        <span id="error_msg1">{lang('NO_BALANCE')}</span>
        <span id="trans_pass_req">{lang('Please_type_transaction_password')}</span>
                  
        <span id="error_msg3">{lang('Please_type_Amount')}</span>
        <span id="msg4">{lang('Amount_is_required')}</span>     
        <span id="validate_msg1">{lang('digits_only')}</span>
        <span id="error_msg5">{lang('you_dont_have_enough_balance')}</span>
        <span id="error_msg12">{lang('digits_only')}</span>
        <span id="error_msg11">{lang('you_dont_have_enough_balance')}</span>
        <span id="greater_than_0">{lang('greater_than_0')}</span>
        <span id="invalid_amount">{lang('Amount_should_be_multiple')}</span>
        
    
</div>
  <div class="col-md-7 col-md-offset-2" style="min-height: 600px" >  
  
      {form_open_multipart('user/ewallet/monthly_pay_post', 'role="form"  method="post" name="form" id="msform"')}
      
      <label><h3>Subscription Fee : {$monthly_fee}</h3></label>
      <style>
       .stripe-button-el{
           display: block;
  max-width: 300px;
  margin: auto;
  top: 50%;
        }
    </style>
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="{$key}"
        data-amount=""
        data-name="Register"
        data-description="Payment through Stripe"
        data-image="{$SITE_URL}/uploads/images/logos/{$site_info["logo"]}"
        data-locale="auto"
        data-zip-code="true">
    </script>
   
   
       {form_close()}
       

  </div>
{/block}
{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_ewallet_fund.js" type="text/javascript" ></script> 
{/block}