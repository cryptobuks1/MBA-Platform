{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" class="no-display">
        <span id="error_msg">{lang('select_user_id')}</span>
    </div>

    <input type="hidden" id="search_member_error" value="{lang('search_member_error')}" />
    <input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}" />

    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('admin/sponsor_tree','role="form" class="" name="search_member" id="search_member" method="post"')}
                <div class="col-sm-3 padding_both">
                    <div class="form-group">
                        <label class="required" for="user_name">{lang('user_name')}</label>
                        <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off" size="100">
                    </div>
                </div>
                <div class="col-sm-2 padding_both_small">
                    <div class="form-group mark_paid">
                        <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit" name="search_member_submit">
                            {lang('search')}
                        </button>
                    </div>
                </div>
            {form_close()}
            <div class="button_back m-t-sm">
                <a href="{BASE_URL}/admin/my_report/unilevel_history" class="btn m-b-xs m-t-md btn-sm btn-info btn-addon"><i class="fa fa-forward"></i>{lang('go_to_unilevel_list')}</a>
            </div>
        </div>
    </div>
    
    <div id="summary" class="tree_main"></div>
    <input id="root_user_name" value="{$user_name}" type="hidden">
    <input id="tree_url" value="{$BASE_URL}admin/tree/tree_view_sponsor" type="hidden">

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