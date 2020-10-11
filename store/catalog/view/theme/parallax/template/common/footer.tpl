 <!--  footer -->
   <?php if($wg24themeoptionpanel_home1testimonial_prallax) { ?>
     <!--  testimonial -->
            <section class="testimonial-area padding-top">
                <div class="testmonial-inner">
                    <div class="container">
                        <div class="item" id="testmonial">
                            <?php  echo  html_entity_decode($wg24themeoptionpanel_home1testimonial_prallax); ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Testimonial -->
    <?php } ?>        
            
            <footer class="footer-area">
                <div class="footer-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                  <?php if($wg24themeoptionpanel_footer_about_info_prallax) { ?>
                                <!--  footer About -->
                              <?php  echo  html_entity_decode($wg24themeoptionpanel_footer_about_info_prallax); ?> 
                                <!-- / footer About -->
                                  <?php } ?> 
                            </div>
                            <div class=" col-sm-6 col-md-2 col-lg-2">
                                <!--  footer information -->
                                <div class="information">
                                    <h3 class="hadding-title"><?php echo $text_information; ?></h3>
                                    <div class="footer-content">
                                        <ul>
                                            <?php foreach ($informations as $information) { ?>
                                            <li><a href="<?php echo $information['href']; ?>"><i class="fa fa-angle-double-right"></i> <span><?php echo $information['title']; ?></span></a></li>
                                            <?php } ?>
                                            <li><a href="<?php echo $voucher; ?>"> <i class="fa fa-angle-double-right"></i> <span><?php echo $text_voucher; ?></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- / footer information -->
                            </div>
 
                            <div class="col-sm-6 col-md-2 col-lg-2">
                                <!--  footer Custom Service -->
                                <div class="service col-sm col-xs1">
                                    <h3 class="hadding-title"><span><?php echo $text_service; ?></span></h3>
                                    <div class="footer-content">
                                        <ul>
                                            <li><a href="<?php echo $contact; ?>"> <i class="fa fa-angle-double-right"></i> <span><?php echo $text_contact; ?></span></a></li>
                                            <!--<li><a href="<?php echo $return; ?>"> <i class="fa fa-angle-double-right"></i> <span><?php echo $text_return; ?></span></a></li>-->
                                            <li><a href="<?php echo $sitemap; ?>"> <i class="fa fa-angle-double-right"></i> <span><?php echo $text_sitemap; ?></span></a></li>
                                            <li><a href="<?php echo $manufacturer; ?>"><i class="fa fa-angle-double-right"></i>  <span><?php echo $text_manufacturer; ?></span></a></li>
                                            <li><a href="<?php echo $special; ?>"><i class="fa fa-angle-double-right"></i>  <span><?php echo $text_special; ?></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- / footer Custom Service -->
                            </div>
                            <div class=" col-sm-6 col-md-2 col-lg-2">
                                <!--  footer my account -->
                                <div class="account col-sm col-xs1">
                                    <h3 class="hadding-title"><?php echo $text_account; ?></h3>
                                    <div class="footer-content">
                                        <ul>
                                            <li><a href="<?php echo $account; ?>"><i class="fa fa-angle-double-right"></i>
                                                    <span><?php echo $text_account; ?></span></a></li>
                                            <li><a href="<?php echo $order; ?>"><i class="fa fa-angle-double-right"></i>
                                                    <span><?php echo $text_order; ?></span></a></li>
                                            <li><a href="<?php echo $wishlist; ?>"><i class="fa fa-angle-double-right"></i>
                                                    <span><?php echo $text_wishlist; ?></span></a></li>
                                            <li><a href="<?php echo $newsletter; ?>"><i class="fa fa-angle-double-right"></i>
                                                    <span><?php echo $text_newsletter; ?></span></a></li>
                                              <li><a href="<?php echo $affiliate; ?>"><i class="fa fa-angle-double-right"></i>
                                                    <span><?php echo $text_affiliate; ?></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- / footer my account -->
                            </div>
                            <!-- newsletter -->
                            <div class=" col-sm-12 col-md-3 col-lg-3">
                                <!--  footer newsletter -->
                                <div class="newsletter col-sm col-xs1">
                                    <h3 class="hadding-title"><?php  echo  html_entity_decode($wg24themeoptionpanel_newslettertext_prallax); ?></h3>
                                  
                                    <div class="footer-content">
                                         <?php echo  $fnewslatter; ?>
                                        
                                        <div class="footer-social-box">
                                            <div class="footer-social-inner">
                                                <h3 class="hadding-title"><span><?php  echo  html_entity_decode($wg24themeoptionpanel_flowustext_prallax); ?></span></h3>
                                                <div class="footer-social-icon">
                                                    <ul>
                                                        <?php if($wg24themeoptionpanel_face_b_icon_url_prallax!='') { ?>
                                                        <li><a class="facebook" href=" <?php echo $wg24themeoptionpanel_face_b_icon_url_prallax;?>"><i class="fa fa-facebook"></i></a></li>
                                                        <?php } ?>
                                                          <?php if($wg24themeoptionpanel_twitt_icon_url_prallax!='') { ?>
                                                        <li><a class="twitter" href=" <?php echo $wg24themeoptionpanel_twitt_icon_url_prallax;?>"><i class="fa fa-twitter"></i></a></li>
                                                        <?php } ?>
                                                         <?php if($wg24themeoptionpanel_google_icon_url_prallax!='') { ?>
                                                        <li><a class="google" href=" <?php echo $wg24themeoptionpanel_google_icon_url_prallax;?>"><i class="fa fa-google-plus"></i></a></li>
                                                        <?php } ?>
                                                         <?php if($wg24themeoptionpanel_skype_icon_url_prallax!='') { ?>
                                                        <li><a class="skype" href=" <?php echo $wg24themeoptionpanel_skype_icon_url_prallax;?>"><i class="fa fa-skype"></i></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / footer newsletter -->
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="footer-buttom">
                            <div class="footer-line"></div>
                            <!--  footer payment -->
                            <div class="payment-options">
                                <ul>
                                     <?php if($wg24themeoptionpanel_fot_paypla_id_prallax!='') { ?>
                                    <li><a href=" <?php echo $wg24themeoptionpanel_fot_paypla_id_prallax;?>"><i class="fa fa-cc-paypal"></i></a></li>
                                     <?php } ?>
                                        <?php if($wg24themeoptionpanel_fot_ccstripe_id_prallax!='') { ?>
                                    <li><a href=" <?php echo $wg24themeoptionpanel_fot_ccstripe_id_prallax;?>"><i class="fa fa-cc-stripe"></i></a></li>
                                     <?php } ?>
                                        <?php if($wg24themeoptionpanel_fot_visa_id_prallax!='') { ?>
                                    <li><a href=" <?php echo $wg24themeoptionpanel_fot_visa_id_prallax;?>"><i class="fa fa-cc-visa"></i></a></li>
                                     <?php } ?>
                                        <?php if($wg24themeoptionpanel_fot_mastercard_id_prallax!='') { ?>
                                    <li><a href=" <?php echo $wg24themeoptionpanel_fot_mastercard_id_prallax;?>"><i class="fa fa-cc-mastercard"></i></a></li>
                                     <?php } ?>
                                     <?php if($wg24themeoptionpanel_fot_americanexpress_id_prallax!='') { ?>
                                    <li><a href=" <?php echo $wg24themeoptionpanel_fot_americanexpress_id_prallax;?>"><i class="fa fa-cc-amex"></i></a></li>
                                     <?php } ?>
                                     
                                    <?php if($wg24themeoptionpanel_fot_paycon_1_prallax_add!='') { ?>
                                    <li><a href="<?php echo $wg24themeoptionpanel_fot_cus_pay1_id_prallax;?>"><img src="<?php echo $wg24themeoptionpanel_fot_paycon_1_prallax_add;?>" alt=""/></a></li>
                                     <?php } ?>
                                       <?php if($wg24themeoptionpanel_fot_paycon_2_prallax_add!='') { ?>
                                    <li><a href="<?php echo $wg24themeoptionpanel_fot_cus_pay2_id_prallax;?>"><img src="<?php echo $wg24themeoptionpanel_fot_paycon_2_prallax_add;?>" alt=""/></a></li>
                                     <?php } ?>
                                     
                                </ul>
                            </div>
                            <!-- / footer payment -->
                            <!-- / footer copyright -->
                            <div class="copyright">
                                 <?php  echo  html_entity_decode($wg24themeoptionpanel_footer_copy_text_prallax); ?> 
                            </div>
                            <!-- / footer copyright -->
                        </div>
                    </div>
                </div>
            </footer>
            <div class="top-bottom" id="tot-buttom" style="display: block;"><span class="fa fa-play"></span></div>
            <!-- / footer -->
        </div>
        <!-- / page-->
    </div>
    <!-- / wrapper-->
    <!-- jquery ui -->
    <script src="catalog/view/theme/parallax/assets/plugins/jquery-ui-1.12.0/jquery-ui.min.js"></script>
    <!-- bootstarp -->
    <script src="catalog/view/theme/parallax/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- owl carousel -->
    <script src="catalog/view/theme/parallax/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- nivo slider -->
    <script src="catalog/view/theme/parallax/assets/plugins/Nivo-Slider/jquery.nivo.slider.js"></script>
    <!-- elevatezoom -->
    <script src="catalog/view/theme/parallax/assets/plugins/elevatezoom/jquery.elevatezoom.js" type="text/javascript"></script>
    <!-- magnific popup -->
     <!-- countdown -->
    <script src="catalog/view/theme/parallax/assets/plugins/countdown/jquery.plugin.min.js"></script>
    <script src="catalog/view/theme/parallax/assets/plugins/countdown/jquery.countdown.min.js"></script>
    <script src="catalog/view/theme/parallax/assets/plugins/magnific/jquery.magnific-popup.min.js"></script>
    <!-- accordion -->
    <script src="catalog/view/theme/parallax/assets/js/jquery.accordion.source.js"></script>
    <!-- ddslick -->
    
    <script src="catalog/view/theme/parallax/assets/js/jquery.ddslick.min.js"></script>
    <!-- custom js -->
    <script src="catalog/view/theme/parallax/assets/js/theme.js"></script>
     <script src="catalog/view/theme/parallax/assets/js/newslatter.js"></script>
    
    
<script type="text/javascript">
        jQuery(document).ready(function($) {
          
            /*  select  menu */
            $(function() {
                $(".selector12").selectmenu();
            });
        });
    </script>
    <script type="text/javascript">
    new AdvancedNewsletter({
        container_id: '#advanced-newsletter-box',
        input_id: 'input[name=email]',
        submit_id: '#enter-subscribe'
    });
</script>
</body>
</html>