{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;"> <span id="left_join">{lang('left_join')}</span> <span id="right_join">{lang('right_join')}</span> <span id="join">{lang('joinings')}</span> <span id="confirm_msg">{lang('are_you_sure_want_delete')}</span> </div>
   {if $banner_count >0}
  <div class="fb-profile"> <a href="" class="wall-img-edit-btn"></a> 
  <a target="_blank" href="https://{$banner[0]['url']}">
  <img align="left" class="fb-image-lg" src="{$SITE_URL}/uploads/images/latest_uploads/{$banner[0]['image_name']}"/></a>
                <div class="edit_button"> </div>
                <div class="col-sm-9">
                </div>
                <div class="col-sm-12">
                </div>
 </div>
  {else}
        <h4 align="center">{lang('no_uploads')}</h4>
{/if}
 
            {if $count >0}
             {foreach from=$image_det item=v}
          <div class="panel panel-default">
                <div class="col-lg-4">
                      
                        <div class="panel-body">
                            <div class="clearfix text-center">
                                <div class="inline">
                                    <a target="_blank" href="https://{$v.url}"> <img src="{$SITE_URL}/uploads/images/latest_uploads/{$v.image_name}" style="height: 200px;"/></a>
                                </div>
                            </div>
                        </div>
                    
                   
                </div></div>
               {/foreach}  
   
    
{/if}
{/block}
<style>

</style>
  
     
  