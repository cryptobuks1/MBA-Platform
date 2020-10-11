<?php echo $header; ?>
<!--  breadcrumb -->
<section class="breadcrumb-area padding-top-product">
    <div class="container">
        <div class="breadcrumb breadcrumb-box">
            <ul>
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><span ><span><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>
<!-- / breadcrumb -->
<!-- Register -->
<section class="main-page container">
    <div class="main-container col1-layout">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="main">
            <div class="col-main">
                <section class="shopping-cart">
                    <div class="page-title margin-buttom-product"><span><?php echo $heading_title; ?></span></div>
                    <?php if(!$is_logged) { ?>
                        <p><?php echo $text_account_already; ?></p>
                    <?php } ?>
                    <p><?php echo $text_denotes_required_field; ?></p>
                    <div class="checkout-area">
                        <div id="content" ><?php echo $content_top; ?>
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo $text_step1; ?></h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-step1">
                                        <div class="panel-body"></div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo $text_step2; ?></h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-step2">
                                        <div class="panel-body"></div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo $text_step3; ?></h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-step3">
                                        <div class="panel-body"></div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo $text_step4; ?></h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-step4">
                                        <div class="panel-body"></div>
                                    </div>
                                </div>
                                <?php if ($shipping_required) { ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo $text_step5; ?></h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-step5">
                                        <div class="panel-body"></div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo $text_step6; ?></h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-step6">
                                        <div class="panel-body"></div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo $text_step7; ?></h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-step7">
                                        <div class="panel-body"></div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title"><?php echo $text_step8; ?></h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-step8">
                                        <div class="panel-body"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <?php echo $content_bottom; ?></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
<!-- / Register -->

<script type="text/javascript"><!--
    $(document).ready(function() {
        
        <?php   $step = 0;
            for ($step = 1; $step <= $load_step; $step++){   
                $step_title = "text_step".$step; ?>       
               
                $.ajax({
                    url: 'index.php?route=register/step<?php echo $step; ?>',
                        dataType: 'html',
                        success: function(html) {
                            $('#collapse-step<?php echo $step; ?> .panel-body').html(html);

                            $('#collapse-step<?php echo $step; ?>').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step<?php echo $step; ?>" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $$step_title; ?><i class="fa fa-caret-down"></i></a>');
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                });
        <?php } ?>
    
       $('#collapse-step<?php echo $load_step; ?>').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step<?php echo $load_step; ?>'+'" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_load_step; ?><i class="fa fa-caret-down"></i></a>');
       $('a[href=\'#collapse-step<?php echo $load_step; ?>'+'\']').trigger('click');      
    });
            // step 1 : Sponsor ID
            $(document).delegate('#button-step1', 'click', function() {
    $.ajax({
    url: 'index.php?route=register/step1/save',
            type: 'post',
            data: $('#collapse-step1 input[type=\'text\'], #collapse-step1 select,#collapse-step1 input[type=\'hidden\']'),
            dataType: 'json',
            beforeSend: function() {
            $('#button-step1').button('loading');
            },
            complete: function() {
            $('#button-step1').button('reset');
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    $('.has-error').removeClass('has-error');
                    if (json['redirect']) {
            location = json['redirect'];
            } else if (json['error']) {
            if (json['error']['warning']) {
            $('#collapse-step1 .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            for (i in json['error']) {
            var element = $('#input-step1-' + i);
                    if ($(element).parent().hasClass('input-group') || $(element).parent().hasClass('checkbox') || $(element).parent().hasClass('radio')) {
            $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
            } else {
            $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
            }
            }
            // Highlight any found errors
            $('.text-danger').each(function() {
            $(this).parents('.form-group').first().addClass('has-error');
            });
            } else {
            $.ajax({
            url: 'index.php?route=register/step2',
                    dataType: 'html',
                    success: function(html) {
                    $('#collapse-step2 .panel-body').html(html);
                            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?> <i class="fa fa-caret-down"></i></a>');
                            $('a[href=\'#collapse-step2\']').trigger('click');
                            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<?php echo $text_step3; ?>');
                            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<?php echo $text_step4; ?>');
                            <?php if ($shipping_required) { ?>
                            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<?php echo $text_step5; ?>');
                            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<?php echo $text_step6; ?>');
                            <?php } ?>
                            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
                            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
            }
            },
            error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });
    });
            // step 2 : Sponsor ID Info : Back
            $(document).delegate('#button-step2-back', 'click', function() {

    $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?> <i class="fa fa-caret-down"></i></a>');
            $('a[href=\'#collapse-step1\']').trigger('click');
            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<?php echo $text_step3; ?>');
            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<?php echo $text_step4; ?>');
            <?php if ($shipping_required) { ?>
            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<?php echo $text_step5; ?>');
            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<?php echo $text_step6; ?>');
            <?php } ?>
            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
    });
            // step 2 : Sponsor ID Info : Continue
            $(document).delegate('#button-step2-continue', 'click', function() {

    $.ajax({
    url: 'index.php?route=register/step3',
            dataType: 'html',
            success: function(html) {
            $('#collapse-step3 .panel-body').html(html);
                    $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?> <i class="fa fa-caret-down"></i></a>');
                    $('a[href=\'#collapse-step3\']').trigger('click');
                    $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
                    $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
                    $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<?php echo $text_step4; ?>');
                    <?php if ($shipping_required) { ?>
                    $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<?php echo $text_step5; ?>');
                    $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<?php echo $text_step6; ?>');
                    <?php } ?>
                    $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
                    $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
            },
            error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });
    });
            // step 3 : Account types :  Back
            $(document).delegate('#button-step3-back', 'click', function() {

    $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?> <i class="fa fa-caret-down"></i></a>');
            $('a[href=\'#collapse-step2\']').trigger('click');
            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<?php echo $text_step4; ?>');
            <?php if ($shipping_required) { ?>
            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<?php echo $text_step5; ?>');
            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<?php echo $text_step6; ?>');
            <?php } ?>
            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
    });
            // step 3 : Account types : Continue
            $(document).delegate('#button-step3-continue', 'click', function() {
    $.ajax({
    url: 'index.php?route=register/step3/save',
            type: 'post',
            data: $('#collapse-step3 input[name="account_type"]:checked'),
            dataType: 'json',
            beforeSend: function() {
            $('#button-step3-continue').button('loading');
            },
            complete: function() {
            $('#button-step3-continue').button('reset');
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    $('.has-error').removeClass('has-error');
                    if (json['redirect']) {
            location = json['redirect'];
            } else if (json['error']) {
            if (json['error']['warning']) {
            $('#collapse-step3 .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            for (i in json['error']) {
            var element = $('#input-step3-' + i);
                    if ($(element).parent().hasClass('input-group') || $(element).parent().hasClass('checkbox') || $(element).parent().hasClass('radio')) {
            $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
            } else {
            $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
            }
            }

            // Highlight any found errors
            $('.text-danger').each(function() {
            $(this).parents('.form-group').first().addClass('has-error');
            });
            } else {
            $.ajax({
            url: 'index.php?route=register/step4',
                    dataType: 'html',
                    success: function(html) {
                    $('#collapse-step4 .panel-body').html(html);
                            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?> <i class="fa fa-caret-down"></i></a>');
                            $('a[href=\'#collapse-step4\']').trigger('click');
                            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?><i class="fa fa-caret-down"></i></a>');
                            <?php if ($shipping_required) { ?>
                            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<?php echo $text_step5; ?>');
                            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<?php echo $text_step6; ?>');
                            <?php } ?>
                            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
                            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
            }
            },
            error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });
    });
            // step 4 : Contact Information Back
            $(document).delegate('#button-step4-back', 'click', function() {

    $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?> <i class="fa fa-caret-down"></i></a>');
            $('a[href=\'#collapse-step3\']').trigger('click');
            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?><i class="fa fa-caret-down"></i></a>');
            <?php if ($shipping_required) { ?>
            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<?php echo $text_step5; ?>');
            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<?php echo $text_step6; ?>');
            <?php } ?>
            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
    });
            // step 4 : Contact Information Continue
            $(document).delegate('#button-step4-continue', 'click', function() {
    $.ajax({
    url: 'index.php?route=register/step4/save',
            type: 'post',
            data: $('#collapse-step4 input[type=\'text\'], #collapse-step4 input[type=\'date\'], #collapse-step4 input[type=\'datetime-local\'], #collapse-step4 input[type=\'time\'], #collapse-step4 input[type=\'password\'], #collapse-step4 input[type=\'hidden\'], #collapse-step4 input[type=\'checkbox\']:checked, #collapse-step4 input[type=\'radio\']:checked, #collapse-step4 textarea, #collapse-step4 select,#collapse-step4 input[type=\'email\'],#collapse-step4 input[type=\'tel\'],#collapse-step4 input[type=\'hidden\']'),
            dataType: 'json',
            beforeSend: function() {
            $('#button-step4-continue').button('loading');
            },
            complete: function() {
            $('#button-step4-continue').button('reset');
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    $('.has-error').removeClass('has-error');
                    if (json['redirect']) {
            location = json['redirect'];
            } else if (json['error']) {
            if (json['error']['warning']) {
            $('#collapse-step4 .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            for (i in json['error']) {
                var element = $('#input-step4-' + i);
                if (i == 'date_of_birth') {
                    $('.combodate').after('<div class="text-danger">' + json['error'][i] + '</div>');
                }
                else if ($(element).parent().hasClass('input-group') || $(element).parent().hasClass('radio')) {
                    $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                } 
                else if ($(element).parent().hasClass('checkbox')) {
                    $("#div-agree").after('<div class="text-danger">' + json['error'][i] + '</div>');
                } 
                else {
                    $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                }
            }

            // Highlight any found errors
            $('.text-danger').each(function() {
                $(this).closest('.form-group').addClass('has-error');
            });
            } else {
            var next_url = 'index.php?route=register/step7';
                    var next_tab = 'collapse-step7';
                    var next_title = '<?php echo $text_step7; ?> ';
                    <?php if ($shipping_required) { ?>
                    next_url = 'index.php?route=register/step5';
                    next_tab = 'collapse-step5';
                    next_title = '<?php echo $text_step5; ?> ';
                    <?php } ?>
                    $.ajax({
                    url: next_url,
                            dataType: 'html',
                            success: function(html) {
                            $('#' + next_tab + ' .panel-body').html(html);
                                    $('#' + next_tab).parent().find('.panel-heading .panel-title').html('<a href="#' + next_tab + '" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"> ' + next_title + '<i class="fa fa-caret-down"></i></a>');
                                    $('a[href=\'#' + next_tab + '\']').trigger('click');
                                    $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
                                    $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
                                    $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?><i class="fa fa-caret-down"></i></a>');
                                    $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?><i class="fa fa-caret-down"></i></a>');
                                    <?php if ($shipping_required) { ?>
                                    $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<?php echo $text_step6; ?>');
                                    <?php } ?>
                                    $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
                                    $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                    });
            }
            },
            error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });
    });
            <?php if ($shipping_required) { ?>
            // step 5 : Delivery Information Back
            $(document).delegate('#button-step5-back', 'click', function() {

    $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?> <i class="fa fa-caret-down"></i></a>');
            $('a[href=\'#collapse-step4\']').trigger('click');
            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?><i class="fa fa-caret-down"></i></a>');
            <?php if ($shipping_required) { ?>
            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step5" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step5; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<?php echo $text_step6; ?>');
            <?php } ?>
            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
    });
            // step 5 : Delivery Information Continue
            $(document).delegate('#button-step5-continue', 'click', function() {
    $.ajax({
    url: 'index.php?route=register/step5/save',
            type: 'post',
            data: $('#collapse-step5 input[type=\'text\'], #collapse-step5 input[type=\'date\'], #collapse-step5 input[type=\'datetime-local\'], #collapse-step5 input[type=\'time\'], #collapse-step5 input[type=\'password\'], #collapse-step5 input[type=\'hidden\'], #collapse-step5 input[type=\'checkbox\']:checked, #collapse-step5 input[type=\'radio\']:checked, #collapse-step5 textarea, #collapse-step5 select,#collapse-step5 input[type=\'number\']'),
            dataType: 'json',
            beforeSend: function() {
            $('#button-step5-continue').button('loading');
            },
            complete: function() {
            $('#button-step5-continue').button('reset');
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    $('.has-error').removeClass('has-error');
                    if (json['redirect']) {
            location = json['redirect'];
            } else if (json['error']) {
            if (json['error']['warning']) {
            $('#collapse-step5 .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            for (i in json['error']) {
            var element = $('#input-step5-' + i);
                    if ($(element).parent().hasClass('input-group') || $(element).parent().hasClass('checkbox') || $(element).parent().hasClass('radio')) {
            $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
            } else {
            $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
            }
            }

            // Highlight any found errors
            $('.text-danger').each(function() {
            $(this).parents('.form-group').first().addClass('has-error');
            });
            } else {
            $.ajax({
            url: 'index.php?route=register/step6',
                    dataType: 'html',
                    success: function(html) {
                    $('#collapse-step6 .panel-body').html(html);
                            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step6" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step6; ?> <i class="fa fa-caret-down"></i></a>');
                            $('a[href=\'#collapse-step6\']').trigger('click');
                            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?><i class="fa fa-caret-down"></i></a>');
                            <?php if ($shipping_required) { ?>
                            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step5" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step5; ?><i class="fa fa-caret-down"></i></a>');
                            <?php } ?>
                            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
                            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
            }
            },
            error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });
    });
            // step 6 : Shipping Method Back
            $(document).delegate('#button-step6-back', 'click', function() {

    $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step5" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step5; ?> <i class="fa fa-caret-down"></i></a>');
            $('a[href=\'#collapse-step5\']').trigger('click');
            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?><i class="fa fa-caret-down"></i></a>');
            <?php if ($shipping_required) { ?>
            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step6" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step6; ?><i class="fa fa-caret-down"></i></a>');
            <?php } ?>
            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<?php echo $text_step7; ?>');
            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
    });
            // step 6 : Shipping Method Continue
            $(document).delegate('#button-step6-continue', 'click', function() {
    $.ajax({
    url: 'index.php?route=register/step6/save',
            type: 'post',
            data: $('#collapse-step6 input[type=\'text\'], #collapse-step6 input[type=\'date\'], #collapse-step6 input[type=\'datetime-local\'], #collapse-step6 input[type=\'time\'], #collapse-step6 input[type=\'password\'], #collapse-step6 input[type=\'hidden\'], #collapse-step6 input[type=\'checkbox\']:checked, #collapse-step6 input[type=\'radio\']:checked, #collapse-step6 textarea, #collapse-step6 select'),
            dataType: 'json',
            beforeSend: function() {
            $('#button-step6-continue').button('loading');
            },
            complete: function() {
            $('#button-step6-continue').button('reset');
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    $('.has-error').removeClass('has-error');
                    if (json['redirect']) {
            location = json['redirect'];
            } else if (json['error']) {
            if (json['error']['warning']) {
            $('#collapse-step6 .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            for (i in json['error']) {
            var element = $('#input-step6-' + i);
                    if ($(element).parent().hasClass('input-group') || $(element).parent().hasClass('checkbox') || $(element).parent().hasClass('radio')) {
            $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
            } else {
            $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
            }
            }

            // Highlight any found errors
            $('.text-danger').each(function() {
            $(this).parents('.form-group').first().addClass('has-error');
            });
            } else {
            $.ajax({
            url: 'index.php?route=register/step7',
                    dataType: 'html',
                    success: function(html) {
                    $('#collapse-step7 .panel-body').html(html);
                            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step7" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step7; ?> <i class="fa fa-caret-down"></i></a>');
                            $('a[href=\'#collapse-step7\']').trigger('click');
                            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?><i class="fa fa-caret-down"></i></a>');
                            <?php if ($shipping_required) { ?>
                            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step5" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step5; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step6" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step6; ?><i class="fa fa-caret-down"></i></a>');
                            <?php } ?>
                            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
            }
            },
            error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });
    });
            <?php } ?>
            // step 7 :  Order Confirmation Back
            $(document).delegate('#button-step7-back', 'click', function() {

    <?php if ($shipping_required) { ?>
            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step6" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step6; ?> <i class="fa fa-caret-down"></i></a>');
            $('a[href=\'#collapse-step6\']').trigger('click');
            <?php } else { ?>
            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?> <i class="fa fa-caret-down"></i></a>');
            $('a[href=\'#collapse-step4\']').trigger('click');
            <?php } ?>
            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?><i class="fa fa-caret-down"></i></a>');
            <?php if ($shipping_required) { ?>
            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step5" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step5; ?><i class="fa fa-caret-down"></i></a>');
            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step6" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step6; ?><i class="fa fa-caret-down"></i></a>');
            <?php } ?>
            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<?php echo $text_step8; ?>');
    });
            // step 7 : Order Confirmation Continue
            $(document).delegate('#button-step7-continue', 'click', function() {
                if(window.bitgo_timer != undefined && window.bitgo_timer != 'undefined') {
        clearInterval(window.bitgo_timer);
    }
    if(window.bitgo_request != undefined && window.bitgo_request != 'undefined') {
        clearInterval(window.bitgo_request);
    }
    if(window.blocktrail_request != undefined && window.blocktrail_request != 'undefined') {
        clearInterval(window.blocktrail_request);
    }
    if(window.blocktrail_timer != undefined && window.blocktrail_timer != 'undefined') {
        clearInterval(window.blocktrail_timer);
    }
    if(window.blockchain_timer != undefined && window.blockchain_timer != 'undefined') {
        clearInterval(window.blockchain_timer);
    }
    $.ajax({
    url: 'index.php?route=register/step7/save',
            type: 'post',
            data: $('#collapse-step7 input[type=\'text\'], #collapse-step7 input[type=\'date\'], #collapse-step7 input[type=\'datetime-local\'], #collapse-step7 input[type=\'time\'], #collapse-step7 input[type=\'password\'], #collapse-step7 input[type=\'hidden\'], #collapse-step7 input[type=\'checkbox\']:checked, #collapse-step7 input[type=\'radio\']:checked, #collapse-step7 textarea, #collapse-step7 select'),
            dataType: 'json',
            beforeSend: function() {
            $('#button-step7-continue').button('loading');
                    $('#button-step7-continue').attr('disabled', true);
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    $('.has-error').removeClass('has-error');
                    if (json['redirect']) {
            location = json['redirect'];
            } else if (json['error']) {
            if (json['error']['warning']) {
            $('#collapse-step7 .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            for (i in json['error']) {
            var element = $('#input-step7-' + i);
                    if ($(element).parent().hasClass('input-group') || $(element).parent().hasClass('checkbox') || $(element).parent().hasClass('radio')) {
            $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
            } else {
            $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
            }
            }

            // Highlight any found errors
            $('.text-danger').each(function() {
            $(this).parents('.form-group').first().addClass('has-error');
            });
            } else {
            $.ajax({
            url: 'index.php?route=register/step8',
                    dataType: 'html',
                    complete: function() {
                        $('#button-step7-continue').button('reset');
                    },
                    success: function(html) {
                    $('#collapse-step8 .panel-body').html(html);
                            $('#collapse-step8').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step8" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step8; ?> <i class="fa fa-caret-down"></i></a>');
                            $('a[href=\'#collapse-step8\']').trigger('click');
                            $('#collapse-step1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step1; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step2').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step2; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step3').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step3" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step3; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step4').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step4" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step4; ?><i class="fa fa-caret-down"></i></a>');
                            <?php if ($shipping_required) { ?>
                            $('#collapse-step5').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step5" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step5; ?><i class="fa fa-caret-down"></i></a>');
                            $('#collapse-step6').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step6" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step6; ?><i class="fa fa-caret-down"></i></a>');
                            <?php } ?>
                            $('#collapse-step7').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step7" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step7; ?><i class="fa fa-caret-down"></i></a>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
            }
            },
            error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });
    });
            //--></script>
<?php echo $footer; ?>