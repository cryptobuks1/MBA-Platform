{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('bitgo_gateway')} 
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 style="color:#002855; text-align:center;">{lang('please_do_not_refresh')}</h3>
                                            <h4 style="color:#4f2e5a;text-align:center;padding-top: 15px;" id="quote" class="quote" tabindex="2"><span id="amountSpan">{$amount}</span> BTC</h4>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 25px;">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div class="qr_code_img"><img src="{$PUBLIC_URL}images/b_bitgo.png">
                                                    <div class="but01" style="background-color:#426d9c;height:45px;margin-left: 40px;margin-top: -52px;text-align: center;padding-top: 10px;" >
                                                        <b style="color:#fff;text-align:center;">{lang('pay_with_bitgo')}</b></div>
                                                </div>
                                                <br><br>
                                                <p style="color:#4f2e5a;text-align:center;"> <div id="addressDetails" class="address-details"><code style="font-size: 120% !important;" id="addressCode" class="address" tabindex="4">{$pay_address}</code></div></p>
                                            </div>
                                            <div class="col-md-3"></div></div>
                                    </div><!--ROW-->
                                    <div id="loading" class="qr_code_img_1 text-center">

                                    </div>
                                    <div id="notifications" class="qr_code_img_1 text-center">
                                        <img src="{$PUBLIC_URL}images/blockchain_loading.gif"> <br/> 
                                        {lang('copy_the_address_scan_qr_code_and_do_payments')}
                                    </div>                               
                                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}register"/>
                                    <!-- <div class="timer"></div>-->
                                </div><!---col-md-6-->
                                <div class="col-md-6 qr_code_box m-t-xl"> {$qr_code}
                                    <div style="margin-top: 45px;">
                                        {form_open('upgrade/btc_confirm', 'role="form" class="" method="post"  name="bitgo_form" id="bitgo_form')}
                                            <span id="payment_response">{lang('waiting_for_payment')}</span><br>
                                            <button type="submit" id="btc_confirm" name="btc_confirm" value="btc_confirm" class='btn btn-success'>{lang('finish')}</button>
                                        {form_close()}
                                                
                                    </div>
                                </div>
                                <div class="col-md-6 m-t"><h3>{lang('instructions')}.</h3>
                                    1.{lang('login_to_your_bitcoin_wallet')}.
                                    <br>2.{lang('send_the_given_btc_amount_to')}  <code id="addressCode" class="address" tabindex="4">{$pay_address}
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

<input type="hidden" name="bitgo_verify_url" id="bitgo_verify_url" value="{$BASE_URL}upgrade/ajax_bitgo_payment_verify/">
<input type="hidden" name="bitgo_error_url" id="bitgo_error_url" value="{$BASE_URL}/upgrade/package_upgrade">

{/block}

{block name=script}
<script src="{$PUBLIC_URL}javascript/payment/bitgo.js"></script>
{$smarty.block.parent}
{/block}