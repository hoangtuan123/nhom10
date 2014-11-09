<?php /* Smarty version Smarty-3.1.19, created on 2014-10-13 22:39:06
         compiled from "/home/a1941222/public_html/prestashop/admin4942/themes/default/template/controllers/modules/warning_module.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6970727725434a70ce6c255-09021094%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b00e61d786d36d12e819056788d6930d493aa82' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/admin4942/themes/default/template/controllers/modules/warning_module.tpl',
      1 => 1413213135,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6970727725434a70ce6c255-09021094',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5434a70ceabfd7_17188453',
  'variables' => 
  array (
    'module_link' => 0,
    'text' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5434a70ceabfd7_17188453')) {function content_5434a70ceabfd7_17188453($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_link']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</a><?php }} ?>
