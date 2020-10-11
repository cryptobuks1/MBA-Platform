<?php
/* Smarty version 3.1.30, created on 2020-08-04 23:12:16
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/sidebar.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f295eb0cac305_26941375',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e1021b9663f841076c0ee5b67f1459541d6df037' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/sidebar.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f295eb0cac305_26941375 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!-- aside -->
<aside id="aside" class="app-aside hidden-xs bg-dark">
    <?php $_smarty_tpl->_assignInScope('user_type', $_smarty_tpl->tpl_vars['LOG_USER_TYPE']->value);
?>
    <?php if ($_smarty_tpl->tpl_vars['user_type']->value == 'employee') {?>
        <?php $_smarty_tpl->_assignInScope('user_type', 'admin');
?>
    <?php }?>
    <div class="aside-wrap">
        <div class="navi-wrap">
            <!-- user -->
            <div class="clearfix hidden-xs text-center hide" id="aside-user">
                <div class="dropdown wrapper">
                    <?php if ($_smarty_tpl->tpl_vars['LOG_USER_TYPE']->value != 'employee') {?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value;
echo $_smarty_tpl->tpl_vars['user_type']->value;?>
/profile/profile_view">
                           <span class="thumb-lg w-auto-folded avatar m-t-sm">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['profile_pic']->value;?>
" class="img-full" alt="...">
                        </span>
                    </a>
                    <?php }?>
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-folded">
                        <span class="clear">
                            <span class="block m-t-sm">
                                <strong class="font-bold text-lt"><?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
</strong>
                                <b class="caret"></b>
                            </span>
                        </span>
                    </a>
                    <!-- dropdown -->
                    <ul class="dropdown-menu animated fadeInRight w hidden-folded">
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value;
echo $_smarty_tpl->tpl_vars['user_type']->value;?>
/profile/profile_view">
                                <span><?php echo lang('profile_management');?>
</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value;?>
register/user_register">
                                <span><?php echo lang('signup');?>
</span>
                            </a>
                        </li>
                        <?php if ($_smarty_tpl->tpl_vars['HELP_STATUS']->value === 'yes' && DEMO_STATUS == 'yes') {?>
                        <li>
                            <a href="https://infinitemlmsoftware.com/help" target="_blank">
                                <span><?php echo ucfirst(lang('help'));?>
</span>
                            </a>
                        </li>
                        <?php }?>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value;?>
login/logout">
                                <span><?php echo lang('logout');?>
</span>
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

                    <?php $_smarty_tpl->_assignInScope('prev_menu_id', '');
?>
                    <?php $_smarty_tpl->_assignInScope('prev_type', '');
?>
                    <?php $_smarty_tpl->_assignInScope('url', '');
?>
                    <?php $_smarty_tpl->_assignInScope('common_pages', explode(',',"19,143,4,153,154,196"));
?>
                    <?php $_smarty_tpl->_assignInScope('path_root', ((string)$_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value).((string)$_smarty_tpl->tpl_vars['user_type']->value)."/");
?>

                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LEFT_MENU']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php $_smarty_tpl->_assignInScope('current_menu_id', $_smarty_tpl->tpl_vars['v']->value['menu_id']);
?>
                        <?php if ($_smarty_tpl->tpl_vars['prev_menu_id']->value == $_smarty_tpl->tpl_vars['current_menu_id']->value) {?>
                            <?php $_smarty_tpl->_assignInScope('current_type', 'submenu');
?>
                            <?php $_smarty_tpl->_assignInScope('route_submenu_url', explode("/",$_smarty_tpl->tpl_vars['v']->value['submenu_url']));
?>
                             <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['submenu_url_id'],$_smarty_tpl->tpl_vars['common_pages']->value)) {?>
                                <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value).((string)$_smarty_tpl->tpl_vars['route_submenu_url']->value[1]));
?>
                                <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['menu_id'] == '44') {?> <!--CRM -->
                                <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value).((string)$_smarty_tpl->tpl_vars['v']->value['submenu_url']));
?>
                             <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['submenu_url_id'] != '') {?>
                                <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['path_root']->value).((string)$_smarty_tpl->tpl_vars['route_submenu_url']->value[1]));
?>
                             <?php }?> 

                            <?php $_smarty_tpl->_assignInScope('url', $_smarty_tpl->tpl_vars['full_url']->value);
?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['menu_id'] == '32') {?>
                                <?php $_smarty_tpl->_assignInScope('text_key', ((string)$_smarty_tpl->tpl_vars['v']->value['menu_id'])."_".((string)$_smarty_tpl->tpl_vars['v']->value['submenu_url_id']));
?>
                            <?php } else { ?> 
                                <?php $_smarty_tpl->_assignInScope('text_key', ((string)$_smarty_tpl->tpl_vars['v']->value['menu_id'])."_".((string)$_smarty_tpl->tpl_vars['v']->value['submenu_id'])."_".((string)$_smarty_tpl->tpl_vars['v']->value['submenu_url_id']));
?>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['table_status'] == 'yes' && $_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Board' && $_smarty_tpl->tpl_vars['v']->value['submenu_url_id'] == '101') {?>
                                 <?php $_smarty_tpl->_assignInScope('text_key', lang('2_77_101'));
?>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == 'yes' && $_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Unilevel') {?>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['submenu_url_id'] == '188') {?>
                                    <?php $_smarty_tpl->_assignInScope('text_key', lang('12_109_12'));
?>
                                <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['submenu_url_id'] == '35') {?>
                                    <?php $_smarty_tpl->_assignInScope('text_key', lang('14_28_14'));
?>
                                <?php }?>
                            <?php }?>

                        <?php } else { ?>
                            <?php $_smarty_tpl->_assignInScope('current_type', 'menu');
?>
                            <?php if ($_smarty_tpl->tpl_vars['prev_type']->value == 'submenu') {?>
                                </ul>
                                </li>
                            <?php }?>

                        <?php if ($_smarty_tpl->tpl_vars['v']->value['menu_url']) {?>
                            <?php $_smarty_tpl->_assignInScope('route_menu_url', explode("/",$_smarty_tpl->tpl_vars['v']->value['menu_url']));
?>
                            <?php $_smarty_tpl->_assignInScope('has_submenu', 'no');
?>
                            <?php $_smarty_tpl->_assignInScope('text_key', ((string)$_smarty_tpl->tpl_vars['v']->value['menu_id'])."_".((string)$_smarty_tpl->tpl_vars['v']->value['menu_url_id']));
?>
                            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == 'yes' && $_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Unilevel') {?>
                                <?php if ($_smarty_tpl->tpl_vars['text_key']->value == '46_153') {?> <?php $_smarty_tpl->_assignInScope('text_key', lang('12_109_12'));
?> <?php }?>
                            <?php }?>
                            <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['menu_url_id'],$_smarty_tpl->tpl_vars['common_pages']->value)) {?>
                                  <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value).((string)$_smarty_tpl->tpl_vars['route_menu_url']->value[1]));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['menu_url_id'] != '') {?>
                                  <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['path_root']->value).((string)$_smarty_tpl->tpl_vars['route_menu_url']->value[1]));
?>
                            <?php }?> 
                            <?php $_smarty_tpl->_assignInScope('url', $_smarty_tpl->tpl_vars['full_url']->value);
?>
                        <?php } else { ?>
                            <?php $_smarty_tpl->_assignInScope('has_submenu', 'yes');
?>
                            <?php $_smarty_tpl->_assignInScope('text_key', ((string)$_smarty_tpl->tpl_vars['v']->value['menu_id'])."_#");
?>
                            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == 'yes' && $_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Unilevel') {?>
                                <?php if ($_smarty_tpl->tpl_vars['text_key']->value == '12_#') {?>
                                    <?php $_smarty_tpl->_assignInScope('text_key', lang('12_12'));
?>
                                <?php } elseif ($_smarty_tpl->tpl_vars['text_key']->value == '14_#') {?>
                                    <?php $_smarty_tpl->_assignInScope('text_key', lang('14_14'));
?>
                                <?php }?>
                            <?php }?>
                            <?php $_smarty_tpl->_assignInScope('url', "javascript:void(0);");
?>
                             <?php $_smarty_tpl->_assignInScope('route_submenu_url', explode("/",$_smarty_tpl->tpl_vars['v']->value['submenu_url']));
?>
                            <?php }?>
                        <?php }?>

                        <?php if ($_smarty_tpl->tpl_vars['current_type']->value == 'menu') {?>
                            <li <?php if ($_smarty_tpl->tpl_vars['v']->value['is_menu_selected']) {?> class="active" <?php }?>>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" class="auto" <?php if ($_smarty_tpl->tpl_vars['v']->value['menu_target'] != 'none') {?> target="<?php echo $_smarty_tpl->tpl_vars['v']->value['menu_target'];?>
" <?php }?>>
                                    <?php if ($_smarty_tpl->tpl_vars['has_submenu']->value == 'yes') {?>
                                        <span class="pull-right text-muted">
                                            <i class="fa fa-fw fa-angle-right text"></i>
                                            <i class="fa fa-fw fa-angle-down text-active"></i>
                                        </span>
                                    <?php }?>
                                    <i class="<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
"></i>
                                    <span><?php echo lang($_smarty_tpl->tpl_vars['text_key']->value);?>
</span>
                                </a>
                                <?php if ($_smarty_tpl->tpl_vars['has_submenu']->value == 'yes') {?>
                                    <ul class="nav nav-sub dk">
                                        <?php $_smarty_tpl->_assignInScope('route_submenu_url', explode("/",$_smarty_tpl->tpl_vars['v']->value['submenu_url']));
?>
                                        <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['submenu_url_id'],$_smarty_tpl->tpl_vars['common_pages']->value)) {?>
                                            <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value).((string)$_smarty_tpl->tpl_vars['route_submenu_url']->value[1]));
?>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['menu_url_id'] != '') {?>
                                          <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['path_root']->value).((string)$_smarty_tpl->tpl_vars['route_submenu_url']->value[1]));
?>
                                        <?php }?> 
                                        <?php $_smarty_tpl->_assignInScope('url', $_smarty_tpl->tpl_vars['full_url']->value);
?>
                                        <?php $_smarty_tpl->_assignInScope('text_key', ((string)$_smarty_tpl->tpl_vars['v']->value['menu_id'])."_".((string)$_smarty_tpl->tpl_vars['v']->value['submenu_id'])."_".((string)$_smarty_tpl->tpl_vars['v']->value['submenu_url_id']));
?>
                                <?php } else { ?>
                                    </li>
                                <?php }?>
                            <?php }?>

                            <?php if ($_smarty_tpl->tpl_vars['current_type']->value == 'menu' && $_smarty_tpl->tpl_vars['v']->value['menu_url'] == '' && $_smarty_tpl->tpl_vars['v']->value['submenu_url'] != '') {?>
                                <?php $_smarty_tpl->_assignInScope('current_type', 'submenu');
?>
                                <?php $_smarty_tpl->_assignInScope('text_key', ((string)$_smarty_tpl->tpl_vars['v']->value['menu_id'])."_".((string)$_smarty_tpl->tpl_vars['v']->value['submenu_id'])."_".((string)$_smarty_tpl->tpl_vars['v']->value['submenu_url_id']));
?>
                                <?php $_smarty_tpl->_assignInScope('route_submenu_url', explode("/",$_smarty_tpl->tpl_vars['v']->value['submenu_url']));
?>
                                <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['submenu_url_id'],$_smarty_tpl->tpl_vars['common_pages']->value)) {?>
                                    <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value).((string)$_smarty_tpl->tpl_vars['route_submenu_url']->value[1]));
?>
                                <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['menu_id'] == '44') {?> <!--CRM -->
                                    <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value).((string)$_smarty_tpl->tpl_vars['v']->value['submenu_url']));
?>
                                <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['submenu_url_id'] != '') {?>
                                    <?php $_smarty_tpl->_assignInScope('full_url', ((string)$_smarty_tpl->tpl_vars['path_root']->value).((string)$_smarty_tpl->tpl_vars['route_submenu_url']->value[1]));
?>
                                <?php }?>
                                <?php $_smarty_tpl->_assignInScope('url', $_smarty_tpl->tpl_vars['full_url']->value);
?>

                            <?php }?>

                            <?php if ($_smarty_tpl->tpl_vars['current_type']->value == 'submenu') {?>
                                <li <?php if ($_smarty_tpl->tpl_vars['v']->value['is_submenu_selected']) {?> class="active" <?php }?>>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
">
                                        <span><?php echo lang($_smarty_tpl->tpl_vars['text_key']->value);?>
</span>
                                    </a>
                                </li>
                            <?php }?>

                            <?php $_smarty_tpl->_assignInScope('prev_menu_id', $_smarty_tpl->tpl_vars['current_menu_id']->value);
?>
                            <?php $_smarty_tpl->_assignInScope('prev_type', $_smarty_tpl->tpl_vars['current_type']->value);
?>

                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </ul>
            </nav>
            <!-- nav --> 
        </div>
    </div>
</aside>
<!-- / aside -->
<?php }
}
