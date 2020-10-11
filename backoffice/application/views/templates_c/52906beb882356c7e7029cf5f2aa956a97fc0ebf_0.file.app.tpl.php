<?php
/* Smarty version 3.1.30, created on 2020-09-26 16:51:23
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/lcp/app.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6ee4eb002691_89972851',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52906beb882356c7e7029cf5f2aa956a97fc0ebf' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/lcp/app.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6ee4eb002691_89972851 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
    <link rel="shortcut icon" type="image/png" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value['favicon'];?>
" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="VBThemes" />
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
css/lcp/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
css/lcp/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
css/lcp/layout.css">
    
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13205558785f6ee4eaf3b8f7_42743798', 'style');
?>

</head>

<body>
<input type="hidden" name="base_url" id="base_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
" />
    <input type="hidden" name="current_url" id="current_url" value="<?php echo $_smarty_tpl->tpl_vars['CURRENT_URL']->value;?>
" />
    <input type="hidden" name="current_url_full" id="current_url_full" value="<?php echo $_smarty_tpl->tpl_vars['CURRENT_URL_FULL']->value;?>
" />

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15434701435f6ee4eaf3c717_03054397', 'content');
?>

  
  
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/jquery.validate.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/switch_lang.js" type="text/javascript"><?php echo '</script'; ?>
>
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
javascript/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "css") {?>
            <link href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
css/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" rel="stylesheet" type="text/css" />
        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "plugins/js") {?>
            <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
plugins/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "plugins/css") {?>
            <link href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
plugins/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" rel="stylesheet" type="text/css" />
        <?php }?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


    <?php $_smarty_tpl->_assignInScope('curr_date', date('Y'));
?>
    <p class="text-center">
    <?php echo $_smarty_tpl->tpl_vars['curr_date']->value;?>
 © <?php echo $_smarty_tpl->tpl_vars['site_info']->value['company_name'];?>
 
    <?php if ($_smarty_tpl->tpl_vars['FOOTER_DEMO_STATUS']->value == 'yes') {?>
    - <?php echo lang('developed_by_infinite_open_source_solution_llp');?>

    <?php }?>
</p>
    <?php echo '<script'; ?>
>
        jQuery(document).ready(function () {
            jQuery("#close_link").click(function () {
                jQuery("#message_box").fadeOut(1000);
            });
        });
    <?php echo '</script'; ?>
>
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12411983145f6ee4eb0020c3_33882923', 'script');
?>

</body>

</html><?php }
/* {block 'style'} */
class Block_13205558785f6ee4eaf3b8f7_42743798 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'style'} */
/* {block 'content'} */
class Block_15434701435f6ee4eaf3c717_03054397 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'content'} */
/* {block 'script'} */
class Block_12411983145f6ee4eb0020c3_33882923 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'script'} */
}
