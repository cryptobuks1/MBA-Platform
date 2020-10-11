
 <div class="account-list padding-top-product">
            <div class="account-list-inner">
                <div class="title-box">
                    <span class="sub-title"><?php echo $heading_title; ?></span>
                </div>
                <div class="account-list-box">
                    <ul>
                         <?php foreach ($informations as $information) { ?>
           <li class="account-item">
                <a href="<?php echo $information['href']; ?>"><span class="fa fa-angle-double-right"></span><?php echo $information['title']; ?></a>
            </li>
        <?php } ?>
      <li class="account-item">
            <a href="<?php echo $contact; ?>"><span class="fa fa-angle-double-right"></span><?php echo $text_contact; ?></a>
        </li>

       <li class="account-item">
            <a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a>
                      </li>
                    </ul>
                </div>
            </div>
        </div>

