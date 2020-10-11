<div id="tooltip_div" style="display:none;">
    {foreach from= $tooltip_array item=v}
        <div id="user_{$v['board_username']}" class="tree_img_tree">
            <div class="Demo_head_bg">
                {$a = dirname(FCPATH)}
                {$b = '/uploads/images/profile_picture/'}
                {$c = $v['user_photo']}
                {$d = "{$a}{$b}{$c}"}
                {if file_exists($d)}
                    <img src="{$SITE_URL}/uploads/images/profile_picture/{$v['user_photo']}"/>
                {else}
                    <img src="{$SITE_URL}/uploads/images/profile_picture/nophoto.jpg" />
                {/if}
                <p>{$v['board_username']}</p>
            </div>
            <div class="body_text_tree">
                {if $tooltip_config['first_name'] == 'yes'}
                    <div class="binary_bg">
                        <p class="text-center">{$v['full_name']}</p>
                    </div>
                {/if}
                <ul class="list-group no-radius">
                    {if $tooltip_config['join_date'] == 'yes'}
                        <li class="list-group-item">
                            <div class="pull-right">{date('Y/m/d', strtotime($v['date_of_joining']))}</div>
                            <div class="pull-left">{lang('join_date')}:</div>
                        </li>
                    {/if}
                    {if $MODULE_STATUS['mlm_plan'] == 'Binary'}
                        {if $tooltip_config['left'] == 'yes'}
                            <li class="list-group-item">
                                <div class="pull-right">{round($v['left'], 2)}</div>
                                <div class="pull-left">{lang('left')}:</div>
                            </li>
                        {/if}
                        {if $tooltip_config['right'] == 'yes'}
                            <li class="list-group-item">
                                <div class="pull-right">{round($v['right'], 2)}</div>
                                <div class="pull-left">{lang('right')}:</div>
                            </li>
                        {/if}
                        {if $tooltip_config['left_carry'] == 'yes'}
                            <li class="list-group-item">
                                <div class="pull-right">{round($v['left_carry'], 2)}</div>
                                <div class="pull-left">{lang('left_carry')}:</div>
                            </li>
                        {/if}
                        {if $tooltip_config['right_carry'] == 'yes'}
                            <li class="list-group-item">
                                <div class="pull-right">{round($v['right_carry'], 2)}</div>
                                <div class="pull-left">{lang('right_carry')}:</div>
                            </li>
                        {/if}
                    {/if}
                    {if $tooltip_config['personal_pv'] == 'yes'}
                        <li class="list-group-item">
                            <div class="pull-right">{$v['personal_pv']|default:0}</div>
                            <div class="pull-left">{lang('personal_PV')}:</div>
                        </li>
                    {/if}
                    {if $tooltip_config['gpv'] == 'yes'}
                        <li class="list-group-item">
                            <div class="pull-right">{$v['group_pv']|default:0}</div>
                            <div class="pull-left">{lang('group_PV')}:</div>
                        </li>
                    {/if}
                    {if $MODULE_STATUS['mlm_plan'] == 'Donation' && $v['donation_level']}
                        {if $tooltip_config['donation_level'] == 'yes'}
                            <li class="list-group-item">
                                <div class="donation_level">{$v['donation_level']}</div>
                            </li>
                        {/if}
                    {/if}
                    {if $MODULE_STATUS['rank_status'] == 'yes' && $v['user_rank']}
                        {if $tooltip_config['rank_status']=="yes"}
                            <div class="tooltip_rank">{$v['user_rank']}</div>
                        {/if}
                    {/if}
                </ul>
            </div>
        </div>
    {/foreach}
</div>

{assign var="board_depth" value=$user_board_details['board_depth']}
{assign var="board_width" value=$user_board_details['board_width']}
{assign var="board_users" value=$user_board_details['board_users']}

<div class="tree_main">
    <div class="tableview_container orgChart" id="tree_div" >
        {assign var="user_level" value={$board_depth}}

        {for $level= 0 to {$board_depth} step +1  }

            {assign var="colspan" value={pow($board_width,$level)}}
            {assign var="total_columns" value={pow($board_width,$user_level)}}
            {assign var="row_width" value={$total_columns * $colspan * 100}}

            <div class="row" style="margin:0px auto; width: {$row_width}px!important ;">
                {foreach from=$board_users[$level] item=v }
                    {$class = "table_active"}
                    {if {$v.user_name}=="NA"}
                        {$class = "table_inactive"}
                    {/if}

                    <div  class="table-div" style="width: {$colspan*100}px !important ;">
                        <a href="javascript:void(0);" id="userlink_{$v.user_name}" class="tree_icon with_tooltip" data-tooltip-content="#user_{$v.user_name}">   
                            <div  class="{$class}"> 
                                {$v.user_name}
                            </div>   
                        </a>
                    </div>
                {/foreach} 
                <br clear="all" />
            </div>    
            {$user_level = $user_level-1}
        {/for}            
    </div> 
</div>

