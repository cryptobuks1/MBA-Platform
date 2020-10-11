<script type="text/javascript">
 <?php  if($wg24themeoptionpanel_c_list_grid_prallax=="grid_view") { ?>
jQuery(document).ready(function($){
    $("#products-grid").fadeIn("slow");
   $("#products-list").fadeOut("slow");
});
<?php } else {  ?> 
jQuery(document).ready(function($){
    $("#products-grid").fadeOut("slow");
   $("#products-list").fadeIn("slow");
});
<?php }   ?>    
   </script>
   
    <style type="text/css">

            <?php if($wg24themeoptionpanel_scrol_top_to_prallax=="hide") { ?>
               #tot-buttom{ display:none !important; }
            <?php } ?>
            body{
                <?php if($wg24themeoptionpanel_col_skin_prallax=="customeskin"){ ?>
                color:<?php echo $wg24themeoptionpanel_col_body_font_prallax; ?>;
                <?php }
                
                ?>
                
            font-family:<?php if($wg24themeoptionpanel_body_select_font_prallax=="show"){ echo $wg24themeoptionpanel_body_google_font_prallax['face']; ?>,sans-serif <?php }else{ echo $wg24themeoptionpanel_body_sy_font_prallax['face'];} ?>;
           
            font-size:<?php echo $wg24themeoptionpanel_body_size_font_prallax; ?>px;
            <?php if($wg24themeoptionpanel_bg_img_prallax=="show"){ 
                if($wg24themeoptionpanel_bg_cust_patten_prallax)  { ?>
                background: url("<?php  echo  $wg24themeoptionpanel_bg_cust_patten_prallax;?>") <?php echo $wg24themeoptionpanel_bg_repeter_prallax;?> <?php echo $wg24themeoptionpanel_bg_attached_prallax; ?> <?php echo $wg24themeoptionpanel_bg_positin_prallax;?> <?php echo $wg24themeoptionpanel_col_body_bg_prallax;?>;
                <?php } else{ ?>
                          background: url("<?php echo $wg24themeoptionpanel_bg_patten_prallax;?>") <?php echo $wg24themeoptionpanel_bg_repeter_prallax;?> <?php echo $wg24themeoptionpanel_bg_attached_prallax; ?> <?php echo $wg24themeoptionpanel_bg_positin_prallax;?> <?php echo $wg24themeoptionpanel_col_body_bg_prallax; ?>;
                          <?php 
            }
            } 
            else{ }
            ?>
            <?php if($wg24themeoptionpanel_col_skin_prallax=="customeskin"){ ?>
                    background-color:<?php echo $wg24themeoptionpanel_col_body_bg_prallax;?>;
                <?php }  ?>
            }    
            /****   all header fontfamily and transfrom  ***/ 
           h2.product-hadding,.promo-title,.free-shipping-box .hadding-title,.hadding-title{
                font-family:<?php if($wg24themeoptionpanel_heders_select_font_prallax=="show"){ echo $wg24themeoptionpanel_heders_gol_font_prallax['face']; ?> <?php }else{ echo $wg24themeoptionpanel_heders_gol_font_prallax['face'];} ?>;
            }    
        </style>  
        <?php if($wg24themeoptionpanel_col_skin_prallax=="customeskin"){ ?>
        <style type="text/css">  
            /* link color */
            a{
            color:<?php echo $wg24themeoptionpanel_col_link_font1_prallax; ?>
            }
            a:hover,a:focus{
             color:<?php echo $wg24themeoptionpanel_col_link_h_font1_prallax; ?>
            }
            .form-control {
            background: <?php echo $wg24themeoptionpanel_input_bg_col_prallax; ?>;
            border: 1px solid <?php echo $wg24themeoptionpanel_input_text_col_prallax; ?>;
            color: <?php echo $wg24themeoptionpanel_input_bord_col_prallax; ?>;
            }
            /* menu */
            
    .top-bar ul li a,.sf-menu > li > a,.btn.btn-link.btn-block.language-select, 
    .btn.btn-link.btn-block.currency-select ,.sf-menu > li > a,.block-cart button,.style-3 .category-list .category-list-inner > ul > li > a {
  color: <?php echo $wg24themeoptionpanel_h_m_link_col_prallax; ?>;
}
.nav > li > a:hover, .nav > li > a:focus,.sf-menu > li:hover, .sf-menu > li.sfHover, .sf-menu > li.sfHover > a,
.sf-menu > li.active ,.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus,.btn.btn-link.btn-block.language-select:hover, 
.btn.btn-link.btn-block.currency-select:hover ,.sf-menu > li:hover > a,
ul.sf-menu li.active > a,.block-cart button:hover{
  color: <?php echo $wg24themeoptionpanel_h_m_link_h_col_prallax; ?>;
}

ul.sf-vartical-menu > li > a {
 color:#333;
}
    /* color 1 */
    .gray9-bg,.top-bar ul li:hover ul.dropdown-menu,.promo1 .promo-title > span::before {
    background-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
/* border colro */
.header-container .header-search button {
  border: 1px solid <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
    /* color 2*/
    .sf-menu > li:hover, .sf-menu > li.sfHover, .sf-menu > li.sfHover > a, .sf-menu > li.active,
    .header-container .header-search button:hover,.mmenu-banner-text,
    .sfish-menu > .menu-animation > li:hover, .sfish-menu > .menu-animation > li > ul > li:hover ,
    .header-cart-mini:hover button, .block-cart button:focus,.promo2 .promo-title > span::before{
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}

/* color */
.sub-heading span:hover, #sf-menu > ul > li ul > li > a:hover,.RightToLeft .Headding, .LeftToRight .Headding {
  color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}


/* border color */
.header-container .header-search button:hover,.sf-menu > li.megamenu > ul > li a.sub-heading > span,
.header-cart-mini:hover button, .block-cart button:focus{
  border-color:  <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
    
    /*color 3 */
.white-bg {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary13_col_prallax; ?>;
  color:<?php echo $wg24themeoptionpanel_whitcolortext_col_prallax; ?> !important;
}

/* button    colr for all button thee  */
 /* normal color */
 .RightToLeft .readmore a, .LeftToRight .readmore a{
 background-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
 }
 
 /* hover */
.RightToLeft .readmore a:hover, .RightToLeft .readmore a:focus, .LeftToRight .readmore a:hover, .LeftToRight .readmore a:focus{
 background-color:<?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}


/* arrow icon normal colro and hover color */ 

.owl-prev, .owl-next,.slider-area .nivo-prevNav, .slider-area .nivo-nextNav {
  border-color:<?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
  color:<?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
.owl-prev:hover, .owl-next:hover,.slider-area .nivo-prevNav:hover, .slider-area .nivo-nextNav:hover,.top-bottom .fa-play  {
  border-color:  <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
  color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}

/* prodcut */
.product-hadding > span,.twitter-hadding > span,
.footer-social-inner .hadding-title > span,
.page-title > span,.account-title,.hadding > span  {
  border-bottom: 2px solid <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.lable-sale {
  background-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
.lable-new {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
button.btn-button.cart-button:hover{
color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
button.btn-button.cart-button:hover{
background:none !important;
}
a.btn-button:hover{
    color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
 button.btn-button:hover, input.btn-button:hover ,a.btn-button:hover, button.btn-button:hover, input.btn-button:hover{
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.line-color::after {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
ul.tab-menu > li > a {
  background-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
  border: 1px solid <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;;
}
ul.tab-menu > li.active > a, ul.tab-menu > li.active > a:hover,
ul.tab-menu > li.active > a:focus, ul.tab-menu > li.active > a:active,
ul.tab-menu > li:hover > a {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
  border: 1px solid <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.rating .star.active,.product-shop .new-price ,.list-unstyled .editable.instock {
  color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.free-shipping-box:hover .free-sp-icon-box-inner .fa,.footer-address i {
  color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.readmore > a:hover ,#testmonial .owl-dot.active{
  color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.latest-blog-content a.read-more:hover, .latest-blog-content a.read-more:focus {
  border: 2px solid <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
  color:<?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.after-before-line-top::before,.after-before-line-top::after  {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.testmonial-inner {
  border-bottom: 3px solid <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
/* button */
.newsletter .submit-btn,.product-img-box .icon:hover, .product-img-box .icon:focus, .product-img-box .icon:active {
  background-color:<?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
.newsletter .submit-btn:hover,.product-img-box .icon  {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.btn-primary, .btn-default,.comment-respond-inner button.submit-btn, .comment-respond-inner input.submit-btn {
  background-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
  border-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
.btn-primary:hover, .btn-default:hover, .btn-primary:focus,
.btn-default:focus,.add-to-cart button.btn-button:hover,.comment-respond-inner button.submit-btn:hover, 
.comment-respond-inner button.submit-btn:focus,
.comment-respond-inner input.submit-btn:focus,
.comment-respond-inner input.submit-btn:hover {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
  border-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}

.product-shop button.btn-button,.border:hover  {
  border: 2px solid <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.single-product-tab .nav-tabs > li.active > a, 
.single-product-tab .nav-tabs > li.active > a:hover,
.single-product-tab .nav-tabs > li > a:hover, 
.single-product-tab .nav-tabs > li > a:focus{
border-color:<?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
    color:<?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
/* home 2 */
.style-2-header-bg {
  background-color:<?php echo $wg24themeoptionpanel_home2menubgcol_prallax; ?>;
}
.header-cart-mini.style-2 span.fa-shopping-bag {
  background-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
.slider-2-style .RightToLeft .sub-heading, .slider-2-style .LeftToRight .sub-heading{
color:<?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.slider-2-style .RightToLeft .readmore a, .slider-2-style .LeftToRight .readmore a,.style-2 a.read-more {
  border-color: <?php echo $wg24themeoptionpanel_golbalsendary13_col_prallax; ?>;
  color: <?php echo $wg24themeoptionpanel_golbalsendary13_col_prallax; ?>;
}
.slider-2-style .RightToLeft .readmore a:hover, .slider-2-style .LeftToRight .readmore a:hover,.add-banner2-price,.style-2 a.read-more:hover {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary13_col_prallax; ?>;
  color:#fff;
}
.style-2 .add-banner-link h2 span {
  color: <?php echo $wg24themeoptionpanel_golbalsendary13_col_prallax; ?>;
}
.style-2 .free-sp-icon-box-inner {
  background: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
.border-color:hover{
    border-color:<?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.popular-tag-content li {
  background-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}

.popular-tag-content li:hover {
  background-color:<?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.popular-tag-content li:hover a{
color:#fff;
}
.text-content > span{
color:<?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
/* home page 3 */
.style-3 .sf-menu > li:hover,
.style-3 .sf-menu > li.sfHover,
.style-3 .sf-menu > li.sfHover > a,
.style-3 .sf-menu > li.active {
  background-color: <?php echo $wg24themeoptionpanel_footer_bg_col_prallax; ?>;
}
.tomato-bg {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.slider-3-content .Headding {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
  color: #fff;
}
.slider-3-content > .sub-heading {
  background-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
  color: #fff;
}
.slider-3-content > .slider-line::before {
  background-color:  <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.slider-3-content > .readmore a.read-more {
  border: 1px solid  <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
  color:  <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.slider-3-content > .readmore a.read-more:hover, .slider-3-content > .readmore a.read-more:focus {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
   border: 1px solid  <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
/* shipping message */
.style-3 .free-shgipping-box {
  border-color:<?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
.style-3 .free-sp-icon-box-inner {
  background-color:<?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
.style-3 .free-shgipping-box:hover {
  border-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.style-3 .free-shgipping-box:hover .free-sp-icon-box-inner {
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.style-3 .free-shgipping-box:hover .shipping-content .hadding-title {
  color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.promobanner-3 .promo-content span {
  color:  <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.after-before-line-righthover::before ,
.promobanner-3-inner:hover .after-before-line-righthover::after,
.after-before-line-lefthover::after,
.after-before-line-lefthover::before,.product-banner-after-lefthover::before,.product-banner-after-righthover::before,
.product-banner-after-righthover::after,.product-banner-after-lefthover::after{
  background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}
.style-3.product-tab {
  background-color: <?php echo $wg24themeoptionpanel_gobprimary1_col_prallax; ?>;
}
.tab-style-2 .nav-tabs > li > a {
  color: <?php echo $wg24themeoptionpanel_h_m_link_col_prallax; ?>;
}
.product-tab-title {
  border-bottom: 2px solid <?php echo $wg24themeoptionpanel_h_m_link_col_prallax; ?>;
  color: <?php echo $wg24themeoptionpanel_h_m_link_col_prallax; ?>;
}
.product-tab-title .tab-left-line {
  background-color: <?php echo $wg24themeoptionpanel_h_m_link_col_prallax; ?>;
}
.tab-style-2 .nav-tabs > li:hover > a, .tab-style-2 .nav-tabs > li:focus > a, .tab-style-2 .nav-tabs > li.active > a {
  color: <?php echo $wg24themeoptionpanel_h_m_link_h_col_prallax; ?>;
    background-color: <?php echo $wg24themeoptionpanel_golbalsendary1_col_prallax; ?>;
}




/* footer */
.block-cart button {
  background-color: <?php echo $wg24themeoptionpanel_footer_bg_col_prallax; ?>;
  border: 1px solid <?php echo $wg24themeoptionpanel_footer_bg_col_prallax; ?>;
}
.footer-area {
  background-color:<?php echo $wg24themeoptionpanel_footer_bg_col_prallax; ?>; 
}
.footer-area h3.hadding-title {
  color: <?php echo $wg24themeoptionpanel_f_heading_col_prallax; ?>;
}
.footer-inner a,.footer-about,.copyright > p {
  color:<?php echo $wg24themeoptionpanel_f_heading_col_prallax; ?>;
}
.footer-inner a:hover {
  color: <?php echo $wg24themeoptionpanel_f_link_h_col_prallax; ?>;
}





           
        </style>   
        <?php  } ?> 
   
        
      