$(function () {
    var address = $('#address').val();
    var btcs = new WebSocket('wss://ws.blockchain.info/inv');
    btcs.onopen = function () {
        btcs.send(JSON.stringify({
            "op": "addr_sub",
            "addr": address
        }));
    };
    btcs.onmessage = function (onmsg) {
        var response = JSON.parse(onmsg.data);
        var getOuts = response.x.out;
        var countOuts = getOuts.length;
        for (i = 0; i < countOuts; i++) {
            //check every output to see if it matches specified address
            var outAdd = response.x.out[i].addr;
            var specAdd = address;
            if (outAdd == specAdd) {
                var amount = response.x.out[i].value;
                var calAmount = amount / 100000000;
                document.getElementById("notifications").innerHTML = "Received: " + calAmount + "BTC";
                window.location.href = $('#path_root').val() + "/blockchain_payment_done";
            };
        };
    }
    $("#change_qr").click(function (e) {
        e.preventDefault();

        var bitcoin_address = $("#addressCode").html();
        var btc_amount = $("#amountSpan").html();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/blockchain/generateBitcoinQrCode/" + bitcoin_address + "/" + btc_amount + "/ajax",
            success: function (result) {
                $("#qr").html(result);
            },
        });
    });
});