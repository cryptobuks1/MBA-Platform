<?php if ($address) { ?>
  <h2><?php echo $text_instruction; ?></h2>
  <div class="row">
    <div class="col-sm-2" style="text-align: center">
      <?php if ($qr) { ?>
        <img src="<?php echo $qr; ?>" style="height: 120px;width: 120px;" alt="<?php echo $address; ?>" title="<?php echo $address; ?>">
      <?php } ?>
      
    </div>
    
    <div class="col-sm-10">
      <p>&nbsp;</p>
      <p><b><?php echo $text_description; ?></b></p>
      <p><pre><?php echo $address; ?></pre></p>
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
     var address = "{$address}";
     var invoice_id = "{$invoice_id}";
     var btcs = new WebSocket('wss://ws.blockchain.info/inv');
     btcs.onopen = function(){
     btcs.send(JSON.stringify({ "op":"addr_sub", "addr":address}));
     };
     btcs.onmessage = function(onmsg)
     {
        var response = JSON.parse(onmsg.data);
        var getOuts = response.x.out;
        var countOuts = getOuts.length; 
        for(i = 0; i < countOuts; i++)
            {
                //check every output to see if it matches specified address
                var outAdd = response.x.out[i].addr;
                var specAdd = address;
                if (outAdd == specAdd)
            {
                var amount = response.x.out[i].value;
                var calAmount = amount / 100000000;
                $("#alert").removeClass("alert-danger").addClass("alert alert-success");
                $(".alert > span:first").removeClass('fa-clock-o');
                $('#button-confirm').removeAttr('disabled');
                //window.location.href= $('#path_root').val()+"/blockchain_payment_done";
            };
            }; 
    }; 
    
// Set the date we're counting down to
var countDownDate = new Date().getTime() + 10*60000;

// Update the count down every 1 second
window.blockchain_timer = setInterval(function() {

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
        clearInterval(window.blockchain_timer);
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
            url: 'index.php?route=extension/payment/block_chain/blockchain_payment_done/',
            data: { address: address, invoice_id: invoice_id},
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