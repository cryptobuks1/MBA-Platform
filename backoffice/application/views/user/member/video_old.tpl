{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<style>
section {
    margin:25px 0;
}



/*--------------------------
    Carousel Styling
--------------------------*/
.carousel {
    
    .inner-content {
        min-height: 100px;
    }
    
    .carousel-indicators {
        bottom:0; //Align to bottom of parent div

        li {
            margin:0 2px;
            width: 18px;
            height: 18px;
            background: transparent;
            border-color: lighten(#000, 15%);
            border-width: 3px;

            &.active {
                background: lighten(#000, 15%);
            }
        }
    }
    
    .carousel-control {
        font-size: 52px;
        background:transparent;
        text-shadow:none;
        color: #000;
        opacity:1;
        
        //Hover, Focus and Active styles
        &:hover, &:focus, &:active {
            color:lighten(#000, 20%);
        }
    }


    //Video Carousel
        &#video-carousel {
            padding-bottom:90px; //Extra padding for '.carousel-indicators'


            .carousel-inner {
                border:2px solid #f3f3f3;
                background-color:#f3f3f3;//Prevents background image being shown when switching slides
                
                //Inner content - Wrapper for the '.youtube-video' div
                .inner-content {
                    min-height: 420px; //Change this for different viewports
                    
                    //The YouTube video - This styling may cause issues
                    .youtube-video {
                        position: absolute;
                        left:0;
                        top:0;
                    }
                }
                
                //Play button and button wrapper
                .play-button-wrapper {
                    cursor:pointer;
                    
                    //Wrapper overlays the entire video
                    z-index: 9999;
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    
                    //This centers the play buton
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            }

            //Control buttons - Left/Right
            .carousel-control {
                color:rgba(#000, 0.6);
                width: auto;
                line-height: 400px;//Height of the items

                &.left {
                    margin-left:-200px;
                }

                &.right {
                    margin-right:-200px;
                }
                
                //Hover, Focus and Active styles
                &:hover, &:focus, &:active {
                    color:rgba(#000, 0.90);
                }
            }
        }
}



/*--------------------------
    Button Styling
--------------------------*/
.btn {
    text-shadow:none;
    
    //Hover, Focus and Active styles
    &:hover, &:focus, &:active {
        border-color: transparent;
    }
    
    //Play button
    &.btn-video {
        padding: 20px;
        font-size: 40px;
        line-height: 0;
        border-radius: 0;
    }
}
</style>
<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('you_must_enter_subject')}</span>
    <span id="validate_msg2">{lang('you_must_enter_message')}</span>   
</div>

  

        <div class="panel panel-default">
            <div class="tab">
                <div class="content">
 <section>

        <div class="container-fluid">
            
            <div class="row">
                <div class="col-sm-12 col-sm-offset-3 text-center" style="margin-left:0px!important;">
                    <div id="video-carousel" class="carousel " data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#video-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#video-carousel" data-slide-to="1"></li>
                            <li data-target="#video-carousel" data-slide-to="2"></li>
                        </ol>
                        
                        
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                             {foreach $video as $videoone }
                            <div class="item active">
                                <!-- Button inside item so it slides with the carousel -->
                               
                                <div class="inner-content">
                                    <!-- id: Increment this each time - data-id: YouTube video ID -->
                                    
                                  <div class="col-xs-12 col-sm-6 col-md-12" style="height: 500px; width:1000px">
                                          <iframe src="https://player.vimeo.com/video/{substr($videoone['video_link'], 8)}" allowfullscreen="allowfullscreen" width="100%" height="89%" frameborder="0"></iframe>
                                    <h2> {$videoone['video_description']}</h2>
                                    </div>
                                    
                                </div>
                              
                            </div>
                            {/foreach}
 {foreach $videos as $video }
                            <div class="item">
                                <!-- Button inside item so it slides with the carousel -->
                           
                                
                                <div class="inner-content">
                                    <!-- id: Increment this each time - data-id: YouTube video ID -->
                                   <div class="col-xs-12 col-sm-6 col-md-12" style="height: 600px;">
                                          <iframe src="https://player.vimeo.com/video/{substr($video['video_link'], 8)}" allowfullscreen="allowfullscreen" width="97%" height="89%" frameborder="0"></iframe>
                                     <h2> {$video['video_description']}</h2>
                                    </div>
                                </div>
                            </div>
                              {/foreach}
              



                        <!-- Controls -->
                        <a class="left carousel-control" href="#video-carousel" role="button" data-slide="prev" style="width:2px;">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>

                        <a class="right carousel-control" href="#video-carousel" role="button" data-slide="next" style="width:13px;">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>

    </section>
                </div>
            </div>
        </div>
{/block}
                
{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}/javascript/validate_invite_wallpost.js"></script>

  



  <script src="{$PUBLIC_URL}/javascript/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>

    <script src="{$PUBLIC_URL}javascript/fullcalendar/lib/jquery.min.js" type="text/javascript"></script>


     <script src="{$PUBLIC_URL}javascript/fullcalendar/lib/moment.min.js" type="text/javascript"></script>
     <script>
/*
 * Carousel setup
 */
(function(){
    // setup your carousels as you normally would using JS
    // or via data attributes according to the documentation
    // https://getbootstrap.com/javascript/#carousel
    $('#video-carousel').carousel({ interval: false });                 //Disable auto-slide
}());



/*
 * Video carousel - Dynamically load in YouTube videos based on 'data-id'
 */
    //Load the YouTube Iframe API
    var tag = document.createElement('script');

    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);


    //This will be the object name for interacting with the videos in the rest of this code
    var videoArray = new Array();



    //Function: onYouTubePlayerAPIReady - Run when API is ready
    function onYouTubePlayerAPIReady() {
        
        //Look for video 'data-id' in the '.youtube-video' div
        var videos = document.querySelectorAll('#video-carousel .youtube-video');
        
        
        //Loop through each div found
        for (var i = 0; i < videos.length; i++) {

            //Create an array to hold the video IDs from 'data-id'
            dataset = videos[i].dataset.id;
            
            //This will be the variable name for inserting videos into the HTML divs
            var divID = 'vid-' + i.toString();
            
            //Setup video object, configure how videos should be presented
            videoArray[i] = new YT.Player(divID, {
                height: '100%',
                width: '100%',
                playerVars: {
                    'autoplay': 0,
                    'controls': 0,
                    'modestbranding': 1,
                    'rel': 0,
                    'showinfo': 0,
                    'loop': 1,
                    'iv_load_policy': 3
                },
                videoId: dataset, //Uses current looped ID from array
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
            
        }
    }



    //Function: onPlayerReady - Run when video player is ready
    function onPlayerReady(event) {

        //When the Bootstrap Carousel moves
        $('#video-carousel').on('slide.bs.carousel', function () {

            //Find each Iframe within '#video-carousel'
            $(this).find('iframe').each(function(){
                
                //Pause all YouTube videos
                event.target.pauseVideo();
                
            });

            
            //Show custom video button
            $('.play-button-wrapper .btn-video').show();

        });


    }



    //Function: onPlayerStateChange - Run when a videos state has changed
    function onPlayerStateChange(event) {

        //Find all custom video buttons within '#video-carousel'
        $("#video-carousel").find('.play-button-wrapper .btn-video').each(function(){

            //If video has Ended
            if (event.data == YT.PlayerState.ENDED) {
                $(this).fadeIn("Slow");//Fade out
                $(this).find('i').attr("class", "fa fa-play");
            }

            //If video is Playing
            if (event.data == YT.PlayerState.PLAYING) {
                $(this).find('i').attr("class", "fa fa-pause");//Change icon
                $(this).fadeOut("Slow");//Fade out
            }

            //If video is Paused
            if (event.data == YT.PlayerState.PAUSED) {
                $(this).fadeIn("Slow");//Fade out
                $(this).find('i').attr("class", "fa fa-play");
            }

            //If video is Buffering
            if (event.data == YT.PlayerState.BUFFERING) {
                $(this).find('i').attr("class", "fa fa-circle-o-notch fa-spin fa-fw");
            }

        });
    }



    //Bind Click and Touchstart events to the custom video button
    $( ".play-button-wrapper" ).bind("click touchstart", function() {

        //Find the active carousel slide and target the Iframe within it
        $("#video-carousel").find('.active iframe').each(function(){
            
            //Find the integer from the div ID and split - Use objectID[1] to output the integer
            var objectID = $(this).attr('id').split('-');

            
            //If the active slide's video is Playing
            if (videoArray[ objectID[1] ].getPlayerState() == 1) {
                videoArray[ objectID[1] ].pauseVideo();     //Pause video on click

            //If the active slide's video is Paused
            } else if (videoArray[ objectID[1] ].getPlayerState() == 2) {
                videoArray[ objectID[1] ].playVideo();      //Play video on click

            //If the video is doing anything else
            } else {
                videoArray[ objectID[1] ].playVideo();      //Play video on click
            }

        });
    });


     </script>
   
{/block}