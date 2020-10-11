{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" class="no-display">
        <span id="error_msg">{lang('select_user_id')}</span>
    </div>
    <input type="hidden" id="search_member_error" value="{lang('search_member_error')}" />
    <input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}" />
    <div class="panel panel-default m-t">
        <div class="panel-body">
            {form_open('user/genology_tree','role="form" class="" name="search_member" id="search_member" method="post"')}
                <div class="col-sm-3 padding_both">
                    <div class="form-group">
                        <label class="required" for="user_name">{lang('user_name')}</label>
                        <input class="form-control user_downline_autolist" type="text" id="user_name" name="user_name" autocomplete="Off" size="100">
                    </div>
                </div>
                <div class="col-sm-2 padding_both_small">
                    <div class="form-group credit_debit_button">
                        <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit" name="search_member_submit">
                            {lang('search')}
                        </button>
                    </div>
                </div>
            {form_close()}
            <div class="button_back m-t-md">
                {if $MODULE_STATUS['mlm_plan'] == "Binary"}
                    <a href="{BASE_URL}/user/binary_leg_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-forward"></i>{lang('binary_leg_settings')}</a>
                    <a href="{BASE_URL}/user/view_leg_count" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-forward"></i>{lang('go_to_leg_details')}</a>
                {/if}
                {if $MODULE_STATUS['mlm_plan'] == "Unilevel"}
                    <a href="{BASE_URL}/user/my_referal" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-forward"></i>{lang('go_to_my_referals')}</a>
                {else}
                    <a href="{BASE_URL}/user/binary_history" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-forward"></i>{lang('downline_list')}</a>
                {/if}
            </div>
        </div>
    </div>
    <div id="summary" class="tree_main"></div>
    <input id="root_user_name" value="{$user_name}" type="hidden">
    <input id="tree_url" value="{$BASE_URL}user/tree/tree_view" type="hidden">
    <div class="panel panel-default m-t">
        <div class="panel-body">
            <div class="col-lg-9 col-sm-12 col-md-9">
                <div class="m-b m-t-sm tree_img">
                    <img src="{$PUBLIC_URL}images/tree/active.png">
                    <p>{lang('customer')}</p>
                    <img src="{$PUBLIC_URL}images/tree/blue.png">
                    <p>{lang('business_affiliate')}</p>
                    <img src="{$PUBLIC_URL}images/tree/Brown.png">
                    <p>{lang('rank_2')}</p>
                    <img src="{$PUBLIC_URL}images/tree/gray.png">
                    <p>{lang('rank_3')}</p>
                    <img src="{$PUBLIC_URL}images/tree/green.png">
                    <p>{lang('rank_4')}</p>
                    <img src="{$PUBLIC_URL}images/tree/light green.png">
                    <p>{lang('rank_5')}</p>
                    <img src="{$PUBLIC_URL}images/tree/orenge.png">
                    <p>{lang('rank_6')}</p>
                    <img src="{$PUBLIC_URL}images/tree/pink.png">
                    <p>{lang('rank_7')}</p>
                    <img src="{$PUBLIC_URL}images/tree/red.png">
                    <p>{lang('rank_8')}</p>
                    <img src="{$PUBLIC_URL}images/tree/sky blue.png">
                    <p>{lang('rank_9')}</p>
                    <img src="{$PUBLIC_URL}images/tree/yellow.png">
                    <p>{lang('rank_10')}</p>
                    <img src="{$PUBLIC_URL}images/tree/inactive.png">
                    <p>{lang('inactive')}</p>
                  
                    {if $MLM_PLAN != 'Matrix'}
                        <img src="{$PUBLIC_URL}images/tree/add_disabled.png">
                        <p>{lang('disabled')}</p>
                    {/if}
                    <img src="{$PUBLIC_URL}images/tree/add.png">
                    <p>{lang('vacant')}</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12 col-md-3 m-t-md">
                <div class=" pull-right">
                    <button class="btn m-b-xs btn-primary zoom-in"><i class="glyphicon glyphicon-zoom-in"></i></button>
                    <button class="btn m-b-xs btn-info zoom-out"><i class="glyphicon glyphicon-zoom-out"></i></button>
                    <button class="btn m-b-xs btn-primary zoom-reset"><i class="icon-power"></i></button>
                </div>
    
            </div>
        </div>
    </div>
{/block}

{block name=style}
    {$smarty.block.parent}
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/tree.css" type="text/css"/>
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/tree_tooltip.css" type="text/css"/>
{/block}
{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}theme/libs/jquery/panzoom/jquery.panzoom.min.js"></script>
    <script src="{$PUBLIC_URL}javascript/tree/jquery.tree.js"></script>
    <script src="{$PUBLIC_URL}javascript/tree/genealogy.js"></script>
{/block}