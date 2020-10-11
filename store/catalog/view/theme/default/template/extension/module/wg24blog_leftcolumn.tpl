   <!--  category menu -->
            <div class="nav_vmmenu-area">
                <div class="nav_inner">
                    <div class="vmmenu-title gray9-bg"><i class="fa fa-list"></i><span>categories</span></div>
                    <div class="category-list">
                        <div class="category-list-inner">
                            <ul class="sf-vartical-menu2 accordion">

                               <?php if(isset($blogcategorys)){ foreach($blogcategorys as $blogcategory){
                                  if($blogcategory['child']) { ?>
                                  <li class="parent">
                                    <a href="<?php echo $blogcategory['href'];?>"><span><?php echo $blogcategory['title'];?></span></a>
                                    <ul>
                                  <?php  foreach($blogcategory['child'] as $blogcategorychil){ ?>      
                               <li>
                                    <a href="<?php echo $blogcategorychil['href'];?>"><span><?php echo $blogcategorychil['title'];?></span></a>
                                </li>
                                    <?php } ?>    
                                    </ul>
                                </li>
                                  <?php }else{ ?>  
                                   <li>
                                    <a href="<?php echo $blogcategory['href'];?>"><span><?php echo $blogcategory['title'];?></span></a>
                                </li>
                             <?php }} } ?>  


                            </ul>

                        </div>
                    </div>
                    <div class="more lable0 gray9-bg"> 
                        <a  class="dropdown-toggle" aria-expanded="false" href="#" data-toggle="dropdown"><i class="fa fa-plus"></i><span>More Categories</span></a>
                    </div>
                </div>
            </div>
            <!-- / category menu -->
<div class="left-blog-search padding-top-product">
        <div class="left-blog-search-inner">
            <div class="hadding"><span>Search</span></div>
            <div class="left-blog-search-box" id='blogsearch'>
                <input type="text" name="blogsearch" class="form-control blog-search-input" placeholder="Search Here..">
                <a  class="btn submit-btn blog-search"><span class="fa fa-search"></span></a>
            </div>

        </div>
  </div>
<script type="text/javascript"><!--     
 /* Search */
 $('#blogsearch input[name=\'blogsearch\']').parent().find('a.blog-search').on('click', function() {
         url = $('base').attr('href') + 'index.php?route=module/wg24blog';
         var value = $('#blogsearch input[name=\'blogsearch\']').val();

         if (value) {
                 url += '&search=' + encodeURIComponent(value);
         }
         location = url;
 });

//--></script>     
<div class="left-recent-post padding-top-product">
                                        <div class="left-recent-post-inner">
                                            <div class="hadding"><span>Recent Blog</span></div>
                                             <?php if(isset($latestposts)){ foreach($latestposts as $latestpost){ ?>
                                            <div class="recent-media">
                                                <div class="resent-media-img">
                                                    <a href="<?php echo $latestpost['href'];?>">
                                                        <img alt="<?php echo $latestpost['title'];?>" src="<?php echo $latestpost['image'];?>">
                                                    </a>
                                                </div>
                                                <div class="media-content">
                                                    <div class="product-name"><a href="<?php echo $latestpost['href'];?>"><?php echo $latestpost['title'];?></a></div>
                                                    <div class="post-meta">
                                                        <ul>
                                                            <li><?php echo $latestpost['adddate'];?></li>
                                                            <li><span class="fa fa-comment"></span><a href=""><?php echo $latestpost['totalcomment'];?>Comments</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                                <?php } } ?>  
                                        </div>
                                    </div>

<div class="left-recent-post padding-top-product">
                                        <div class="left-recent-post-inner">
                                            <div class="hadding"><span>Recent Comments</span></div>
  <?php if(isset($latestcomments)){ foreach($latestcomments as $latestcomment){ ?>
                                            <div class="recent-media">
                                                <div class="resent-media-img">
                                                    <a href="<?php echo $latestcomment['href'];?>">
                                                        <img alt="<?php echo $latestcomment['title'];?>" src="<?php echo $latestcomment['image'];?>" width="50" height="50">
                                                    </a>
                                                </div>
                                                <div class="media-content">
                                                    <div class="product-name"><a href="<?php echo $latestcomment['href'];?>"><?php echo $latestcomment['title'];?></a></div>
                                                    <div class="post-meta">
                                                        <p><?php echo $latestcomment['comment'];?></p>
                                                        <ul>
                                                            <li><span class="fa fa-user"></span><a><?php echo $latestcomment['name'];?></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
 <?php } } ?>  
                                        </div>
                                    </div>