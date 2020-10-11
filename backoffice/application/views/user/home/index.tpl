{extends file=$BASE_TEMPLATE}

{block name=script}
{$smarty.block.parent}
<script src="{$PUBLIC_URL}plugins/clipboard.min.js" type="text/javascript"></script>
<script src="{$PUBLIC_URL}javascript/todo_config.js" type="text/javascript"></script>
<script>
  country_map_data = {
    $map_data
  };
</script>
{/block}
{if $join_type =='affiliate'}
{block name=$CONTENT_BLOCK}
<style>
  .demo_section {

    display: none;
  }

  .setting_margin_top {

    margin-top: -50px;
  }

  .setting_margin {
    margin-left: 230px;
  }

  .wrapper_index {

    padding: 15px
  }

  .demo_margin_top {

    margin-top: -30px;
  }

  .demo_footer_user {
    margin-top: -50px;
  }

  < !--opoup-->.demo_margin_top {

    margin-top: -30px;
  }

  .modal-content_1 {
    background-color: #fff;

  }

  .pager {

    margin: 0px 0;
    box-shadow: 0px 2px 17px 0px #19191942;
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

  .modal-dialog.modal-md.index {
    width: 35%;
    top: 7%;
    margin: 0 auto;
    position: relative;
    right: 0;
  }

  div#subscribeModal {
    padding-right: 0px !important;
  }





  @media (max-width:767px) {
    .demo_section {

      display: block;
    }

    .moblie_demo {

      display: none;

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

    .modal-content_1 {
      background-color: #fff !important;

    }
  }
</style>
{include file="user/home/rank_popup.tpl"}
<div id="span_js_messages" style="display: none;"> <span id="left_join">{lang('left_join')}</span> <span
    id="right_join">{lang('right_join')}</span> <span id="join">{lang('joinings')}</span> <span
    id="confirm_msg">{lang('are_you_sure_want_delete')}</span> </div>
<input name="mlm_plan" id="mlm_plan" type="hidden" value="{$MLM_PLAN}" />
<div class="col-sm-12">
  <div class="row">
    <div class="row row-sm text-center"> {if $MODULE_STATUS['roi_status']=="yes"}
      <div class="col-sm-4">
        <div class="panel padder-v item">
          <div class="h1 text-info font-thin h1">
            {$DEFAULT_SYMBOL_LEFT}{($roi_details*$DEFAULT_CURRENCY_VALUE)|round:2}{$DEFAULT_SYMBOL_RIGHT}</div>
          <span class="text-muted text-xs">{if
            $MODULE_STATUS['hyip_status']=="yes"}{lang('total_deposit')}{else}{lang('Hyip')}{/if}</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right">
                <li class="text-center"><a href="">{lang('view_more')}</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      {/if}
      {if $MODULE_STATUS['ewallet_status']=="yes" && $MODULE_STATUS['roi_status'] == "no"}
      <div class="col-sm-4" id="section_tile1">
        <div class="panel padder-v item">
          <div class="h1 text-info font-thin h1"> {$total_amount} </div>
          <span class="text-muted text-xs">{lang('commission_earned')}</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
            </div>
          </div>
        </div>
      </div>
      {/if}
      {if {$MLM_PLAN} != "Donation" && $MODULE_STATUS['hyip_status'] != "yes"}
      <div class="col-sm-4" id="section_tile2">
        <div class="panel padder-v item bg-primary">
          <div class="text-white font-thin h1 block1" id="sales_total">{$total_payout}</div>
          <span class="text-muted text-xs">{lang('payout_released')}</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      {/if}
      <div class="col-sm-4" id="section_tile2">
        <div class="panel padder-v item bg-primary">
          <span class="text-muted text-xs">{lang('left_team')}</span>
          <div class="text-white font-thin  block1" id="sales_total">USERS : {$total_left_user_count}</div>
          <div class="text-white font-thin  block1" id="sales_total">BV : {$total_left_user_pv}</div>

          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4" id="section_tile3">
        <div class="panel padder-v item bg-info">
          <div class="text-white font-thin h1 block1" id="total_payout"> {$requested_amount} </div>
          <span class="text-muted text-xs">{lang('payout_pending')}</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right" id="payout_dash">
                <li class="active"><a href="javascript:void(0);" id="all_payout"><i class="fa fa-list margin-r-5"></i>
                    {lang('all')}</a></li>
                <li><a href="javascript:void(0);" id="yearly_payout"><i class="fa fa-calendar margin-r-5"></i>
                    {lang('this_year')}</a></li>
                <li><a href="javascript:void(0);" id="monthly_payout"><i class="fa fa-calendar margin-r-5"></i>
                    {lang('this_month')}</a></li>
                <li><a href="javascript:void(0);" id="weekly_payout"><i class="fa fa-calendar margin-r-5"></i>
                    {lang('this_week')}</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-2" id="section_tile2">
        <div class="panel padder-v item bg-primary">
          <div class="text-white font-thin h1 block1" id="sales_total">{$total_sales}</div>
          <span class="text-muted text-xs">{lang('total_sales')}</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-2" id="section_tile2">
        <div class="panel padder-v item bg-info">
          <div class="text-white font-thin h1 block1" id="sales_total">{$total_users}</div>
          <span class="text-muted text-xs">{lang('total_users')}</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4" id="section_tile2">
        <div class="panel padder-v item bg-primary">

          <span class="text-muted text-xs">{lang('right_team')}</span>
          <div class="text-white font-thin block1" id="sales_total">USERS : {$total_right_user_count}</div>
          <div class="text-white font-thin  block1" id="sales_total">BV : {$total_right_user_pv}</div>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      <!---hyip section-->
      {if {$MLM_PLAN} =="Unilevel" && $MODULE_STATUS['hyip_status']=="yes"}

      <div class="col-xs-6">
        <div class="panel padder-v item bg-info">
          <div class="text-info font-thin h1 block1">
            {$DEFAULT_SYMBOL_LEFT}{($total_matured_deposit*$DEFAULT_CURRENCY_VALUE)|round:2}{$DEFAULT_SYMBOL_RIGHT}
          </div>
          <span class="text-muted text-xs"> {lang('matured_deposit')}</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right">
                <li class="text-center"><a href="{$BASE_URL}user/matured_deposit"> {lang('view_more')}</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      {/if}
      <!---end hyip section-->

      <!---DONATION TILE-->
      {if {$MLM_PLAN} == "Donation"}
      <div class="col-xs-6">
        <div class="panel padder-v item bg-primary">
          <div class="text-white font-thin h1 block1">{$DEFAULT_SYMBOL_LEFT}{$given_commission}{$DEFAULT_SYMBOL_RIGHT}
          </div>
          <span class="text-muted text-xs">{lang('given_donation')}</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right">
                <li class="text-center"><a href="{$BASE_URL}user/donation/sent_donation_report"> View More</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="panel padder-v item bg-info">
          <div class="text-white font-thin h1 block1">
            {$DEFAULT_SYMBOL_LEFT}{$recieved_commission}{$DEFAULT_SYMBOL_RIGHT}</div>
          <span class="text-muted text-xs">{lang('received_donation')}</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right">
                <li class="text-center"><a href="{$BASE_URL}user/donation/recieve_donation_report"> View More</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!--END DONATION TILE-->

      <div class="col-xs-12 m-b-md">
        <div class="r bg-light dker item hbox no-border">
          <div class="col w-xs v-middle hidden-md">
            <div class="sparkline inline">
              <button class="btn btn-sm btn-primary" type="submit">
                <a class="btn1 btn-4 btn-4a icon-arrow"
                  href="{$BASE_URL}user/donation/donation_view">{lang('donate')}</a>
              </button>
            </div>
          </div>
          <div class="col dk padder-v r-r">
            <div class="text-primary-dk font-thin h1"><span>{$level_name}</span></div>
            <span class="text-muted text-xs">{lang('your_current_status')}</span>
          </div>
        </div>
      </div>
      {/if}
    </div>


  </div>

  <div class="row">
    <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{lang('personal_data')}</h4>
        </div>
        <div class="row" style="margin:1px;min-height:210px !important;">
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Username</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$LOG_USER_NAME}</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Total Personal Volume</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$personal_pv}</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Current Rank</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$rank_name}</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Highest Rank Achieved</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$highest_rank}</label>
          </div>
        </div>
      </div>
    </div>


    <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{lang('earnings')}</h4>
        </div>
        <div class="row" style="margin:1px;min-height:210px;">
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('last_7_days')}</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            {if $last_week_earnings==NULL}
            <label>00</label>
            {else}
            <label>{$last_week_earnings}</label>
            {/if}
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('last_30_days')}</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            {if $last_month_earnings==NULL}
            <label>00</label>
            {else}
            <label>{$last_month_earnings}</label>
            {/if}

          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('avg_earnings')}</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            {if $avg_earnings==NULL}
            <label>00</label>
            {else}
            <label>{$avg_earnings}</label>
            {/if}

          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('year_earnings')}</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            {if $year_earnings==NULL}
            <label>00</label>
            {else}
            <label>{$year_earnings}</label>
            {/if}
          </div>

        </div>
      </div>
    </div>
    {* <br />
    <br /> *}
    <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{$LOG_USER_NAME}</h4>
          <div>{lang('package')} : <b>{$current_product}</b></div>
          <a href="profile_view">{lang('view_profile')}</a>
        </div>
        <div class="row" style="margin:1px;min-height:175px;">
          <div class="col-sm-5" style="margin-top:10px;">
            <label>{lang('sponsor_name')}</label>
          </div>
          <div class="col-sm-5" style="margin-top:10px;">
            <label>{$sponsor_name}</label>
          </div>
          <div class="col-sm-5" style="margin-top:10px;">
            <label>{lang('placement_user_name')}</label>
          </div>
          <div class="col-sm-5" style="margin-top:10px;">
            <label>{$placement_name}</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('gpv')}</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$group_pv}</label>
          </div>

        </div>
      </div>
    </div>

     {* NEXT RANK *}
    <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{lang('next_rank_achievement')}</h4>
        </div>
        <div class="row" style="margin:1px;min-height:210px;">
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('nex_rank')}</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$next_rank}</label>
          </div>

  <div class="col-sm-8" style="margin-top:10px;">
            <label>Current Referral Count</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$total_users} </label>
          </div>
            <div class="col-sm-8" style="margin-top:10px;">
            <label>Referral count required for {$next_rank}</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$rankCriteria["next_rank"]["referral_count"]}</label>
          </div>

                <div class="col-sm-8" style="margin-top:10px;">
            <label>Referral count still required</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{max($rankCriteria.next_rank.referral_count-$rankCriteria.current_rank.referral_count,0)}</label>
          </div>


          <div class="col-sm-8" style="margin-top:10px;">
            <label>Total Personal Volume</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$personal_pv}</label>
          </div>

            <div class="col-sm-8" style="margin-top:10px;">
            <label>Personal PV required for {$next_rank}</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$rankCriteria["next_rank"]["personal_pv"]}</label>
          </div>

          <div class="col-sm-8" style="margin-top:10px;">
            <label>PV still required</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{max($rankCriteria.next_rank.personal_pv-$rankCriteria.current_rank.personal_pv,0)}</label>
          </div>
        
        
          {* <div class="col-sm-8" style="margin-top:10px;">
            <label>Referral count required to rank up</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>TODO </label>
          </div> *}
        
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Weak leg BV required to rank up to {$next_rank}</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label>{$rankCriteria["next_rank"]["group_pv"]} </label>
          </div>
          
        </div>
      </div>
    </div>
    {* EXTRA STUFF *}

    {* <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{$LOG_USER_NAME}</h4>
          <div>{lang('package')} : <b>{$current_product}</b></div>
          <a href="profile_view">{lang('view_profile')}</a>
        </div>
        <div class="row" style="margin:1px;min-height:175px;">
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('sponsor_name')}</label>
          </div>
          <div class="col-sm-1" style="margin-top:10px;">
            <label>{$sponsor_name}</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('placement_user_name')}</label>
          </div>
          <div class="col-sm-1" style="margin-top:10px;">
            <label>{$placement_name}</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('pv')}</label>
          </div>
          <div class="col-sm-1" style="margin-top:10px;">
            <label>{$personal_pv}</label>
          </div>
          <!-- <div class="col-sm-8" style="margin-top:10px;">
                <label>{lang('gpv')}</label>
            </div>
            <div class="col-sm-2" style="margin-top:10px;">
                <label>{$group_pv}</label>
            </div> -->

        </div>
      </div>
    </div>
    *}
    {* EXTRA EXTRA STUFF *}
    {* <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{$LOG_USER_NAME}</h4>
          <div>{lang('package')} : <b>{$current_product}</b></div>
          <a href="profile_view">{lang('view_profile')}</a>
        </div>
        <div class="row" style="margin:1px;min-height:175px;">
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('sponsor_name')}</label>
          </div>
          <div class="col-sm-1" style="margin-top:10px;">
            <label>{$sponsor_name}</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('placement_user_name')}</label>
          </div>
          <div class="col-sm-1" style="margin-top:10px;">
            <label>{$placement_name}</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>{lang('pv')}</label>
          </div>
          <div class="col-sm-1" style="margin-top:10px;">
            <label>{$personal_pv}</label>
          </div>
        </div>
      </div>
    </div> *}


  </div>

  <div class="row">
    <div class="col-sm-4">
      <div class="panel no-border" id="section_top_earners" style="min-height:640px;">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{lang('top_earners')}</h4>
        </div>
        <ul class="list-group list-group-lg m-b-none">
          {assign var="i" value=0 }
          {foreach from=$top_earners item=j}
          <li class="list-group-item"> <a href="javascript:void(0);" class="thumb-sm m-r"> <img
                src="{$j['profile_picture_full']}" class="r r-2x"> </a>
            <span class="pull-right text-muted inline m-t-sm">{$j['place']}</span>
            <!--balance_amount-->
            <a href="javascript:void(0);">{$j['user_name']}</a> </li>
          {$i=$i+1}
          {/foreach}
          {if $i==0}
          <li class="list-group-item">{lang('no_data_found')}</li>
          {/if}
        </ul>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{lang('top_recruiters')}</h4>
        </div>
        <ul class="list-group list-group-lg m-b-none">
          {assign var="i" value=0 }
          {foreach from=$top_recruters item=j}
          <li class="list-group-item"><a href="javascript:void(0);"> {$j.user_name}</a>
            <span class="pull-right">{$j.count}</span></li>
          {$i=$i+1}
          {/foreach}
          {if $i==0}
          <li class="list-group-item">{lang('no_data_found')}</li>
          {/if}
        </ul>
      </div>
    </div>
    <div class="col-sm-4">
      {if $MODULE_STATUS['replicated_site_status'] == "yes"}
      <div class="col-xs-12" id="section_tile5">
        <div class="panel item">
          <div class="panel-body">
            <div class="pull-right icon_margin_top">
              <button title="{lang('share_link')}" onClick="twittershare('{$site_url}/replica/{$LOG_USER_NAME}');"
                class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
              {* <button title="{lang('share_link')}" onClick="googlePlusShare('{$site_url}/replica/{$LOG_USER_NAME}');"
                class="btn btn-lg btn-icon btn-link text-danger"><i class="fa fa-google-plus"></i></button> *}
              <button title="{lang('share_link')}"
                onClick="facebookShare('https://www.facebook.com/sharer/sharer.php?u={$site_url}/replica/{$LOG_USER_NAME}');"
                class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
            </div>
            <div class="clear pull-left">
              <div class="text-left m-b-xs block">{lang('Your_Replicated_Website_Link')}<i class="icon-twitter"></i>
              </div>
              <div
                data-clipboard-text="{if DEMO_STATUS == 'yes'}{$site_url}/replica/{$ADMIN_USER_NAME}/{$LOG_USER_NAME}{else}{$site_url}/replica/{$LOG_USER_NAME}{/if}"
                id="copy_link_replica" class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i
                  class="fa fa-copy text-info"></i>{lang('copy_link')}</div>
            </div>
          </div>
        </div>
      </div>
      {/if}
    </div>

    <!--<div class="col-sm-4">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{lang('package_overview')}</h4>
        </div>-->
    <!-- <ul class="list-group list-group-lg m-b-none">
          {assign var="i" value=0 }
          {foreach from=$top_recruters item=j}
           
          {$i=$i+1}
          {/foreach}
          {if $i==0}
          <li class="list-group-item">{lang('no_data_found')}</li>
          {/if}
        </ul>-->
    <!-- {if count($prgrsbar_data) > 0 && $MODULE_STATUS['product_status'] == 'yes'}
    <div class="col wrapper-lg w-lg bg-light dk r-r">
     
      {$j=0}
      <div class=""> {assign var=text_class value=['text-primary','text-primary','text-primary','text-primary']}
        {assign var=bg_class value=['bg-primary','bg-primary','bg-primary','bg-primary']}
        {foreach from=$prgrsbar_data item=v}
        <div class=""> <span class="pull-right {$text_class[$j]}">{$v.joining_count}</span> <span>{$v.package_name}</span> </div>
        <div class="progress progress-xs m-t-sm bg-white">
          <div class="progress-bar {$bg_class[$j]}" data-toggle="tooltip" data-original-title="{$prgrsbar_data[0]['perc'] * $v.joining_count}%" style="width: {$prgrsbar_data[0]['perc'] * $v.joining_count}%"></div>
        </div>
        {$j=$j+1}
        {/foreach} </div>
      {if $j > 3}
      <div class="pull-right read_more_button-top"> <a href="{$BASE_URL}user/home/package_list" class="read_more bg-primary">{lang('view_more')}</a> </div>
      {/if} </div>
    {/if}
      </div>
    
   
  </div>-->

  </div>
  <br>
  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="reservation_detail_model"
    data-backdrop="static" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
          <h4 class="modal-title" id="modaltitle"></h4>
        </div>
        <div class="modal-body" id="reservation_detail_model_body"> </div>
      </div>
    </div>
  </div>

  {/block}


  {else}{block name=$CONTENT_BLOCK}
  <div id="span_js_messages" style="display: none;"> <span id="left_join">{lang('left_join')}</span> <span
      id="right_join">{lang('right_join')}</span> <span id="join">{lang('joinings')}</span> <span
      id="confirm_msg">{lang('are_you_sure_want_delete')}</span> </div>
  <input name="mlm_plan" id="mlm_plan" type="hidden" value="{$MLM_PLAN}" />
  <div class="col">
    <div class="row">
      <div class="col-lg-6 col-md-12" id="section_tile">
        <div class="row row-sm text-center"> {if $MODULE_STATUS['roi_status']=="yes"}
          <div class="col-xs-6">
            <div class="panel padder-v item">
              <div class="h1 text-info font-thin h1">
                {$DEFAULT_SYMBOL_LEFT}{($roi_details*$DEFAULT_CURRENCY_VALUE)|round:2}{$DEFAULT_SYMBOL_RIGHT}</div>
              <span class="text-muted text-xs">{if
                $MODULE_STATUS['hyip_status']=="yes"}{lang('total_deposit')}{else}{lang('Hyip')}{/if}</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href="">{lang('view_more')}</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          {/if}
          {if $MODULE_STATUS['ewallet_status']=="yes" && $MODULE_STATUS['roi_status'] == "no"}
          <div class="col-xs-6" id="section_tile1">
            <div class="panel padder-v item">
              <div class="h1 text-info font-thin h1"> {$total_amount} </div>
              <span class="text-muted text-xs">{lang('e_wallet')}</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                </div>
              </div>
            </div>
          </div>
          {/if}
          {if {$MLM_PLAN} != "Donation" && $MODULE_STATUS['hyip_status'] != "yes"}
          <div class="col-xs-6" id="section_tile2">
            <div class="panel padder-v item bg-primary">
              <div class="text-white font-thin h1 block1" id="sales_total">{$total_sales}</div>
              <span class="text-muted text-xs">{lang('sales')}</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right" id="sales_dash">
                    <li class="active"><a href="javascript:void(0);" id="all_sales"><i
                          class="fa fa-list margin-r-5"></i> {lang('all')}</a></li>
                    <li><a href="javascript:void(0);" id="yearly_sales"><i class="fa fa-calendar margin-r-5"></i>
                        {lang('this_year')}</a></li>
                    <li><a href="javascript:void(0);" id="monthly_sales"><i class="fa fa-calendar margin-r-5"></i>
                        {lang('this_month')}</a></li>
                    <li><a href="javascript:void(0);" id="weekly_sales"><i class="fa fa-calendar margin-r-5"></i>
                        {lang('this_week')}</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          {/if}
          <div class="col-xs-6" id="section_tile3">
            <div class="panel padder-v item bg-info">
              <div class="text-white font-thin h1 block1" id="total_payout"> {$total_payout} </div>
              <span class="text-muted text-xs">{lang('payout')}</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right" id="payout_dash">
                    <li class="active"><a href="javascript:void(0);" id="all_payout"><i
                          class="fa fa-list margin-r-5"></i> {lang('all')}</a></li>
                    <li><a href="javascript:void(0);" id="yearly_payout"><i class="fa fa-calendar margin-r-5"></i>
                        {lang('this_year')}</a></li>
                    <li><a href="javascript:void(0);" id="monthly_payout"><i class="fa fa-calendar margin-r-5"></i>
                        {lang('this_month')}</a></li>
                    <li><a href="javascript:void(0);" id="weekly_payout"><i class="fa fa-calendar margin-r-5"></i>
                        {lang('this_week')}</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          {if {$MLM_PLAN} != "Donation" && $MODULE_STATUS['hyip_status'] != "yes"}
          <div class="col-xs-6" id="section_tile4">
            <div class="panel padder-v item">
              <div class="font-thin text-info h1" id="mail_total">{$read_mail}</div>
              <span class="text-muted text-xs">{lang('mail')}</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right" id="mail_dash">
                    <li class="active"><a href="javascript:void(0);" id="all_mail"><i class="fa fa-list margin-r-5"></i>
                        {lang('all')}</a></li>
                    <li><a href="javascript:void(0);" id="yearly_mail"><i class="fa fa-calendar margin-r-5"></i>
                        {lang('this_year')}</a></li>
                    <li><a href="javascript:void(0);" id="monthly_mail"><i class="fa fa-calendar margin-r-5"></i>
                        {lang('this_month')}</a></li>
                    <li><a href="javascript:void(0);" id="weekly_mail"><i class="fa fa-calendar margin-r-5"></i>
                        {lang('this_week')}</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          {/if}
          <!---hyip section-->
          {if {$MLM_PLAN} =="Unilevel" && $MODULE_STATUS['hyip_status']=="yes"}
          <div class="col-xs-6">
            <div class="panel padder-v item bg-primary">
              <div class="text-white font-thin h1 block1">
                {$DEFAULT_SYMBOL_LEFT}{($total_active_deposit*$DEFAULT_CURRENCY_VALUE)|round:2}{$DEFAULT_SYMBOL_RIGHT}
              </div>
              <span class="text-muted text-xs"> {lang('active_deposit')}</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href="{$BASE_URL}user/active_deposit"> {lang('view_more')}</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel padder-v item bg-info">
              <div class="text-info font-thin h1 block1">
                {$DEFAULT_SYMBOL_LEFT}{($total_matured_deposit*$DEFAULT_CURRENCY_VALUE)|round:2}{$DEFAULT_SYMBOL_RIGHT}
              </div>
              <span class="text-muted text-xs"> {lang('matured_deposit')}</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href="{$BASE_URL}user/matured_deposit"> {lang('view_more')}</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          {/if}
          <!---end hyip section-->

          <!---DONATION TILE-->
          {if {$MLM_PLAN} == "Donation"}
          <div class="col-xs-6">
            <div class="panel padder-v item bg-primary">
              <div class="text-white font-thin h1 block1">
                {$DEFAULT_SYMBOL_LEFT}{$given_commission}{$DEFAULT_SYMBOL_RIGHT}</div>
              <span class="text-muted text-xs">{lang('given_donation')}</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href="{$BASE_URL}user/donation/sent_donation_report"> View More</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel padder-v item bg-info">
              <div class="text-white font-thin h1 block1">
                {$DEFAULT_SYMBOL_LEFT}{$recieved_commission}{$DEFAULT_SYMBOL_RIGHT}</div>
              <span class="text-muted text-xs">{lang('received_donation')}</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href="{$BASE_URL}user/donation/recieve_donation_report"> View More</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!--END DONATION TILE-->

          <div class="col-xs-12 m-b-md">
            <div class="r bg-light dker item hbox no-border">
              <div class="col w-xs v-middle hidden-md">
                <div class="sparkline inline">
                  <button class="btn btn-sm btn-primary" type="submit">
                    <a class="btn1 btn-4 btn-4a icon-arrow"
                      href="{$BASE_URL}user/donation/donation_view">{lang('donate')}</a>
                  </button>
                </div>
              </div>
              <div class="col dk padder-v r-r">
                <div class="text-primary-dk font-thin h1"><span>{$level_name}</span></div>
                <span class="text-muted text-xs">{lang('your_current_status')}</span>
              </div>
            </div>
          </div>
          {/if}
          {if $is_app}
          {if $MODULE_STATUS['replicated_site_status'] == "yes"}
          <div class="col-xs-12" id="section_tile5">
            <div class="panel item">
              <div class="panel-body">
                <div class="pull-right icon_margin_top">
                  <button title="{lang('share_link')}" onClick="twittershare('{$site_url}/replica/{$LOG_USER_NAME}');"
                    class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
                  {* <button title="{lang('share_link')}"
                    onClick="googlePlusShare('{$site_url}/replica/{$LOG_USER_NAME}');"
                    class="btn btn-lg btn-icon btn-link text-danger"><i class="fa fa-google-plus"></i></button> *}
                  <button title="{lang('share_link')}"
                    onClick="facebookShare('https://www.facebook.com/sharer/sharer.php?u={$site_url}/replica/{$LOG_USER_NAME}');"
                    class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
                </div>
                <div class="clear pull-left">
                  <div class="text-left m-b-xs block">{lang('Your_Replicated_Website_Link')}<i class="icon-twitter"></i>
                  </div>
                  <div
                    data-clipboard-text="{if DEMO_STATUS == 'yes'}{$site_url}/replica/{$ADMIN_USER_NAME}/{$LOG_USER_NAME}{else}{$site_url}/replica/{$LOG_USER_NAME}{/if}"
                    id="copy_link_replica" class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i
                      class="fa fa-copy text-info"></i>{lang('copy_link')}</div>
                </div>
              </div>
            </div>
          </div>
          {/if}
          {if $MODULE_STATUS['lead_capture_status'] == "yes"}
          <div class="col-xs-12" id="section_tile6">
            <div class="panel item">
              <div class="panel-body">
                <div class="pull-right icon_margin_top">
                  <button title="{lang('share_link')}" onClick="twittershare('{$site_url}/lcp/{$LOG_USER_NAME}');"
                    class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
                  {* <button title="{lang('share_link')}" onClick="googlePlusShare('{$site_url}/lcp/{$LOG_USER_NAME}');"
                    class="btn btn-lg btn-icon btn-link text-danger"><i class="fa fa-google-plus"></i></button> *}
                  <button title="{lang('share_link')}"
                    onClick="facebookShare('https://www.facebook.com/sharer/sharer.php?u={$site_url}/lcp/{$LOG_USER_NAME}');"
                    class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
                </div>
                <div class="clear pull-left">
                  <div class="text-left block m-b-xs">{lang('Your_Lead_Capture_Page')}<i class="icon-twitter"></i>
                  </div>
                  <div
                    data-clipboard-text="{if DEMO_STATUS == 'yes'}{$site_url}/lcp/{$ADMIN_USER_NAME}/{$LOG_USER_NAME}{else}{$site_url}/lcp/{$LOG_USER_NAME}{/if}"
                    id="copy_link_lcp" class="  b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i
                      class="fa fa-copy text-info"></i>{lang('copy_link')}</div>
                </div>
              </div>
            </div>
          </div>
          {/if}
          {/if}
        </div>
      </div>
      <div class="col-lg-6 col-md-12">
        <div class="panel wrapper" id="section_country_graph">
          <h4 class="font-thin m-t-none m-b text-muted hidden"></h4>
          <div id="country_graph"></div>
        </div>
      </div>
    </div>
    <div class="panel hbox hbox-auto-xs no-border">
      <div class="col wrapper">
        <div class="dropdown pull-right">
          <div data-toggle="dropdown" aria-expanded="false"><i class="fas fa fa-cog fa-spin"></i></div>
          <ul class="dropdown-menu dropdown-menu_right" id="joinings_graph">
            <li class=""><a id="yearly_joining_graph" href="javascript:void(0);"><i
                  class="fa fa-calendar margin-r-5"></i> {lang('year')}</a></li>
            <li class="active"><a id="monthly_joining_graph" href="javascript:void(0);"><i
                  class="fa fa-calendar margin-r-5"></i> {lang('month')}</a></li>
            <li><a id="daily_joining_graph" href="javascript:void(0);"><i class="fa fa-calendar margin-r-5"></i>
                {lang('day')}</a></li>
          </ul>
        </div>
        <h4 class="font-thin m-t-none m-b-none text-primary-lt">{lang('joinings')}</h4>
        <span class="m-b block text-sm text-muted"></span>
        <div id="joining_graph_div" style="height: 240px;"></div>
      </div>
      {if count($prgrsbar_data) > 0 && $MODULE_STATUS['product_status'] == 'yes'}
      <div class="col wrapper-lg w-lg bg-light dk r-r">
        <h4 class="font-thin m-t-none m-b">{lang('membership')}</h4>
        {$j=0}
        <div class=""> {assign var=text_class value=['text-primary','text-primary','text-primary','text-primary']}
          {assign var=bg_class value=['bg-primary','bg-primary','bg-primary','bg-primary']}
          {foreach from=$prgrsbar_data item=v}
          <div class=""> <span class="pull-right {$text_class[$j]}">{$v.joining_count}</span>
            <span>{$v.package_name}</span> </div>
          <div class="progress progress-xs m-t-sm bg-white">
            <div class="progress-bar {$bg_class[$j]}" data-toggle="tooltip"
              data-original-title="{$prgrsbar_data[0]['perc'] * $v.joining_count}%"
              style="width: {$prgrsbar_data[0]['perc'] * $v.joining_count}%"></div>
          </div>
          {$j=$j+1}
          {/foreach}
        </div>
        {if $j > 3}
        <div class="pull-right read_more_button-top"> <a href="{$BASE_URL}user/home/package_list"
            class="read_more bg-primary">{lang('view_more')}</a> </div>
        {/if}
      </div>
      {/if}
    </div>
    <div class="panel wrapper">
      <div class="row">
        <div class="col-md-6 b-r b-light no-border-xs"> <a
            href="javascript:loadModal(1, '{lang('to_do_list')}', 'user/home/add_todo');" data-toggle="modal"
            class="text-muted pull-right text-lg" title="{lang('add_task')}"><i class="icon-plus"></i></a>
          <h4 class="font-thin m-t-none m-b-md text-muted">{lang('to_do_list')}</h4>
          <div class=" m-b todo_list_height"> {$i = 0}
            {$todo_pending = 0}
            {$todo_done = 0}
            {foreach from=$todo_list item=v}
            {if $v.status == 'completed'}
            {$todo_done = $todo_done + 1}
            {else}
            {$todo_pending = $todo_pending + 1}
            {/if}
            {form_open('user/home/delete_todo','role="form" class="" method="post" name="todo_register"
            id="todo_form"')}
            <input type='hidden' name="tsk_id" id="tsk_id" value="{$v.task_id}">
            <div class="m-b">
              <div class="pull-right m-l"> <span class="label text-base bg-light pos-rlt m-r"> <i
                    class="arrow right arrow-light"></i> {$v.time} </span>
                <button type="submit" class="btn-link h4 text-danger" onClick="return deleteTask();"
                  title={lang('delete')}><i class="fa fa-trash-o"></i></button>
                <button type="button" class="btn-link h4 text-info"
                  onClick="loadModal({$v.task_id}, '{lang('to_do_list')}', 'user/home/edit_todo');"
                  title="{lang('edit_list')}"><i class="fa fa-edit"></i></button>
              </div>
              <div class="clear"> <a href="javascript:void(0);" class=" block m-b-sm">
                  <div class="checkbox">
                    <label class="i-checks">
                      <input type="checkbox" onClick="statusChange({$v.task_id}, $(this));" {if $v.status=='completed' }
                        checked {/if}> <i></i>{$v.task|truncate:15} </label>
                  </div>
                  <i class="icon-twitter"></i>
                </a> </div>
            </div>
            {form_close()}
            {$i = $i++}
            {/foreach}
            {if count($todo_list) <= 0} <div>{lang('no_data_found')}
          </div>
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
            <div class="text-muted font-bold text-xs m-t m-b">{lang('done')}</div>
          </div>
          <div class="col-xs-6 text-center">
            <div id="todo_pending" class="inline m-t">
              <div> <span class="text-info h4">{$todo_pending_percent|round}%</span> </div>
            </div>
            <div class="text-muted font-bold text-xs m-t m-b">{lang('pending')}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted">{lang('top_earners')}</h4>
        </div>
        <ul class="list-group list-group-lg m-b-none">
          {assign var="i" value=0 }
          {foreach from=$top_earners item=j}
          <li class="list-group-item"> <a href="javascript:void(0);" class="thumb-sm m-r"> <img
                src="{$j['profile_picture_full']}" class="r r-2x"> </a> <span
              class="pull-right text-muted inline m-t-sm">{$j['balance_amount']}</span> <a
              href="javascript:void(0);">{$j['user_name']}</a> </li>
          {$i=$i+1}
          {/foreach}
          {if $i==0}
          <li class="list-group-item">{lang('no_data_found')}</li>
          {/if}
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="list-group list-group-lg list-group-sp" id="section_social_media"> <a {if $is_app}
          href="{$social_media_info['fb_link']}" target="_blank" {else} href="#" target="" {/if}
          class="list-group-item clearfix"> <span class="pull-left m-r">
            <button class="btn btn-rounded btn-lg btn-icon btn-facebook"> <i class="fa fa-facebook"></i> </button>
          </span> <span class="clear"> <span>{lang('facebook_users')}</span> <span
              class="social_iocs pull-center hidden-xs">{lang('facebook')}</span> <small
              class="text-muted clear text-ellipsis">{$social_media_info['fb_count']} +</small> </span> </a> {* <a {if
          $is_app} href="{$social_media_info['gplus_link']}" target="_blank" {else} href="#" target="" {/if}
          class="list-group-item clearfix"> <span class="pull-left m-r">
            <button class="btn btn-rounded btn-lg btn-icon btn-lkin"> <i class="fa fa-linkedin"></i> </button>
          </span> <span class="clear"> <span>{lang('linkedin_users')}</span> <span
              class="social_iocs pull-center hidden-xs">{lang('linkedin')}</span> <small
              class="text-muted clear text-ellipsis">{$social_media_info['gplus_count']} +</small> </span> </a> *} <a
          {if $is_app} href="{$social_media_info['twitter_link']}" target="_blank" {else} href="#" target="" {/if}
          class="list-group-item clearfix"> <span class="pull-left m-r">
            <button class="btn btn-rounded btn-lg btn-icon btn-info"> <i class="fa fa-twitter"></i> </button>
          </span> <span class="clear"> <span>{lang('twitter_users')}</span> <span
              class="social_iocs pull-center hidden-xs">{lang('twitter')}</span> <small
              class="text-muted clear text-ellipsis">{$social_media_info['twitter_count']} +</small> </span> </a> <a {if
          $is_app} href="{$social_media_info['inst_link']}" target="_blank" {else} href="#" target="" {/if}
          class="list-group-item clearfix"> <span class="pull-left m-r">
            <button class="btn btn-rounded btn-lg btn-icon btn-instagarm"> <i class="fa fa-instagram"></i> </button>
          </span> <span class="clear"> <span>{lang('instagram_users')}</span> <span
              class="social_iocs pull-center hidden-xs">{lang('instagram')}</span> <small
              class="text-muted clear text-ellipsis">{$social_media_info['inst_count']} +</small> </span> </a> </div>
    </div>
  </div>
</div>
<br>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="reservation_detail_model"
  data-backdrop="static" class="modal fade" style="display: none;">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
        <h4 class="modal-title" id="modaltitle"></h4>
      </div>
      <div class="modal-body" id="reservation_detail_model_body"> </div>
    </div>
  </div>
</div>
{/block}

{block name=right_content}
<div class="col w-md  bg-auto no-border-xs" id="right_section">
  <div class="b-l bg-white  tab-content" id="right_section_new_member">
    <div role="tabpanel" class="tab-pane active" id="tab-1">
      <div class="wrapper-md">
        <div class="bg-primary text-center wrapper-sm m-l-n-new m-r-n">{lang('new_members')|capitalize}</div>
        <ul class="list-group no-bg no-borders pull-in list_link">
          {assign var="i" value=0 }
          {foreach from=$latest_joinees item=j}
          <li class="list-group-item"> <a href="javascript:void(0);" class="pull-left thumb-sm m-r"> <img
                src="{$j['profile_picture_full']}"> </a>
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
  <div class="b-l bg-white padder-md height_top_recruiters" id="right_section_top_recruiter">
    <div class="streamline b-l m-b">
      <div class="bg-primary wrapper-sm m-l-n m-r-n m-b text-center">{lang('top_recruiters')}</div>
      {assign var="i" value=0}
      {foreach from=$top_recruters item=j}
      {$i=$i+1}
      {$k=fmod($i, 4)}
      <div class="sl-item b-l {if $k==1}b-primary{elseif $k==2}b-warning{elseif $k==3}b-info{/if}">
        <div class="m-l margin-list-mobile">
          <li class="list-group-item"> <a href="javascript:void(0);" class="pull-left thumb-sm m-r"> <img
                src="{$j['profile_picture_full']}"> </a>
            <div class="clear">
              <div><a href="javascript:void(0);">Hello {$j.user_name}</a></div>
              <span class="text-muted">{$j.count}</span>
            </div>
          </li>
        </div>
      </div>
      {/foreach}
      {if $i==0}
      <div class="sl-item b-l b-primary">
        <div class="m-l  margin-list-mobile">
          <li class="list-group-item">{lang('no_data_found')}</li>
        </div>
      </div>
      {/if}
    </div>
  </div>
</div>

{include file="user/home/rank_popup.tpl"}

<style>
  .demo_section {

    display: none;
  }

  .setting_margin_top {

    margin-top: -50px;
  }

  .setting_margin {
    margin-left: 230px;
  }

  .wrapper_index {

    padding: 15px
  }

  .demo_margin_top {

    margin-top: -30px;
  }

  .demo_footer_user {
    margin-top: -50px;
  }

  < !--opoup-->.demo_margin_top {

    margin-top: -30px;
  }

  .modal-content_1 {
    background-color: #fff;

  }

  .pager {

    margin: 0px 0;
    box-shadow: 0px 2px 17px 0px #19191942;
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

  .modal-dialog.modal-md.index {
    width: 35%;
    top: 7%;
    margin: 0 auto;
    position: relative;
    right: 0;
  }

  div#subscribeModal {
    padding-right: 0px !important;
  }


  .modal {
    position: fixed;
    left: 50%;
  }


  @media (max-width:767px) {
    .demo_section {

      display: block;
    }

    .moblie_demo {

      display: none;

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

    .modal-content_1 {
      background-color: #fff !important;

    }
  }
</style>
{/block}
{/if}
{block name=home_wrapper_out}
<div class="demo_footer_user"> {include file="layout/demo_footer.tpl"} </div>
{/block}