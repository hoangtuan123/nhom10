<?php /* Smarty version Smarty-3.1.19, created on 2014-10-14 09:30:31
         compiled from "/home/a1941222/public_html/prestashop/admin4942/themes/default/template/helpers/list/list_action_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16746903735434a4ccb092b4-81198183%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '07afee0b4b56c8115e0163877f8501c5ebbf1d2e' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/admin4942/themes/default/template/helpers/list/list_action_view.tpl',
      1 => 1413213296,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16746903735434a4ccb092b4-81198183',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5434a4ccb49473_14688214',
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5434a4ccb49473_14688214')) {function content_5434a4ccb49473_14688214($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" >
	<i class="icon-search-plus"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
