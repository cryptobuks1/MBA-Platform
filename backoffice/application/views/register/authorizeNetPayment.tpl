{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('authorize_authentication')} 
            </div>
            <div class="panel-body">

                <table align="center" width="50%">
                    <tr>
                        <td>

                            {*<form method='post' action="https://secure.authorize.net/gateway/transact.dll">*}
                            {form_open('https://test.authorize.net/gateway/transact.dll', 'method="post"')}
                            <input type='hidden' name="x_login" value="{$api_login_id}" />
                            <input type='hidden' name="x_fp_hash" value="{$fingerprint}" />
                            <input type='hidden' name="x_amount" value="{$amount}" />
                            <input type='hidden' name="x_fp_timestamp" value="{$fp_timestamp}" />
                            <input type='hidden' name="x_fp_sequence" value="{$fp_sequence}" />
                            <input type='hidden' name="x_version" value="3.1">
                            <input type='hidden' name="x_show_form" value="payment_form">
                            <input type='hidden' name="inf_token" value="f6f7369316c4928fdceaaed397356f5b">
                            <input type='hidden' name="from_payment" value="authorize">
                            {*                   <input type='hidden' name="x_test_request" value="false" />*}
                            <input type='hidden' name="x_method" value="cc">
                                                        
                            <input type='hidden' name='x_receipt_link_URL' value="{$BASE_URL}register/payment_done" />
                            <input type='hidden' name='x_receipt_link_text' value="click here to continue" />
                            <input type='hidden' name='x_receipt_link_method' value="POST" />
                            
                            <input type='submit' value="Click here for the secure payment form" class="btn btn-red btn-block">


                            {form_close()}
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>

{/block}

