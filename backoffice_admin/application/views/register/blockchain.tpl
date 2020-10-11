{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div class="row" {if !$LOG_USER_ID}style="margin-top: 50px;"{/if}>
    <div class="{if $LOG_USER_ID} col-sm-12 {else} col-sm-10 col-sm-offset-1 {/if}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('blockchain')} 
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="container" style="margin:auto; background-color:#fff;">
                          <div class="row" style="margin-bottom:15px;">
                           <div class="col-md-6">
                            <div class="row">
                                 <div class="col-md-12">
                                 <h4 style="color:#002855; text-align:center;">{lang('please_wait_for_transaction_completion_do_not_press_back_or_refresh_button')}</h4>
                                  <h3 style="color:#4f2e5a;text-align:center;padding-top: 15px;" id="quote" class="quote" tabindex="2"><span id="amountSpan">{$amount_in_btc}</span> BTC</h3>
                                 </div>
                                 <div class="col-md-12">
                                  <div class="col-md-3"></div>
                                   <div class="col-md-6">
                                    <div class="qr_code_img">
                                        <img src="{$PUBLIC_URL}images/b_blockchain.png">
                                     <div class="but01" style="background-color:#426d9c;height:45px;margin-left: 35px;margin-top: -52px;text-align: center;padding-top: 10px;">
                                     <b style="color:#fff;text-align:center;">{lang('pay_with_blockchain')}</b></div>
                                    </div>
                                        <br><br>
                                        <p style="color:#4f2e5a;text-align:center;"> 
                                            <div id="addressDetails" class="address-details"><code id="addressCode" style="font-size: 120% !important;" class="address" tabindex="4">{$address}</code>
                                            </div>
                                        </p>
                                   </div>
                                 <div class="col-md-3"></div>
                             </div>
                                <div class="col-md-12 text-center">
                                <div id="loading" style="text-align:center;padding-top: 15px;">

                                </div>
                                    <div id="notifications" class=" qr_code_img_1">
                                        <img src="{$PUBLIC_URL}images/blockchain_loading.gif" width=100 height=100> <br/> {lang('waiting_for_payment')}{lang('please_do_not_refresh')}
                                    </div>
                                    </div>
                                </div><!--ROW-->
                                 <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}register/"/>
                                 <input type="hidden" id="redirect_path" name="redirect_path" value="{$PATH_TO_ROOT_DOMAIN}register/user_register">
                                <div class="timer"></div>
                           </div><!---col-md-6-->
                           <div class="col-md-6 qr_code_box m-t-xl" id="qr"> {$qr_code}</div>
                                <div class="col-md-6 m-t"><h3>{lang('instructions')}.</h3>
                                    1.{lang('login_to_your_bitcoin_wallet')}.
                                    <br>2.{lang('send_the_given_btc_amount_to')}  
                                    <code id="addressCode" class="address" tabindex="4">{$address}
                                    </code>
                                </div>
                          </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="address" id="address" value="{$address}">

{/block}

{block name=script}
<script src="{$PUBLIC_URL}javascript/payment/blockchain.js"></script>
{$smarty.block.parent}
{/block}

