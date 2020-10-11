<?php
/* Smarty version 3.1.30, created on 2020-09-25 18:08:08
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/select_report/rank_performance_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6da568274ac1_34259434',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '89b72ca4d793f1c7576fb19a1a908af7fe106cd6' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/select_report/rank_performance_report.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6da568274ac1_34259434 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16599929015f6da568273c25_21641542', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_16599929015f6da568273c25_21641542 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="button_back">
    <a onClick="print_report(); return false;"><button class="btn m-b-xs btn-sm btn-primary btn-addon hidden-xs hidden-sm hidden-md"><i class="icon-printer"></i><?php echo lang('Print');?>
</button>
    </a></div>
    <div id="print_area" class="panel-body panel">
<div class="img"><img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value["logo"];?>
" /> </div>
<div class="row">
    <div class="col-xs-6">
        <h4><?php echo $_smarty_tpl->tpl_vars['site_info']->value["company_name"];?>
</h4>
        <p><?php echo $_smarty_tpl->tpl_vars['site_info']->value["company_address"];?>
</p>
        <p> <?php echo lang('phone');?>
: <?php echo $_smarty_tpl->tpl_vars['site_info']->value["phone"];?>
<br> <?php echo lang('email');?>
:<?php echo $_smarty_tpl->tpl_vars['site_info']->value["email"];?>
 </p>
    </div>
</div>
 
<h2 class="text-center"><?php echo $_smarty_tpl->tpl_vars['report_name']->value;?>
</h2>
<h3>
    <center><?php echo lang('current_rank');?>
 :
        <font color="#ff0000">
        <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['rank_id']) {?>
            <?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['rank_name'];?>

        <?php } else { ?>
            NA
        <?php }?>
        </font>
    </center>
</h3>
<h4>
    <center style="font-size: 12px;"><?php echo lang('next_rank');?>
 :
        <font color="green">
        <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_id']) {?>
            <?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_name'];?>

        <?php } else { ?>
            NA
        <?php }?>
        </font>
    </center>
</h4>
<div class="panel panel-default ng-scope">
<div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <tbody>
            <tr class="text">
                <td><strong><?php echo lang('user_name');?>
</strong></td>
                <td><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</td>
            </tr>
            <tr>
                <td><strong> <?php echo lang('current_rank');?>
</strong></td>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['rank_id']) {?>
                        <?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['rank_name'];?>

                    <?php } else { ?>
                        NA
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td><strong><?php echo lang('next_rank');?>
</strong></td>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_id']) {?>
                        <?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_name'];?>

                    <?php } else { ?>
                        NA
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td><strong><?php echo lang('current_referral_count');?>
</strong></td>
                <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['referral_count'];?>
</td>
            </tr>
            <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_id']) {?>
                <tr>
                    <td><strong><?php echo lang('referral_count_for');?>
 <?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_name'];?>
</strong></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['referral_count'];?>
</td>
                </tr>
                <tr>
                    <td><strong><?php echo lang('needed_referral_count');?>
</strong></td>
                    <td><?php echo max($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['referral_count']-$_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['referral_count'],0);?>
</td>
                </tr>
            <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['criteria']['personal_pv']) {?>
                <tr>
                    <td><strong><?php echo lang('current_personal_pv');?>
</strong></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['personal_pv'];?>
</td>
                </tr>
                <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_id']) {?>
                    <tr>
                        <td><strong><?php echo lang('personal_pv_for');?>
 <?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_name'];?>
</strong></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['personal_pv'];?>
</td>
                    </tr>
                    <tr>
                        <td><strong><?php echo lang('needed_personal_pv');?>
</strong></td>
                        <td><?php echo max($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['personal_pv']-$_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['personal_pv'],0);?>
</td>
                    </tr>
                <?php }?>
            <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['criteria']['group_pv']) {?>
                <tr>
                    <td><strong><?php echo lang('current_group_pv');?>
</strong></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['group_pv'];?>
</td>
                </tr>
                <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_id']) {?>
                    <tr>
                        <td><strong><?php echo lang('gpv_for');?>
 <?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_name'];?>
</strong></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['group_pv'];?>
</td>
                    </tr>
                    <tr>
                        <td><strong><?php echo lang('needed_group_pv');?>
</strong></td>
                        <td><?php echo max($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['group_pv']-$_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['group_pv'],0);?>
</td>
                    </tr>
                <?php }?>
            <?php }?>
            
            <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['criteria']['downline_count']) {?>
                <tr>
                    <td><strong><?php echo lang('current_downline_count');?>
</strong></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['downline_count'];?>
</td>
                </tr>
                <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_id']) {?>
                    <tr>
                        <td><strong><?php echo lang('downline_count_for');?>
 <?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_name'];?>
</strong></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['downline_count'];?>
</td>
                    </tr>
                    <tr>
                        <td><strong><?php echo lang('needed_downline_count');?>
</strong></td>
                        <td><?php echo max($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['downline_count']-$_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['downline_count'],0);?>
</td>
                    </tr>
                <?php }?>
            <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['criteria']['downline_package_count'] && $_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['package_name']) {?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['package_name'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <tr>
                        <td><strong><?php echo lang('current_downline_count');?>
(<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
)</strong></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['downline_package_count'][$_smarty_tpl->tpl_vars['k']->value];?>
</td>
                    </tr>
                    <?php if ($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_id']) {?>
                        <tr>
                            <td><strong><?php echo lang('downline_count_for');?>
 <?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['rank_name'];?>
(<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
)</strong></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['downline_package_count'][$_smarty_tpl->tpl_vars['k']->value];?>
</td>
                        </tr>
                        <tr>
                            <td><strong><?php echo lang('needed_downline_count');?>
(<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
)</strong></td>
                            <td><?php echo max($_smarty_tpl->tpl_vars['rank_achievement']->value['next_rank']['downline_package_count'][$_smarty_tpl->tpl_vars['k']->value]-$_smarty_tpl->tpl_vars['rank_achievement']->value['current_rank']['downline_package_count'][$_smarty_tpl->tpl_vars['k']->value],0);?>
</td>
                        </tr>
                    <?php }?>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            <?php }?>
        </tbody>

    </table>
    </div>
    </div>
</div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
