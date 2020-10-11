<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="alert alert-warning" style="display: none"><i class="fa fa-refresh"></i>
            <span></span>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <div class="alert alert-info" style="display: none"><i class="fa fa-info-circle"></i>
            <span></span>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <div class="alert alert-danger" style="display: none"><i class="fa fa-exclamation-circle"></i>
            <span></span>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <div class="alert alert-success" style="display: none"><i class="fa fa-check-circle"></i>
            <span></span>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo 'Validation your module'; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-validation" class="form-horizontal">
                    <div class="form-group">
                        <div style="text-align: center;">Sorry to bothering you, but please fill out the information below:</div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-name"><?php echo $language->get('Order ID:'); ?></label>
                        <div class="col-sm-3">
                            <input type="text" name="order_id" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-name"><?php echo $language->get('Email purchased:'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="email" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-name"></label>
                        <div class="col-sm-10">
                            <a href="javascript:void(1)" class="btn btn-default validate" style="background: green; color: white"><i class="fa fa-key"></i> Validate</a>
                            <a href="javascript:void(2)" class="btn btn-default skip-validate"><i class="fa fa-history"></i> Skip</a> <i style="color:#ccc">You can skip this step, but you still need fill and validate your site in future</i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    <!--
    $(document).ready(function(){
        $("#form-validation .validate").click(function(){

            $(".alert-danger").hide();
            $(".alert-warning").hide();
            $(".alert-success").hide();
            var order_id = $.trim($("input[name=order_id]").val());
            var email = $.trim($("input[name=email]").val());
            if(order_id == "" || email == ""){
                $(".alert-danger").show().find("span").html("Enter your <b>order id</b> and <b>email</b> was use for purchased module<");
                return false;
            }
            $(".alert-info").show().find("span").html("Validating. Please wait ...");
            $.ajax({
                type: "POST",
                url: "<?php echo $action.'&token='.$token?>",
                data: "validate_order=true&order_id="+order_id+"&email="+email,
                success: function(data){
                    var json = $.parseJSON(data);

                    if(!json.VALIDATE_ORDER_ID){
                        $(".alert-info").hide();
                        $(".success").hide();
                        if(json.NOTE != ""){
                            $(".alert-warning").show().find("span").html("You have using module for multi domain, pls contact me to unlock this. Thanks you.");
                        }else{
                            $(".alert-warning").show().find("span").html("Order ID or Email using for purchased on market is not valid. Pls try again.");
                        }

                        setTimeout(function(){
                            $(".alert-warning").hide()
                        }, 4200);
                    }else{
                        $(".alert-info").hide();
                        $(".alert-warning").hide();
                        $(".alert-success").show().find("span").html("Checkin completed! Wait to reload");
                        setTimeout(function(){
                            $(".alert-success").hide()
                        }, 4200);
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }
                }
            });
        });
        $("#form-validation .skip-validate").click(function(){
            $(".alert-info").show().find("span").html("Skipping. Please wait ...");
            $.ajax({
                type: "POST",
                url: "<?php echo $action.'&token='.$token?>",
                data: "validate_skip=true",
                success: function(data){
                    var json = $.parseJSON(data);
                    if(typeof json.error == 'undefined'){
                        $(".alert-info").hide();
                        $(".alert-success").show().find("span").html("Skip completed! Wait to reload");

                        setTimeout(function(){
                            location.reload();
                        }, 2500);
                    }else{
                        $(".alert-info").show().find("span").html("Skip not complete! Please validate your module.");
                    }
                }
            });
        });
    });
    //-->
</script>
<?php echo $footer; ?>