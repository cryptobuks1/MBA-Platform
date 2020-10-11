<?php if ($bitcoin_address) { ?>
  <h2><?php echo $text_instruction; ?></h2>
  <div class="row">
    <div class="col-sm-2" style="text-align: center">
      <?php if ($qr_code) { ?>
        <img src="<?php echo $qr_code;?>" style="height: 120px;width: 120px;" alt="<?php echo $bitcoin_address; ?>" title="<?php echo $bitcoin_address; ?>">
      <?php } ?>
      
    </div>
    
    <div class="col-sm-10">
      <p>&nbsp;</p>
      <p><b><?php echo $text_description; ?></b></p>
      <p><pre><?php echo $bitcoin_address; ?></pre></p>
      <div class="form-group">
          <div id ="alert">
          <span class="fa fa-clock-o"></span> <span id="demo"> </span>
          </div>     
      </div>
    </div>
  </div>
  <div class="buttons">
    <div class="pull-right">
      <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>"/>
    </div>
  </div>
  <script type="text/javascript"><!--
     
     $('#button-confirm').attr('disabled', true);
     
     window.bitgo_request = setInterval(function() {
        $.ajax({
		url: 'index.php?route=extension/regpayment/bitgo/ajaxBitgoPaymentVerify',
		type: 'post',
		dataType: 'json',
		cache: false,
		success: function(data) {
                    console.log("output :" + data);
                    if (data == 'yes') {
                    clearInterval(window.bitgo_request);
                    clearInterval(window.bitgo_timer);
                    $("#alert").removeClass("alert-danger").addClass("alert alert-success");
                    $(".alert > span:first").removeClass('fa-clock-o');
                    document.getElementById("demo").innerHTML = "PAYMENT RECEIEVED.";
                    $('#button-confirm').removeAttr('disabled');
                    }  
                }
        });    
    },3000);
    
// Set the date we're counting down to
var countDownDate = new Date().getTime() + 10*60000;

// Update the count down every 1 second
window.bitgo_timer = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for minutes and seconds
    
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";
    
    // If the count down is over, reload 
    if (distance < 0) {
        clearInterval(window.bitgo_request);
        clearInterval(window.bitgo_timer);
        $("#alert").removeClass("alert-success").addClass("alert alert-danger");
        document.getElementById("demo").innerHTML = "TIME EXPIRED";
         setTimeout(function () {
                    window.location.href = 'index.php?route=common/home';
                }, 500);
    }
}, 1000);
$('#button-confirm').on('click', function() {
        $.ajax({
            type: 'post',
            url: 'index.php?route=extension/regpayment/bitgo/bitgoSuccess',
            dataType: 'json',
            cache: false,
            beforeSend: function() {
                $('#button-confirm').button('loading');
            },
            complete: function() {
                $('#button-confirm').button('reset');
            },
            success: function(json) {
                if (json['error']) {                    
                    alert(json['error']);
                }
                if (json['success']) {
                    location = json['success'];
                }
            }
        });
    });
//--></script> 
<?php } ?>
