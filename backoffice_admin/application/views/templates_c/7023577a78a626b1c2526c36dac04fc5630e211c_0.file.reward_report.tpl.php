<?php
/* Smarty version 3.1.30, created on 2020-08-18 12:51:35
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/reward_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f3b4237699965_99254292',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7023577a78a626b1c2526c36dac04fc5630e211c' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/reward_report.tpl',
      1 => 1574499220,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f3b4237699965_99254292 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20873272245f3b4237698fe9_77046674', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_20873272245f3b4237698fe9_77046674 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display:none;">

        <span id="error_msg"><?php echo lang('you_must_select_from_date');?>
</span>
        <span id="error_msg1"><?php echo lang('you_must_select_to_date');?>
</span>
        <span id="error_msg2"><?php echo lang('you_must_select_from_to_date_correctly');?>
</span>
        <span id="error_msg3"><?php echo lang('you_must_select_product');?>
</span>
        <span id="error_msg4"><?php echo lang('you_must_select_a_to_date_greater_than_from_date');?>
</span>
        <span id="error_msg5"><?php echo lang('digits_only');?>
</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php ob_start();
echo $_smarty_tpl->tpl_vars['SHORT_URL']->value;
$_prefixVariable1=ob_get_clean();
echo form_open($_prefixVariable1,'role="form" class="" name="search_member" id="search_member"
        action="" method="post"');?>

            <input type="hidden" id="search_member_error" value="<?php echo lang('search_member_error');?>
" />
            <input type="hidden" id="search_member_error2" value="<?php echo lang('invalid_user_name');?>
" />
            

            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="" for="user_name"><?php echo lang('user_name');?>
</label>
                    <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off">
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="" for="week_date1"><?php echo lang('from_date');?>
</label>
                    <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value="">
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class=""><?php echo lang('to_date');?>
</label>
                    <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> 
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit"
                            name="search_member_submit">
                        <?php echo lang('search');?>

                    </button>
                </div>
            </div>
            <?php echo form_close();?>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <legend>
                <span class="fieldset-legend"><?php echo lang('reward_report');?>
<b><?php if ($_smarty_tpl->tpl_vars['user_name']->value != "admin" && $_smarty_tpl->tpl_vars['user_name']->value != NULL) {?>: <?php echo $_smarty_tpl->tpl_vars['user_name']->value;
}?></b></span>
            </legend>
            <div class="table-responsive">
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead class="table-bordered">
                        <tr class="th">
                            <th><?php echo lang('slno');?>
</th>
                            <th><?php echo lang('user_name');?>
</th>
                            <th><?php echo lang('rank');?>
</th>

                            <th><?php echo lang('reward');?>
</th>

                            <th><?php echo lang('date');?>
</th>
                        </tr>
                    </thead>
                    <?php if (count($_smarty_tpl->tpl_vars['details']->value) > 0) {?>
                        <div class="button_back">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/excel/create_excel_reward_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i><?php echo lang('create_excel');?>
</button></a>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/excel/create_csv_reward_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i><?php echo lang('create_csv');?>
</button></a>
                        </div>
                        <tbody>
                            <?php $_smarty_tpl->_assignInScope('i', "0");
?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>

                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>

                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['rank_name'];?>
</td>

                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['reward'];?>
</td>

                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['date'];?>
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
                            <tr>
                                <td colspan="8">
                                    <h4><?php echo lang('no_details');?>
</h4>
                                </td>
                            </tr>
                        </tbody>
                    <?php }?>
                </table>
            </div>
            <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>


        </div>
    </div>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
