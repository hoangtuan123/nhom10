<?php /* Smarty version Smarty-3.1.19, created on 2014-10-22 08:14:21
         compiled from "/home/a1941222/public_html/prestashop/modules/likealotmodule/likealot.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1569508830544704ed79bdf9-72485393%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '26051ea15756407ba3148ede9b4d985e61a13144' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/likealotmodule/likealot.tpl',
      1 => 1413940356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1569508830544704ed79bdf9-72485393',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'action' => 0,
    'faces' => 0,
    'send' => 0,
    'width' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_544704ed7f0e36_16688776',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_544704ed7f0e36_16688776')) {function content_544704ed7f0e36_16688776($_smarty_tpl) {?><p>
	<fb:like 
    	ref="under_price" 
        href="<?php echo $_SERVER['HTTP_HOST'];?>
<?php echo $_SERVER['REQUEST_URI'];?>
" 
        action="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" 
        show_faces="<?php echo $_smarty_tpl->tpl_vars['faces']->value;?>
"
        send="<?php echo $_smarty_tpl->tpl_vars['send']->value;?>
"
        width="<?php echo $_smarty_tpl->tpl_vars['width']->value;?>
"
        height="23" 
        font="Arial">
     </fb:like>
</p><?php }} ?>
