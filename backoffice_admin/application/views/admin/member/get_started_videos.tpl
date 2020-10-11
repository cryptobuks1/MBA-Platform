{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<style>
/*.videos-grid {*/
/*  display:grid;*/
/*  grid-template-columns:1fr 1fr 1fr;*/
/*  grid-column-gap: 30px;*/
/*}*/

.videos-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap: 20px;
}

/*.videos-grid-video {*/
/*}*/

/*.videos-grid-video > iframe {*/
/*  height:270px;*/
/*}*/
.videos-grid-video {
    background: #eee;
    border: 1px solid #dadada;
}
</style>
<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('you_must_enter_subject')}</span>
    <span id="validate_msg2">{lang('you_must_enter_message')}</span>   
</div>


<div class="panel panel-default">
    <div class="tab">
        <div class="content">
                            {if count($videos) > 0}
            <div class="videos-grid">
            {foreach $videos as $video }

                <div class="videos-grid-video">
                     <h5>{$video['package_name']}</h5>
                     <div>
                <iframe width="100%" height="70%" src="https://player.vimeo.com/video/{substr($video['video_link'], 8)}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
               </div>
                <h5>{$video['video_description']}</h5>
                </div>
            {/foreach}
            </div>
                        {else}
            <h4 align="center">
                    <font>{lang('no_data')}</font>
                </h4>
                {/if}
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



   
{/block}