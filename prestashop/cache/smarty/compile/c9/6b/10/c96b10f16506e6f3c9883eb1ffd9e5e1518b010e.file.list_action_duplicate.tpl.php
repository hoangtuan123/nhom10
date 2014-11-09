<?php /* Smarty version Smarty-3.1.19, created on 2014-10-13 22:40:12
         compiled from "/home/a1941222/public_html/prestashop/admin4942/themes/default/template/helpers/list/list_action_duplicate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8846864475434a3ff05fd60-50679385%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c96b10f16506e6f3c9883eb1ffd9e5e1518b010e' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/admin4942/themes/default/template/helpers/list/list_action_duplicate.tpl',
      1 => 1413213291,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8846864475434a3ff05fd60-50679385',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5434a3ff0ebb71_32274871',
  'variables' => 
  array (
    'action' => 0,
    'confirm' => 0,
    'location_ok' => 0,
    'location_ko' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5434a3ff0ebb71_32274871')) {function content_5434a3ff0ebb71_32274871($_smarty_tpl) {?>
<a href="#" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')) document.location = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['location_ok']->value, ENT_QUOTES, 'UTF-8', true);?>
'; else document.location = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['location_ko']->value, ENT_QUOTES, 'UTF-8', true);?>
'; return false;">
	<i class="icon-copy"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>
