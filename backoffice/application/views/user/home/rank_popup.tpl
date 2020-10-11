
{if $current_date >= $subscription_end_date}

<!--USER POPUP-->
<div class="modal fade text-center py-5" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md index" role="document">
        <div class="modal-content_1 b-white">
            <div class="modal-body backgound_modal">
                <div class="p-3">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon-close"></i></button>
                     <div class="clearfix">
                       {* <a href="javascript:void(0);" class="thumb-md">
                            <img style="width:50px;" src="{$SITE_URL}/uploads/images/logos/silver.jpg">
                        </a>*}
                        {*<div class="clear">
                            <div class="h3 m-t-xs m-b-xs">
                                {if $rank_achievement.current_rank.rank_id}
                                    {$rank_achievement.current_rank.rank_name}
                                {else}
                                    NA
                                {/if}
                                <i class="fa fa-circle text-success pull-right text-xs m-t-sm"></i>
                            </div>
                            {if $rank_achievement.next_rank.rank_id}
                                <small class="text-muted h4">{lang('next_rank')}: <span class="text-info">{$rank_achievement.next_rank.rank_name}</span></small>
                            {/if}
                        </div>*}
                    </div>
                  {*  <ul class="list-group no-radius">
                        <li class="list-group-item pager">
                            <div class="pull-right"><span class="badge bg-info">{max($rank_achievement.next_rank.referral_count-$rank_achievement.current_rank.referral_count,0)}</span></div>
                            <div class="pull-left">{lang('referral_count')}</div>
                        </li>
                        {if $rank_achievement.criteria.personal_pv}
                            <li class="list-group-item pager">
                                <div class="pull-right"><span class="badge bg-info">{max($rank_achievement.next_rank.personal_pv-$rank_achievement.current_rank.personal_pv,0)}</span></div>
                                <div class="pull-left">{lang('personal_pv')}</div>
                            </li>
                        {/if}
                        {if $rank_achievement.criteria.group_pv}
                            <li class="list-group-item pager">
                                <div class="pull-right"><span class="badge bg-info">{max($rank_achievement.next_rank.group_pv-$rank_achievement.current_rank.group_pv,0)}</span></div>
                                <div class="pull-left">{lang('group_pv')}</div>
                            </li>
                        {/if}
                        {if $rank_achievement.criteria.downline_count}
                            <li class="list-group-item pager">
                                <div class="pull-right"><span class="badge bg-info">{max($rank_achievement.next_rank.downline_count-$rank_achievement.current_rank.downline_count,0)}</span></div>
                                <div class="pull-left">{lang('downline_count')}</div>
                            </li>
                        {/if}
                        {if $rank_achievement.criteria.downline_package_count && $rank_achievement.current_rank.package_name}
                            {foreach from=$rank_achievement.current_rank.package_name item=v key=k}
                                <li class="list-group-item pager">
                                    <div class="pull-right"><span class="badge bg-info">{max($rank_achievement.next_rank.downline_package_count[$k]-$rank_achievement.current_rank.downline_package_count[$k],0)}</span></div>
                                    <div class="pull-left">{lang('downline_count')}({$v})</div>
                                </li>
                            {/foreach}
                        {/if}
                    </ul> *}
                    <blockquote class="lavander">
                       {* {if $rank_achievement.current_rank.rank_id && $rank_achievement.next_rank.rank_id}*}
                            <h1>
                                <span class="Clavander">{*{lang('congratulations')}*}</span> 
                                {*{lang('for_achieving_current_rank')|replace:'%s':$rank_achievement.current_rank.rank_name}
                                {lang('you_deserve_it_every_bit')}*}
                                {lang('you_have_to_pay_a_monthly_subscription')}
                                {lang('of')}
                                {$monthly_fee}
                            </h1>
                            <p class="text-info">{*{lang('now_aim_for_next_rank')|replace:'%s':$rank_achievement.next_rank.rank_name}*}
                                <a href="{$BASE_URL}user/monthly_payment">click here!</a>
                            </p>
                        {*{elseif !$rank_achievement.current_rank.rank_id}
                            <h1>
                                {lang('no_rank_quote')}
                            </h1>
                        {elseif $rank_achievement.current_rank.rank_id && !$rank_achievement.next_rank.rank_id}
                            <h1>
                                {lang('highest_rank_quote')}
                            </h1>*}
                        {*{/if}*}
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>
<!--USER POPUP-->
{/if}