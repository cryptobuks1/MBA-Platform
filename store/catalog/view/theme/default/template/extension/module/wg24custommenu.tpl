 
 <?php if(isset($blogcategorys)){ foreach($blogcategorys as $blogcategory){
    if($blogcategory['child']) { ?>
    <li class="sfish-menu">
      <a href="<?php echo $blogcategory['href'];?>"><?php echo $blogcategory['title'];?><i aria-hidden="true" class="fa fa-angle-down"></i></a>
      <ul class="menu-animation sfmenuffect">
    <?php  foreach($blogcategory['child'] as $blogcategorychil){ ?>      
 <li>
      <a href="<?php echo $blogcategorychil['href'];?>"><?php echo $blogcategorychil['title'];?></a>
  </li>
      <?php } ?>    
      </ul>
  </li>
    <?php }else{ ?>  
     <li>
      <a href="<?php echo $blogcategory['href'];?>"><span><?php echo $blogcategory['title'];?></span></a>
  </li>
   <?php }} } ?>  
