 <?php  if($wg24themeoptionpanel_homepage123_prallax=="homepage1") { ?>  
<?php if($module==0){ ?>
     <!--  promo banner -->
            <section class="promo-banner-area padding-top">
                <div class="container">
                    <div class="row">
                        <!--  promo1 -->
                          <?php $i=1; foreach ($banners as $banner) { ?>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <div class="promo-banner-inner promo-box<?php echo $i;?>">
                                <div class="promo-ing">
                                    <img src="<?php echo $banner['image']; ?>"  alt="<?php echo $banner['description']['title']; ?>"  />
                                </div>
                                <?php  echo  html_entity_decode($banner['description']['desce']); ?>
                            </div>
                        </div>
                         <?php $i=$i+1; } ?>
                        <!-- / promo1 -->
                    </div>
                </div>
            </section>
            <!-- / promo banner -->
      <?php } } ?>      
            
<?php  if($wg24themeoptionpanel_homepage123_prallax=="homepage2") { ?>  
<?php if($module==1){ ?>
<!--  promo banner -->
    <!--  add banner -->
<div class="add-banner-top margin-buttom ">
    <div class="add-banner-top-inner style-2 resbaner">
        <div class="row">
             <?php $i=1; foreach ($banners as $banner) { ?>
            <!-- banner-1 -->
            <div class="col-md-6">
                <div class="add-banner-box">
                    <div class="add-banner-img">
                        <img src="<?php echo $banner['image']; ?>"  alt="<?php echo $banner['description']['title']; ?>"  />
                        <div class="add-banner-link">
                            <?php  echo  html_entity_decode($banner['description']['desce']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / banner-1 -->
            <!--  add banner -->
  <?php $i=$i+1; } ?>
        </div>
    </div>
</div>

<!-- / promo banner -->
<?php } } ?>   
<?php  if($wg24themeoptionpanel_homepage123_prallax=="homepage3") { ?>  
<?php if($module==2){ ?>
<!--  promo banner -->
<?php  if($wg24themeoptionpanel_home3freedeliverymes_prallax!=''){ ?>
       <!-- free shipping -->
            <section class="style-3 free-shipping padding-top">
                <div class="container resbaner">
                    <div class="row">
                          <?php  echo  html_entity_decode($wg24themeoptionpanel_home3freedeliverymes_prallax); ?>
                    </div>
                </div>
            </section>
            <!-- / free shipping -->
    <?php } ?>        
            <!--  promo banner-3 -->
            <section class="promobanner-3 padding-top">
                <div class="container resbaner">
                    <div class="row">
                       <!-- banner-1 -->
                       <?php $i=1; foreach ($banners as $banner) { ?>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="promobanner-3-inner <?php if($i==2){ echo 'two'; } ?>">
                                <div class="promobanner-3-image">
                                    <img src="<?php echo $banner['image']; ?>"  alt="<?php echo $banner['description']['title']; ?>"  />
                                </div>
                                <?php  echo  html_entity_decode($banner['description']['desce']); ?>
                            </div>
                        </div>
                         <?php $i=$i+1; } ?>
                        <!-- / banner-1 -->
                    </div>
                </div>
            </section>
            <!--  / promo banner-3 -->
<?php } } ?>  