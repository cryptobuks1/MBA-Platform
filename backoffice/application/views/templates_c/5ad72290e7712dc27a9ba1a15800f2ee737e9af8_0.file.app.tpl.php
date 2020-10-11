<?php
/* Smarty version 3.1.30, created on 2020-09-25 14:45:48
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/app.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d75fca44d88_92252736',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5ad72290e7712dc27a9ba1a15800f2ee737e9af8' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/app.tpl',
      1 => 1584362205,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d75fca44d88_92252736 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="en" class="">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/css/main.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/css/menu.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/css/responsive.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/css/app.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/plugins/zebra-datepicker/css/metallic/zebra_datepicker.min.css" />
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9890709205f6d75fca28fc4_85790552', 'style');
?>

</head>

<body data-spy="scroll" data-target="#navbar" data-offset="60">
    <input type="hidden" name="base_url" id="base_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
" />
    <input type="hidden" name="current_url" id="current_url" value="<?php echo $_smarty_tpl->tpl_vars['CURRENT_URL']->value;?>
" />
    <input type="hidden" name="current_url_full" id="current_url_full" value="<?php echo $_smarty_tpl->tpl_vars['CURRENT_URL_FULL']->value;?>
" />
    <input type="hidden" name="site_url" id="site_url" value="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/" />

    <?php if (!$_smarty_tpl->tpl_vars['MAINTENANCE_MODE']->value) {?>
    <div id='preloader'>
        <div class='loader'>
           <!--  <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/img/three-dots.svg" width="60" alt=""> -->
        </div>
    </div><!-- Preloader -->
    <div class="bg-dark_top">
        <div class="container">
            <ul class="nav navbar-nav nav-menu">
                <li class="m-l"><i class="fa fa-user-o"></i> <?php echo $_smarty_tpl->tpl_vars['USER_DATA']->value['user_name'];?>
</li>
                <li class="m-l"><i class="icon-user"></i><i class="fa fa-envelope-open-o"></i> <?php echo $_smarty_tpl->tpl_vars['USER_DATA']->value['email'];?>
</li>
                
            </ul>
            
            <?php if ($_smarty_tpl->tpl_vars['LANG_STATUS']->value == 'yes') {?>
            <div class="pull-right">
                <a class="dropdown-toggle lang-a" data-close-others="true" data-hover="dropdown" data-toggle="dropdown"
                    href="#">

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

                </a>
                <ul class="language_block dropdown-menu lang" data-hover="dropdown">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LANG_ARR']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <li onclick="getSwitchLanguage('<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_code'];?>
');">
                        <span class="dropdown-menu-title">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/flags/<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_code'];?>
.png" />
                            <?php echo $_smarty_tpl->tpl_vars['v']->value['lang_name'];?>

                        </span>
                    </li>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </ul>
            </div>
            <?php }?>
            
        </div>
    </div>
    <header id="header" class="header_section">
        <nav id="navbar_wrap" class="navbar header_1 header">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="nav-btn navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="brand"><img alt="Infinite MLM Software" src="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
../uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value['logo'];?>
"
                            style="height: 50px;"> </a> </div>
                <div id="navbar" class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav nav-menu">
                        <li <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'replica/home') {?> class="active" <?php }?>> <a href="<?php echo SITE_URL;?>
/replica/home"><?php echo lang('Home');?>
</a></li>
                        <li <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'replica/about_us') {?> class="active" <?php }?>> <a href="<?php echo SITE_URL;?>
/replica/about_us"><?php echo lang('About');?>
</a></li>
                        <li <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'replica/contact') {?> class="active" <?php }?>> <a href="<?php echo SITE_URL;?>
/replica/contact"><?php echo lang('Contact');?>
</a></li>
                        <li <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'replica/user_register') {?> class="active" <?php }?>> <a href="<?php echo SITE_URL;?>
/replica_register"><?php echo lang('Register');?>
</a></li>
                    </ul>
                </div>
                <!--/.navbar-collapse -->
            </div>
        </nav>
    </header>

    <?php if (isset($_smarty_tpl->tpl_vars['content']->value['top_banner'])) {?>
    <section id="home" class="hero_section" style='background-image: url("<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/banners/<?php echo $_smarty_tpl->tpl_vars['content']->value["top_banner"];?>
");'>
        <?php } else { ?>
        <section id="home" class="hero_section" style='background-image: url(<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
../backoffice/public_html/images/banners/banner_image1.png);'>
            <?php }?>
            <div class="container">
                <div class="display-table">
                    <div class="table-cell">
                        <div class="hero_content align-center">

                            <h1><?php echo $_smarty_tpl->tpl_vars['site_info']->value['company_name'];?>
</h1>
                            
                            <br>
                            <a href="<?php echo SITE_URL;?>
/replica_register" class="zarra_btn">Join Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- Hero Section -->

        <div class="app app-header-fixed ">
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13360500515f6d75fca39103_00448581', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

        </div>

        <?php if ($_smarty_tpl->tpl_vars['ADDON_MODULE']->value) {?>
        <div class="container" style="margin-top: 18px;">
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <p><i class="fa fa-info-circle"></i> <b>Note!</b> This is add-on module. <a href="https://infinitemlmsoftware.com/pricing.php"
                                target="_blank"><b>Click here</b></a> for more details.</p>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19808804575f6d75fca3d455_38957670', 'footer');
?>

        <a data-scroll href="#header" id="scroll-to-top"><i class="fa fa-angle-up" style="font-size: 25px;"></i> </a>

        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/js/vendor/jquery-1.12.4.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/js/vendor/bootstrap.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/js/main.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/js/switch_lang.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>
            $(function () {
                $.ajaxSetup({
                    data: {
                    <?php echo $_smarty_tpl->tpl_vars['CSRF_TOKEN_NAME']->value;?>
: "<?php echo $_smarty_tpl->tpl_vars['CSRF_TOKEN_VALUE']->value;?>
"
                }
            });
        });
        <?php echo '</script'; ?>
>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4295964985f6d75fca3eb34_71821680', 'script');
?>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ARR_SCRIPT']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
        <?php $_smarty_tpl->_assignInScope('type', $_smarty_tpl->tpl_vars['v']->value['type']);
?>
        <?php $_smarty_tpl->_assignInScope('loc', $_smarty_tpl->tpl_vars['v']->value['loc']);
?>
        <?php if ($_smarty_tpl->tpl_vars['type']->value == "js") {?>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/js/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "css") {?>
        <link href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/css/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" rel="stylesheet" type="text/css" />
        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "plugins/js") {?>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/plugins/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "plugins/css") {?>
        <link href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/plugins/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" rel="stylesheet" type="text/css" />
        <?php }?>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</body>

</html>
<?php }
}
/* {block 'style'} */
class Block_9890709205f6d75fca28fc4_85790552 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'style'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_13360500515f6d75fca39103_00448581 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'footer'} */
class Block_19808804575f6d75fca3d455_38957670 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <footer class="footer_section  bg-dark align-center">
            <div class="container">
                <p class="pull-left"><?php echo date('Y');?>
 © <?php if (isset($_smarty_tpl->tpl_vars['site_info']->value['company_name'])) {?> <?php echo $_smarty_tpl->tpl_vars['site_info']->value['company_name'];?>
 <?php } else { ?> Infinite MLM Software 10.0 - Developed by Infinite Open Source
                    Solutions LLP™ <?php }?></p>
                <div class="pull-right">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
replica/policy">Privacy Policy</a> I
                    <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
replica/terms">Terms and Conditions</a>
                </div>
            </div>
        </footer><!-- /.footer_section -->
        <?php
}
}
/* {/block 'footer'} */
/* {block 'script'} */
class Block_4295964985f6d75fca3eb34_71821680 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'script'} */
}
