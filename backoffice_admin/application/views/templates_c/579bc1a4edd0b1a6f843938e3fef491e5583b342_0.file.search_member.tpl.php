<?php
/* Smarty version 3.1.30, created on 2020-08-05 21:23:43
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/search_member.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a96bf5dbc13_48514421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '579bc1a4edd0b1a6f843938e3fef491e5583b342' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/search_member.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2a96bf5dbc13_48514421 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4911613215f2a96bf5da2c0_39493730', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>
 
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19583671805f2a96bf5db823_40610419', 'script');
?>
 <?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_4911613215f2a96bf5da2c0_39493730 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display: none;">
        <span id="errmsg"><?php echo lang('You_must_enter_keyword_to_search');?>
</span>
        <span id="row_msg"><?php echo lang('rows');?>
</span>
        <span id="show_msg"><?php echo lang('shows');?>
</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body ">
            <?php echo form_open('admin/search_member','role="form" class="" method="post"  name="search_mem" id="search_mem"');?>

            <input type="hidden" name="base_url" id="base_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/">
            <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
            <div class="col-sm-6 padding_both">
            <div class="form-group">
                <label><?php echo lang('keyword');?>
</label>
                <input class="form-control" placeholder="<?php echo lang('Username_Name_Address_MobileNo');?>
.." type="text" name="keyword" id="keyword" autocomplete="Off">
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button class="btn btn-sm btn-primary " type="submit" name="search_member" id="search_member" value="<?php echo lang('search_member');?>
"><?php echo lang('search');?>
</button>
                    
                    <button class="btn btn-sm btn-primary " formnovalidate="formnovalidate" type="submit" name="reset" id="reset" value="<?php echo lang('clear');?>
"><?php echo lang('clear');?>
</button>
                </div>
            </div>
            <?php echo form_close();?>

        </div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['flag']->value) {?>
        <input type="hidden" id="search_key" value="<?php echo $_smarty_tpl->tpl_vars['search_key']->value;?>
">
        <div class="panel panel-default ng-scope">
        <div class="panel-body">
        <div class="table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><?php echo lang('sl_no');?>
</th>
                        <th><?php echo lang('user_name');?>
</th>
                        <th><?php echo lang('name');?>
</th>
                        <th><?php echo lang('sponser_name');?>
</th>
                        <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes') {?>
                            <th><?php echo lang('rank');?>
</th>
                        <?php }?>
                        <th><?php echo lang('mobile_no');?>
</th>
                        <th><?php echo lang('address');?>
</th>
                        <th><?php echo lang('view_profile');?>
</th>
                    </tr>
                </thead>
                <?php if (count($_smarty_tpl->tpl_vars['mem_arr']->value) > 0) {?>
                    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                    <?php $_smarty_tpl->_assignInScope('class', '');
?>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mem_arr']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>
                                <?php $_smarty_tpl->_assignInScope('class', 'tr1');
?>
                            <?php } else { ?>
                                <?php $_smarty_tpl->_assignInScope('class', 'tr2');
?>
                            <?php }?>
                            <?php $_smarty_tpl->_assignInScope('id', ((string)$_smarty_tpl->tpl_vars['v']->value['user_id']));
?>
                            <?php $_smarty_tpl->_assignInScope('user_name', ((string)$_smarty_tpl->tpl_vars['v']->value['user_name']));
?>
                            <?php $_smarty_tpl->_assignInScope('user_detail_name', ((string)$_smarty_tpl->tpl_vars['v']->value['user_detail_name']));
?>
                            <?php $_smarty_tpl->_assignInScope('user_detail_address', ((string)$_smarty_tpl->tpl_vars['v']->value['user_detail_address']));
?>
                            <?php $_smarty_tpl->_assignInScope('user_detail_mobile', ((string)$_smarty_tpl->tpl_vars['v']->value['user_detail_mobile']));
?>
                            <?php $_smarty_tpl->_assignInScope('user_detail_country', ((string)$_smarty_tpl->tpl_vars['v']->value['user_detail_country']));
?>
                            <?php $_smarty_tpl->_assignInScope('encrypt_id', ((string)$_smarty_tpl->tpl_vars['v']->value['user_id_en']));
?>
                            <?php $_smarty_tpl->_assignInScope('active', ((string)$_smarty_tpl->tpl_vars['v']->value['active']));
?>
                            <?php $_smarty_tpl->_assignInScope('sponser_name', ((string)$_smarty_tpl->tpl_vars['v']->value['sponser_name']));
?>
                            <?php $_smarty_tpl->_assignInScope('status', '');
?>
                            <?php if ($_smarty_tpl->tpl_vars['active']->value == 'yes') {?>
                                <?php ob_start();
echo lang('active');
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('status', $_prefixVariable1);
?>

                                <?php $_smarty_tpl->_assignInScope('title', "Block");
?>
                            <?php } else { ?>
                                <?php ob_start();
echo lang('inactive');
$_prefixVariable2=ob_get_clean();
$_smarty_tpl->_assignInScope('status', $_prefixVariable2);
?>
                                <?php $_smarty_tpl->_assignInScope('title', "Activate");
?>
                            <?php }?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value+1;?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>

                                <?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == 'yes') {?>
                                    <b  class="badge label-primary-1"><?php echo $_smarty_tpl->tpl_vars['status']->value;?>
</b>   
                                <?php } else { ?>
                                    <b  class="badge label-primary-2"><?php echo $_smarty_tpl->tpl_vars['status']->value;?>
</b>    
                                <?php }?>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['user_detail_name']->value;?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['sponser_name']->value;?>
</td>
                                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes') {?>
                                    <td>
                                    <?php if (!empty($_smarty_tpl->tpl_vars['v']->value['rank'])) {?> 
                                        <span class="rank_color_code" style="background-color:<?php echo $_smarty_tpl->tpl_vars['v']->value['rank_color'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['rank'];?>
</span>
                                    <?php } else { ?>
                                        <span class="rank_color_code"><?php echo lang('na');?>
</span>
                                    <?php }?>
                                    </td>
                                <?php }?>
                                <td><?php echo $_smarty_tpl->tpl_vars['user_detail_mobile']->value;?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['user_detail_address']->value;?>
</td>
                                <td>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/profile/profile_view/<?php echo $_smarty_tpl->tpl_vars['encrypt_id']->value;?>
" title="View" class="btn-link  text-primary">
                                        <i class="glyphicon glyphicon-camera"></i> 
                                    </a>
                                </td>
                            </tr>
                            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <tr><td colspan="8" align="center"><h4 align="center"> <?php echo lang('No_User_Found');?>
</h4></td></tr>
                    </tbody>
                <?php }?>
            </table>
            </div>
            </div>
        </div>
    <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

    <?php }
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_19583671805f2a96bf5db823_40610419 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php echo '<script'; ?>
>
        jQuery(document).ready(function () {
            ValidateMember.init();
            highlightSearchKey('<?php echo $_smarty_tpl->tpl_vars['search_key']->value;?>
');
        });
    <?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
