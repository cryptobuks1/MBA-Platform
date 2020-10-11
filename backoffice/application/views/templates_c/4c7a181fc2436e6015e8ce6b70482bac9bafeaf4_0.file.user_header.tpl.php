<?php
/* Smarty version 3.1.30, created on 2020-09-25 14:33:30
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/layout/user_header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d731accde68_67830628',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c7a181fc2436e6015e8ce6b70482bac9bafeaf4' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/layout/user_header.tpl',
      1 => 1599655639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d731accde68_67830628 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!-- header -->

<header id="header" class="app-header navbar" role="menu"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- navbar header -->
    <div class="navbar-header bg-dark">
        <button class="pull-right visible-xs dk" ui-toggle-class="show" target=".navbar-collapse">
            <i class="glyphicon glyphicon-cog"></i>
        </button>
        <button class="pull-right visible-xs" ui-toggle-class="off-screen" target=".app-aside" ui-scroll="app">
            <i class="glyphicon glyphicon-align-justify"></i>
        </button>
        <!-- brand -->
        <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/home/index" class="navbar-brand text-lt">
            
            <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value["logo"];?>
" alt="." class="">
            
        </a>
        <!-- / brand -->
    </div>
    <!-- / navbar header -->

    <!-- navbar collapse -->
    <div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
        <!-- buttons -->
        <div class="nav navbar-nav hidden-xs">
            <a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="app-aside-folded" target=".app">
                <i class="fa fa-dedent fa-fw text"></i>
                <i class="fa fa-indent fa-fw text-active"></i>
            </a>
            <a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="show" target="#aside-user">
                <i class="icon-user fa-fw"></i>
            </a>
        </div>
        <!-- / buttons -->


        <ul class="nav navbar-nav">
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == 'yes') {?>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

                    <span class="visible-xs-inline"><?php echo lang('change_your_currency');?>
</span>
                    <b class="caret"></b>
                </a>
                <!-- dropdown -->
                <ul class="dropdown-menu animated fadeInRight">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['CURRENCY_ARR']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <li>
                        <a href="javascript:switchCurrency('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"><?php echo $_smarty_tpl->tpl_vars['v']->value['symbol_left'];
echo $_smarty_tpl->tpl_vars['v']->value['title'];
echo $_smarty_tpl->tpl_vars['v']->value['symbol_right'];?>
</a>
                    </li>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </ul>
                <!-- / dropdown -->
            </li>
            <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['LANG_STATUS']->value == 'yes') {?>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle width_flag">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LANG_ARR']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php if ($_smarty_tpl->tpl_vars['LANG_ID']->value == $_smarty_tpl->tpl_vars['v']->value['lang_id']) {?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/flags/<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_code'];?>
.png" />
                        <?php }?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <span class="visible-xs-inline"><?php echo lang('change_your_language');?>
</span>
                    <b class="caret"></b>
                </a>
                <!-- dropdown -->
                <ul class="dropdown-menu animated fadeInRight">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LANG_ARR']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <li>
                        <a href="javascript:changeDefaultLanguage('<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_id'];?>
');">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/flags/<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_code'];?>
.png" /> <?php echo $_smarty_tpl->tpl_vars['v']->value['lang_name'];?>

                        </a>
                    </li>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </ul>
                <!-- / dropdown -->
            </li>
            <?php }?>
             
        </ul>
        <ul class="nav navbar-nav" style="margin-top: 5px;">
        <?php if ($_smarty_tpl->tpl_vars['rank_name']->value) {?>
        <b style="font-size: 25px;color:white;"><?php echo $_smarty_tpl->tpl_vars['rank_name']->value;?>
 </b>
        <?php }?></ul>
        
           
        <!-- navbar right -->
        <ul class="nav navbar-nav navbar-right">
            
          

            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    <i class="fa fa-fw fa-envelope-o"></i>
                    <span class="visible-xs-inline"><?php echo lang('mail_notification');?>
</span>
                    <?php if ($_smarty_tpl->tpl_vars['unread_mail']->value > 0) {?>
                    <span class="badge badge-sm up bg-danger pull-right-xs"><?php echo $_smarty_tpl->tpl_vars['unread_mail']->value;?>
</span>
                    <?php }?>
                </a>
                <!-- dropdown -->
                <div class="dropdown-menu w-xl animated fadeInUp">
                    <div class="panel bg-white">
                        <div class="panel-heading b-light bg-light">
                            <strong>
                                <?php if ($_smarty_tpl->tpl_vars['unread_mail']->value > 0) {?>
                                <?php echo sprintf(lang('you_have_n_mail'),$_smarty_tpl->tpl_vars['unread_mail']->value);?>

                                <?php } else { ?>
                                <?php echo lang('you_have_no_new_mail');?>

                                <?php }?>
                            </strong>
                        </div>
                        <div class="list-group">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mail_content']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/mail/mail_management" class="list-group-item">
                                <span class="pull-left m-r thumb-sm">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['v']->value['image'];?>
" alt="..." class="img-circle">
                                </span>
                                <span class="clear block m-b-none">
                                    <?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
<br>
                                    <?php echo $_smarty_tpl->tpl_vars['v']->value['mailadsubject'];?>
<br>
                                    <small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['v']->value['mailadiddate'];?>
</small>
                                </span>
                            </a>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </div>
                        <div class="panel-footer text-sm">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/mail/mail_management" class="pull-right"><i class="fa fa-cog"></i></a>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/mail/mail_management" data-toggle="class:show animated fadeInRight"><?php echo lang('see_all_messages');?>
</a>
                        </div>
                    </div>
                </div>
                <!-- / dropdown -->
            </li>

            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    <i class="fa fa-fw fa-bell-o"></i>
                    <span class="visible-xs-inline"><?php echo lang('notification');?>
</span>
                    <?php if ($_smarty_tpl->tpl_vars['notification_count']->value > 0) {?>
                    <span class="badge badge-sm up bg-danger pull-right-xs"><?php echo $_smarty_tpl->tpl_vars['notification_count']->value;?>
</span>
                    <?php }?>
                </a>
                <!-- dropdown -->
                <div class="dropdown-menu w-xl animated fadeInUp">
                    <div class="panel bg-white">
                        <div class="panel-heading b-light bg-light">
                            <strong>
                                <?php if ($_smarty_tpl->tpl_vars['notification_count']->value > 0) {?>
                                <?php echo $_smarty_tpl->tpl_vars['notification_count']->value;?>
 <?php echo lang('missed_notification');?>

                                <?php } else { ?>
                                <?php echo lang('you_have_no_notification');?>

                                <?php }?>
                            </strong>
                        </div>
                        <div class="list-group">
                            <?php if ($_smarty_tpl->tpl_vars['payout_count']->value > 0) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/payout/payout_release_request" class="list-group-item">
                                <i class="fa fa-fw fa-bullhorn"></i>
                                <?php echo sprintf(lang('you_have_n_payout_released'),$_smarty_tpl->tpl_vars['payout_count']->value);?>

                            </a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['pin_count']->value > 0 && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['pin_status'] == "yes") {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/epin/my_epin" class="list-group-item">
                                <i class="fa fa-fw fa-bell"></i>
                                <?php echo sprintf(lang('you_have_n_epin_confirmed'),$_smarty_tpl->tpl_vars['pin_count']->value);?>

                            </a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['feedback_count']->value > 0) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/document/download_document" class="list-group-item">
                                <i class="fa fa-fw fa-film"></i>
                                
                                # <?php echo $_smarty_tpl->tpl_vars['feedback_count']->value;?>
 <?php echo lang('documents');?>

                            </a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['news_count']->value > 0) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/view_news" class="list-group-item">
                                <i class="fa fa-fw fa-newspaper-o"></i>
                                <?php echo sprintf(lang('you_have_n_news'),$_smarty_tpl->tpl_vars['news_count']->value);?>

                            </a>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <!-- / dropdown -->
            </li>

            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
                    <?php if ($_smarty_tpl->tpl_vars['LOG_USER_TYPE']->value != 'employee') {?>
                    <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['profile_pic']->value;?>
" alt="...">
                        <i class="on md b-white bottom"></i>
                    </span>
                    <?php }?>
                    <span class="hidden-sm hidden-md"><?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
</span>
                    <b class="caret"></b>
                </a>
                <!-- dropdown -->
                <ul class="dropdown-menu animated fadeInRight w">
                    <li>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT']->value;?>
user/profile/profile_view">
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
            </li>

        </ul>
        <!-- / navbar right -->
    </div>
    <!-- / navbar collapse -->
    
    <meta http-equiv="Content-Security-Policy" content="default-src *; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://d3hb14vkzrxvla.cloudfront.net connect-src chatapi.helpscout.net;" >
<?php echo '<script'; ?>
 {csp-style-nonce} type="text/javascript">!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 {csp-style-nonce} type="text/javascript">window.Beacon('init', '5f795348-49eb-4b0a-8215-4e01c8e3acf3')<?php echo '</script'; ?>
>


</header>
<!-- / header --><?php }
}
