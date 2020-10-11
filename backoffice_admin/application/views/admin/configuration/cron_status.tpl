{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
   <div id="span_js_messages" style="display:none;">
    <span id="load_msg">{lang('loading')}</span>
</div> 

<a href="{$BASE_URL}admin/cron/daily_investment" class="btn m-b-xs btn-md btn-primary" name="cron" id="cronid" value="cron" >{lang('ROI_cron')}</a>
<div class="card mb-2 pink-gradient">
        <div class="card-body ">
          <div class="media">
            <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
            <h6 class="my-0">{lang('note_cron_status')}</h6>
          </div>
        </div>
      </div>
{/block}