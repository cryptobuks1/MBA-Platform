{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
   <div id="span_js_messages" style="display:none;">
    <span id="load_msg">{lang('loading')}</span>
</div> 

<div class="form-group">
<label>{lang('calculate_user_rank_cron')}</label>
<a href="{$BASE_URL}admin/cron/run_cron/rank" class="btn m-b-xs btn-md btn-primary" name="cron" id="cronid" value="cron" >{lang('calculate_user_rank_cron')}</a>
<div class="card mb-2 pink-gradient">
        <div class="card-body ">
          <div class="media">
            <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
            <h6 class="my-0">{lang('note_cron_status')}</h6>
          </div>
        </div>
      </div>
</div>
            
<div class="form-group">
<label>{lang('binary_commission_monthly_cron')}</label>
<a href="{$BASE_URL}admin/cron/run_cron/binary_bonus" class="btn m-b-xs btn-md btn-primary" name="cron" id="cronid" value="cron" >{lang('binary_commission_monthly_cron')}</a>
<div class="card mb-2 pink-gradient">
        <div class="card-body ">
          <div class="media">
            <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
            <h6 class="my-0">{lang('note_cron_status')}</h6>
          </div>
        </div>
      </div>
</div>
            
<div class="form-group">
<label>{lang('calculate_global_bonus_cron')}</label>
<a href="{$BASE_URL}admin/cron/run_cron/global_bonus" class="btn m-b-xs btn-md btn-primary" name="cron" id="cronid" value="cron" >{lang('calculate_global_bonus_cron')}</a>
<div class="card mb-2 pink-gradient">
        <div class="card-body ">
          <div class="media">
            <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
            <h6 class="my-0">{lang('note_cron_status')}</h6>
          </div>
        </div>
      </div>
</div>
            
 <div class="form-group">
<label>{lang('calculate_car_bonus_cron')}</label>
<a href="{$BASE_URL}admin/cron/run_cron/car_bonus" class="btn m-b-xs btn-md btn-primary" name="cron" id="cronid" value="cron" >{lang('calculate_car_bonus_cron')}</a>
<div class="card mb-2 pink-gradient">
        <div class="card-body ">
          <div class="media">
            <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
            <h6 class="my-0">{lang('note_cron_status')}</h6>
          </div>
        </div>
      </div>
</div>   

<div class="form-group">
<label>{lang('subscription_cron')}</label>
<a href="{$BASE_URL}admin/cron/reccuring_purchse" class="btn m-b-xs btn-md btn-primary" name="cron" id="cronid" value="cron" >{lang('subscription_cron')}</a>
<div class="card mb-2 pink-gradient">
        <div class="card-body ">
          <div class="media">
            <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
            <h6 class="my-0">{lang('note_cron_status')}</h6>
          </div>
        </div>
      </div>
</div>        
{/block}