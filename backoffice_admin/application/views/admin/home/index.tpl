 {extends file=$BASE_TEMPLATE}

{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}plugins/clipboard.min.js" type="text/javascript"></script>
    <script src="{$PUBLIC_URL}javascript/todo_config.js" type="text/javascript"></script>
    <script>
        country_map_data = {$map_data};
    </script>
{/block}


{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="left_join">{lang('left_join')}</span>
    <span id="right_join">{lang('right_join')}</span>
    <span id="join">{lang('joinings')}</span>
    <span id="confirm_msg">{lang('are_you_sure_want_delete')}</span>
</div>

{if $LOG_USER_TYPE!='employee'}

<input name="mlm_plan" id="mlm_plan" type="hidden" value="{$MLM_PLAN}" />
<div id="span_js_messages" style="display: none;"> <span id="left_join">{lang('left_join')}</span> <span id="right_join">{lang('right_join')}</span> <span id="join">{lang('joinings')}</span> <span id="confirm_msg">{lang('are_you_sure_want_delete')}</span> </div>
<div class="col">
    <div class="row">
        <div class="col-lg-6 col-md-12" id="section_tile">
            <div class="row row-sm text-center">
                {if $MODULE_STATUS['roi_status']=="yes"}
                 {block name='ewallet'}
                 <div class="col-xs-6">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">{$DEFAULT_SYMBOL_LEFT}{($roi_details*$DEFAULT_CURRENCY_VALUE)|round:2}{$DEFAULT_SYMBOL_RIGHT}</div>
                        <span class="text-muted text-xs">{if $MODULE_STATUS['hyip_status']=="yes"}{lang('total_deposit')}{else}{lang('Hyip')}{/if}</span>
                        <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                     <li class="text-center"><a href="{$BASE_URL}admin/roi_details">{lang('view_more')}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                 {/block}
                 {/if}

               {block name='mail'}
               {if {$MLM_PLAN} != "Donation"  && $MODULE_STATUS['hyip_status'] != "yes"}                 
                <div class="col-xs-6" id="section_tile4">
                   <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">
                            {$total_active_ibo}
                        </div>
                        <span class="text-muted text-xs">{lang('total_active_ibo')}</span>
                       
                    </div>
                </div>
                {/if}
                {/block}

                {block name='sales'}
                 {if {$MLM_PLAN} != "Donation"  && $MODULE_STATUS['hyip_status'] != "yes"}        
                <div class="col-xs-6" id="section_tile2">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1" id="sales_total">{$monthly_sales}</div>
                        <span class="text-muted text-xs">{lang('sales')}</span>
                        <div class="top text-right w-full">
                           {* <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right" id="sales_dash">
                                    <li class="active"><a href="javascript:void(0);" id="all_sales"><i class="fa fa-list margin-r-5"></i> {lang('all')}</a></li>
                                    <li><a href="javascript:void(0);" id="yearly_sales"><i class="fa fa-calendar margin-r-5"></i> {lang('this_year')}</a></li>
                                    <li><a href="javascript:void(0);" id="monthly_sales"><i class="fa fa-calendar margin-r-5"></i> {lang('this_month')}</a></li>
                                    <li><a href="javascript:void(0);" id="weekly_sales"><i class="fa fa-calendar margin-r-5"></i> {lang('this_week')}</a></li>
                                </ul>
                            </div>*}
                        </div>
                    </div>
                </div>
                {/if} 
                {/block}

                 <div class="col-xs-6" id="section_tile3">
                    <div class="panel padder-v item bg-info">
                        <div class="text-white font-thin h1 block1" id="total_payout">
                            {$active_user_count}
                        </div>
                        <span class="text-muted text-xs">{lang('active_user_count')}</span>
                       
                    </div>
                </div>

               {block name='mail'}
               {if {$MLM_PLAN} != "Donation"  && $MODULE_STATUS['hyip_status'] != "yes"}                 
                <div class="col-xs-6" id="section_tile4">
                   <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">
                            {$new_active_ibo}
                        </div>
                        <span class="text-muted text-xs">{lang('new_ibo')}</span>
                       
                    </div>
                </div>
                {/if}
                {/block}
                {if $MODULE_STATUS['ewallet_status']=="yes" && $MODULE_STATUS['roi_status'] == "no"} 
                {block name='ewallet'}
                <div class="col-xs-6" id="section_tile1">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">
                            {$read_mail}
                        </div>
                        <span class="text-muted text-xs">{lang('mail')}</span>
                       
                    </div>
                </div>
                 {/block}
                 {/if}
                 {block name='sales'}
                 {if {$MLM_PLAN} != "Donation"  && $MODULE_STATUS['hyip_status'] != "yes"}        
                <div class="col-xs-6" id="section_tile2">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1" id="sales_total">{$new_customer}</div>
                        <span class="text-muted text-xs">{lang('new_customer')}</span>
                        
                    </div>
                </div>
                {/if} 
                {/block}
                  <!---hyip section-->
                 {if {$MLM_PLAN} == "Unilevel" && $MODULE_STATUS['hyip_status']=="yes"} 
                    {block name='active_deposit'}
                     <div class="col-xs-6">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1">{$DEFAULT_SYMBOL_LEFT}{($total_active_deposit*$DEFAULT_CURRENCY_VALUE)|round:2}{$DEFAULT_SYMBOL_RIGHT}</div>
                        <span class="text-muted text-xs">{lang('active_deposit')}</span>
                        <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                     <li class="text-center"><a href="{$BASE_URL}admin/active_deposit">{lang('view_more')}</a></li>
                                </ul>
                            </div>
                        </div>
                      </div>
                    </div>
                    {/block}
                    {block name='matured_deposit'}
                    <div class="col-xs-6">
                        <div class="panel padder-v item">
                            <div class="text-info font-thin h1 block1">{$DEFAULT_SYMBOL_LEFT}{($total_matured_deposit*$DEFAULT_CURRENCY_VALUE)|round:2}{$DEFAULT_SYMBOL_RIGHT}</div>
                            <span class="text-muted text-xs">{lang('matured_deposit')}</span>

                            <div class="top text-right w-full">
                                <div class="dropdown">
                                    <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                    <ul class="dropdown-menu dropdown-menu_right">

                                        <li class="text-center"><a href="{$BASE_URL}admin/matured_deposit">{lang('view_more')}</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    {/block}
                {/if}
                 <!---end hyip section-->
                 
                 <!---DONATION TILE-->
                  {if {$MLM_PLAN} == "Donation"} 
                  <div class="col-xs-6">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1">{$DEFAULT_SYMBOL_LEFT}{$given_commission}{$DEFAULT_SYMBOL_RIGHT}</div>
                        <span class="text-muted text-xs">{lang('given_donation')}</span>
                         <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                   <li class="text-center"><a href="{$BASE_URL}admin/donation/given_donation_report"> {lang('view_more')}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-xs-6">
                    
                    <div class="panel padder-v item bg-white">
                        <div class="text-info font-thin h1 block1">{$DEFAULT_SYMBOL_LEFT}{$recieved_commission}{$DEFAULT_SYMBOL_RIGHT}</div>
                        <span class="text-muted text-xs">{lang('received_donation')}</span>
                          <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                     
                                    <li class="text-center"><a href="{$BASE_URL}admin/donation/recieve_donation_report">{lang('view_more')}</a></li>
                                     
                                </ul>
                            </div>
                        </div>
                         
                    </div> 
                </div>
                {/if}
                <!--END DONATION TILE-->
                
{block name='replica'}
                {if $MODULE_STATUS['replicated_site_status'] == "yes"}
                    <div class="col-xs-12" id="section_tile5">
                        <div class="panel item">
                            <div class="panel-body">
                                <div class="pull-right icon_margin_top">
                                    <button title="{lang('share_link')}" onclick="twittershare('{$site_url}/replica/{$LOG_USER_NAME}');" class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
                                    {* <button title="{lang('share_link')}" onclick="googlePlusShare('{$site_url}/replica/{$LOG_USER_NAME}');" class="btn btn-lg btn-icon btn-link text-danger"><i class="fa fa-google-plus"></i></button> *}
                                    <button title="{lang('share_link')}" onclick="facebookShare('https://www.facebook.com/sharer/sharer.php?u={$site_url}/replica/{$LOG_USER_NAME}');" class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
                                </div>
                                <div class="clear pull-left">
                                    <div class="text-left m-b-xs block">{lang('Your_Replicated_Website_Link')}<i class="icon-twitter"></i></div>
                                    
                                        <div data-clipboard-text="{$site_url}/replica/{$LOG_USER_NAME}" id="copy_link_replica" class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i class="fa fa-copy text-info"></i>{lang('copy_link')}</div>
                                         
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}
            {/block}
            
            </div>
        </div>
 <div class="col-lg-6 col-md-12" id="section_tile">
            <div class="row row-sm text-center">
                {if $MODULE_STATUS['roi_status']=="yes"}
                 {block name='ewallet'}
                 <div class="col-xs-6">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">{$DEFAULT_SYMBOL_LEFT}{($roi_details*$DEFAULT_CURRENCY_VALUE)|round:2}{$DEFAULT_SYMBOL_RIGHT}</div>
                        <span class="text-muted text-xs">{if $MODULE_STATUS['hyip_status']=="yes"}{lang('total_deposit')}{else}{lang('Hyip')}{/if}</span>
                        <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                     <li class="text-center"><a href="{$BASE_URL}admin/roi_details">{lang('view_more')}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                 {/block}
                 {/if}

                {if $MODULE_STATUS['ewallet_status']=="yes" && $MODULE_STATUS['roi_status'] == "no"} 
                {block name='ewallet'}
                <div class="col-xs-6" id="section_tile1">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">
                            {$business_summery}
                        </div>
                        <span class="text-muted text-xs">{lang('revenue')}</span>
                       
                    </div>
                </div>
                 {/block}
                 {/if}

                      
                 {block name='payout'}
                <div class="col-xs-6" id="section_tile3">
                    <div class="panel padder-v item bg-info">
                        <div class="text-white font-thin h1 block1" id="total_payout">
                            {$total_payout}
                        </div>
                        <span class="text-muted text-xs">{lang('payout')}</span>
                       
                    </div>
                </div>
               {/block}
               

               
                <div class="col-xs-6" id="section_tile2">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1" id="sales_total">{$total_commission_paid}</div>
                        <span class="text-muted text-xs">{lang('commission_due')}</span>
                       
                    </div>
                </div>

                              
                {block name='sales'}
                 {if {$MLM_PLAN} != "Donation"  && $MODULE_STATUS['hyip_status'] != "yes"}        
               <div class="col-xs-6" id="section_tile1">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">{$total_sales}</div>
                        <span class="text-muted text-xs">{lang('total_sales')}</span>
                        <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right" id="sales_dash">
                                    <li class="active"><a href="javascript:void(0);" id="all_sales"><i class="fa fa-list margin-r-5"></i> {lang('all')}</a></li>
                                    <li><a href="javascript:void(0);" id="yearly_sales"><i class="fa fa-calendar margin-r-5"></i> {lang('this_year')}</a></li>
                                    <li><a href="javascript:void(0);" id="monthly_sales"><i class="fa fa-calendar margin-r-5"></i> {lang('this_month')}</a></li>
                                    <li><a href="javascript:void(0);" id="weekly_sales"><i class="fa fa-calendar margin-r-5"></i> {lang('this_week')}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {/if} 
                {/block}
              <div class="col-xs-6" id="section_tile4">
                    <div class="panel padder-v item">
                        <div class="font-thin text-info h1" id="mail_total">{$total_profit_date}</div>
                        <span class="text-muted text-xs">{lang('net_profit')}</span>
                        <div class="top text-right w-full">
                           
                        </div>
                    </div>
                </div>

                      
                <div class="col-xs-6" id="section_tile2">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1" id="sales_total">{$ewallet_balance}</div>
                        <span class="text-muted text-xs">{lang('ewallet_balance')}</span>
                       
                    </div>
                </div>

           
            </div>
       
         {block name='lcp'}
                {if $MODULE_STATUS['lead_capture_status'] == "yes"}
                    <!-- <div class="col-xs-12" id="section_tile6">
                        <div class="panel item">
                            <div class="panel-body">
                                <div class="pull-right icon_margin_top">
                                    <button title="{lang('share_link')}" onclick="twittershare('{$site_url}/lcp/{$LOG_USER_NAME}');" class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
                                    {* <button title="{lang('share_link')}" onclick="googlePlusShare('{$site_url}/lcp/{$LOG_USER_NAME}');" class="btn btn-lg btn-icon btn-link text-danger"><i class="fa fa-google-plus"></i></button> *}
                                    <button title="{lang('share_link')}" onclick="facebookShare('https://www.facebook.com/sharer/sharer.php?u={$site_url}/lcp/{$LOG_USER_NAME}');" class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
                                </div>
                                <div class="clear pull-left">
                                    <div class="text-left m-b-xs block">{lang('Your_Lead_Capture_Page')}<i class="icon-twitter"></i></div>
                                    
                                        <div id="copy_link_lcp" data-clipboard-text="{$site_url}/lcp/{$LOG_USER_NAME}" class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i class="fa fa-copy text-info"></i>{lang('copy_link')}</div>
                                         
                                </div>
                            </div>
                        </div>
                    </div> -->
                {/if}
            {/block}
            
            <div class="col-xs-12" id="section_tile6">
                <div class="panel item">
                    <div class="panel-body">
                        <div class="clear pull-left">
                            <div class="text-left m-b-xs block">{lang('total_users')}<i class="icon-twitter"></i></div>
                            <div class="font-thin h2 block1" id="sales_total">{$total_users}</div>
                        </div>
                    </div>
                </div>
            </div>
            
             </div>
    </div>
  <div class="panel hbox hbox-auto-xs no-border">
    {block name='joinings'} 
        <div class="col wrapper">
            <div class="dropdown pull-right">
                <div data-toggle="dropdown" aria-expanded="false"><i class="fas fa fa-cog fa-spin"></i></div>
                <ul class="dropdown-menu dropdown-menu_right" id="joinings_graph">
                    <li class="active"><a id="yearly_joining_graph" href="javascript:void(0);"><i class="fa fa-calendar margin-r-5"></i> {lang('year')}</a></li>
                    <li><a id="monthly_joining_graph" href="javascript:void(0);"><i class="fa fa-calendar margin-r-5"></i> {lang('month')}</a></li>
                    <li><a id="daily_joining_graph" href="javascript:void(0);"><i class="fa fa-calendar margin-r-5"></i> {lang('day')}</a></li>
                </ul>
            </div>
            <h4 class="font-thin m-t-none m-b-none">{lang('current_joinings')}</h4>
            <span class="m-b block text-sm text-muted"></span>
            <div id="joining_graph_div"  style="height: 240px;"></div>
        </div>
        {if count($prgrsbar_data) > 0 && $MODULE_STATUS['product_status'] == 'yes'}
            <div class="col wrapper-lg w-lg bg-light dk r-r">
                <h4 class="font-thin m-t-none m-b">{lang('membership')}</h4>
                {$j=0}
                <div class="">
                    {assign var=text_class value=['text-primary','text-primary','text-primary','text-primary']}
                    {assign var=bg_class value=['bg-primary','bg-primary','bg-primary','bg-primary']}
                    {foreach from=$prgrsbar_data item=v}
                        <div class="">
                            <span class="pull-right {$text_class[$j]}">{$v.joining_count}</span>
                            <span>{$v.package_name}</span>
                        </div>
                        <div class="progress progress-xs m-t-sm bg-white">
                            <div class="progress-bar {$bg_class[$j]}" data-toggle="tooltip" data-original-title="{$prgrsbar_data[0]['perc'] * $v.joining_count}%" style="width: {$prgrsbar_data[0]['perc'] * $v.joining_count}%"></div>
                        </div>
                        {$j=$j+1}
                    {/foreach}
                </div>
                {if $j > 3}
                    <div class="pull-right margin_top_mobile">
                        <a href="{$BASE_URL}admin/home/package_list" class="read_more bg-primary">{lang('view_more')}</a>
                    </div>
                {/if}
            </div>
        {/if}
    {/block} 
    </div>
    {block name='to_do'} 
    <div class="panel wrapper">
        <div class="row">
            <div class="col-md-6 b-r b-light no-border-xs">
                <a href="javascript:loadModal(1, '{lang('to_do_list')}', 'admin/home/add_todo');" data-toggle="modal" class="text-muted pull-right text-lg" title="{lang('add_task')}"><i class="icon-plus"></i></a>
                <h4 class="font-thin m-t-none m-b-md text-muted">{lang('to_do_list')}</h4>
                <div class=" m-b todo_list_height">
                    {$i = 0}
                    {$todo_pending = 0}
                    {$todo_done = 0}
                    {foreach from=$todo_list item=v}
                        {if $v.status == 'completed'}
                            {$todo_done = $todo_done + 1}
                        {else}
                            {$todo_pending = $todo_pending + 1}
                        {/if}
                        {form_open('admin/home/delete_todo','role="form" class="" method="post" name="todo_register" id="todo_form"')}
                            <input type='hidden' name="tsk_id" id="tsk_id" value="{$v.task_id}">
                            <div class="m-b">
                                <div class="pull-right m-l">
                                    <span class="label text-base bg-light pos-rlt m-r">
                                        <i class="arrow right arrow-light"></i>
                                        {$v.time}
                                    </span>
                                    <button type="submit" class="btn-link h4 text-danger" onclick="return deleteTask();" title={lang('delete')}><i class="fa fa-trash-o"></i></button>
                                    <button type="button" class="btn-link h4 text-info" onclick="loadModal({$v.task_id}, '{lang('to_do_list')}', 'admin/home/edit_todo');" title="{lang('edit_list')}"><i class="fa fa-edit"></i></button>
                                </div>
                                <div class="clear">
                                    <a href="javascript:void(0);" class=" block m-b-sm">
                                        <div class="checkbox">
                                            <label class="i-checks">
                                                <input type="checkbox" onclick="statusChange({$v.task_id}, $(this));" {if $v.status == 'completed'} checked {/if}>
                                                <i></i>{$v.task|truncate:15}
                                            </label>
                                        </div>
                                        <i class="icon-twitter"></i>
                                    </a>
                                </div>
                            </div>
                        {form_close()}
                        {$i = $i++}
                    {/foreach}
                    {if count($todo_list) <= 0}
                        <div>{lang('no_data_found')}</div>
                    {/if}
                </div>
            </div>
            {$todo_done_percent = 0}
            {$todo_pending_percent = 0}
            {if count($todo_list) > 0}
                {$todo_done_percent = ($todo_done / count($todo_list)) * 100}
                {$todo_pending_percent = ($todo_pending / count($todo_list)) * 100}
            {/if}
            <input type="hidden" id="todo_done_percent" value="{$todo_done_percent}">
            <input type="hidden" id="todo_pending_percent" value="{$todo_pending_percent}">
            <div class="col-md-6">
                <div class="row row-sm">
                    <div class="col-xs-6 text-center">
                        <div id="todo_done" class="inline m-t">
                            <div><span class="text-primary h4">{$todo_done_percent|round}%</span></div>
                        </div>
                        <div class="text-muted font-bold text-base m-t m-b">{lang('done')}</div>
                    </div>
                    <div class="col-xs-6 text-center">
                        <div id="todo_pending" class="inline m-t">
                            <div> <span class="text-info h4">{$todo_pending_percent|round}%</span> </div>
                        </div>
                        <div class="text-muted font-bold text-base m-t m-b">{lang('pending')}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/block}
    <div class="row">
    {block name='top_earners'} 
        <div class="col-md-6" style="min-height:640px;">
            <div class="panel no-border" id="section_top_earners">
                <div class="panel-heading wrapper b-b b-light">
                    <h4 class="font-thin m-t-none m-b-none text-muted">{lang('top_earners')}</h4>
                </div>
                <ul class="list-group list-group-lg m-b-none">
                    {assign var="i" value=0 }
                    {foreach from=$top_earners item=j}
                        <li class="list-group-item">
                            <a href="javascript:void(0);" class="thumb-sm m-r">
                                <img src="{$j['profile_picture_full']}" class="r r-2x">
                            </a>
                             <span class="pull-right text-muted inline m-t-sm">{$j['place']}</span><!--balance_amount-->
                            <a href="javascript:void(0);">{$j['user_name']}</a>
                        </li>
                        {$i=$i+1}
                    {/foreach}
                    {if $i==0}
                        <li class="list-group-item">{lang('no_data_found')}</li>
                    {/if}
                </ul>
            </div>
        </div>
    {/block}

    {block name='social_media'}            
        <div class="col-md-6">
            <div class="list-group list-group-lg list-group-sp" id="section_social_media">
                <a href="{$social_media_info['fb_link']}" target="_blank" class="list-group-item clearfix">
                    <span class="pull-left m-r">
                        <button class="btn btn-rounded btn-lg btn-icon btn-facebook">
                            <i class="fa fa-facebook"></i>
                        </button>
                    </span>
                    <span class="clear">
                        <span>{lang('facebook_users')}</span>
                        <span class="social_iocs pull-center hidden-xs">{lang('facebook')}</span>
                        <small class="text-muted clear text-ellipsis">{$social_media_info['fb_count']} +</small>
                    </span>
                </a>
                {* <a href="{$social_media_info['gplus_link']}" target="_blank" class="list-group-item clearfix">
                    <span class="pull-left m-r">
                        <button class="btn btn-rounded btn-lg btn-icon btn-lkin">
                            <i class="fa fa-linkedin"></i>
                        </button>
                    </span>
                    <span class="clear">
                        <span>{lang('linkedin_users')}</span>
                        <span class="social_iocs pull-center hidden-xs">{lang('linkedin')}</span>
                        <small class="text-muted clear text-ellipsis">{$social_media_info['gplus_count']} +</small>
                    </span>
                </a> *}
                <a href="{$social_media_info['twitter_link']}" target="_blank" class="list-group-item clearfix">
                    <span class="pull-left m-r">
                        <button class="btn btn-rounded btn-lg btn-icon btn-info">
                            <i class="fa fa-twitter"></i>
                        </button>
                    </span>
                    <span class="clear">
                        <span>{lang('twitter_users')}</span>
                        <span class="social_iocs pull-center hidden-xs">{lang('twitter')}</span>
                        <small class="text-muted clear text-ellipsis">{$social_media_info['twitter_count']} +</small>
                    </span>
                </a>
                <a href="{$social_media_info['inst_link']}" target="_blank" class="list-group-item clearfix">
                    <span class="pull-left m-r">
                        <button class="btn btn-rounded btn-lg btn-icon btn-instagarm">
                            <i class="fa fa-instagram"></i>
                        </button>
                    </span>
                    <span class="clear">
                        <span>{lang('instagram_users')}</span>
                        <span class="social_iocs pull-center hidden-xs">{lang('instagram')}</span>
                        <small class="text-muted clear text-ellipsis">{$social_media_info['inst_count']} +</small>
                    </span>
                </a>
            </div>
        </div>
    {/block}
    </div>
</div>

{/if}

  
<br>
 



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="reservation_detail_model" data-backdrop="static"
    class="modal fade" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                <h4 class="modal-title" id="modaltitle"></h4>
            </div>
            <div class="modal-body" id="reservation_detail_model_body">
            </div>
        </div>
    </div>
</div>


<!---POPUP DESIGN--->
 
{if $DEMO_STATUS == 'yes'}
    {if $is_preset_demo}
      <div class="modal fade text-center py-5"  id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md index" role="document">
                <div class="modal-content_1 b-white">
                    <div class="modal-body backgound_modal">
                    <div class="p-3">
                        <button aria-hidden="true" data-dismiss="modal" class="close text-white" type="button"><i class="icon-close"></i></button>
                    <h3 class="modal-title text-white">
                     <img style="width: 60px;" src="https://infinitemlmsoftware.com/wp-content/uploads/2018/08/medium_box-only.png"> 
                    Notice</h3>
                    
                        <p class="text-white"><small>You are viewing shared demo. Multiple users may try this demo simultaneously.Try<a class="h4 text-warning" href="https://infinitemlmsoftware.com/register.php" target="_blank" > custom demo </a>as per your configurations</small> </p>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div> 
    {/if}
{/if}
<!---END POPUP DESIGN-->

<style>
.demo_section {
    
    display: none ;
}
.setting_margin_top {
    
        margin-top: -50px;
}
.setting_margin{
        margin-left: 230px;
}
.wrapper_index{
    
    padding:15px
}
.demo_margin_top {
    
    margin-top: -30px;
}
.modal-content_1 {
     background-color: #c713138c;
    
}
.modal-content_1 {
    position: relative;
     
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #999;
    border: 1px solid rgba(255, 255, 255, 0.58);
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
    box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
}
@media (max-width:767px)
{
.demo_section {
    
    display: block;
}  
   .moblie_demo {
    
 display: none ;
     
} 
.setting_margin {
    margin-left: 0px;
}

.setting_margin_top {
    margin-top: -49px !important;
}
.demo_margin_top {
    margin-top: -27px !important;
}
}
</style>
{/block}

{if $LOG_USER_TYPE!='employee'}

{block name=right_content}

<div class="col w-md  bg-auto no-border-xs b-r" id="right_section">
   {block name=new_members}
    <div class="b-l bg-white  tab-content" id="right_section_new_member">
        <div role="tabpanel" class="tab-pane active" id="tab-1">
            <div class="wrapper-md">
                <div class="bg-primary text-center wrapper-sm m-l-n-new m-r-n">{lang('new_members')|capitalize}</div>
                <ul class="list-group no-bg no-borders pull-in list_link">
                    {assign var="i" value=0 }
                    {foreach from=$latest_joinees item=j}
                        <li class="list-group-item">
                            <a href="javascript:void(0);" class="pull-left thumb-sm m-r">
                                <img src="{$j['profile_picture_full']}">
                            </a>
                            <div class="clear">
                                <div><a href="javascript:void(0);">{$j['user_name']}</a></div>
                                <span class="text-muted">{$j['date_of_joining']}</span>
                            </div>
                        </li>
                        {$i=$i+1}
                    {/foreach}
                    {if $i==0}
                        <li class="list-group-item">{lang('no_data_found')}</li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
    {/block}
    {block name=top_recruiters}
    <div class="b-l bg-white padder-md height_top_recruiters" id="right_section_top_recruiter">
        <div class="streamline  m-b">
            <div class="bg-primary wrapper-sm m-l-n m-r-n m-b text-center">{lang('top_recruiters')}</div>
            {assign var="i" value=0}
            {foreach from=$top_recruters item=j}
                {$i=$i+1}
                {$k=fmod($i, 4)}
                <div class="sl-item b-l {if $k==1}b-primary{elseif $k==2}b-warning{elseif $k==3}b-info{/if}">
                    <div class="m-l margin-list-mobile">
                        <li class="list-group-item">
                            <a href="javascript:void(0);" class="pull-left thumb-sm m-r">
                                <img src="{$j['profile_picture_full']}">
                            </a>
                            <div class="clear">
                                <div><a href="javascript:void(0);">{$j.user_name}</a></div>
                                <span class="text-muted">{$j.count}</span>
                            </div>
                        </li>
                    </div>
                </div>
            {/foreach}
            {if $i==0}
                <div class="sl-item b-l b-primary">
                    <div class="m-l">
                        <li class="list-group-item">{lang('no_data_found')}</li>
                    </div>
                </div>
            {/if}
        </div>
        
    </div>
   {/block}
</div>

{/block}

{/if}

{if $LOG_USER_TYPE!='employee'}
{block name=home_wrapper_out}
    {include file="admin/configuration/system_setting_common.tpl"}
    {include file="layout/demo_footer.tpl"}
{/block}
{/if}
