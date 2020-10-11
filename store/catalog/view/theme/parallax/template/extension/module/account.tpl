
<div class="account-list">
<div class="account-list-inner">
    <div class="title-box">
        <span class="sub-title"><?php echo $heading_title; ?> </span>
    </div>
    <div class="account-list-box">
        <ul>
             <?php if (!$logged) { ?>
   <li class="account-item"><a href="<?php echo $login; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_login; ?></a> </li>
   <li class="account-item"><a href="<?php echo $register; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_register; ?></a> </li>
   <li class="account-item"><a href="<?php echo $forgotten; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_forgotten; ?></a></li>
  <?php } ?>
   <li class="account-item"><a href="<?php echo $account; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_account; ?></a></li>
  <?php if ($logged) { ?>
   <li class="account-item"><a href="<?php echo $edit; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_edit; ?></a> </li>
   <li class="account-item"><a href="<?php echo $password; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_password; ?></a></li>
  <?php } ?>
   <li class="account-item"><a href="<?php echo $address; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_address; ?></a></li>
   <li class="account-item"><a href="<?php echo $wishlist; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_wishlist; ?></a> </li>
   <li class="account-item"><a href="<?php echo $order; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_order; ?></a></li>
   <li class="account-item"><a href="<?php echo $download; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_download; ?></a></li>
   <li class="account-item"><a href="<?php echo $recurring; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_recurring; ?></a></li>
   <li class="account-item"><a href="<?php echo $reward; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_reward; ?></a> </li>
   <li class="account-item"><a href="<?php echo $return; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_return; ?></a></li>
   <li class="account-item"><a href="<?php echo $transaction; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_transaction; ?></a> </li>
   <li class="account-item"><a href="<?php echo $newsletter; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_newsletter; ?></a></li>
  <?php if ($logged) { ?>
  <li class="account-item"> <a href="<?php echo $logout; ?>" ><span class="fa fa-angle-double-right"></span><?php echo $text_logout; ?></a></li>
  <?php } ?>
        
        </ul>
    </div>
</div>
</div>

