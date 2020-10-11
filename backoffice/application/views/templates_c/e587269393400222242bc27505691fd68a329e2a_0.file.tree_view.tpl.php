<?php
/* Smarty version 3.1.30, created on 2020-09-25 15:36:18
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/tree/tree_view.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d81d25b9ea1_52963305',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e587269393400222242bc27505691fd68a329e2a' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/tree/tree_view.tpl',
      1 => 1591246661,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d81d25b9ea1_52963305 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="tooltip_div" style="display:none;">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tooltip_array']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
        <div id="user_<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
" class="tree_img_tree">
            <div class="Demo_head_bg">
                <?php $_smarty_tpl->_assignInScope('a', dirname(FCPATH));
?>
                <?php $_smarty_tpl->_assignInScope('b', '/uploads/images/profile_picture/');
?>
                <?php $_smarty_tpl->_assignInScope('c', $_smarty_tpl->tpl_vars['v']->value['photo']);
?>
                <?php $_smarty_tpl->_assignInScope('d', ((string)$_smarty_tpl->tpl_vars['a']->value).((string)$_smarty_tpl->tpl_vars['b']->value).((string)$_smarty_tpl->tpl_vars['c']->value));
?>
                <?php if (file_exists($_smarty_tpl->tpl_vars['d']->value)) {?>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['v']->value['photo'];?>
"/>
                <?php } else { ?>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/nophoto.jpg" />
                <?php }?>
                <p><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</p>
            </div>
            <div class="body_text_tree">
                <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['first_name'] == 'yes') {?>
                    <div class="binary_bg">
                        <p class="text-center"><?php echo $_smarty_tpl->tpl_vars['v']->value['full_name'];?>
</p>
                    </div>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['join_type'] == 'yes') {?>
                    <li class="list-group-item">
                            <div class="pull-right"><?php echo $_smarty_tpl->tpl_vars['v']->value['join_type'];?>
</div>
                            <div class="pull-left"><?php echo lang('join_type');?>
:</div>
                     </li>
                <?php }?>
                <ul class="list-group no-radius">
                    <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['join_date'] == 'yes') {?>
                        <li class="list-group-item">
                            <div class="pull-right"><?php echo date('Y/m/d',strtotime($_smarty_tpl->tpl_vars['v']->value['join_date']));?>
</div>
                            <div class="pull-left"><?php echo lang('join_date');?>
:</div>
                        </li>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['sponsor'] == 'yes') {?>
                        <li class="list-group-item">
                            <div class="pull-right"><?php echo $_smarty_tpl->tpl_vars['v']->value['sponsor'];?>
</div>
                            <div class="pull-left"><?php echo lang('sponsor');?>
:</div>
                        </li>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['mlm_plan'] == 'Binary') {?>
                        <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['left'] == 'yes') {?>
                            <li class="list-group-item">
                                <div class="pull-right"><?php echo round($_smarty_tpl->tpl_vars['v']->value['left'],2);?>
</div>
                                <div class="pull-left"><?php echo lang('left');?>
:</div>
                            </li>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['right'] == 'yes') {?>
                            <li class="list-group-item">
                                <div class="pull-right"><?php echo round($_smarty_tpl->tpl_vars['v']->value['right'],2);?>
</div>
                                <div class="pull-left"><?php echo lang('right');?>
:</div>
                            </li>
                        <?php }?>
                        
                        <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['left_carry'] == 'yes') {?>
                            <li class="list-group-item">
                                <div class="pull-right"><?php echo round($_smarty_tpl->tpl_vars['v']->value['left_carry'],2);?>
</div>
                                <div class="pull-left"><?php echo lang('left_carry');?>
:</div>
                            </li>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['right_carry'] == 'yes') {?>
                            <li class="list-group-item">
                                <div class="pull-right"><?php echo round($_smarty_tpl->tpl_vars['v']->value['right_carry'],2);?>
</div>
                                <div class="pull-left"><?php echo lang('right_carry');?>
:</div>
                            </li>
                        <?php }?>
                    <?php }?>
                    
                         <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['downline_count'] == 'yes') {?>
                        <li class="list-group-item">
                            <div class="pull-right"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['left_user_count'])===null||$tmp==='' ? 0 : $tmp);?>
</div>
                            <div class="pull-left"><?php echo lang('left_user_count');?>
:</div>
                        </li>
                        <li class="list-group-item">
                            <div class="pull-right"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['right_user_count'])===null||$tmp==='' ? 0 : $tmp);?>
</div>
                            <div class="pull-left"><?php echo lang('right_user_count');?>
:</div>
                        </li>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['personal_pv'] == 'yes') {?>
                        <li class="list-group-item">
                            <div class="pull-right"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['personal_pv'])===null||$tmp==='' ? 0 : $tmp);?>
</div>
                            <div class="pull-left"><?php echo lang('personal_PV');?>
:</div>
                        </li>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['gpv'] == 'yes') {?>
                        <li class="list-group-item">
                            <div class="pull-right"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['group_pv'])===null||$tmp==='' ? 0 : $tmp);?>
</div>
                            <div class="pull-left"><?php echo lang('group_PV');?>
:</div>
                        </li>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['rank_status'] == 'yes') {?>
                         <li class="list-group-item">
                            <div class="pull-right"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['left_rank_pv'])===null||$tmp==='' ? 0 : $tmp);?>
</div>
                            <div class="pull-left"><?php echo lang('left_rank_pv');?>
:</div>
                        </li>
                        <li class="list-group-item">
                            <div class="pull-right"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['right_rank_pv'])===null||$tmp==='' ? 0 : $tmp);?>
</div>
                            <div class="pull-left"><?php echo lang('right_rank_pv');?>
:</div>
                        </li> 
                        <li class="list-group-item">
                            <div class="pull-right"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['monthly_rank_pv'])===null||$tmp==='' ? 0 : $tmp);?>
</div>
                            <div class="pull-left"><?php echo lang('monthly_rank_pv');?>
:</div>
                        </li>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['mlm_plan'] == 'Donation' && $_smarty_tpl->tpl_vars['v']->value['donation_level']) {?>
                        <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['donation_level'] == 'yes') {?>
                            <li class="list-group-item">
                                <div class="donation_level"><?php echo $_smarty_tpl->tpl_vars['v']->value['donation_level'];?>
</div>
                            </li>
                        <?php }?>
                    <?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['subscription_end_date'] == 'yes') {?>
                        <li class="list-group-item">
                            <div class="pull-right"><?php echo date('Y/m/d',strtotime($_smarty_tpl->tpl_vars['v']->value['subs_end_date']));?>
</div>
                            <div class="pull-left"><?php echo lang('subscription_end_date');?>
:</div>
                        </li>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes' && $_smarty_tpl->tpl_vars['v']->value['rank_name']) {?>
                        <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['rank_status'] == "yes") {?>
                            <div class="tooltip_rank" style="background-color:<?php echo $_smarty_tpl->tpl_vars['v']->value['rank_color'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['rank_name'];?>
</div>
                        <?php }?>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['tooltip_config']->value['join_type'] == "yes" && $_smarty_tpl->tpl_vars['v']->value['join_type'] == "customer" && $_smarty_tpl->tpl_vars['v']->value['rank_id'] == NULL) {?>
                           
                                <div class="tooltip_rank" style="background-color:<?php echo $_smarty_tpl->tpl_vars['v']->value['rank_color'];?>
"><?php if ($_smarty_tpl->tpl_vars['v']->value['join_type'] == 'customer') {?>
                                <?php echo lang('customer');?>

                                <?php }?></div>
                          
                   <?php }?>
                </ul>
            </div>
        </div>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</div>

<?php echo $_smarty_tpl->tpl_vars['display_tree']->value;?>


<div id="tree" class="orgChart"></div>
<?php }
}
