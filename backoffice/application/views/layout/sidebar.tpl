<!-- aside -->
<aside id="aside" class="app-aside hidden-xs bg-dark">
    {$user_type = $LOG_USER_TYPE}
    {if $user_type == 'employee'}
        {$user_type = 'admin'}
    {/if}
    <div class="aside-wrap">
        <div class="navi-wrap">
            <!-- user -->
            <div class="clearfix hidden-xs text-center hide" id="aside-user">
                <div class="dropdown wrapper">
                    {if $LOG_USER_TYPE!='employee'}
                    <a href="{$PATH_TO_ROOT}{$user_type}/profile/profile_view">
                           <span class="thumb-lg w-auto-folded avatar m-t-sm">
                            <img src="{$SITE_URL}/uploads/images/profile_picture/{$profile_pic}" class="img-full" alt="...">
                        </span>
                    </a>
                    {/if}
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-folded">
                        <span class="clear">
                            <span class="block m-t-sm">
                                <strong class="font-bold text-lt">{$LOG_USER_NAME}</strong>
                                <b class="caret"></b>
                            </span>
                        </span>
                    </a>
                    <!-- dropdown -->
                    <ul class="dropdown-menu animated fadeInRight w hidden-folded">
                        <li>
                            <a href="{$PATH_TO_ROOT}{$user_type}/profile/profile_view">
                                <span>{lang('profile_management')}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{$PATH_TO_ROOT}register/user_register">
                                <span>{lang('signup')}</span>
                            </a>
                        </li>
                        {if $HELP_STATUS==='yes' && DEMO_STATUS == 'yes'}
                        <li>
                            <a href="https://infinitemlmsoftware.com/help" target="_blank">
                                <span>{lang('help')|ucfirst}</span>
                            </a>
                        </li>
                        {/if}
                        <li class="divider"></li>
                        <li>
                            <a href="{$PATH_TO_ROOT}login/logout">
                                <span>{lang('logout')}</span>
                            </a>
                        </li>
                    </ul>
                    <!-- / dropdown -->
                </div>
                <div class="line dk hidden-folded"></div>
            </div>
            <!-- / user -->

            <!-- nav -->
            <nav ui-nav class="navi clearfix">
                <ul class="nav">

                    {$prev_menu_id=""}
                    {$prev_type=""}
                    {$url = ''}
                    {assign var='common_pages' value=','|explode:"19,143,4,153,154,196"}
                    {$path_root = "{$PATH_TO_ROOT}{$user_type}/"}

                    {foreach from=$LEFT_MENU item=v key=k}
                        {$current_menu_id = $v.menu_id}
                        {if $prev_menu_id == $current_menu_id}
                            {$current_type = 'submenu'}
                            {assign var=route_submenu_url value="/"|explode:$v.submenu_url}
                             {if in_array($v.submenu_url_id, $common_pages)}
                                {$full_url= "$PATH_TO_ROOT`$route_submenu_url[1]`"}
                                {elseif $v.menu_id == '44'} <!--CRM -->
                                {$full_url = "$PATH_TO_ROOT`$v.submenu_url`"}
                             {elseif $v.submenu_url_id !=''}
                                {$full_url= "$path_root`$route_submenu_url[1]`"}
                             {/if} 

                            {$url = $full_url}
                            {if $v.menu_id == '32'}
                                {$text_key = "`$v.menu_id`_`$v.submenu_url_id`"}
                            {else} 
                                {$text_key = "`$v.menu_id`_`$v.submenu_id`_`$v.submenu_url_id`"}
                            {/if}
                            {if $MODULE_STATUS['table_status'] =='yes' && $MLM_PLAN == 'Board' && $v.submenu_url_id == '101'}
                                 {$text_key = lang('2_77_101')}
                            {/if}
                            {if $MODULE_STATUS['hyip_status'] =='yes' && $MLM_PLAN == 'Unilevel'}
                                {if $v.submenu_url_id == '188'}
                                    {$text_key = lang('12_109_12')}
                                {else if $v.submenu_url_id == '35'}
                                    {$text_key = lang('14_28_14')}
                                {/if}
                            {/if}

                        {else}
                            {$current_type='menu'}
                            {if $prev_type == 'submenu'}
                                </ul>
                                </li>
                            {/if}

                        {if $v.menu_url}
                            {assign var=route_menu_url value="/"|explode:$v.menu_url}
                            {$has_submenu = 'no'}
                            {$text_key = "`$v.menu_id`_`$v.menu_url_id`"}
                            {if $MODULE_STATUS['hyip_status'] =='yes' && $MLM_PLAN == 'Unilevel'}
                                {if $text_key == '46_153'} {$text_key = lang('12_109_12')} {/if}
                            {/if}
                            {if in_array($v.menu_url_id, $common_pages)}
                                  {$full_url= "$PATH_TO_ROOT`$route_menu_url[1]`"}
                            {elseif $v.menu_url_id !=''}
                                  {$full_url= "$path_root`$route_menu_url[1]`"}
                            {/if} 
                            {$url = $full_url}
                        {else}
                            {$has_submenu = 'yes'}
                            {$text_key = "`$v.menu_id`_#"}
                            {if $MODULE_STATUS['hyip_status'] =='yes' && $MLM_PLAN == 'Unilevel'}
                                {if $text_key == '12_#'}
                                    {$text_key = lang('12_12')}
                                {else if $text_key == '14_#'}
                                    {$text_key = lang('14_14')}
                                {/if}
                            {/if}
                            {$url = "javascript:void(0);"}
                             {assign var=route_submenu_url value="/"|explode:$v.submenu_url}
                            {/if}
                        {/if}

                        {if $current_type == 'menu'}
                            <li {if $v.is_menu_selected} class="active" {/if}>
                                <a href="{$url}" class="auto" {if $v.menu_target!='none'} target="{$v.menu_target}" {/if}>
                                    {if $has_submenu == 'yes'}
                                        <span class="pull-right text-muted">
                                            <i class="fa fa-fw fa-angle-right text"></i>
                                            <i class="fa fa-fw fa-angle-down text-active"></i>
                                        </span>
                                    {/if}
                                    <i class="{$v.icon}"></i>
                                    <span>{lang($text_key)}</span>
                                </a>
                                {if $has_submenu == 'yes'}
                                    <ul class="nav nav-sub dk">
                                        {assign var=route_submenu_url value="/"|explode:$v.submenu_url}
                                        {if in_array($v.submenu_url_id, $common_pages)}
                                            {$full_url= "$PATH_TO_ROOT`$route_submenu_url[1]`"}
                                        {elseif $v.menu_url_id !=''}
                                          {$full_url= "$path_root`$route_submenu_url[1]`"}
                                        {/if} 
                                        {$url = $full_url}
                                        {$text_key = "`$v.menu_id`_`$v.submenu_id`_`$v.submenu_url_id`"}
                                {else}
                                    </li>
                                {/if}
                            {/if}

                            {if $current_type == 'menu' && $v.menu_url =='' && $v.submenu_url != ''}
                                {$current_type='submenu'}
                                {$text_key = "`$v.menu_id`_`$v.submenu_id`_`$v.submenu_url_id`"}
                                {assign var=route_submenu_url value="/"|explode:$v.submenu_url}
                                {if in_array($v.submenu_url_id, $common_pages)}
                                    {$full_url= "$PATH_TO_ROOT`$route_submenu_url[1]`"}
                                {elseif $v.menu_id == '44'} <!--CRM -->
                                    {$full_url = "$PATH_TO_ROOT`$v.submenu_url`"}
                                {elseif $v.submenu_url_id !=''}
                                    {$full_url= "$path_root`$route_submenu_url[1]`"}
                                {/if}
                                {$url = $full_url}

                            {/if}

                            {if $current_type == 'submenu'}
                                <li {if $v.is_submenu_selected} class="active" {/if}>
                                    <a href="{$url}">
                                        <span>{lang($text_key)}</span>
                                    </a>
                                </li>
                            {/if}

                            {$prev_menu_id=$current_menu_id}
                            {$prev_type=$current_type}

                    {/foreach}
                </ul>
            </nav>
            <!-- nav --> 
        </div>
    </div>
</aside>
<!-- / aside -->
