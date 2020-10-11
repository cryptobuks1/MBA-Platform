
   <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style type="text/css">

        .panel-title {

            display: inline;

            font-weight: bold;

        }

        .display-table {

            display: table;

        }

        .display-tr {

            display: table-row;

        }

        .display-td {

            display: table-cell;

            vertical-align: middle;

            width: 61%;

        }

    </style>

    <div class="container">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">

                <div class="panel panel-default credit-card-box">

                    <div class="panel-heading display-table" >

                        <div class="row display-tr" >

                            <h3 class="panel-title display-td" >Payment Details</h3>

                            <div class="display-td" >                            

                                <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">

                            </div>

                        </div>                    

                    </div>

                    <div class="panel-body"style="background-color: #a7a7a7;">
                       
                        <form action="<?php echo $action; ?>" method="post" id="payment-form" class="form-horizontal require-validation" data-cc-on-file="false">


                        <input type="hidden" id="stripe_publishable_key" name="stripe_publishable_key" value="<?php echo $stripe_key; ?>">
                                              
                        <div class='form-row row'>
                                        <p style="color:red;text-align:center;">WARNING!!! DO NOT REFRESH OR CLICK ANY BUTTONS WHILE PAYMENT IS PROCESSING</p>

                            <div class='col-xs-12 form-group required'>
                                <div class="col-sm-12">
                                    <label class='control-label'>Name on Card</label> 
                                </div>
                                <div class="col-sm-12">
                                    <input class='form-control' size='4' type='text'>
                                </div>
                            </div>


                        </div>
                        <div class='form-row row'>

                            <div class='col-xs-12 form-group required'>
                                <div class="col-sm-12">
                                    <label class='control-label'>Card Number</label> 
                                </div>
                                <div class="col-sm-12">
                                    <input  autocomplete='off' class='form-control card-number' size='20' type='text'>
                                </div>
                            </div>


                        </div>

                        <div class='form-group'  style="margin-left: 0px !important;">

                            <div class='col-xs-12 col-md-4 form-group cvc required' style="margin-left: 10px;">

                                <label class='control-label'>CVC</label> <input autocomplete='off'

                                                                                class='form-control card-cvc' placeholder='ex. 311' size='4'

                                                                                type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Month</label> <input

                                    class='form-control card-expiry-month' placeholder='MM' size='2'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Year</label> <input

                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'

                                    type='text'>

                            </div>

                        </div>



                        <div class='row'>

                            <div class='col-md-12 error form-group hide'>
                                <div class="col-sm-12">
                                    <div class='alert-danger alert'>
                                        Please correct the errors and try again.
                                    </div>

                                </div>
                            </div>

                        </div>



                        <div class="row">

                            <div class="col-xs-12">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                                </div>

                            </div>

                        </div>
                     </form>

                    </div>

                </div>        

            </div>

        </div>
    </div>


    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">

        $(function () {

            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function (e) {
               
                var $form = $(".require-validation"),
                        inputSelector = ['input[type=email]', 'input[type=password]',
                            'input[type=text]', 'input[type=file]',
                            'textarea'].join(', '),
                        $inputs = $form.find('.required').find(inputSelector),
                        $errorMessage = $form.find('div.error'),
                        valid = true;

                $errorMessage.addClass('hide');



                $('.has-error').removeClass('has-error');

                $inputs.each(function (i, el) {

                    var $input = $(el);

                    if ($input.val() === '') {

                        $input.parent().addClass('has-error');

                        $errorMessage.removeClass('hide');

                        e.preventDefault();

                    }

                });



                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    var stripe_publishable_key = $('#stripe_publishable_key').val();

                    Stripe.setPublishableKey(stripe_publishable_key);

                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()

                    }, stripeResponseHandler);

                }



            });



            function stripeResponseHandler(status, response) {
  
                if (response.error) {

                    $('.error')

                            .removeClass('hide')

                            .find('.alert')

                            .text(response.error.message);

                } else {

                    var token = response['id'];

                    $form.find('input[type=text]').empty();

                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.append("<input type='hidden' name='card_num' value='" + $('.card-number').val() + "'/>");
                    $form.append("<input type='hidden' name='exp_month' value='" + $('.card-expiry-month').val() + "'/>");
                    $form.append("<input type='hidden' name='exp_year' value='" + $('.card-expiry-year').val() + "'/>");
                    $form.append("<input type='hidden' name='cvc' value='" + $('.card-cvc').val() + "'/>");

                    $form.get(0).submit();

                }

            }



        });

    </script>
    <script>
        jQuery(document).ready(function () {
        });
    </script>