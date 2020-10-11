<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
    <script type="text/javascript">!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});
</script><script type="text/javascript">window.Beacon('init', '01349c57-cb69-44cc-bbee-a9112fbf5fd8')</script>
<!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
 <!-- bootstrap -->
    <link href="catalog/view/theme/parallax/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- ui -->
    <link href="catalog/view/theme/parallax/assets/plugins/jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <!-- owl carousel -->
    <link href="catalog/view/theme/parallax/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="catalog/view/theme/parallax/stylesheet/stylesheet.css" rel="stylesheet">
    <!-- theme style -->
    <link href="catalog/view/theme/parallax/assets/css/themestyles.css" rel="stylesheet" type="text/css">
    <!-- nivo-slider  -->
    <link href="catalog/view/theme/parallax/assets/css/slider.css" rel="stylesheet" type="text/css">
    <link href="catalog/view/theme/parallax/assets/plugins/Nivo-Slider/nivo-slider.css" rel="stylesheet" type="text/css">
  
    <link href="catalog/view/theme/parallax/assets/css/responsive.css" rel="stylesheet" type="text/css">
    <!-- magnific popup -->
    <link href="catalog/view/theme/parallax/assets/plugins/magnific/magnific-popup.css" type="text/css" rel="stylesheet" media="screen" />
    <!-- font awesome -->
    <link href="catalog/view/theme/parallax/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <!-- animation -->
    <link href="catalog/view/theme/parallax/assets/css/animate.css" rel="stylesheet" type="text/css">
    <!-- media css -->
       <!-- rtl -->
 <?php if($direction=='rtl') { ?>
   <link rel="stylesheet" type="text/css" href="catalog/view/theme/parallax/assets/css/rtlstyle.css" media="screen" >
<?php } ?>
    <!-- media css -->
    <!--[if lt IE 9]>
         <link href="24webgroup"/>
        <script src="catalog/view/theme/parallax/assets/html5shiv.js"></script>
        <script src="catalog/view/theme/parallax/assets/respond.js"></script>
        <![endif]-->
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>

<?php echo $customstyle; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/parallax/assets/css/dp-style-customise.css" >
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

</head>
<body class="<?php echo $class; ?>">
    <!--  wrapper-->
    <div class="wrapper">
        <!-- page-->
        <div class="page">
           <?php if($wg24themeoptionpanel_homepage123_prallax=="homepage1") { ?>    
            <!-- header -->
            <header>
                <!-- top-bar-->
                <div class="top-bar gray9-bg">
                    <div class="container">
                        <div class="row">
                            <!-- top links -->
                            <div class="col-sm-8 col-md-8 col-lg-6 top-links">
                                <ul class="nav navbar-nav">
                                    <li class="list-line dropdown flags"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown">
                                          <span class="fa fa-user"></span> <?php echo $text_account; ?>
                                        </a>
                                    <ul class="dropdown-menu sfmenuffect">
                                      <?php if ($logged) { ?>
                                      <li><a href="<?php echo $account; ?>"> <span><?php echo $text_account; ?></span></a></li>
                                      <li><a href="<?php echo $order; ?>"> <span><?php echo $text_order; ?></span></a></li>
                                      <li><a href="<?php echo $transaction; ?>"> <span><?php echo $text_transaction; ?></span></a></li>
                                      <li><a href="<?php echo $download; ?>"> <span><?php echo $text_download; ?></span></a></li>
                                      <li><a href="<?php echo $logout; ?>"> <span><?php echo $text_logout; ?></span></a></li>
                                      <?php } else { ?>
                                      <li><a href="<?php echo $register; ?>"> <span><?php echo $text_register; ?></span></a></li>
                                      <li><a href="<?php echo $login; ?>"> <span><?php echo $text_login; ?></span></a></li>
                                      <?php } ?>
                                    </ul>
                                  </li>
                                 <!-- <li><a href="<?php echo $wishlist; ?>" id="wishlist-total"  title="<?php echo $text_wishlist; ?>"><span class="fa fa-heart"></span><?php echo $text_wishlist; ?></a></li>-->
                                  <li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><span class="fa fa-shopping-cart"></span><?php echo $text_shopping_cart; ?></a></li>
                                  <li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><span class="fa fa-arrow-circle-right"></span><?php echo $text_checkout; ?></a></li>
                                </ul>
                            </div>
                            <!--/ top links -->
                            <!-- langue & currency -->
                            <div class="col-sm-4 col-md-4 col-lg-6 lang-currency">
                                <ul class="nav navbar-nav pull-right">
                                    <!-- langue -->
                                       <?php echo $language; ?>
                                    <!--/ langue  -->
                                    <!-- currency -->
                                      <?php echo $currency; ?>
                                    <!-- / currency -->
                                </ul>
                            </div>
                            <!-- / langue currency -->
                        </div>
                    </div>
                </div>
                <!-- / top-bar-->
                <!-- header-container -->
                <div class="header-container">
                    <div class="container">
                        <div class="row">
                            <!-- logo-->
                            <div class="col-sm-6 col-md-4  col-lg-4">
                                <div class="logo">
                                        <?php if ($logo) { ?>
                                        <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
                                        <?php } else { ?>
                                        <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                                        <?php } ?>
                                </div>
                            </div>
                            <!-- / logo-->
                            <!--  message -->
                            <div class="col-md-4 col-lg-4 hidden-sm hidden-xs">
                                <div class="header-message-box">
                                    <?php
                                    if(isset($wg24themeoptionpanel_ret_mheader_prallax)) {
                                      echo '<i class="fa fa-mail-forward"></i> <span class="gray60 message-content">';
                                    echo  html_entity_decode($wg24themeoptionpanel_ret_mheader_prallax);
                                      echo  '</span>';
                                    }
                                    ?> 
                                </div>
                            </div>
                            <!--/ message-->
                            <!--  min search bar -->
                            <div class="col-sm-6 col-md-4  col-lg-4">
                                <div class="header-search">
                                     <?php echo $search; ?>
                                </div>
                            </div>
                            <!-- / mini search bar -->
                        </div>
                    </div>
                </div>
                <!-- / header-container -->
                <!--  main menu -->
                <div class="header-menu gray9-bg">
                    <div class="container">
                        <!-- header menu -->
                        <div class="nav-container">
                            <nav class="navigation" id="sf-menu">
                                <ul class="sf-menu sf-js-enabled sf-arrow">
                                     <li class="active sfish-menu">
                                        <a href="<?php echo $home; ?>"><span class="home-icon"></span>
                                          <?php   if(isset($wg24themeoptionpanel_hometext_prallax)) {
                                                echo  html_entity_decode($wg24themeoptionpanel_hometext_prallax);
                                                } 
                                            ?>
                                        </a>
                                    </li>
                                     <?php $parrent=1; foreach ($categories as $category) {  ?>
                                      <?php if ($category['children']) { ?>
                                  <?php if ($parrent<=$wg24themeoptionpanel_megamenushow_prallax) { ?>
                                        <li class="megamenu">
                                            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?><i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                            <ul class="mmenuffect">
                                                <li class="row">
                                                    <div class="col-md-9 col-sm-8">
                                                           <?php  foreach ($category['children'] as $children) {  ?> 
                                                        <div class="col-md-3 col-sm-6">
                                                            <a class="sub-heading" href="<?php echo $children['href']; ?>"><span><?php echo $children['name']; ?></span></a>
                                                                <?php if ($children['children3']) { ?>
                                                                    <ul>
                                                                        <?php  foreach ($children['children3'] as $children3) {  ?>   
                                                                            <li>
                                                                            <a href="<?php echo $children3['href']; ?>"><?php echo $children3['name']; ?></a>
                                                                            </li>
                                                                        <?php }  ?> 
                                                                    </ul>
                                                                <?php }  ?> 
                                                        </div>
                                                        <?php } ?>
                                                        <div class="clear"></div>
                                                        
                                                        <?php
                                                        if($parrent==1){
                                                            if(isset($wg24themeoptionpanel_firstmegamenu1_prallax)) {
                                                            echo  html_entity_decode($wg24themeoptionpanel_firstmegamenu1_prallax);
                                                            }
                                                          }  
                                                           if($parrent==2){
                                                             if(isset($wg24themeoptionpanel_firstmegamenu12_prallax)) {
                                                            echo  html_entity_decode($wg24themeoptionpanel_firstmegamenu12_prallax);
                                                            }
                                                            }
                                                        ?> 
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                          <?php
                                                           if($parrent==1){
                                                            if(isset($wg24themeoptionpanel_firstmegamenu2_prallax)) {
                                                            echo  html_entity_decode($wg24themeoptionpanel_firstmegamenu2_prallax);
                                                            }
                                                           }
                                                            if($parrent==2){
                                                             if(isset($wg24themeoptionpanel_firstmegamenu22_prallax)) {
                                                            echo  html_entity_decode($wg24themeoptionpanel_firstmegamenu22_prallax);
                                                            }
                                                            }
                                                        ?> 
                                                    </div>
                                                </li>
                                                <!-- mega menu / -->
                                                <!-- / sf menu -->
                                            </ul>
                                        </li>
                                  <?php }else{ ?>
                                        <li class="sfish-menu">
                                            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?><i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                            <ul class="menu-animation sfmenuffect">
                                              <?php  foreach ($category['children'] as $children) {  ?> 
                                                <li>
                                                    <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                                                      <?php if ($children['children3']) { ?>
                                                    <ul class="sfmenuffect">
                                                       <?php  foreach ($children['children3'] as $children3) {  ?>   
                                                        <li>
                                                            <a href="<?php echo $children3['href']; ?>"><?php echo $children3['name']; ?></a>
                                                        </li>
                                                      <?php }  ?> 
                                                    </ul>
                                                      <?php }  ?> 
                                                </li>
                                                 <?php }  ?> 
                                                
                                                <!-- / sf menu -->
                                            </ul>
                                        </li>
                                    <?php } } else { ?>
                                    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                                    <?php } ?>
                                <?php $parrent=$parrent+1;} ?> 
                                <?php  if($wg24themeoptionpanel_blogtoptext_prallax){ ?>
                                <li><a href="<?php echo $blogs; ?>"><?php echo $wg24themeoptionpanel_blogtoptext_prallax; ?></a></li>
                                <?php } ?>
                                
                                <?php echo $custommenulink; ?>
                                
                                    
                                </ul>
                            </nav>
                        </div>
                        <!-- / header menu -->
                        <!--  cart bar  -->
                        <div class="header-cart-mini">
                            <div class="topcart-mini-container">
                                    <?php echo $cart; ?>
                            </div>
                        </div>
                        <!-- / cart bar -->
                        <!-- mobile menu -->
                        <div class="mobile-container " style="display: none">
                            <div class="mobile-menu-toggle">
                                <ul>
                                    <li class="toggle-icon"><a href="#">
                                            <?php   if(isset($wg24themeoptionpanel_t_category_prallax)) {
                                                echo  html_entity_decode($wg24themeoptionpanel_t_category_prallax);
                                                } ?>
                                        </a></li>
                                </ul>
                            </div>
                            <div style="display: none;" class="mobile-main-menu">
                                <ul class="accordion">
                                  <?php  foreach ($categories as $category) {  ?>
                                        <?php if ($category['children']) { ?>
                                        <li class="parent">
                                           <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                            <ul class="children" style="display: none;">
                                                <?php  foreach ($category['children'] as $children) {  ?> 
                                                <?php if ($children['children3']) { ?>
                                                <li class="parent">
                                                    <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                                                    <ul class="children" style="display: none;">
                                                       <?php  foreach ($children['children3'] as $children3) {  ?>  
                                                        <li> <a href="<?php echo $children3['href']; ?>"><?php echo $children3['name']; ?></a></li>
                                                          <?php } ?>
                                                    </ul>
                                                    <span class="down-up">&nbsp;</span>
                                                </li>
                                                <?php }else { ?> 
                                                    <li>
                                                        <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                                                    </li>
                                                
                                                <?php } ?>
                                                
                                                 <?php }  ?> 
                                                
                                            </ul>
                                              
                                            <span class="down-up">&nbsp;</span>
                                        </li>
                                       
                                        <?php } else{ ?>
                                        <li>
                                            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                        </li>
                                        
                                    <?php }} ?>
                                     <?php  if($wg24themeoptionpanel_blogtoptext_prallax){ ?>
                                <li><a href="<?php echo $blogs; ?>"><?php echo $wg24themeoptionpanel_blogtoptext_prallax; ?></a></li>
                                <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <!-- / mobile menu -->
                    </div>
                </div>
            </header>
            <!-- header -->
         <?php } ?>
         <!-- end home 1-->
             <?php if($wg24themeoptionpanel_homepage123_prallax=="homepage2" ) { ?>
            <header class="header-style-2">
                <!-- top-bar-->
                <div class="top-bar style-2-header-bg">
                    <div class="container">
                        <div class="row">
                            <!-- top links -->
                            <div class="col-sm-8 col-md-8 col-lg-6 top-links">
                                <ul class="nav navbar-nav">
                                    <li class="list-line dropdown flags"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown">
                                          <span class="fa fa-user"></span> <?php echo $text_account; ?>
                                        </a>
                                    <ul class="dropdown-menu sfmenuffect">
                                      <?php if ($logged) { ?>
                                      <li><a href="<?php echo $account; ?>"> <span><?php echo $text_account; ?></span></a></li>
                                      <li><a href="<?php echo $order; ?>"> <span><?php echo $text_order; ?></span></a></li>
                                      <li><a href="<?php echo $transaction; ?>"> <span><?php echo $text_transaction; ?></span></a></li>
                                      <li><a href="<?php echo $download; ?>"> <span><?php echo $text_download; ?></span></a></li>
                                      <li><a href="<?php echo $logout; ?>"> <span><?php echo $text_logout; ?></span></a></li>
                                      <?php } else { ?>
                                      <li><a href="<?php echo $register; ?>"> <span><?php echo $text_register; ?></span></a></li>
                                      <li><a href="<?php echo $login; ?>"> <span><?php echo $text_login; ?></span></a></li>
                                      <?php } ?>
                                    </ul>
                                  </li>
                                  <!--<li><a href="<?php echo $wishlist; ?>" id="wishlist-total"  title="<?php echo $text_wishlist; ?>"><span class="fa fa-heart"></span><?php echo $text_wishlist; ?></a></li>-->
                                  <li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><span class="fa fa-shopping-cart"></span><?php echo $text_shopping_cart; ?></a></li>
                                  <li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><span class="fa fa-arrow-circle-right"></span><?php echo $text_checkout; ?></a></li>
                                </ul>
                            </div>
                            <!-- / top links -->
                            <!-- langue & currency -->
                            <div class=" col-sm-4 col-md-4 col-lg-6 lang-currency">
                                 <ul class="nav navbar-nav pull-right">
                                    <!-- langue -->
                                       <?php echo $language; ?>
                                    <!--/ langue  -->
                                    <!-- currency -->
                                      <?php echo $currency; ?>
                                    <!-- / currency -->
                                </ul>
                            </div>
                            <!-- / langue currency -->
                        </div>
                    </div>
                </div>
                <!-- / top-bar -->
                <!-- header-container -->
                <div class="header-container">
                    <div class="container">
                        <div class="row">
                            <!-- logo-->
                            <div class="col-sm-3 col-md-4  col-lg-4">
                                <div class="logo">
                                  <?php if ($logo) { ?>
                                        <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
                                        <?php } else { ?>
                                        <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                                        <?php } ?>
                                </div>
                            </div>
                            <!-- / logo -->
                            <!-- min search bar -->
                            <div class="col-sm-6 col-md-4  col-lg-4">
                                 <div class="header-search">
                                     <?php echo $search; ?>
                                </div>
                            </div>
                            <!-- / mini search bar -->
                            <!-- mini cart -->
                            <div class="col-sm-3 col-md-4  col-lg-4">
                                <div class="header-cart-mini style-2">
                                    <div class="topcart-mini-container">
                                       <?php echo $cart; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- / main cart -->
                        </div>
                    </div>
                </div>
                <!-- / header-container -->
                <!-- main menu -->
                <div class="header-menu style-2-header-bg">
                    <div class="container">
                        <!-- header menu -->
                        <div class="nav-container">
                            <nav class="navigation" id="sf-menu">
                                <ul class="sf-menu sf-js-enabled sf-arrow">
                                     <li class="active sfish-menu">
                                        <a href="<?php echo $home; ?>"><span class="home-icon"></span>
                                          <?php   if(isset($wg24themeoptionpanel_hometext_prallax)) {
                                                echo  html_entity_decode($wg24themeoptionpanel_hometext_prallax);
                                                } 
                                            ?>
                                        </a>
                                    </li>
                                     <?php $parrent=1; foreach ($categories as $category) {  ?>
                                      <?php if ($category['children']) { ?>
                                  <?php if ($parrent<=$wg24themeoptionpanel_megamenushow_prallax) { ?>
                                        <li class="megamenu">
                                            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?><i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                            <ul class="mmenuffect">
                                                <li class="row">
                                                    <div class="col-md-9 col-sm-8">
                                                           <?php  foreach ($category['children'] as $children) {  ?> 
                                                        <div class="col-md-3 col-sm-6">
                                                            <a class="sub-heading" href="<?php echo $children['href']; ?>"><span><?php echo $children['name']; ?></span></a>
                                                                <?php if ($children['children3']) { ?>
                                                                    <ul>
                                                                        <?php  foreach ($children['children3'] as $children3) {  ?>   
                                                                            <li>
                                                                            <a href="<?php echo $children3['href']; ?>"><?php echo $children3['name']; ?></a>
                                                                            </li>
                                                                        <?php }  ?> 
                                                                    </ul>
                                                                <?php }  ?> 
                                                        </div>
                                                        <?php } ?>
                                                        <div class="clear"></div>
                                                        
                                                        <?php
                                                        if($parrent==1){
                                                            if(isset($wg24themeoptionpanel_firstmegamenu1_prallax)) {
                                                            echo  html_entity_decode($wg24themeoptionpanel_firstmegamenu1_prallax);
                                                            }
                                                          }  
                                                           if($parrent==2){
                                                             if(isset($wg24themeoptionpanel_firstmegamenu12_prallax)) {
                                                            echo  html_entity_decode($wg24themeoptionpanel_firstmegamenu12_prallax);
                                                            }
                                                            }
                                                        ?> 
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                          <?php
                                                           if($parrent==1){
                                                            if(isset($wg24themeoptionpanel_firstmegamenu2_prallax)) {
                                                            echo  html_entity_decode($wg24themeoptionpanel_firstmegamenu2_prallax);
                                                            }
                                                           }
                                                            if($parrent==2){
                                                             if(isset($wg24themeoptionpanel_firstmegamenu22_prallax)) {
                                                            echo  html_entity_decode($wg24themeoptionpanel_firstmegamenu22_prallax);
                                                            }
                                                            }
                                                        ?> 
                                                    </div>
                                                </li>
                                                <!-- mega menu / -->
                                                <!-- / sf menu -->
                                            </ul>
                                        </li>
                                  <?php }else{ ?>
                                        <li class="sfish-menu">
                                            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?><i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                            <ul class="menu-animation sfmenuffect">
                                              <?php  foreach ($category['children'] as $children) {  ?> 
                                                <li>
                                                    <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                                                      <?php if ($children['children3']) { ?>
                                                    <ul class="sfmenuffect">
                                                       <?php  foreach ($children['children3'] as $children3) {  ?>   
                                                        <li>
                                                            <a href="<?php echo $children3['href']; ?>"><?php echo $children3['name']; ?></a>
                                                        </li>
                                                      <?php }  ?> 
                                                    </ul>
                                                      <?php }  ?> 
                                                </li>
                                                 <?php }  ?> 
                                                
                                                <!-- / sf menu -->
                                            </ul>
                                        </li>
                                    <?php } } else { ?>
                                    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                                    <?php } ?>
                                <?php $parrent=$parrent+1;} ?> 
                                     <?php  if($wg24themeoptionpanel_blogtoptext_prallax){ ?>
                                <li><a href="<?php echo $blogs; ?>"><?php echo $wg24themeoptionpanel_blogtoptext_prallax; ?></a></li>
                                <?php } ?>
                                </ul>
                            </nav>
                        </div>
                        <!-- / header menu -->
                        <!-- mobile menu -->
                        <div class="mobile-container " style="display: none">
                            <div class="mobile-menu-toggle">
                                <ul>
                                    <li class="toggle-icon"><a href="#">
                                            <?php   if(isset($wg24themeoptionpanel_t_category_prallax)) {
                                                echo  html_entity_decode($wg24themeoptionpanel_t_category_prallax);
                                                } ?>
                                        </a></li>
                                </ul>
                            </div>
                            <div style="display: none;" class="mobile-main-menu">
                                <ul class="accordion">
                                  <?php  foreach ($categories as $category) {  ?>
                                        <?php if ($category['children']) { ?>
                                        <li class="parent">
                                           <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                            <ul class="children" style="display: none;">
                                                <?php  foreach ($category['children'] as $children) {  ?> 
                                                <?php if ($children['children3']) { ?>
                                                <li class="parent">
                                                    <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                                                    <ul class="children" style="display: none;">
                                                       <?php  foreach ($children['children3'] as $children3) {  ?>  
                                                        <li> <a href="<?php echo $children3['href']; ?>"><?php echo $children3['name']; ?></a></li>
                                                          <?php } ?>
                                                    </ul>
                                                    <span class="down-up">&nbsp;</span>
                                                </li>
                                                <?php }else { ?> 
                                                    <li>
                                                        <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                                                    </li>
                                                <?php } ?>
                                                 <?php }  ?> 
                                                
                                            </ul>
                                              
                                            <span class="down-up">&nbsp;</span>
                                        </li>
                                       
                                        <?php } else{ ?>
                                        <li>
                                            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                        </li>
                                        
                                    <?php }} ?>
                                     <?php  if($wg24themeoptionpanel_blogtoptext_prallax){ ?>
                                <li><a href="<?php echo $blogs; ?>"><?php echo $wg24themeoptionpanel_blogtoptext_prallax; ?></a></li>
                                <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <!-- / mobile menu -->
                    </div>
                </div>
            </header>
         <?php } ?>
<?php if($wg24themeoptionpanel_homepage123_prallax=="homepage3" ) { ?>
  <!-- header -->
            <header class="header-style-3 style-3">
              <!-- top-bar-->
                <div class="top-bar gray9-bg">
                    <div class="container">
                        <div class="row">
                            <!-- top links -->
                            <div class="col-sm-8 col-md-8 col-lg-6 top-links">
                                <ul class="nav navbar-nav">
                                    <li class="list-line dropdown flags"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown">
                                          <span class="fa fa-user"></span> <?php echo $text_account; ?>
                                        </a>
                                    <ul class="dropdown-menu sfmenuffect">
                                      <?php if ($logged) { ?>
                                      <li><a href="<?php echo $account; ?>"> <span><?php echo $text_account; ?></span></a></li>
                                      <li><a href="<?php echo $order; ?>"> <span><?php echo $text_order; ?></span></a></li>
                                      <li><a href="<?php echo $transaction; ?>"> <span><?php echo $text_transaction; ?></span></a></li>
                                      <li><a href="<?php echo $download; ?>"> <span><?php echo $text_download; ?></span></a></li>
                                      <li><a href="<?php echo $logout; ?>"> <span><?php echo $text_logout; ?></span></a></li>
                                      <?php } else { ?>
                                      <li><a href="<?php echo $register; ?>"> <span><?php echo $text_register; ?></span></a></li>
                                      <li><a href="<?php echo $login; ?>"> <span><?php echo $text_login; ?></span></a></li>
                                      <?php } ?>
                                    </ul>
                                  </li>
                                 <!-- <li><a href="<?php echo $wishlist; ?>" id="wishlist-total"  title="<?php echo $text_wishlist; ?>"><span class="fa fa-heart"></span><?php echo $text_wishlist; ?></a></li>-->
                                  <li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><span class="fa fa-shopping-cart"></span><?php echo $text_shopping_cart; ?></a></li>
                                  <li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><span class="fa fa-arrow-circle-right"></span><?php echo $text_checkout; ?></a></li>
                                </ul>
                            </div>
                            <!--/ top links -->
                            <!-- langue & currency -->
                            <div class="col-sm-4 col-md-4 col-lg-6 lang-currency">
                                <ul class="nav navbar-nav pull-right">
                                    <!-- langue -->
                                       <?php echo $language; ?>
                                    <!--/ langue  -->
                                    <!-- currency -->
                                      <?php echo $currency; ?>
                                    <!-- / currency -->
                                </ul>
                            </div>
                            <!-- / langue currency -->
                        </div>
                    </div>
                </div>
                <!-- / top-bar-->
                <!--  header-container -->
                <div class="header-container style-3">
                     <!-- header-container -->
                    <div class="container">
                        <div class="row">
                            <!-- logo-->
                            <div class="col-sm-3 col-md-4  col-lg-4">
                                <div class="logo">
                                  <?php if ($logo) { ?>
                                        <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
                                        <?php } else { ?>
                                        <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                                        <?php } ?>
                                </div>
                            </div>
                            <!-- / logo -->
                            <!-- min search bar -->
                            <div class="col-sm-6 col-md-4  col-lg-4">
                                 <div class="header-search">
                                     <?php echo $search; ?>
                                </div>
                            </div>
                            <!-- / mini search bar -->
                            <!-- mini cart -->
                            <div class="col-sm-3 col-md-4  col-lg-4">
                                <div class="header-cart-mini style-2">
                                    <div class="topcart-mini-container">
                                       <?php echo $cart; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- / main cart -->
                        </div>
                    </div>
                <!-- / header-container -->
                </div>
            </header>
            <!-- / header -->
            <div class="nav-menu style-3">
                <div class="container">
                    <div class="margin-left-0 col-md-3 col-lg-3">
                       <!-- category menu -->
                        <div class="nav_vmmenu-area style-3 hidden-xs hidden-sm">
                            <div class="nav_inner">
                                <div class="vmmenu-title tomato-bg <?php if($class!='common-home'){ ?> category-menu-home3click <?php } ?>"><i class="fa fa-list"></i><span><?php echo $wg24themeoptionpanel_t_category_prallax; ?></span></div>
                                <div class="<?php if($class!='common-home'){ ?> category-menu-home3 <?php } ?>">
                                <div class="category-list gray9-bg">
                                        <div class="category-list-inner">
                                            <ul class="sf-vartical-menu sf-menu">
                                                <li>
                                                    <a href=""><i class="fa fa-home"></i><span><?php echo $wg24themeoptionpanel_hometext_prallax; ?></span></a>
                                                </li>
                                            <?php  foreach ($categories as $category) {  ?>
                                        <?php if ($category['children']) { ?>
                                        <li class="parrent">
                                            <a href="<?php echo $category['href']; ?>"><span><?php echo $category['name']; ?></span></a>
                                            <ul class="sfmenuffect">
                                                <?php  foreach ($category['children'] as $children) {  ?> 
                                                <?php if ($children['children3']) { ?>
                                                <li class="parrent">
                                                    <a href="<?php echo $children['href']; ?>"><span><?php echo $children['name']; ?></span></a>
                                                    <ul class="sfmenuffect" >
                                                       <?php  foreach ($children['children3'] as $children3) {  ?>  
                                                       <li> <a href="<?php echo $children3['href']; ?>"><span><?php echo $children3['name']; ?></span></a></li>
                                                          <?php } ?>
                                                    </ul>
                                                </li>
                                                <?php }else { ?> 
                                                    <li>
                                                        <a href="<?php echo $children['href']; ?>"><span><?php echo $children['name']; ?></span></a>
                                                    </li>
                                                <?php } ?>
                                                 <?php }  ?> 
                                            </ul>
                                        </li>
                                        <?php } else{ ?>
                                        <li>
                                            <a href="<?php echo $category['href']; ?>"><span><?php echo $category['name']; ?></span></a>
                                        </li>
                                        
                                    <?php }} ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="more lable0 gray9-bg">
                                        <a class="dropdown-toggle" aria-expanded="false" href="#" data-toggle="dropdown"><i class="fa fa-plus"></i><span><?php echo $wg24themeoptionpanel_t_category_prallax; ?></span></a>
                                    </div>
                                </div>
                        
                            </div>
                        </div>
                        <!-- / category menu -->
                    </div>
                    <div class="col-md-9 col-lg-9 margin-right-0">
                        <div class="header-menu gray9-bg">
                           <!-- navigation menu -->
                            <div class="nav-container  hidden-xs ">
                                <nav class="navigation" id="sf-menu">
                                    <ul class="sf-menu sf-js-enabled sf-arrow">
                                        <li class="megamenu">
                                            <a href=""><?php echo $wg24themeoptionpanel_populartext_prallax; ?><i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                            <ul class="mmenuffect">
                                                <li class="product-container">
                                                    <ul class="products-grid row">
                                                        <?php   foreach ($mpopularproducts as $product) {  ?>
                                                        <!-- item -->
                                                        <li class="col-sm-4 col-md-4 col-lg-4">
                                                        <div class="item">
                                                        <div class="product-details">
                                                            <div class="product-media">
                                                            <!--  product image  -->
                                                                <div class="product-img">
                                                                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                                                <!--  hover box -->
                                                                <div class="hover-box">
                                                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                                              <!--  <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
                                                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>-->
                                                                </div>
                                                            <!-- / hover box -->
                                                            </div>
                                                        <!-- / product image -->
                                                        <!--  sale and new box -->
                                                        <div class="product-lable-box">
                                                        <?php if ($product['price'] && $product['special']) { ?>
                                                        <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                                                        <?php } ?>       
                                                        </div>
                                                        <!-- / sale and new box -->
                                                        </div>
                                                        <div class="line-color"></div>
                                                        <div class="product-content">
                                                        <div class="product-content-inner">
                                                            <div class="product-con-left">
                                                            <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                                            <div class="ratting-box">
                                                            <div class="rating">
                                                            <?php if ($product['rating']) { ?>
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <?php if ($product['rating'] < $i) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } else { ?>
                                                            <span class="star active"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            <?php } else{ ?> 
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>
                                                          
                                                            </div>
                                                               <div class="product-con-right">
                                                                  <div class="product-price">
                                                            <?php if ($product['price']) { ?>
                                                            <?php if (!$product['special']) { ?>
                                                            <span class="new-price"> <?php echo $product['price']; ?></span>
                                                            <?php } else { ?>
                                                            <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        <!-- / item -->
                                                        </li>
                                                        <?php    } ?>
                                                    </ul>
                                                </li>
                                                <!-- mega menu / -->
                                                <!-- / sf menu -->
                                            </ul>
                                        </li>

                                        <li class="megamenu">
                                            <a href="#"><?php echo $wg24themeoptionpanel_home1bestsaletext_prallax; ?><i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                            <ul class="mmenuffect">
                                                <li class="product-container">
                                                    <ul class="products-grid row">
                                                        <?php   foreach ($mbestsales as $product) {  ?>
                                                        <!-- item -->
                                                        <li class="col-sm-4 col-md-4 col-lg-4">
                                                        <div class="item">
                                                        <div class="product-details">
                                                            <div class="product-media">
                                                            <!--  product image  -->
                                                                <div class="product-img">
                                                                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                                                <!--  hover box -->
                                                                <div class="hover-box">
                                                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                                         <!--       <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
                                                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>-->
                                                                </div>
                                                            <!-- / hover box -->
                                                            </div>
                                                        <!-- / product image -->
                                                        <!--  sale and new box -->
                                                        <div class="product-lable-box">
                                                        <?php if ($product['price'] && $product['special']) { ?>
                                                        <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                                                        <?php } ?>       
                                                        </div>
                                                        <!-- / sale and new box -->
                                                        </div>
                                                        <div class="line-color"></div>
                                                        <div class="product-content">
                                                        <div class="product-content-inner">
                                                            <div class="product-con-left">
                                                            <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                                            <div class="ratting-box">
                                                            <div class="rating">
                                                            <?php if ($product['rating']) { ?>
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <?php if ($product['rating'] < $i) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } else { ?>
                                                            <span class="star active"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            <?php } else{ ?> 
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>
                                                          
                                                            </div>
                                                               <div class="product-con-right">
                                                                  <div class="product-price">
                                                            <?php if ($product['price']) { ?>
                                                            <?php if (!$product['special']) { ?>
                                                            <span class="new-price"> <?php echo $product['price']; ?></span>
                                                            <?php } else { ?>
                                                            <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        <!-- / item -->
                                                        </li>
                                                        <?php  } ?>
                                                    </ul>
                                                </li>
                                                <!-- mega menu / -->
                                                <!-- / sf menu -->
                                            </ul>
                                        </li>
                                         <li class="megamenu">
                                            <a href="#"><?php echo $wg24themeoptionpanel_home1toprattingtext_prallax; ?><i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                            <ul class="mmenuffect">
                                                <li class="product-container">
                                                    <ul class="products-grid row">
                                                        <?php   foreach ($mtoprated as $product) {  ?>
                                                        <!-- item -->
                                                        <li class="col-sm-4 col-md-4 col-lg-4">
                                                        <div class="item">
                                                        <div class="product-details">
                                                            <div class="product-media">
                                                            <!--  product image  -->
                                                                <div class="product-img">
                                                                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                                                <!--  hover box -->
                                                                <div class="hover-box">
                                                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                                               <!-- <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
                                                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>-->
                                                                </div>
                                                            <!-- / hover box -->
                                                            </div>
                                                        <!-- / product image -->
                                                        <!--  sale and new box -->
                                                        <div class="product-lable-box">
                                                        <?php if ($product['price'] && $product['special']) { ?>
                                                        <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                                                        <?php } ?>       
                                                        </div>
                                                        <!-- / sale and new box -->
                                                        </div>
                                                        <div class="line-color"></div>
                                                        <div class="product-content">
                                                        <div class="product-content-inner">
                                                            <div class="product-con-left">
                                                            <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                                            <div class="ratting-box">
                                                            <div class="rating">
                                                            <?php if ($product['rating']) { ?>
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <?php if ($product['rating'] < $i) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } else { ?>
                                                            <span class="star active"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            <?php } else{ ?> 
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>
                                                          
                                                            </div>
                                                               <div class="product-con-right">
                                                                  <div class="product-price">
                                                            <?php if ($product['price']) { ?>
                                                            <?php if (!$product['special']) { ?>
                                                            <span class="new-price"> <?php echo $product['price']; ?></span>
                                                            <?php } else { ?>
                                                            <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        <!-- / item -->
                                                        </li>
                                                        <?php  } ?>
                                                    </ul>
                                                </li>
                                                <!-- mega menu / -->
                                                <!-- / sf menu -->
                                            </ul>
                                        </li>
                                         <li class="megamenu">
                                            <a href="#"><?php echo $wg24themeoptionpanel_home1Specialtext_prallax; ?><i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                            <ul class="mmenuffect">
                                                <li class="product-container">
                                                    <ul class="products-grid row">
                                                        <?php   foreach ($mspecials as $product) {  ?>
                                                        <!-- item -->
                                                        <li class="col-sm-4 col-md-4 col-lg-4">
                                                        <div class="item">
                                                        <div class="product-details">
                                                            <div class="product-media">
                                                            <!--  product image  -->
                                                                <div class="product-img">
                                                                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                                                <!--  hover box -->
                                                                <div class="hover-box">
                                                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                                              <!--  <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
                                                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>-->
                                                                </div>
                                                            <!-- / hover box -->
                                                            </div>
                                                        <!-- / product image -->
                                                        <!--  sale and new box -->
                                                        <div class="product-lable-box">
                                                        <?php if ($product['price'] && $product['special']) { ?>
                                                        <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                                                        <?php } ?>       
                                                        </div>
                                                        <!-- / sale and new box -->
                                                        </div>
                                                        <div class="line-color"></div>
                                                        <div class="product-content">
                                                        <div class="product-content-inner">
                                                            <div class="product-con-left">
                                                            <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                                            <div class="ratting-box">
                                                            <div class="rating">
                                                            <?php if ($product['rating']) { ?>
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <?php if ($product['rating'] < $i) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } else { ?>
                                                            <span class="star active"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            <?php } else{ ?> 
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>
                                                          
                                                            </div>
                                                               <div class="product-con-right">
                                                                  <div class="product-price">
                                                            <?php if ($product['price']) { ?>
                                                            <?php if (!$product['special']) { ?>
                                                            <span class="new-price"> <?php echo $product['price']; ?></span>
                                                            <?php } else { ?>
                                                            <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        <!-- / item -->
                                                        </li>
                                                        <?php  } ?>
                                                    </ul>
                                                </li>
                                                <!-- mega menu / -->
                                                <!-- / sf menu -->
                                            </ul>
                                        </li>
                                        <?php if($wg24themeoptionpanel_mcostomblock_prallax!=''){ ?>
                                        <li class="megamenu">
                                            <?php  echo  html_entity_decode($wg24themeoptionpanel_mcostomblock_prallax); ?>
                                        </li>
                                       <?php } ?> 
                                   <?php  if($wg24themeoptionpanel_blogtoptext_prallax){ ?>
                                <li><a href="<?php echo $blogs; ?>"><?php echo $wg24themeoptionpanel_blogtoptext_prallax; ?></a></li>
                                <?php } ?>
                                    </ul>
                                </nav>
                            </div>
                            <!-- navigation menu -->
                           <!-- mobile menu -->
                        <div class="mobile-container " style="display: none">
                            <div class="mobile-menu-toggle">
                                <ul>
                                    <li class="toggle-icon"><a href="#">
                                            <?php   if(isset($wg24themeoptionpanel_t_category_prallax)) {
                                                echo  html_entity_decode($wg24themeoptionpanel_t_category_prallax);
                                                } ?>
                                        </a></li>
                                </ul>
                            </div>
                            <div style="display: none;" class="mobile-main-menu">
                                <ul class="accordion">
                                  <?php  foreach ($categories as $category) {  ?>
                                        <?php if ($category['children']) { ?>
                                        <li class="parent">
                                           <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                            <ul class="children" style="display: none;">
                                                <?php  foreach ($category['children'] as $children) {  ?> 
                                                <?php if ($children['children3']) { ?>
                                                <li class="parent">
                                                    <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                                                    <ul class="children" style="display: none;">
                                                       <?php  foreach ($children['children3'] as $children3) {  ?>  
                                                        <li> <a href="<?php echo $children3['href']; ?>"><?php echo $children3['name']; ?></a></li>
                                                          <?php } ?>
                                                    </ul>
                                                    <span class="down-up">&nbsp;</span>
                                                </li>
                                                <?php }else { ?> 
                                                    <li>
                                                        <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                                                    </li>
                                                
                                                <?php } ?>
                                                
                                                 <?php }  ?> 
                                                
                                            </ul>
                                              
                                            <span class="down-up">&nbsp;</span>
                                        </li>
                                       
                                        <?php } else{ ?>
                                        <li>
                                            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                        </li>
                                        
                                    <?php }} ?>
                                </ul>
                            </div>
                        </div>
                        <!-- / mobile menu -->
                        </div>
                        <!--  slider -->
            <!-- / header-container -->
            
            <?php if($class!='common-home'){ ?>
             </div>
                 </div>
             </div>
            <?php } ?>
            
            
<?php } ?>