{*start: HEADER *}
<script src="{$PUBLIC_URL}javascript/currency.js" type="text/javascript" ></script>
<div class="navbar navbar-inverse navbar-fixed-top">
    {* start: TOP NAVIGATION CONTAINER *}
    <div class="container">
        <div class="navbar-header">
            {* start: RESPONSIVE MENU TOGGLER *}
            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="clip-list-2"></span>
            </button>
            {* end: RESPONSIVE MENU TOGGLER *}
            {* start: LOGO *}    
            <div class="logo-header">
                <a class="navbar-brand" href="{$BASE_URL}super_admin/home/index"> 
                    <img src="{$SITE_URL}/uploads/images/logos/{$site_info["logo"]}" class="logo"/>
                </a>     
            </div>
            {* end: LOGO *}
        </div>
        <div class="navbar-tools">
            {* start: TOP NAVIGATION MENU *}

            <ul class="nav navbar-right">
                <!-- start: USER DROPDOWN -->
                <li class="dropdown current-user">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                        <img src="{$SITE_URL}/uploads/images/profile_picture/nophoto.jpg" class="circle-img" alt="" height="30px" width="30px">

                        <span class="username">{$LOG_USER_NAME}</span>
                        <i class="clip-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{$BASE_URL}super_admin/login/logout">
                                <i class="clip-switch"></i>
                                &nbsp;{lang('logout')}
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end: USER DROPDOWN -->
            </ul>
            <!-- end: TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- end: TOP NAVIGATION CONTAINER -->
</div>
<!-- end: HEADER -->
<!-- start: MAIN CONTAINER -->
<div class="main-container">
    <div class="navbar-content">
        <!-- start: SIDEBAR -->
        <div class="main-navigation navbar-collapse collapse">
            <!-- start: MAIN MENU TOGGLER BUTTON -->
            <div class="navigation-toggler">
                <i class="clip-chevron-left"></i>
                <i class="clip-chevron-right"></i>
            </div>
            <!-- end: MAIN MENU TOGGLER BUTTON -->
            {include file="super_admin/layout/menu.tpl" title="Example Smarty Page" name=""}
        </div>
        <!-- end: SIDEBAR -->
    </div>
    <!-- start: PAGE -->
    <div class="main-content">
        <div class="container">
            <!-- start: PAGE HEADER -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: PAGE TITLE & BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li>
                            <i class="clip-pencil"></i>
                            <a href="{$BASE_URL}super_admin/home/index">
                                {lang('dashboard')}
                            </a>
                        </li>
                        {if $HEADER_LANG['page_top_header']!=lang('dashboard')}
                            <li>
                                <a href="#">
                                    {$HEADER_LANG['page_top_header']}
                                </a>
                            </li>
                        {/if}
                        {if $HEADER_LANG['page_top_small_header'] != ""}
                            <li class="active">
                                {$HEADER_LANG['page_top_small_header']}
                            </li>
                        {/if}
                        <li class="pull-right">		
                            <span class="date" style="padding: 0px 0px 0px 10px;">
                                <timestamp id="date"></timestamp> 
                            </span>
                            <div id="clock"></div>

                            <div style="float: left;border-right: 1px solid #999999;padding: 0px 10px 0px 0px;">
                                <input value="{$SERVER_TIME}" id="serverClock_input" hidden>
                                <input value="{$SERVER_DATE}" id="serverDate_input" hidden>
                                <span class="date">
                                    <timestamp id="server_date"></timestamp> 
                                </span>
                                <div id="server_clock" style="float: right;"></div> 
                            </div>
                        </li> 
                    </ol>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                    <!-- start: PAGE HEADER -->
                    <div class="page-header">
                        <h1>{$HEADER_LANG['page_header']} 
                            {if $HEADER_LANG['page_small_header'] != ""}
                                <small>{$HEADER_LANG['page_small_header']}</small>
                            {/if}
                        </h1>
                    </div>
                </div>
            </div>
            <!-- end: PAGE HEADER --> 
            {include file="super_admin/layout/error_box.tpl" title="" name=""}