<?php
/* Smarty version 3.1.30, created on 2020-08-04 23:12:16
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/app.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f295eb0c5e723_95191538',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '42fda370cf3b22e247845c6f40c4a2a8bf34b605' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/app.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f295eb0c5e723_95191538 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="en" class="">

<head>
    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
    <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 5.0, user-scalable = yes">


    
    <link rel="shortcut icon" type="image/png" href="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value["favicon"];?>
" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/assets/animate.css/animate.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/assets/font-awesome/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/assets/simple-line-icons/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/bootstrap/dist/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/css/font.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/zebra-datepicker/css/metallic/zebra_datepicker.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/autocomplete/jquery.autocomplete.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/css/app.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/css/custom.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/tooltipster/css/tooltipster.bundle.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css" type="text/css" />

    

    
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ARR_SCRIPT']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
        <?php $_smarty_tpl->_assignInScope('type', $_smarty_tpl->tpl_vars['v']->value['type']);
?>
        <?php $_smarty_tpl->_assignInScope('loc', $_smarty_tpl->tpl_vars['v']->value['loc']);
?>
        <?php if ($_smarty_tpl->tpl_vars['loc']->value == "header") {?>
            <?php if ($_smarty_tpl->tpl_vars['type']->value == "js") {?>
                <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text/javascript" ><?php echo '</script'; ?>
>
            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "css") {?>
                <link href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
css/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" rel="stylesheet" type="text/css" />
            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "plugins/js") {?>
                <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
plugins/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text/javascript" ><?php echo '</script'; ?>
>
            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "plugins/css") {?>
                <link href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
plugins/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" rel="stylesheet" type="text/css" />
            <?php }?>
        <?php }?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3984566915f295eb0c47cd5_15260224', 'style');
?>


</head>

<body>

    
    <input type = "hidden" name = "base_url" id = "base_url" value = "<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
" />
    <input type = "hidden" name = "img_src_path" id="img_src_path" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
"/>
    <input type = "hidden" name = "current_url" id = "current_url" value = "<?php echo $_smarty_tpl->tpl_vars['CURRENT_URL']->value;?>
" />
    <input type = "hidden" name = "current_url_full" id = "current_url_full" value = "<?php echo $_smarty_tpl->tpl_vars['CURRENT_URL_FULL']->value;?>
" />
    <input type = "hidden" name = "DEFAULT_CURRENCY_VALUE" id="DEFAULT_CURRENCY_VALUE" value="<?php echo $_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value;?>
"/>
    <input type = "hidden" name = "DEFAULT_CURRENCY_CODE" id="DEFAULT_CURRENCY_CODE" value="<?php echo $_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_CODE']->value;?>
"/>
    <input type = "hidden" name = "DEFAULT_SYMBOL_LEFT" id="DEFAULT_SYMBOL_LEFT" value="<?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
"/>
    <input type = "hidden" name = "DEFAULT_SYMBOL_RIGHT" id="DEFAULT_SYMBOL_RIGHT" value="<?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
"/>
    <input type = "hidden" name = "DEFAULT_PRECISION" id="DEFAULT_PRECISION" value="<?php echo $_smarty_tpl->tpl_vars['PRECISION']->value;?>
"/>
    <?php if ($_smarty_tpl->tpl_vars['LOG_USER_ID']->value) {?>
    <input type = "hidden" name = "logout_time" id="logout_time" value="<?php echo $_smarty_tpl->tpl_vars['Logout_time']->value;?>
"/>
    <?php }?>

    <?php $_smarty_tpl->_assignInScope('left_symbol', NULL);
?>
    <?php $_smarty_tpl->_assignInScope('right_symbol', NULL);
?>
    <?php $_smarty_tpl->_assignInScope('input_group_hide', "input-group-hide");
?>
    <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?>
        <?php $_smarty_tpl->_assignInScope('input_group_hide', '');
?>
        <?php $_smarty_tpl->_assignInScope('left_symbol', "<span class='input-group-addon'>".((string)$_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value)."</span>");
?>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value) {?>
        <?php $_smarty_tpl->_assignInScope('input_group_hide', '');
?>
        <?php $_smarty_tpl->_assignInScope('right_symbol', "<span class='input-group-addon'>".((string)$_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value)."</span>");
?>
    <?php }?>
    <input type="hidden" name="input_group_hide" id="input_group_hide" value="<?php echo $_smarty_tpl->tpl_vars['input_group_hide']->value;?>
">

    

    <div class="app app-header-fixed ">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21178128545f295eb0c4ce41_43591501', 'header');
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13809434445f295eb0c4d552_25462995', 'sidebar');
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9918440435f295eb0c4dc22_65229031', 'content');
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4663483285f295eb0c4e2c4_29539659', 'footer');
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18163401175f295eb0c4e978_61046621', 'theme_setting');
?>

    </div>

    
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/jquery/dist/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
        $(function() {
            $.ajaxSetup({
                data: {
                    <?php echo $_smarty_tpl->tpl_vars['CSRF_TOKEN_NAME']->value;?>
: "<?php echo $_smarty_tpl->tpl_vars['CSRF_TOKEN_VALUE']->value;?>
"
                }
            });
            themeSettingData = <?php echo $_smarty_tpl->tpl_vars['THEME_SETTING']->value;?>
;
        });
    <?php echo '</script'; ?>
>
    <?php if ($_smarty_tpl->tpl_vars['LANG_ID']->value == 1) {?>  <?php $_smarty_tpl->_assignInScope('lang_code', '');
?> <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 2) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_es');
?> <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 3) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_ch');
?> <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 4) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_de');
?>  <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 5) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_pt');
?> <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 6) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_fr');
?> 
    <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 7) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_it');
?> <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 8) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_tr');
?> <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 9) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_po');
?> <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 10) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_ar');
?> <?php } elseif ($_smarty_tpl->tpl_vars['LANG_ID']->value == 11) {?> <?php $_smarty_tpl->_assignInScope('lang_code', '_ru');
?>  <?php } else { ?> <?php $_smarty_tpl->_assignInScope('lang_code', '');
?> <?php }?>
    
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/bootstrap/dist/js/bootstrap.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/ui-load.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/ui-jp.config.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/ui-jp.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/ui-nav.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/ui-toggle.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/ui-client.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/wizard.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/theme-setting.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/zebra-datepicker/zebra_datepicker.min<?php echo $_smarty_tpl->tpl_vars['lang_code']->value;?>
.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/autocomplete/jquery.autocomplete.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/js/custom.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/tooltipster/js/tooltipster.bundle.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
plugins/jquery-validation/dist/jquery.validate.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/main.js"><?php echo '</script'; ?>
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
        <?php if ($_smarty_tpl->tpl_vars['loc']->value == "footer") {?>
            <?php if ($_smarty_tpl->tpl_vars['type']->value == "js") {?>
                <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text/javascript" ><?php echo '</script'; ?>
>
            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "css") {?>
                <link href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
css/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" rel="stylesheet" type="text/css" />
            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "plugins/js") {?>
                <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
plugins/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text/javascript" ><?php echo '</script'; ?>
>
            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "plugins/css") {?>
                <link href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
plugins/<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" rel="stylesheet" type="text/css" />
            <?php }?>
        <?php }?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20961342925f295eb0c5db10_41086864', 'script');
?>


</body>

</html>
<?php }
/* {block 'style'} */
class Block_3984566915f295eb0c47cd5_15260224 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'style'} */
/* {block 'header'} */
class Block_21178128545f295eb0c4ce41_43591501 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'header'} */
/* {block 'sidebar'} */
class Block_13809434445f295eb0c4d552_25462995 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'sidebar'} */
/* {block 'content'} */
class Block_9918440435f295eb0c4dc22_65229031 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'content'} */
/* {block 'footer'} */
class Block_4663483285f295eb0c4e2c4_29539659 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'footer'} */
/* {block 'theme_setting'} */
class Block_18163401175f295eb0c4e978_61046621 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'theme_setting'} */
/* {block 'script'} */
class Block_20961342925f295eb0c5db10_41086864 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'script'} */
}