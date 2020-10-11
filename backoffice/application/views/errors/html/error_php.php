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
                    <h3>Oops! Something's wrong!</h3>
                    <p>
                        <br>
                        It looks as though we've broken something on our system.
                        <br>
                        Don't panic, we are fixing it! Please come back in a while.
                    </p>
                    <!--A PHP Error was encountered-->
                    <?php //if (ENVIRONMENT != 'production') { ?>
                        <p>Severity: <?php echo $severity; ?></p>
                        <p>Message:  <?php echo $message; ?></p>
                        <p>Filename: <?php echo $filepath; ?></p>
                        <p>Line Number: <?php echo $line; ?></p>
                    <?php //} ?>
                </div>
            </div>
        </div>
    </body>
</html>