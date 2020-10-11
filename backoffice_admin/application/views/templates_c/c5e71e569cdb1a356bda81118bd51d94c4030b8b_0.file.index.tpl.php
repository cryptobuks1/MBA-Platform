<?php
/* Smarty version 3.1.30, created on 2020-08-05 05:53:36
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/home/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f29bcc0985fa8_73277285',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c5e71e569cdb1a356bda81118bd51d94c4030b8b' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/home/index.tpl',
      1 => 1591251808,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/configuration/system_setting_common.tpl' => 1,
    'file:layout/demo_footer.tpl' => 1,
  ),
),false)) {
function content_5f29bcc0985fa8_73277285 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/home/mbatradingacadem/public_html/office/backoffice_admin/application/third_party/Smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_capitalize')) require_once '/home/mbatradingacadem/public_html/office/backoffice_admin/application/third_party/Smarty/plugins/modifier.capitalize.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_642778445f29bcc0927f54_12604566', 'script');
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1327557705f29bcc0978f00_94798336', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php if ($_smarty_tpl->tpl_vars['LOG_USER_TYPE']->value != 'employee') {?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11573900745f29bcc0983fa0_69231472', 'right_content');
?>


<?php }?>

<?php if ($_smarty_tpl->tpl_vars['LOG_USER_TYPE']->value != 'employee') {
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13851789505f29bcc0985965_61678606', 'home_wrapper_out');
?>

<?php }
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'script'} */
class Block_642778445f29bcc0927f54_12604566 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
plugins/clipboard.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/todo_config.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
        country_map_data = <?php echo $_smarty_tpl->tpl_vars['map_data']->value;?>
;
    <?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
/* {block 'ewallet'} */
class Block_21058612315f29bcc0932ad1_82052890 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                 <div class="col-xs-6">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round(($_smarty_tpl->tpl_vars['roi_details']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value),2);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
                        <span class="text-muted text-xs"><?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == "yes") {
echo lang('total_deposit');
} else {
echo lang('Hyip');
}?></span>
                        <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                     <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/roi_details"><?php echo lang('view_more');?>
</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                 <?php
}
}
/* {/block 'ewallet'} */
/* {block 'mail'} */
class Block_19678211165f29bcc0934ff7_58929577 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

               <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable1=ob_get_clean();
if ($_prefixVariable1 != "Donation" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] != "yes") {?>                 
                <div class="col-xs-6" id="section_tile4">
                   <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">
                            <?php echo $_smarty_tpl->tpl_vars['total_active_ibo']->value;?>

                        </div>
                        <span class="text-muted text-xs"><?php echo lang('total_active_ibo');?>
</span>
                       
                    </div>
                </div>
                <?php }?>
                <?php
}
}
/* {/block 'mail'} */
/* {block 'sales'} */
class Block_11162544165f29bcc09370a1_37257985 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                 <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable2=ob_get_clean();
if ($_prefixVariable2 != "Donation" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] != "yes") {?>        
                <div class="col-xs-6" id="section_tile2">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1" id="sales_total"><?php echo $_smarty_tpl->tpl_vars['monthly_sales']->value;?>
</div>
                        <span class="text-muted text-xs"><?php echo lang('sales');?>
</span>
                        <div class="top text-right w-full">
                           
                        </div>
                    </div>
                </div>
                <?php }?> 
                <?php
}
}
/* {/block 'sales'} */
/* {block 'mail'} */
class Block_7854037035f29bcc0939624_36640059 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

               <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable3=ob_get_clean();
if ($_prefixVariable3 != "Donation" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] != "yes") {?>                 
                <div class="col-xs-6" id="section_tile4">
                   <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">
                            <?php echo $_smarty_tpl->tpl_vars['new_active_ibo']->value;?>

                        </div>
                        <span class="text-muted text-xs"><?php echo lang('new_ibo');?>
</span>
                       
                    </div>
                </div>
                <?php }?>
                <?php
}
}
/* {/block 'mail'} */
/* {block 'ewallet'} */
class Block_14804524815f29bcc093b352_28120828 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <div class="col-xs-6" id="section_tile1">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">
                            <?php echo $_smarty_tpl->tpl_vars['read_mail']->value;?>

                        </div>
                        <span class="text-muted text-xs"><?php echo lang('mail');?>
</span>
                       
                    </div>
                </div>
                 <?php
}
}
/* {/block 'ewallet'} */
/* {block 'sales'} */
class Block_6702682575f29bcc093d375_72935606 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                 <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable4=ob_get_clean();
if ($_prefixVariable4 != "Donation" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] != "yes") {?>        
                <div class="col-xs-6" id="section_tile2">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1" id="sales_total"><?php echo $_smarty_tpl->tpl_vars['new_customer']->value;?>
</div>
                        <span class="text-muted text-xs"><?php echo lang('new_customer');?>
</span>
                        
                    </div>
                </div>
                <?php }?> 
                <?php
}
}
/* {/block 'sales'} */
/* {block 'active_deposit'} */
class Block_1568310375f29bcc0940039_15458038 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                     <div class="col-xs-6">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round(($_smarty_tpl->tpl_vars['total_active_deposit']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value),2);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
                        <span class="text-muted text-xs"><?php echo lang('active_deposit');?>
</span>
                        <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                     <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/active_deposit"><?php echo lang('view_more');?>
</a></li>
                                </ul>
                            </div>
                        </div>
                      </div>
                    </div>
                    <?php
}
}
/* {/block 'active_deposit'} */
/* {block 'matured_deposit'} */
class Block_5793326305f29bcc0941fb1_38789059 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                    <div class="col-xs-6">
                        <div class="panel padder-v item">
                            <div class="text-info font-thin h1 block1"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round(($_smarty_tpl->tpl_vars['total_matured_deposit']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value),2);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
                            <span class="text-muted text-xs"><?php echo lang('matured_deposit');?>
</span>

                            <div class="top text-right w-full">
                                <div class="dropdown">
                                    <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                    <ul class="dropdown-menu dropdown-menu_right">

                                        <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/matured_deposit"><?php echo lang('view_more');?>
</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
}
}
/* {/block 'matured_deposit'} */
/* {block 'replica'} */
class Block_20535172525f29bcc0947da8_00815165 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['replicated_site_status'] == "yes") {?>
                    <div class="col-xs-12" id="section_tile5">
                        <div class="panel item">
                            <div class="panel-body">
                                <div class="pull-right icon_margin_top">
                                    <button title="<?php echo lang('share_link');?>
" onclick="twittershare('<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');" class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
                                    
                                    <button title="<?php echo lang('share_link');?>
" onclick="facebookShare('https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');" class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
                                </div>
                                <div class="clear pull-left">
                                    <div class="text-left m-b-xs block"><?php echo lang('Your_Replicated_Website_Link');?>
<i class="icon-twitter"></i></div>
                                    
                                        <div data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
" id="copy_link_replica" class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i class="fa fa-copy text-info"></i><?php echo lang('copy_link');?>
</div>
                                         
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            <?php
}
}
/* {/block 'replica'} */
/* {block 'ewallet'} */
class Block_1697696135f29bcc094b212_76858816 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                 <div class="col-xs-6">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round(($_smarty_tpl->tpl_vars['roi_details']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value),2);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
                        <span class="text-muted text-xs"><?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == "yes") {
echo lang('total_deposit');
} else {
echo lang('Hyip');
}?></span>
                        <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                     <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/roi_details"><?php echo lang('view_more');?>
</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                 <?php
}
}
/* {/block 'ewallet'} */
/* {block 'ewallet'} */
class Block_11545412805f29bcc094d1d5_60669220 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <div class="col-xs-6" id="section_tile1">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1">
                            <?php echo $_smarty_tpl->tpl_vars['business_summery']->value;?>

                        </div>
                        <span class="text-muted text-xs"><?php echo lang('revenue');?>
</span>
                       
                    </div>
                </div>
                 <?php
}
}
/* {/block 'ewallet'} */
/* {block 'payout'} */
class Block_7135919915f29bcc094e470_24244966 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <div class="col-xs-6" id="section_tile3">
                    <div class="panel padder-v item bg-info">
                        <div class="text-white font-thin h1 block1" id="total_payout">
                            <?php echo $_smarty_tpl->tpl_vars['total_payout']->value;?>

                        </div>
                        <span class="text-muted text-xs"><?php echo lang('payout');?>
</span>
                       
                    </div>
                </div>
               <?php
}
}
/* {/block 'payout'} */
/* {block 'sales'} */
class Block_1741999275f29bcc0951b93_78715255 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                 <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable7=ob_get_clean();
if ($_prefixVariable7 != "Donation" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] != "yes") {?>        
               <div class="col-xs-6" id="section_tile1">
                    <div class="panel padder-v item">
                        <div class="h1 text-info font-thin h1"><?php echo $_smarty_tpl->tpl_vars['total_sales']->value;?>
</div>
                        <span class="text-muted text-xs"><?php echo lang('total_sales');?>
</span>
                        <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right" id="sales_dash">
                                    <li class="active"><a href="javascript:void(0);" id="all_sales"><i class="fa fa-list margin-r-5"></i> <?php echo lang('all');?>
</a></li>
                                    <li><a href="javascript:void(0);" id="yearly_sales"><i class="fa fa-calendar margin-r-5"></i> <?php echo lang('this_year');?>
</a></li>
                                    <li><a href="javascript:void(0);" id="monthly_sales"><i class="fa fa-calendar margin-r-5"></i> <?php echo lang('this_month');?>
</a></li>
                                    <li><a href="javascript:void(0);" id="weekly_sales"><i class="fa fa-calendar margin-r-5"></i> <?php echo lang('this_week');?>
</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?> 
                <?php
}
}
/* {/block 'sales'} */
/* {block 'lcp'} */
class Block_15693728655f29bcc0955ba0_68227871 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['lead_capture_status'] == "yes") {?>
                    <!-- <div class="col-xs-12" id="section_tile6">
                        <div class="panel item">
                            <div class="panel-body">
                                <div class="pull-right icon_margin_top">
                                    <button title="<?php echo lang('share_link');?>
" onclick="twittershare('<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');" class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
                                    
                                    <button title="<?php echo lang('share_link');?>
" onclick="facebookShare('https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');" class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
                                </div>
                                <div class="clear pull-left">
                                    <div class="text-left m-b-xs block"><?php echo lang('Your_Lead_Capture_Page');?>
<i class="icon-twitter"></i></div>
                                    
                                        <div id="copy_link_lcp" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
" class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i class="fa fa-copy text-info"></i><?php echo lang('copy_link');?>
</div>
                                         
                                </div>
                            </div>
                        </div>
                    </div> -->
                <?php }?>
            <?php
}
}
/* {/block 'lcp'} */
/* {block 'joinings'} */
class Block_1607636125f29bcc0961d25_84725369 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
        <div class="col wrapper">
            <div class="dropdown pull-right">
                <div data-toggle="dropdown" aria-expanded="false"><i class="fas fa fa-cog fa-spin"></i></div>
                <ul class="dropdown-menu dropdown-menu_right" id="joinings_graph">
                    <li class="active"><a id="yearly_joining_graph" href="javascript:void(0);"><i class="fa fa-calendar margin-r-5"></i> <?php echo lang('year');?>
</a></li>
                    <li><a id="monthly_joining_graph" href="javascript:void(0);"><i class="fa fa-calendar margin-r-5"></i> <?php echo lang('month');?>
</a></li>
                    <li><a id="daily_joining_graph" href="javascript:void(0);"><i class="fa fa-calendar margin-r-5"></i> <?php echo lang('day');?>
</a></li>
                </ul>
            </div>
            <h4 class="font-thin m-t-none m-b-none"><?php echo lang('current_joinings');?>
</h4>
            <span class="m-b block text-sm text-muted"></span>
            <div id="joining_graph_div"  style="height: 240px;"></div>
        </div>
        <?php if (count($_smarty_tpl->tpl_vars['prgrsbar_data']->value) > 0 && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['product_status'] == 'yes') {?>
            <div class="col wrapper-lg w-lg bg-light dk r-r">
                <h4 class="font-thin m-t-none m-b"><?php echo lang('membership');?>
</h4>
                <?php $_smarty_tpl->_assignInScope('j', 0);
?>
                <div class="">
                    <?php $_smarty_tpl->_assignInScope('text_class', array('text-primary','text-primary','text-primary','text-primary'));
?>
                    <?php $_smarty_tpl->_assignInScope('bg_class', array('bg-primary','bg-primary','bg-primary','bg-primary'));
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['prgrsbar_data']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <div class="">
                            <span class="pull-right <?php echo $_smarty_tpl->tpl_vars['text_class']->value[$_smarty_tpl->tpl_vars['j']->value];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['joining_count'];?>
</span>
                            <span><?php echo $_smarty_tpl->tpl_vars['v']->value['package_name'];?>
</span>
                        </div>
                        <div class="progress progress-xs m-t-sm bg-white">
                            <div class="progress-bar <?php echo $_smarty_tpl->tpl_vars['bg_class']->value[$_smarty_tpl->tpl_vars['j']->value];?>
" data-toggle="tooltip" data-original-title="<?php echo $_smarty_tpl->tpl_vars['prgrsbar_data']->value[0]['perc']*$_smarty_tpl->tpl_vars['v']->value['joining_count'];?>
%" style="width: <?php echo $_smarty_tpl->tpl_vars['prgrsbar_data']->value[0]['perc']*$_smarty_tpl->tpl_vars['v']->value['joining_count'];?>
%"></div>
                        </div>
                        <?php $_smarty_tpl->_assignInScope('j', $_smarty_tpl->tpl_vars['j']->value+1);
?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </div>
                <?php if ($_smarty_tpl->tpl_vars['j']->value > 3) {?>
                    <div class="pull-right margin_top_mobile">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/home/package_list" class="read_more bg-primary"><?php echo lang('view_more');?>
</a>
                    </div>
                <?php }?>
            </div>
        <?php }?>
    <?php
}
}
/* {/block 'joinings'} */
/* {block 'to_do'} */
class Block_708007875f29bcc096f050_15829010 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
    <div class="panel wrapper">
        <div class="row">
            <div class="col-md-6 b-r b-light no-border-xs">
                <a href="javascript:loadModal(1, '<?php echo lang('to_do_list');?>
', 'admin/home/add_todo');" data-toggle="modal" class="text-muted pull-right text-lg" title="<?php echo lang('add_task');?>
"><i class="icon-plus"></i></a>
                <h4 class="font-thin m-t-none m-b-md text-muted"><?php echo lang('to_do_list');?>
</h4>
                <div class=" m-b todo_list_height">
                    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                    <?php $_smarty_tpl->_assignInScope('todo_pending', 0);
?>
                    <?php $_smarty_tpl->_assignInScope('todo_done', 0);
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['todo_list']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php if ($_smarty_tpl->tpl_vars['v']->value['status'] == 'completed') {?>
                            <?php $_smarty_tpl->_assignInScope('todo_done', $_smarty_tpl->tpl_vars['todo_done']->value+1);
?>
                        <?php } else { ?>
                            <?php $_smarty_tpl->_assignInScope('todo_pending', $_smarty_tpl->tpl_vars['todo_pending']->value+1);
?>
                        <?php }?>
                        <?php echo form_open('admin/home/delete_todo','role="form" class="" method="post" name="todo_register" id="todo_form"');?>

                            <input type='hidden' name="tsk_id" id="tsk_id" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['task_id'];?>
">
                            <div class="m-b">
                                <div class="pull-right m-l">
                                    <span class="label text-base bg-light pos-rlt m-r">
                                        <i class="arrow right arrow-light"></i>
                                        <?php echo $_smarty_tpl->tpl_vars['v']->value['time'];?>

                                    </span>
                                    <button type="submit" class="btn-link h4 text-danger" onclick="return deleteTask();" title=<?php echo lang('delete');?>
><i class="fa fa-trash-o"></i></button>
                                    <button type="button" class="btn-link h4 text-info" onclick="loadModal(<?php echo $_smarty_tpl->tpl_vars['v']->value['task_id'];?>
, '<?php echo lang('to_do_list');?>
', 'admin/home/edit_todo');" title="<?php echo lang('edit_list');?>
"><i class="fa fa-edit"></i></button>
                                </div>
                                <div class="clear">
                                    <a href="javascript:void(0);" class=" block m-b-sm">
                                        <div class="checkbox">
                                            <label class="i-checks">
                                                <input type="checkbox" onclick="statusChange(<?php echo $_smarty_tpl->tpl_vars['v']->value['task_id'];?>
, $(this));" <?php if ($_smarty_tpl->tpl_vars['v']->value['status'] == 'completed') {?> checked <?php }?>>
                                                <i></i><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['v']->value['task'],15);?>

                                            </label>
                                        </div>
                                        <i class="icon-twitter"></i>
                                    </a>
                                </div>
                            </div>
                        <?php echo form_close();?>

                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value++);
?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <?php if (count($_smarty_tpl->tpl_vars['todo_list']->value) <= 0) {?>
                        <div><?php echo lang('no_data_found');?>
</div>
                    <?php }?>
                </div>
            </div>
            <?php $_smarty_tpl->_assignInScope('todo_done_percent', 0);
?>
            <?php $_smarty_tpl->_assignInScope('todo_pending_percent', 0);
?>
            <?php if (count($_smarty_tpl->tpl_vars['todo_list']->value) > 0) {?>
                <?php $_smarty_tpl->_assignInScope('todo_done_percent', ($_smarty_tpl->tpl_vars['todo_done']->value/count($_smarty_tpl->tpl_vars['todo_list']->value))*100);
?>
                <?php $_smarty_tpl->_assignInScope('todo_pending_percent', ($_smarty_tpl->tpl_vars['todo_pending']->value/count($_smarty_tpl->tpl_vars['todo_list']->value))*100);
?>
            <?php }?>
            <input type="hidden" id="todo_done_percent" value="<?php echo $_smarty_tpl->tpl_vars['todo_done_percent']->value;?>
">
            <input type="hidden" id="todo_pending_percent" value="<?php echo $_smarty_tpl->tpl_vars['todo_pending_percent']->value;?>
">
            <div class="col-md-6">
                <div class="row row-sm">
                    <div class="col-xs-6 text-center">
                        <div id="todo_done" class="inline m-t">
                            <div><span class="text-primary h4"><?php echo round($_smarty_tpl->tpl_vars['todo_done_percent']->value);?>
%</span></div>
                        </div>
                        <div class="text-muted font-bold text-base m-t m-b"><?php echo lang('done');?>
</div>
                    </div>
                    <div class="col-xs-6 text-center">
                        <div id="todo_pending" class="inline m-t">
                            <div> <span class="text-info h4"><?php echo round($_smarty_tpl->tpl_vars['todo_pending_percent']->value);?>
%</span> </div>
                        </div>
                        <div class="text-muted font-bold text-base m-t m-b"><?php echo lang('pending');?>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
}
/* {/block 'to_do'} */
/* {block 'top_earners'} */
class Block_2894648435f29bcc0973300_22913033 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
        <div class="col-md-6" style="min-height:640px;">
            <div class="panel no-border" id="section_top_earners">
                <div class="panel-heading wrapper b-b b-light">
                    <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo lang('top_earners');?>
</h4>
                </div>
                <ul class="list-group list-group-lg m-b-none">
                    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['top_earners']->value, 'j');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value) {
?>
                        <li class="list-group-item">
                            <a href="javascript:void(0);" class="thumb-sm m-r">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['j']->value['profile_picture_full'];?>
" class="r r-2x">
                            </a>
                             <span class="pull-right text-muted inline m-t-sm"><?php echo $_smarty_tpl->tpl_vars['j']->value['place'];?>
</span><!--balance_amount-->
                            <a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['j']->value['user_name'];?>
</a>
                        </li>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
                        <li class="list-group-item"><?php echo lang('no_data_found');?>
</li>
                    <?php }?>
                </ul>
            </div>
        </div>
    <?php
}
}
/* {/block 'top_earners'} */
/* {block 'social_media'} */
class Block_16915753135f29bcc0977229_74594223 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
            
        <div class="col-md-6">
            <div class="list-group list-group-lg list-group-sp" id="section_social_media">
                <a href="<?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['fb_link'];?>
" target="_blank" class="list-group-item clearfix">
                    <span class="pull-left m-r">
                        <button class="btn btn-rounded btn-lg btn-icon btn-facebook">
                            <i class="fa fa-facebook"></i>
                        </button>
                    </span>
                    <span class="clear">
                        <span><?php echo lang('facebook_users');?>
</span>
                        <span class="social_iocs pull-center hidden-xs"><?php echo lang('facebook');?>
</span>
                        <small class="text-muted clear text-ellipsis"><?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['fb_count'];?>
 +</small>
                    </span>
                </a>
                
                <a href="<?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['twitter_link'];?>
" target="_blank" class="list-group-item clearfix">
                    <span class="pull-left m-r">
                        <button class="btn btn-rounded btn-lg btn-icon btn-info">
                            <i class="fa fa-twitter"></i>
                        </button>
                    </span>
                    <span class="clear">
                        <span><?php echo lang('twitter_users');?>
</span>
                        <span class="social_iocs pull-center hidden-xs"><?php echo lang('twitter');?>
</span>
                        <small class="text-muted clear text-ellipsis"><?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['twitter_count'];?>
 +</small>
                    </span>
                </a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['inst_link'];?>
" target="_blank" class="list-group-item clearfix">
                    <span class="pull-left m-r">
                        <button class="btn btn-rounded btn-lg btn-icon btn-instagarm">
                            <i class="fa fa-instagram"></i>
                        </button>
                    </span>
                    <span class="clear">
                        <span><?php echo lang('instagram_users');?>
</span>
                        <span class="social_iocs pull-center hidden-xs"><?php echo lang('instagram');?>
</span>
                        <small class="text-muted clear text-ellipsis"><?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['inst_count'];?>
 +</small>
                    </span>
                </a>
            </div>
        </div>
    <?php
}
}
/* {/block 'social_media'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_1327557705f29bcc0978f00_94798336 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" style="display: none;">
    <span id="left_join"><?php echo lang('left_join');?>
</span>
    <span id="right_join"><?php echo lang('right_join');?>
</span>
    <span id="join"><?php echo lang('joinings');?>
</span>
    <span id="confirm_msg"><?php echo lang('are_you_sure_want_delete');?>
</span>
</div>

<?php if ($_smarty_tpl->tpl_vars['LOG_USER_TYPE']->value != 'employee') {?>

<input name="mlm_plan" id="mlm_plan" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;?>
" />
<div id="span_js_messages" style="display: none;"> <span id="left_join"><?php echo lang('left_join');?>
</span> <span id="right_join"><?php echo lang('right_join');?>
</span> <span id="join"><?php echo lang('joinings');?>
</span> <span id="confirm_msg"><?php echo lang('are_you_sure_want_delete');?>
</span> </div>
<div class="col">
    <div class="row">
        <div class="col-lg-6 col-md-12" id="section_tile">
            <div class="row row-sm text-center">
                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['roi_status'] == "yes") {?>
                 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21058612315f29bcc0932ad1_82052890', 'ewallet', $this->tplIndex);
?>

                 <?php }?>

               <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19678211165f29bcc0934ff7_58929577', 'mail', $this->tplIndex);
?>


                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11162544165f29bcc09370a1_37257985', 'sales', $this->tplIndex);
?>


                 <div class="col-xs-6" id="section_tile3">
                    <div class="panel padder-v item bg-info">
                        <div class="text-white font-thin h1 block1" id="total_payout">
                            <?php echo $_smarty_tpl->tpl_vars['active_user_count']->value;?>

                        </div>
                        <span class="text-muted text-xs"><?php echo lang('active_user_count');?>
</span>
                       
                    </div>
                </div>

               <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7854037035f29bcc0939624_36640059', 'mail', $this->tplIndex);
?>

                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['ewallet_status'] == "yes" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['roi_status'] == "no") {?> 
                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14804524815f29bcc093b352_28120828', 'ewallet', $this->tplIndex);
?>

                 <?php }?>
                 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6702682575f29bcc093d375_72935606', 'sales', $this->tplIndex);
?>

                  <!---hyip section-->
                 <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable5=ob_get_clean();
if ($_prefixVariable5 == "Unilevel" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == "yes") {?> 
                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1568310375f29bcc0940039_15458038', 'active_deposit', $this->tplIndex);
?>

                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5793326305f29bcc0941fb1_38789059', 'matured_deposit', $this->tplIndex);
?>

                <?php }?>
                 <!---end hyip section-->
                 
                 <!---DONATION TILE-->
                  <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable6=ob_get_clean();
if ($_prefixVariable6 == "Donation") {?> 
                  <div class="col-xs-6">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['given_commission']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
                        <span class="text-muted text-xs"><?php echo lang('given_donation');?>
</span>
                         <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                   <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/donation/given_donation_report"> <?php echo lang('view_more');?>
</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-xs-6">
                    
                    <div class="panel padder-v item bg-white">
                        <div class="text-info font-thin h1 block1"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['recieved_commission']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
                        <span class="text-muted text-xs"><?php echo lang('received_donation');?>
</span>
                          <div class="top text-right w-full">
                            <div class="dropdown">
                                <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                                <ul class="dropdown-menu dropdown-menu_right">
                                     
                                    <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/donation/recieve_donation_report"><?php echo lang('view_more');?>
</a></li>
                                     
                                </ul>
                            </div>
                        </div>
                         
                    </div> 
                </div>
                <?php }?>
                <!--END DONATION TILE-->
                
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20535172525f29bcc0947da8_00815165', 'replica', $this->tplIndex);
?>

            
            </div>
        </div>
 <div class="col-lg-6 col-md-12" id="section_tile">
            <div class="row row-sm text-center">
                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['roi_status'] == "yes") {?>
                 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1697696135f29bcc094b212_76858816', 'ewallet', $this->tplIndex);
?>

                 <?php }?>

                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['ewallet_status'] == "yes" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['roi_status'] == "no") {?> 
                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11545412805f29bcc094d1d5_60669220', 'ewallet', $this->tplIndex);
?>

                 <?php }?>

                      
                 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7135919915f29bcc094e470_24244966', 'payout', $this->tplIndex);
?>

               

               
                <div class="col-xs-6" id="section_tile2">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1" id="sales_total"><?php echo $_smarty_tpl->tpl_vars['total_commission_paid']->value;?>
</div>
                        <span class="text-muted text-xs"><?php echo lang('commission_due');?>
</span>
                       
                    </div>
                </div>

                              
                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1741999275f29bcc0951b93_78715255', 'sales', $this->tplIndex);
?>

              <div class="col-xs-6" id="section_tile4">
                    <div class="panel padder-v item">
                        <div class="font-thin text-info h1" id="mail_total"><?php echo $_smarty_tpl->tpl_vars['total_profit_date']->value;?>
</div>
                        <span class="text-muted text-xs"><?php echo lang('net_profit');?>
</span>
                        <div class="top text-right w-full">
                           
                        </div>
                    </div>
                </div>

                      
                <div class="col-xs-6" id="section_tile2">
                    <div class="panel padder-v item bg-primary">
                        <div class="text-white font-thin h1 block1" id="sales_total"><?php echo $_smarty_tpl->tpl_vars['ewallet_balance']->value;?>
</div>
                        <span class="text-muted text-xs"><?php echo lang('ewallet_balance');?>
</span>
                       
                    </div>
                </div>

           
            </div>
       
         <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15693728655f29bcc0955ba0_68227871', 'lcp', $this->tplIndex);
?>

            
            <div class="col-xs-12" id="section_tile6">
                <div class="panel item">
                    <div class="panel-body">
                        <div class="clear pull-left">
                            <div class="text-left m-b-xs block"><?php echo lang('total_users');?>
<i class="icon-twitter"></i></div>
                            <div class="font-thin h2 block1" id="sales_total"><?php echo $_smarty_tpl->tpl_vars['total_users']->value;?>
</div>
                        </div>
                    </div>
                </div>
            </div>
            
             </div>
    </div>
  <div class="panel hbox hbox-auto-xs no-border">
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1607636125f29bcc0961d25_84725369', 'joinings', $this->tplIndex);
?>
 
    </div>
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_708007875f29bcc096f050_15829010', 'to_do', $this->tplIndex);
?>

    <div class="row">
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2894648435f29bcc0973300_22913033', 'top_earners', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16915753135f29bcc0977229_74594223', 'social_media', $this->tplIndex);
?>

    </div>
</div>

<?php }?>

  
<br>
 



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="reservation_detail_model" data-backdrop="static"
    class="modal fade" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                <h4 class="modal-title" id="modaltitle"></h4>
            </div>
            <div class="modal-body" id="reservation_detail_model_body">
            </div>
        </div>
    </div>
</div>


<!---POPUP DESIGN--->
 
<?php if ($_smarty_tpl->tpl_vars['DEMO_STATUS']->value == 'yes') {?>
    <?php if ($_smarty_tpl->tpl_vars['is_preset_demo']->value) {?>
      <div class="modal fade text-center py-5"  id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md index" role="document">
                <div class="modal-content_1 b-white">
                    <div class="modal-body backgound_modal">
                    <div class="p-3">
                        <button aria-hidden="true" data-dismiss="modal" class="close text-white" type="button"><i class="icon-close"></i></button>
                    <h3 class="modal-title text-white">
                     <img style="width: 60px;" src="https://infinitemlmsoftware.com/wp-content/uploads/2018/08/medium_box-only.png"> 
                    Notice</h3>
                    
                        <p class="text-white"><small>You are viewing shared demo. Multiple users may try this demo simultaneously.Try<a class="h4 text-warning" href="https://infinitemlmsoftware.com/register.php" target="_blank" > custom demo </a>as per your configurations</small> </p>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div> 
    <?php }
}?>
<!---END POPUP DESIGN-->

<style>
.demo_section {
    
    display: none ;
}
.setting_margin_top {
    
        margin-top: -50px;
}
.setting_margin{
        margin-left: 230px;
}
.wrapper_index{
    
    padding:15px
}
.demo_margin_top {
    
    margin-top: -30px;
}
.modal-content_1 {
     background-color: #c713138c;
    
}
.modal-content_1 {
    position: relative;
     
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #999;
    border: 1px solid rgba(255, 255, 255, 0.58);
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
    box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
}
@media (max-width:767px)
{
.demo_section {
    
    display: block;
}  
   .moblie_demo {
    
 display: none ;
     
} 
.setting_margin {
    margin-left: 0px;
}

.setting_margin_top {
    margin-top: -49px !important;
}
.demo_margin_top {
    margin-top: -27px !important;
}
}
</style>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'new_members'} */
class Block_20735745985f29bcc097e560_62952227 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="b-l bg-white  tab-content" id="right_section_new_member">
        <div role="tabpanel" class="tab-pane active" id="tab-1">
            <div class="wrapper-md">
                <div class="bg-primary text-center wrapper-sm m-l-n-new m-r-n"><?php echo smarty_modifier_capitalize(lang('new_members'));?>
</div>
                <ul class="list-group no-bg no-borders pull-in list_link">
                    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['latest_joinees']->value, 'j');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value) {
?>
                        <li class="list-group-item">
                            <a href="javascript:void(0);" class="pull-left thumb-sm m-r">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['j']->value['profile_picture_full'];?>
">
                            </a>
                            <div class="clear">
                                <div><a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['j']->value['user_name'];?>
</a></div>
                                <span class="text-muted"><?php echo $_smarty_tpl->tpl_vars['j']->value['date_of_joining'];?>
</span>
                            </div>
                        </li>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
                        <li class="list-group-item"><?php echo lang('no_data_found');?>
</li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
    <?php
}
}
/* {/block 'new_members'} */
/* {block 'top_recruiters'} */
class Block_7415917735f29bcc0983ad0_30184020 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="b-l bg-white padder-md height_top_recruiters" id="right_section_top_recruiter">
        <div class="streamline  m-b">
            <div class="bg-primary wrapper-sm m-l-n m-r-n m-b text-center"><?php echo lang('top_recruiters');?>
</div>
            <?php $_smarty_tpl->_assignInScope('i', 0);
?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['top_recruters']->value, 'j');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value) {
?>
                <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                <?php $_smarty_tpl->_assignInScope('k', fmod($_smarty_tpl->tpl_vars['i']->value,4));
?>
                <div class="sl-item b-l <?php if ($_smarty_tpl->tpl_vars['k']->value == 1) {?>b-primary<?php } elseif ($_smarty_tpl->tpl_vars['k']->value == 2) {?>b-warning<?php } elseif ($_smarty_tpl->tpl_vars['k']->value == 3) {?>b-info<?php }?>">
                    <div class="m-l margin-list-mobile">
                        <li class="list-group-item">
                            <a href="javascript:void(0);" class="pull-left thumb-sm m-r">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['j']->value['profile_picture_full'];?>
">
                            </a>
                            <div class="clear">
                                <div><a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['j']->value['user_name'];?>
</a></div>
                                <span class="text-muted"><?php echo $_smarty_tpl->tpl_vars['j']->value['count'];?>
</span>
                            </div>
                        </li>
                    </div>
                </div>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
                <div class="sl-item b-l b-primary">
                    <div class="m-l">
                        <li class="list-group-item"><?php echo lang('no_data_found');?>
</li>
                    </div>
                </div>
            <?php }?>
        </div>
        
    </div>
   <?php
}
}
/* {/block 'top_recruiters'} */
/* {block 'right_content'} */
class Block_11573900745f29bcc0983fa0_69231472 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="col w-md  bg-auto no-border-xs b-r" id="right_section">
   <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20735745985f29bcc097e560_62952227', 'new_members', $this->tplIndex);
?>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7415917735f29bcc0983ad0_30184020', 'top_recruiters', $this->tplIndex);
?>

</div>

<?php
}
}
/* {/block 'right_content'} */
/* {block 'home_wrapper_out'} */
class Block_13851789505f29bcc0985965_61678606 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/system_setting_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <?php $_smarty_tpl->_subTemplateRender("file:layout/demo_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
}
/* {/block 'home_wrapper_out'} */
}
