{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none">
    <span id="error_msg">{lang('select_user_id')}</span>
</div>

<input type="hidden" id="search_member_error" value="{lang('search_member_error')}" />
<input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}" />

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-sm-4 col-xs-12 pull-left m-t-md padding_both">
            <button class="btn m-b-xs btn-primary zoom-in"><i class="glyphicon glyphicon-zoom-in"></i></button>
            <button class="btn m-b-xs btn-info zoom-out"><i class="glyphicon glyphicon-zoom-out"></i></button>
            <button class="btn m-b-xs btn-primary zoom-reset"><i class="icon-power"></i></button>
        </div>
    </div>
</div>

{assign var="step_depth" value=$user_step_details['tree_depth']}
{assign var="step_width" value=$user_step_details['tree_width']}
{assign var="user" value=$user_step_details['users']}

<div class="tree_main">
    <div class="tableview_container" id="tree_div">
        <div style="width: 70px;height:auto;display: inline-block;">
            {foreach from=$user item=items key=step_id}
            <div class="row side-panel" style="height: 100px;align-content: center;top: 1px;line-height: 82px;margin: 5px 2px;">
                {* Step *}
                Step - {$step_id}
            </div>
            {/foreach}
        </div>
        <div style=" float: left;">
            {assign var="user_level" value={$step_depth}}
    
            {assign var="colspan" value='1'}
            {assign var="row_span" value='1'}
    
            {foreach from=$user item=items }
    
            {assign var="total_columns" value={count($items)}}
            {assign var="row_width" value={$row_span * 100}}
    
            <div class="row" style="margin:0px 0px 0px 0px !important;">
                {if $total_columns == 0}
                {$total_columns = 1}
                {/if}
                {$colspan = $row_span / $total_columns }
                {foreach from=$items item=v }
                <div class="table-div" style="width: {$colspan*100}px !important ;">
                    <a href="javascript:void(0);" id="userlink_{$v.user_name}" class="tree_icon with_tooltip"
                        data-tooltip-content="#user_{$v.user_name}">
                        <div class="table_active">
                            {$v.user_name}
                        </div>
                    </a>
                </div>
                {/foreach}
                {if empty($items)}
                <div class="table-div" style="width: {$colspan*100}px !important ;">
                    <a href="javascript:void(0);">
                        <div class="table_active">
    
                        </div>
                    </a>
                </div>
                {/if}
                <br clear="all" />
            </div>
            {$row_span = $row_span+1}
            {/foreach}
        </div>
        <br clear="all" />
    </div>
</div>

<div id="tooltip_div" style="display:none;">
    {foreach from= $tooltip_array item=v}
    <div id="user_{$v['user_name']}" class="tree_img_tree">
        <div class="Demo_head_bg">
            {$a = dirname(FCPATH)}
            {$b = '/uploads/images/profile_picture/'}
            {$c = $v['user_photo']}
            {$d = "{$a}{$b}{$c}"}
            {if file_exists($d)}
            <img src="{$SITE_URL}/uploads/images/profile_picture/{$v['user_photo']}" />
            {else}
            <img src="{$SITE_URL}/uploads/images/profile_picture/nophoto.jpg" />
            {/if}
            <p>{$v['user_name']}</p>
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

{/block}

{block name=style}
    {$smarty.block.parent}
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/tree_stairstep.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/tree_tooltip.css" type="text/css" />
{/block}

{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}theme/libs/jquery/panzoom/jquery.panzoom.min.js"></script>
    <script src="{$PUBLIC_URL}javascript/tree/stairstep.js"></script>
{/block}