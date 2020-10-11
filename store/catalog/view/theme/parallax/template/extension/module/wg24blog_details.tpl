<?php echo $header; ?>
  <section class="breadcrumb-area padding-top-product">
                    <div class="container">
                        <div class="breadcrumb breadcrumb-box">
                            <ul>
                                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                                <li><a href="<?php echo $breadcrumb['href']; ?>"><span ><span><?php echo $breadcrumb['text']; ?></span></span></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </section>
 <section  class="main-page container">
                    <div class="main-container col2-left-layout">
                        <div class="main">
                            <div class="row">
                                <!--  left area -->
                                <div class="col-sm-4 col-md-3 col-lg-3">
                                 <?php include('wg24blog_leftcolumn.tpl'); ?>
                                </div>
                                <!-- / left -->
                                <div class="col-sm-8 col-md-9 col-lg-9">
                                    <div class="col-main">
                                        <?php if($blogpost) { ?>
                                        
                                        <script>
  // Load the SDK asynchronously
  (function(thisdocument, scriptelement, id) {
    var js, fjs = thisdocument.getElementsByTagName(scriptelement)[0];
    if (thisdocument.getElementById(id)) return;
    
    js = thisdocument.createElement(scriptelement); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js"; //you can use 
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
    
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '607388439442793', //Your APP ID
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // These three cases are handled in the callback function.
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };
    
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      _i();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  }  
  
  

  
  function _login() {
    FB.login(function(response) {
       // handle the response
       if(response.status==='connected') {
        _i();
       }
     }, {scope: 'public_profile,email'});
 }
 
 function _i(){
     FB.api('/me',{fields:'name,email'}, function(response) {
          var id=response.id;
         var pic='https://graph.facebook.com/'+id+'/picture?type=small';
         document.getElementById("postavator").value =pic;
        document.getElementById("author").value = response.name;
        document.getElementById("email").value = response.email;
    });
 }

</script>  

  <script src="https://apis.google.com/js/client:platform.js?onload=startApp"></script>
  <script>
  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '329305514486-6mldr34ab899t9304cd37et7irkpk18l.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      attachSignin(document.getElementById('customBtn'));
    });
  };
  function attachSignin(element) {
    console.log(element.id);
    auth2.attachClickHandler(element, {},
        function(googleUser) {
         document.getElementById("author").value = googleUser.getBasicProfile().getName();
          document.getElementById("email").value = googleUser.getBasicProfile().getEmail();
           document.getElementById("postavator").value =googleUser.getBasicProfile().getImageUrl();
        }, function(error) {
          alert(JSON.stringify(error, undefined, 2));
        });
  }
  
  </script>
                                      <div class="blog-details">
                                        <div class="blog-details-inner">
                                            <div class="blog-long-img">
                                            <?php if(!empty($blogpost['video'])){ echo $blogpost['video'];}else{ ?>
                                                <img src="<?php echo $blogpost['thumb']; ?>" width="880" height="400" alt="blog image" />
                                             <?php } ?>
                                            </div>
                                            <div class="blog-content">
                                                <div class="blog-content-inner padding-top-product">
                                                    <div class="hadding-title"><a><?php echo $blogpost['title']; ?></a></div>
                                                </div>
                                                <div class="post-content">
                                                    <ul class="post-meta">
                                                        <li><span class="fa fa-comment-o"></span><a href=""><?php echo $blogpost['totalcomment']; ?> Comments</a></li>
                                                        <li><span class="fa fa-pencil"></span><a href="">Post by <?php echo $blogpost['postadmin']; ?></a></li>
                                                        <li><span class="fa fa-cal/ar"></span><a href=""><?php echo $blogpost['adddate']; ?></a></li>
                                                    </ul>
                                                </div>
                                                <div class="post-detail margin-buttom-product">
                                                    <p><?php echo $blogpost['description']; ?></p>
                                                </div>
                                            </div>

                                            <div class="blog-comment-box">
                                                <div class="blog-comment-inner">
                                                    <div class="hadding"><span>Comments</span></div>
                                                    <div class="comments">
                                                        <?php if(isset($allcomments)){ foreach($allcomments as $allcomment){ ?>
                                                        <div class="athor">
                                                            <div class="comment-img">
                                                                <img src="<?php echo $allcomment['user_pic'];?>" width="50" height="50" alt="athor img" /> 
                                                            </div>
                                                            <div class="media-content">
                                                                <div class="athor">
                                                                    <div class="product-name"><a href=""><?php echo $allcomment['name'];?></a></div>
                                                                    <div class="comment-time">
                                                                        <span class="fa fa-clock-o"><?php echo $allcomment['comment_date'];?></span>
                                                                    </div>
                                                                    <div class="post-meta">
                                                                        <p><?php echo $allcomment['comment'];?></p>
                                                                        <ul>
                                                                            <li><a class="replaybutton" id="replay<?php echo $allcomment['comment_id'];?>" onclick="return addreply(<?php echo $allcomment['comment_id'];?>);"><span class="fa fa-reply-all"></span>Reply</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if(isset($allcomment['childcomment'])){ foreach($allcomment['childcomment'] as $childcomment){ ?>
                                                        <div class="cliet-comment">
                                                            <div class="comment-img">
                                                                <img src="<?php echo $childcomment['user_pic'];?>" width="50" height="50" alt="athor img" /> 
                                                            </div>
                                                            <div class="media-content">
                                                                <div class="athor">
                                                                    <div class="product-name"><a><?php echo $childcomment['name'];?></a></div>
                                                                    <div class="comment-time">
                                                                        <span class="fa fa-clock-o"><?php echo $childcomment['comment_date'];?></span>
                                                                    </div>
                                                                    <div class="post-meta">
                                                                        <p><?php echo $childcomment['comment'];?></p>
                                                                        <ul>
                                                                            <li><a class="replaybutton" onclick="return addreply(<?php echo $allcomment['comment_id'];?>);"><span class="fa fa-reply-all"></span>Reply</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                   <?php }} } } ?>
                                                   
                                                    </div>
                                                    <div class="comment-respond padding-top" id="leavecommentfrom">
                                                        <div class="comment-respond-inner">
                                                            <div class="hadding"><span>Leave a Comment</span></div>
                                                                    <div class="row">
                                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 comment-form-name">
                                                                            <input type="text" value="" class="form-control border-radius " placeholder="Your Name:" name="commentauthor" id="author">
                                                                        </div>
                                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 comment-form-email">
                                                                            <input type="text" value="" class="form-control border-radius" placeholder="Email:" name="commentemail" id="email">
                                                                        </div>
                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                            <div class="comment-form-comment">
                                                                                <textarea rows="12" cols="40" name="commenttext" id="comment" placeholder="Comment:" class="form-control border-radius"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-submit  padding-top-product">
                                                                        <input  type="hidden" name="blogpost_img_id" value="<?php echo isset($blogpost['blogpost_img_id'])?$blogpost['blogpost_img_id']:''; ?>"/>
                                                                        <input type="hidden" name="commentpic" id="postavator"  value="" />
                                                                        <input type="hidden" name="parrent_id" id="parrent_id"  value="0" />
                                                                       <button class="btn submit-btn border-radius" id="submitcomment" type="button">Submit</button>
                                                                    </div>
                                                              <button class="btn submit-btn border-radius" onclick="_login();" type="submit">Sign Up using Facebook</button>
                                                              <div id="gSignInWrapper" class="btn submit-btn border-radius">
                                                          
                                                            <button id="customBtn" class="customGPlusSignIn btn submit-btn border-radius">
                                                            Sign Up using Google
                                                            </button>
                                                            </div>
                                                            <script>startApp();</script>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                        
                                        
                                             <script type="text/javascript"><!-- 
 function addreply(id){
    document.getElementById("parrent_id").value =id;
     }
  $("a.replaybutton").click(function() {
       $('html, body').animate({
        scrollTop:$("#leavecommentfrom").offset().top
    }, 500);
});             
$('#submitcomment').on('click', function() {
	$.ajax({
		url: 'index.php?route=extension/module/wg24blog/blogComments',
                type: 'post',
		data: 'blogpost_img_id=' + encodeURIComponent($('input[name=\'blogpost_img_id\']').val())+'&parrent_id=' + encodeURIComponent($('input[name=\'parrent_id\']').val())+'&commentpic=' + encodeURIComponent($('input[name=\'commentpic\']').val())+'&commentauthor=' + encodeURIComponent($('input[name=\'commentauthor\']').val())+'&commentemail=' + encodeURIComponent($('input[name=\'commentemail\']').val())+'&commenttext=' + encodeURIComponent($('textarea[name=\'commenttext\']').val()),
		dataType: 'json',
		beforeSend: function() {
			$('#submitcomment').button('loading');
		},
		complete: function() {
			$('#submitcomment').button('reset');
		},
		success: function(json) {
                    console.log(json);
			$('.alert, .text-danger').remove();
			if (json['error']) {
                          
				if (json['error']['warning']) {
					$('.comment-respond-inner').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['error']['commentauthor']) {
					$('input[name=\'commentauthor\']').after('<div class="text-danger">' + json['error']['commentauthor'] + '</div>');
				}

				if (json['error']['commentemail']) {
					$('#email').after('<div class="text-danger">' + json['error']['commentemail'] + '</div>');
				}

				if (json['error']['commenttext']) {
					$('textarea[name=\'commenttext\']').after('<div class="text-danger">' + json['error']['commenttext'] + '</div>');
				}
			}
                        if (json['success']) {
                            if (json['success']['success']) {
					$('.comment-respond-inner').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success']['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                                       
                                      $('body').load(json['success']['loadpage']).slideDown("slow");
                                     
                                        var par_id=document.getElementById("parrent_id").value;
                                       if((par_id)==0){
                                        $('html, body').animate({
                                        scrollTop:$(".blog-comment-inner").offset().top
                                        }, 500);
                                         }else{
                                        $('html, body').animate({
                                        scrollTop:$("#replay"+par_id+"").offset().top
                                        }, 500);
                                    }
                                 
                                        
				}

                        }
			
		},
                 error: function(json){
          console.log(json);
      } 
	});
});

//--></script>  
             
                                        
                                        
                                        
                                        
                                        <?php } else{ ?>
                                        <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
                                     <?php   } ?>
                                    </div>
                                </div>  

                            </div>    
                        </div>
                    </div>
                </section>
<?php echo $footer; ?>