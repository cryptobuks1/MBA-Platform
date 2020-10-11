<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3 Version: 1.0 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <title><?php echo ERROR_PAGE_TITLE; ?> | Error found.</title>
    </head>

    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body >
        <div class="row">
            <div class="col-sm-12">

                <div class="panel-body">
                    <div class="error-number bricky">
                        <?php echo $heading; ?>
                    </div>
                    <div class="error-details col-sm-6 col-sm-offset-3">
                        <p>
                            Something's wrong!
                            <br>
                            It looks as though we've broken something on our system.
                            <br>
                            Don't panic, we are fixing it! Please come back in a while.
                            <br>
                            <?php //if (ENVIRONMENT != 'production') { ?>
                                <?php echo $message; ?>
                            <?php //} ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>