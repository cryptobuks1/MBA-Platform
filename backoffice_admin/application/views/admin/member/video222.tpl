{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<style>
.videos-grid {
  display:grid;
  grid-template-columns:1fr 1fr 1fr;
  grid-column-gap: 30px;
}

.videos-grid-video {
}

.videos-grid-video > iframe {
  height:270px;
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('you_must_enter_subject')}</span>
    <span id="validate_msg2">{lang('you_must_enter_message')}</span>   
</div>


<div class="panel panel-default">
    <div class="tab">
        <div class="content">
            <div class="videos-grid">
            {foreach $videos as $video }
                <div class="videos-grid-video"><h3>{$video['package_name']}</h3>
                    <h5>{$video['video_description']}</h5>
                <iframe width="100%" height="100%" src="https://player.vimeo.com/video/{substr($video['video_link'], 8)}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            {/foreach}
            </div>
        </div>
        <ul class="pagination">
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
  </ul>
    </div>
</div>
{/block}
                
{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}/javascript/validate_invite_wallpost.js"></script>

  



  <script src="{$PUBLIC_URL}/javascript/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>

    <script src="{$PUBLIC_URL}javascript/fullcalendar/lib/jquery.min.js" type="text/javascript"></script>


     <script src="{$PUBLIC_URL}javascript/fullcalendar/lib/moment.min.js" type="text/javascript"></script>



   
{/block}