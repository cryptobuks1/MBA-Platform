<?php
/* Smarty version 3.1.30, created on 2020-09-25 16:51:50
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/home/replication_link.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d9386bc2979_51953135',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0ee2c8ab8ac2ed42af1d215046bd56c5b5017c1f' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/home/replication_link.tpl',
      1 => 1576299305,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d9386bc2979_51953135 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7339299885f6d9386bc0cf2_47570142', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11593238875f6d9386bc23b1_28050447', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_7339299885f6d9386bc0cf2_47570142 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="col-xs-12">
                        <div class="panel item">
                            <div class="panel-body">
                                
                             <div class="clear pull-left">
                                
                                 <input type="text" id="copyTarget" value="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
"  readonly style="width: 500px;">
                                    <button id="copyButton"  class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"> 
                                    <i class="fa fa-copy text-info"></i><?php echo lang('copy_link');?>

                                    </button>
                             </div>
                        </div>
                    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_11593238875f6d9386bc23b1_28050447 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

     
          <?php echo '<script'; ?>
>
           document.getElementById("copyButton").addEventListener("click", function() {
             copyToClipboard(document.getElementById("copyTarget"));
            });

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        
        target = elem; 
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
          <?php echo '</script'; ?>
>
        
<?php
}
}
/* {/block 'script'} */
}
