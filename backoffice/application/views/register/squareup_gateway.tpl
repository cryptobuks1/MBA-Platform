{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

    {form_open('register/squareup_payment', 'method="post" class="" name="form" id="nonce-form" role="form"')}
            <input type="hidden" name="application_id" id="application_id" value="{$application_id}">
            <input type="hidden" name="location_id" id="location_id" value="{$location_id}">

            <div class="panel panel-default table-responsive">
                <div class="" id="sq-ccbox">
                  Pay with Credit Card
                  <table class="table table-striped table-bordered table-hover table-full-width overflow_table">
                      <tbody>
                          <tr align="center" >
                            <td>Card Number:</td>
                            <td><div id="sq-card-number"></div></td>
                          </tr>
                          <tr align="center" >
                            <td>CVV:</td>
                            <td><div id="sq-cvv"></div></td>
                          </tr>
                          <tr align="center" >
                            <td>Expiration Date: </td>
                            <td><div id="sq-expiration-date"></div></td>
                          </tr>
                          <tr align="center" >
                            <td>Postal Code:</td>
                            <td><div id="sq-postal-code"></div></td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)" >
                                Pay with card
                              </button>
                            </td>
                          </tr>
                      </tbody>
                  </table>

                  <!-- After a nonce is generated it will be assigned to this hidden input field.-->
                  <input type="hidden" id="card-nonce" name="nonce">
              </div>
            </div>

        {*   <div class=""  id="error_square_card" style="display: none;">
               <div class="col">
                   <h4 id="square_error" style="color: red; margin-left: 10px;"></h4>
               </div>
           </div>  *}
      {*  <div class=""  id="errors" style="color: red; margin-left: 10px;">
            <div class="col">
                <h4 id="p" style="color: red; margin-left: 10px;"></h4>
            </div>
        </div> *} 

    {form_close()}
{/block}

{block name=script}
  {$smarty.block.parent}
<script src="{$PUBLIC_URL}javascript/payment/paymentform.js"></script>
<script src="{$PUBLIC_URL}javascript/payment/sqpaymentform.js"></script>
{/block}

{block name=style}
  {$smarty.block.parent}
<link rel="stylesheet" href="{$PUBLIC_URL}plugins/square/sqpaymentform.css" type="text/css" />
{/block}

