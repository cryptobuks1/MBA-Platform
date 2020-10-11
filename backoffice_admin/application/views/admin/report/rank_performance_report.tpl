{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div class="button_back">
    <a onClick="print_report(); return false;"><button class="btn m-b-xs btn-sm btn-primary btn-addon hidden-xs hidden-sm hidden-md"><i class="icon-printer"></i>{lang('Print')}</button>
    </a></div>
    <div id="print_area" class="panel-body panel">
<div class="img"><img src="{$SITE_URL}/uploads/images/logos/{$site_info["logo"]}" /> </div>
<div class="row">
    <div class="col-xs-6">
        <h4>{$site_info["company_name"]}</h4>
        <p>{$site_info["company_address"]}</p>
        <p> {lang('phone')}: {$site_info["phone"]}<br> {lang('email')}:{$site_info["email"]} </p>
    </div>
</div>
 
<h2 class="text-center">{$report_name}</h2>
<h3>
    <center>{lang('current_rank')} :
        <font color="#ff0000">
        {if $rank_achievement.current_rank.rank_id}
            {$rank_achievement.current_rank.rank_name}
        {else}
            NA
        {/if}
        </font>
    </center>
</h3>
<h4>
    <center style="font-size: 12px;">{lang('next_rank')} :
        <font color="green">
        {if $rank_achievement.next_rank.rank_id}
            {$rank_achievement.next_rank.rank_name}
        {else}
            NA
        {/if}
        </font>
    </center>
</h4>
<div class="panel panel-default ng-scope">
<div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <tbody>
            <tr class="text">
                <td><strong>{lang('user_name')}</strong></td>
                <td>{$user_name}</td>
            </tr>
            <tr>
                <td><strong> {lang('current_rank')}</strong></td>
                <td>
                    {if $rank_achievement.current_rank.rank_id}
                        {$rank_achievement.current_rank.rank_name}
                    {else}
                        NA
                    {/if}
                </td>
            </tr>
            <tr>
                <td><strong>{lang('next_rank')}</strong></td>
                <td>
                    {if $rank_achievement.next_rank.rank_id}
                        {$rank_achievement.next_rank.rank_name}
                    {else}
                        NA
                    {/if}
                </td>
            </tr>
            <tr>
                <td><strong>{lang('current_referral_count')}</strong></td>
                <td>{$rank_achievement.current_rank.referral_count}</td>
            </tr>
            {if $rank_achievement.next_rank.rank_id}
                <tr>
                    <td><strong>{lang('referral_count_for')} {$rank_achievement.next_rank.rank_name}</strong></td>
                    <td>{$rank_achievement.next_rank.referral_count}</td>
                </tr>
                <tr>
                    <td><strong>{lang('needed_referral_count')}</strong></td>
                    <td>{max($rank_achievement.next_rank.referral_count-$rank_achievement.current_rank.referral_count,0)}</td>
                </tr>
            {/if}

            {if $rank_achievement.criteria.personal_pv}
                <tr>
                    <td><strong>{lang('current_personal_pv')}</strong></td>
                    <td>{$rank_achievement.current_rank.personal_pv}</td>
                </tr>
                {if $rank_achievement.next_rank.rank_id}
                    <tr>
                        <td><strong>{lang('personal_pv_for')} {$rank_achievement.next_rank.rank_name}</strong></td>
                        <td>{$rank_achievement.next_rank.personal_pv}</td>
                    </tr>
                    <tr>
                        <td><strong>{lang('needed_personal_pv')}</strong></td>
                        <td>{max($rank_achievement.next_rank.personal_pv-$rank_achievement.current_rank.personal_pv,0)}</td>
                    </tr>
                {/if}
            {/if}

            {if $rank_achievement.criteria.group_pv}
                <tr>
                    <td><strong>{lang('current_group_pv')}</strong></td>
                    <td>{$rank_achievement.current_rank.group_pv}</td>
                </tr>
                {if $rank_achievement.next_rank.rank_id}
                    <tr>
                        <td><strong>{lang('gpv_for')} {$rank_achievement.next_rank.rank_name}</strong></td>
                        <td>{$rank_achievement.next_rank.group_pv}</td>
                    </tr>
                    <tr>
                        <td><strong>{lang('needed_group_pv')}</strong></td>
                        <td>{max($rank_achievement.next_rank.group_pv-$rank_achievement.current_rank.group_pv,0)}</td>
                    </tr>
                {/if}
            {/if}
            
            {if $rank_achievement.criteria.downline_count}
                <tr>
                    <td><strong>{lang('current_downline_count')}</strong></td>
                    <td>{$rank_achievement.current_rank.downline_count}</td>
                </tr>
                {if $rank_achievement.next_rank.rank_id}
                    <tr>
                        <td><strong>{lang('downline_count_for')} {$rank_achievement.next_rank.rank_name}</strong></td>
                        <td>{$rank_achievement.next_rank.downline_count}</td>
                    </tr>
                    <tr>
                        <td><strong>{lang('needed_downline_count')}</strong></td>
                        <td>{max($rank_achievement.next_rank.downline_count-$rank_achievement.current_rank.downline_count,0)}</td>
                    </tr>
                {/if}
            {/if}

            {if $rank_achievement.criteria.downline_package_count && $rank_achievement.current_rank.package_name}
                {foreach from=$rank_achievement.current_rank.package_name item=v key=k}
                    <tr>
                        <td><strong>{lang('current_downline_count')}({$v})</strong></td>
                        <td>{$rank_achievement.current_rank.downline_package_count[$k]}</td>
                    </tr>
                    {if $rank_achievement.next_rank.rank_id}
                        <tr>
                            <td><strong>{lang('downline_count_for')} {$rank_achievement.next_rank.rank_name}({$v})</strong></td>
                            <td>{$rank_achievement.next_rank.downline_package_count[$k]}</td>
                        </tr>
                        <tr>
                            <td><strong>{lang('needed_downline_count')}({$v})</strong></td>
                            <td>{max($rank_achievement.next_rank.downline_package_count[$k]-$rank_achievement.current_rank.downline_package_count[$k],0)}</td>
                        </tr>
                    {/if}
                {/foreach}
            {/if}
        </tbody>

    </table>
    </div>
    </div>
</div>
{/block}
