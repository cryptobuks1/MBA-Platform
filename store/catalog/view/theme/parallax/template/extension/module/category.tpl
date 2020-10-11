
   <!--  category menu -->
    <div class="nav_vmmenu-area">
        <div class="nav_inner">
            <div class="vmmenu-title gray9-bg"><i class="fa fa-list"></i><span><?php echo $heading_title; ?></span></div>
            <div class="category-list">
                <div class="category-list-inner">
                    <ul class="sf-vartical-menu2 accordion">
                        <li>
                            <a href="<?php  echo $home;?>"><i class="fa fa-home"></i><span><?php echo $wg24themeoptionpanel_hometext_prallax; ?></span></a>
                    </li>
                        <?php  foreach ($categories as $category) {  ?>
            <?php if ($category['children']) { ?>
            <li class="parent">
               <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                <ul>
                    <?php  foreach ($category['children'] as $children) {  ?> 
                    <?php if ($children['children3']) { ?>
                    <li class="parent">
                        <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                        <ul>
                           <?php  foreach ($children['children3'] as $children3) {  ?>  
                            <li> <a href="<?php echo $children3['href']; ?>"><?php echo $children3['name']; ?></a></li>
                              <?php } ?>
                        </ul>
                    </li>
                    <?php }else { ?> 
                        <li>
                            <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                        </li>

                    <?php } ?>

                     <?php }  ?> 

                </ul>
            </li>

            <?php } else{ ?>
            <li>
                <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
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
    <!-- / category menu -->




