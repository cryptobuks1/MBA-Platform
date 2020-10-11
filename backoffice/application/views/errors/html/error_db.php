<!DOCTYPE html> <html class="no-js" lang="en"> 
<head>

   <!--- basic page needs
   ================================================== -->
   <meta charset="utf-8">
   <title><?php echo ERROR_PAGE_TITLE; ?> | Database Error found.</title>
   <meta name="description" content="">  
   <meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="<?php echo ERROR_PAGE_RETURN_URL; ?>/public_html/error/css/base.css">  
    <link rel="stylesheet" href="<?php echo ERROR_PAGE_RETURN_URL; ?>/public_html/error/css/main.css">
    <link rel="stylesheet" href="<?php echo ERROR_PAGE_RETURN_URL; ?>/public_html/error/css/vendor.css">     

   <!-- script
   ================================================== -->
   <script src="<?php echo ERROR_PAGE_RETURN_URL; ?>/public_html/error/js/modernizr.js"></script> 
   <!-- favicons
   ================================================== -->
   <link rel="icon" type="image/png" href="<?php echo ERROR_PAGE_RETURN_URL; ?>/public_html/images/logos/fav_6193385_thumb.png"> 
</head>

<body>

    <!-- main content
    ================================================== -->
    <main id="main-404-content" class="main-content-particle-js">

        <div class="content-wrap">

            <div class="shadow-overlay"></div>

            <div class="main-content" style="width:1000px;">
                <div class="row">
                    <div class="col-twelve" style="padding-left: 586px;">

                        <h1 class="kern-this">500 Error.</h1>
                        <h4>Oops! You are stuck at 500</h4>
                        <p>
                            Something's wrong!
                            <br>
                            It looks as though we've broken something on our system.
                            <br>
                            Don't panic, we are fixing it! Please come back in a while.
                        </p>
                        <br>
                        <?php //if (ENVIRONMENT != 'production') { ?>
                        <p>
                            <b><?php echo $heading; ?></b>
                            <?php echo $message; ?>
                        </p>
                        <?php //} ?>


                    </div> <!-- /twelve -->                     
                </div> <!-- /row -->                    
            </div> <!-- /main-content --> 

            <footer>
                <div class="row" style="margin-top: 166px;"> 

                    <!-- <div class="col-seven tab-full social-links pull-right">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>            
                        </ul>
                    </div> -->

                    <div class="col-five tab-full bottom-links">
                        <ul class="links">
                            <li><a href="<?php echo ERROR_PAGE_RETURN_URL?>">Homepage</a></li>

                        </ul>

                        
                    </div>                  

                </div> <!-- /row -->                    
            </footer>

        </div> <!-- /content-wrap -->

    </main> <!-- /main-404-content -->

    <div id="preloader"> 
        <div id="loader"></div>
    </div> 

   <!-- Java Script
   ================================================== --> 
   <script src="<?php echo ERROR_PAGE_RETURN_URL; ?>/public_html/error/js/jquery-2.1.3.min.js"></script>
   <script src="<?php echo ERROR_PAGE_RETURN_URL; ?>/public_html/error/js/plugins.js"></script>
   <script src="<?php echo ERROR_PAGE_RETURN_URL; ?>/public_html/error/js/main.js"></script>

</body>

</html>
