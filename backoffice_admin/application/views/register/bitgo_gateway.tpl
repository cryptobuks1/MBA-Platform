{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

{if $error!=''}
    <div class="col-sm-12">
        <div class="warning"><font color="red">{$error}</font></div>

    </div>
{/if}
<div class="row" {if !$LOG_USER_ID}{/if}>
    <div class="{if $LOG_USER_ID} col-sm-12 {else} col-sm-10 col-sm-offset-1 {/if}">
        <div class="panel panel-default">
             
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-danger"style="display:none;">{lang('blocktrail_warning')}</div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="text-center">{lang('please_do_not_refresh')}</h3>
                                            <h4 class="text-center" id="quote" class="quote" tabindex="2"><span id="amountSpan">{$amount}</span> BTC</h4>
                                        </div>
                                        <div class="col-md-12" >
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div class="qr_code_img"><img src="{$PUBLIC_URL}images/b_bitgo.png">
                                                    <div class="but01" >
                                                        <b class="text-center">{lang('pay_with_bitgo')}</b></div>
                                                </div>
                                                <br><br>
                                                <p class="text-center"> <div id="addressDetails" class="address-details"><code id="addressCode" class="address" tabindex="4">{$pay_address}</code></div></p>
                                            </div>
                                            <div class="col-md-3"></div></div>  
                                <div class="col-md-12 text-center">
                                    <div id="loading" class="text-center" >

                                    </div>
                                    <div id="notifications" class=" qr_code_img_1">
                                        <img src="{$PUBLIC_URL}images/blockchain_loading.gif"> <br/> 
                                        {lang('copy_the_address_scan_qr_code_and_do_payments')}
                                    </div> 
                                    </div> 
                                </div><!--ROW-->                              
                                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}register"/>
                                    <!-- <div class="timer"></div>-->
                                </div><!---col-md-6-->
                                <div class="col-md-6 qr_code_box m-t-xl"> {$qr_code}
                                    <div>
                                        {form_open('register/btc_confirm', 'role="form" class="" method="post"  name="bitgo_form" id="bitgo_form')}
                                            <span id="payment_response">{lang('waiting_for_payment')}</span><br>
                                            <button type="submit" id="btc_confirm" name="btc_confirm" value="btc_confirm" class='btn btn-primary'>{lang('finish')}</button>
                                        {form_close()}                                                
                                    </div>
                                </div>
                                <div class="col-md-6"><h3>{lang('instructions')}.</h3>
                                    1.{lang('login_to_your_bitcoin_wallet')}.
                                    <br>2.{lang('send_the_given_btc_amount_to')}  
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

<input type="hidden" name="bitgo_verify_url" id="bitgo_verify_url" value="{$BASE_URL}register/ajax_bitgo_payment_verify/">
<input type="hidden" name="bitgo_error_url" id="bitgo_error_url" value="{$BASE_URL}/register/register_submit">

{/block}

{block name=script}
<script src="{$PUBLIC_URL}javascript/payment/bitgo.js"></script>
{$smarty.block.parent}
{/block}