{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="content_section bd-bottom">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>
                        {lang('blocktrail_payment')} 
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="container" style="margin:auto; background-color:#fff;">
                                    <div class="row" style="margin-bottom:15px;">
                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="col-md-12" style="margin-top: 85px;">
                                                    <h4 style="color:red; text-align:center;">{lang('please_wait_for_transaction_completion_do_not_press_back_or_refresh_button')}.</h4>
                                                    <h2 style="color:#002855; text-align:center;">{lang('blocktrail_payment')}</h2>
                                                    <h3 style="color:#4f2e5a;text-align:center;padding-top: 15px;" id="quote" class="quote" tabindex="2"><span id="amountSpan">{$bitcoin_amount}</span> BTC</h3>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 25px;">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-6">
                                                        <p style="color:#4f2e5a;text-align:center;"> <div id="addressDetails" class="address-details"><code id="addressCode" class="address" tabindex="4">{$bitcoin_address}</code></div></p>
                                                    </div>
                                                    <div class="col-md-3"></div></div>
                                            </div><!--ROW-->
                                            <div id="loading" style="text-align:center;padding-top: 15px;">
                                            </div>
                                            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}user/member"/>
                                            <!-- <div class="timer"></div>-->
                                        </div><!---col-md-6-->
                                        <div class="col-md-6" style="margin-top: 45px;"> {$qr_code}</div>
                                        <div class="col-md-6" style="margin-top: 45px;"><h3>{lang('instructions')}.</h3>
                                            1.{lang('login_to_your_bitcoin_wallet')}.
                                            <br>2.{lang('send_the_given_btc_amount_to')}  <code id="addressCode" class="address" tabindex="4">{$bitcoin_address}
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

        <span style="display:none" id="msg1">{lang('waiting_for_response')}</span>
        <input type="hidden" id="bitcoin_address" value="{$bitcoin_address}">
        <input type="hidden" id="check_url" value="{$PATH_TO_ROOT_DOMAIN}user/member/bitcoin_response">
        <input type="hidden" id="success_url" value="{$PATH_TO_ROOT_DOMAIN}user/member/bitcoin_registration">
        <input type="hidden" id="error_url" value="{$PATH_TO_ROOT_DOMAIN}user/member/upgrade_package_validity">
    </div>
{/block}

{block name=script}
    <script src="{$PUBLIC_URL}javascript/payment/blocktrail.js"></script>
    {$smarty.block.parent}
{/block}
