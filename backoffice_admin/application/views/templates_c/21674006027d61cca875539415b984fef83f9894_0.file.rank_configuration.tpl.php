<?php
/* Smarty version 3.1.30, created on 2020-08-05 10:03:02
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/rank_configuration.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f29f736f22148_97998240',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '21674006027d61cca875539415b984fef83f9894' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/rank_configuration.tpl',
      1 => 1574145159,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/configuration/system_setting_common.tpl' => 1,
    'file:layout/error_box.tpl' => 2,
  ),
),false)) {
function content_5f29f736f22148_97998240 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_counter')) require_once '/home/mbatradingacadem/public_html/office/backoffice_admin/application/third_party/Smarty/plugins/function.counter.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3198215895f29f736f1f1e6_68201811', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21365356225f29f736f20a03_42600836', 'style');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_579343615f29f736f21d20_56072342', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_3198215895f29f736f1f1e6_68201811 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" style="display:none;">

    <span id="confirm_msg_inactivate"><?php echo lang('sure_you_want_to_inactivate_this_rank');?>
</span>
    <span id="confirm_msg_edit"><?php echo lang('sure_you_want_to_edit_this_rank_there_is_no_undo');?>
</span>
    <span id="confirm_msg_activate"><?php echo lang('sure_you_want_to_activate_this_rank');?>
</span>
    <span id="confirm_msg_delete"><?php echo lang('sure_you_want_to_delete_this_rank_there_is_no_undo');?>
</span><span id="validate_day_lim"><?php echo lang('day_limit');?>
</span>
    <span id="day_lim_req"><?php echo lang('day_lim_req');?>
</span>
</div>

    <?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/system_setting_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


    <!-- <div class="panel panel-default">
        <div class="panel-body">
       <legend><span class="fieldset-legend"><?php echo lang('rank_settings');?>
</span></legend>
            <div class="table-responsive">*}
            <?php echo form_open('','role="form" class="" name="rank_form" id="rank_form"');?>

                <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

               
           

                

               

             -->
    
   <div class="panel panel-default">
        <div class="panel-body">
        <legend><span class="fieldset-legend"><?php echo lang('binary minimum leg');?>
</span></legend>
            <div class="table-responsive">
            <?php echo form_open('admin/configuration/minimum_leg','role="form" class="" name="minimum_leg" id="minimum_leg"');?>

                <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

             
              <div class="form-group">
                <label class="required"><?php echo lang('minimum leg');?>
</label>
                <input class="form-control" type="text" name="minimum_leg" id="minimum_leg" value='<?php echo $_smarty_tpl->tpl_vars['minimum_leg']->value;?>
'>
              </div>
              <?php echo form_error('minimum_leg');?>


                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" name="update" id="update"><?php echo lang('update');?>
</button>
                </div>

            <?php echo form_close();?>

            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend"><?php echo lang('rank_config');?>
</span>
                <a class="btn m-b-xs btn-sm btn-primary btn-addon pull-right" href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/add_new_rank" id="add_rank"><i class="fa fa-plus"></i> <?php echo lang('add_new_rank');?>
</a>
            </legend>
            <div>
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('sl_no');?>
</th>
                                <th><?php echo lang('rank_name');?>
</th>
                                <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['referal_count']) {?>
                                    <th><?php echo lang('referal_count');?>
</th>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['personal_pv']) {?>
                                    <th><?php echo lang('personalpv');?>
</th>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['group_pv']) {?>
                                    <th><?php echo lang('grouppv');?>
</th>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['joinee_package']) {?>
                                    <th><?php echo lang('package_name');?>
</th>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Matrix' || $_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                                    <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['downline_member_count']) {?>
                                        <th><?php echo lang('downline_count');?>
</th>
                                        
                                    <?php }?>
                                <?php }?>
                                <th><?php echo lang('rank_incentive_bonus');?>
</th>
                                <th><?php echo lang('rank_incentive_reward');?>
</th>
                                <th><?php echo lang('binary_bonus');?>
(%)</th>
                                <th><?php echo lang('binary_monthly_cap');?>
</th>
                                <th><?php echo lang('rank_color');?>
</th>
                                <th><?php echo lang('action');?>
</th>
                               
                            </tr>
                        </thead>
                        <?php if (count($_smarty_tpl->tpl_vars['rank_details']->value) > 0) {?>
                        <tbody>
                        <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rank_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                <tr>
                                    <td><?php echo smarty_function_counter(array(),$_smarty_tpl);?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['rank_name'];?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['referal_count']) {?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['referal_count'];?>
</td>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['personal_pv']) {?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['personal_pv'];?>
</td>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['group_pv']) {?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['gpv'];?>
</td>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['joinee_package']) {?>
                                        <td><?php if (isset($_smarty_tpl->tpl_vars['v']->value['joinee_package'][0])) {
echo $_smarty_tpl->tpl_vars['v']->value['joinee_package'][0]['product_name'];
} else { ?>NA<?php }?></td>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Matrix' || $_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                                      <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['downline_member_count']) {?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['downline_count'];?>
</td>
                                      <?php }?>
                                    <?php }?>
                                    
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['rank_incentive_bonus'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['rank_incentive_reward'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['binary_bonus'];?>
</td>
                                  <td><?php echo $_smarty_tpl->tpl_vars['v']->value['binary_monthly_cap'];?>
</td>
                                    <td><span class="rank_col" style="background-color: <?php echo $_smarty_tpl->tpl_vars['v']->value['rank_color'];?>
;"><?php echo $_smarty_tpl->tpl_vars['v']->value['rank_color'];?>
</span></td>
                                    <td class="ipad_button_table">
                                        <?php if ($_smarty_tpl->tpl_vars['v']->value['rank_status'] == "active") {?>
                                            <button class="btn-link btn_size has-tooltip text-info" onclick="edit_rank(<?php echo $_smarty_tpl->tpl_vars['v']->value['rank_id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
')" title="<?php echo lang('edit');?>
"> <i class="fa fa-edit"></i></button>
                                            <button class="btn-link btn_size has-tooltip text-info inactivate_membership_package" onclick="inactivate_rank(<?php echo $_smarty_tpl->tpl_vars['v']->value['rank_id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
')" title="<?php echo lang('inactivate');?>
"><i class="fa fa-ban"></i></button>
                                        <?php } else { ?>
                                            <button class="has-tooltip btn-link btn_size text-info" onclick="activate_rank(<?php echo $_smarty_tpl->tpl_vars['v']->value['rank_id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
')" title="<?php echo lang('activate');?>
"><i class="icon-check"></i></button>
                                        <?php }?>
                                    </td>
                                </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </tbody>
                        <?php } else { ?>
                        <tbody>
                            <tr id="tr-empty"><td align="center"><h4 align="center"><?php echo lang('no_product_found');?>
</h4></td></tr>
                        </tbody>
                        <?php }?>
                    </table>
                </div>
            </div>
        </div>
    </div>


<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'style'} */
class Block_21365356225f29f736f20a03_42600836 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <style>
    .rank_col {
        display: inline;
        padding: .2em .6em .3em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;
    }
    </style>
<?php
}
}
/* {/block 'style'} */
/* {block 'script'} */
class Block_579343615f29f736f21d20_56072342 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

     <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"><?php echo '</script'; ?>
>
      <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/rank_configuration.js" type="text/javascript" ><?php echo '</script'; ?>
> 
     <link href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet">
<?php
}
}
/* {/block 'script'} */
}
