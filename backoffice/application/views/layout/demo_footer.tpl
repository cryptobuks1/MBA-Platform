<!----demo-->
{if DEMO_STATUS == "yes"}
<div class="panel-body setting_margin  demo_margin_top" id="demo_footer">
  <div class="m-b-xxl">
    <div class="panel no-border">
      <div class="wrapper-md">
        <div class="row">
          {if $is_preset_demo}               
            <div class="col-md-6">
              <p><i class="fa fa-check-circle"></i> You are viewing shared demo. Multiple users may try this demo simultaneously.</p>
              <p><i class="fa fa-check-circle"></i> Try  <a class="text-primary" href="https://infinitemlmsoftware.com/register.php" target="_blank">custom demo </a>as per your configurations.</p>
            </div>
          {else} 
            <div class="col-md-6">
              <p><i class="fa fa-check-circle"></i> Custom demo will be automatically deleted after 48 hours unless upgraded.</p>
              <p><i class="fa fa-check-circle"></i> You can upgrade custom demo to one month or can purchase the software.</p>
            </div>   
          {/if}
          <div class="col-md-6 b-l">
            <p><i class="fa fa-check-circle"></i> Once the demo is ready, you can simply move the demo to your own domain name.</p>
            {if $LOG_USER_TYPE=='admin'}<p><i class="fa fa-check-circle"></i> Click here to place a 
            <a class="text-primary" href="{$BASE_URL}admin/revamp/send_feedback" target="_blank">Feedback For Support </a></p>
            {/if}
           
          </div>
          {if !$is_preset_demo && $LOG_USER_TYPE=='admin'}
           <div class="col-md-12 text-center m-t-sm">
            <a class="btn m-b-xs btn-sm btn-primary btn-addon" href="{$BASE_URL}admin/revamp/revamp_update_plan"><i class="fa fa-plus"></i> Upgrade Now</a>
            </div>
            {/if}
        </div>
        <hr>
        
                 <div class="row">
         <div class="col-md-3">
         <ul class="social">
            <li><a href="#">  <i class="fa fa-newspaper-o"></i> </a> </li>
           <span class="m-t-sm">{if $is_app} <a class="font-bold " href="https://blog.infinitemlmsoftware.com" target="_blank">Infinite MLM Blog</a>
           {else}<div class="font-bold " href="" target="_blank">Infinite MLM Blog</div>{/if}</span>
          </ul>
         </div>
         <div class="col-md-3">
         <ul class="social">
            <li><a href="#">  <i class="fa fa-skype"></i> </a> </li>
           <span class="m-t-sm"> <div class="font-bold " href="" target="_blank">infinitemlm</div></span>
          </ul>
         </div>
         <div class="col-md-3">
         <ul class="social">
            <li><a href="#">  <i class="fa fa-whatsapp"></i> </a> </li>
           <span class="m-t-sm"> <div class="font-bold " href="" target="_blank">+91 9562-941-055</div></span>
          </ul>
         </div>
         <div class="col-md-3">
         <ul class="social">
            <li><a href="#">  <i class="fa fa-envelope"></i> </a> </li>
           <span class="m-t-sm"> <div class="font-bold " href="" target="_blank">support@ioss.in</div></span>
          </ul>
         </div>
         </div>
        
      </div>
    </div>
  </div>
</div>
{/if}

<!--end demo--> 


 
