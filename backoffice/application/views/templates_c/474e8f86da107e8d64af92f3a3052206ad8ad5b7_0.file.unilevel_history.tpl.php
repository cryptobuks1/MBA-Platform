<?php
/* Smarty version 3.1.30, created on 2020-09-25 16:40:58
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/my_report/unilevel_history.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d90fa724da2_43856377',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '474e8f86da107e8d64af92f3a3052206ad8ad5b7' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/my_report/unilevel_history.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f6d90fa724da2_43856377 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14592109835f6d90fa724051_07930175', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_14592109835f6d90fa724051_07930175 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['mlm_plan'] == "Unilevel") {?>
        <?php $_smarty_tpl->_assignInScope('path', 'user/genology_tree');
?>
    <?php } else { ?>
        <?php $_smarty_tpl->_assignInScope('path', 'user/sponsor_tree');
?>
    <?php }?>

    <div class="button_back">
        <a href="<?php echo BASE_URL;?>
/<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i><?php echo lang('back');?>
</button></a>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open_multipart('','role="form" class="" name="searchform" id="searchform" method="post"');?>

                <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <div class="col-sm-3 padding_both">
                    <div class="form-group">
                        <label><?php echo lang('level');?>
</label>
                        <select name="level" id="level" class="form-control">
                            <option value="all"><?php echo lang('all');?>
</option>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['level_arr']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['unilevel_histroy_level']->value == $_smarty_tpl->tpl_vars['v']->value) {?>selected=""<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </select>
                    </div>
                </div>
                <div class="col-sm-3 padding_both_small">
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary m-t-t-t" id="user_details" value="<?php echo lang('search');?>
" name="user_details"><?php echo lang('search');?>
</button>
                    </div>
                </div>
            <?php echo form_close();?>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
          <legend><span class="fieldset-legend"><?php echo lang('unilevel_history');?>
</span></legend>
            <div class="table-responsive">
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead>
                        <tr class="th">
                            <th><?php echo lang('slno');?>
</th>
                            <th><?php echo lang('user_name');?>
</th>
                            <th><?php echo lang('name');?>
</th>
                            <th><?php echo lang('enrollment_date');?>
</th>
                            <th><?php echo lang('level');?>
</th>
                            <th><?php echo lang('state');?>
</th>
                            <th><?php echo lang('country');?>
</th>
                            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes') {?>
                        <th><?php echo lang('Rank');?>
</th>
                    <?php }?>
                            <th><?php echo lang('referal');?>
</th>
                        </tr>
                    </thead>
                    <?php if (count($_smarty_tpl->tpl_vars['unievel']->value) > 0) {?>
                      <?php $_smarty_tpl->_assignInScope('i', ((string)$_smarty_tpl->tpl_vars['start']->value));
?>
                      <?php $_smarty_tpl->_assignInScope('class', '');
?>
                        <tbody>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['unievel']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
<b class="badge label-primary-1"><?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == 'yes') {
echo lang('active');
} else {
echo lang('inactive');
}?></b></td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['date_of_joining'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['level'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['state'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['country'];?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes') {?>
                                        <?php if ($_smarty_tpl->tpl_vars['v']->value['rank']) {?>
                                            <td><span class="rank_color_code" style="background-color:<?php echo $_smarty_tpl->tpl_vars['v']->value['rank_color'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['rank'];?>
</td>
                                        <?php } else { ?>
                                            <td><span class="rank_color_code"><?php echo lang('na');?>
</td>
                                        <?php }?>
                                    <?php }?>
                                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;
echo $_smarty_tpl->tpl_vars['path']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['username_enc'];?>
" target="_blank" style="color: #20afa6;"><i class="clip-tree" ></i>&nbsp;<?php echo lang('view_referal');?>
</a></td>
                                </tr>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </tbody>
                    <?php } else { ?>
                        <tbody>
                            <tr><td colspan="9" align="center"><h4 align="center"> <?php echo lang('no_details_found');?>
</h4></td></tr>
                        </tbody>
                    <?php }?>
                </table>
            </div>
        </div>
    </div> <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
