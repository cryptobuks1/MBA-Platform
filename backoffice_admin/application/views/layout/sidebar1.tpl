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
                    {assign var=sub_menu_count value=0}
                    {assign var="c" value=1}
                    {foreach from=$LEFT_MENU item=v key=k}
                        {* {if $c == 1 || $c == 6 || $c == 11 || $c == 16 || $c == 21}
                            <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
								<span>Navigation</span>
							</li>
                        {/if} *}
                        {$sub_menu_count=count($v.sub_menu)}
                        <li {if $v.is_selected} class="active" {/if}>
                            <a href="{$v.link}" class="auto" {if $v.target!='none'} target="{$v.target}" {/if}>
                                {if $sub_menu_count>0}
                                <span class="pull-right text-muted">
                                    <i class="fa fa-fw fa-angle-right text"></i>
                                    <i class="fa fa-fw fa-angle-down text-active"></i>
                                </span>
                                {/if}
                                {if $v.link_ref_id==95 && $unread_mail>0}
                                <b class="badge bg-info pull-right">{$unread_mail}</b>
                                {/if}
                                {if $v.link_ref_id==87}
                                <b class="badge bg-primary pull-right" id ="t_s_n"></b>
                                {/if}
                                <i class="{$v.icon}"></i>
                                <span>{$v.text}</span>
                            </a>
                            {if $sub_menu_count>0}
                            <ul class="nav nav-sub dk">
                                <li class="nav-sub-header">
                                    <a href="{$v.link}">
                                        <span>{$v.text}</span>
                                    </a>
                                </li>
                                {foreach from=$v.sub_menu item=i}
                                <li {if $i.is_selected} class="active" {/if}>
                                    <a href="{$i.link}">
                                        <span>{$i.text}</span>
                                    </a>
                                </li>
                                {/foreach}
                            </ul>
                            {/if}
                        </li>
                        {* {if $c == 5 || $c == 10 || $c == 15 || $c == 20 || $c == 25}
                            <li class="line dk"></li>
                        {/if} *}
                        {$c = $c + 1}
                    {/foreach}
                    
                </ul>
            </nav>
            <!-- nav -->
            
        </div>
    </div>
</aside>
<!-- / aside -->
