<?php /* Smarty version Smarty-3.1.19, created on 2014-10-22 07:32:02
         compiled from "/home/a1941222/public_html/prestashop/modules/facebookcomments/productfooter.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3075304525446fb0262ba78-90599072%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f710e74f963174864ff3e214209d641caa195fa6' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/facebookcomments/productfooter.tpl',
      1 => 1413937699,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3075304525446fb0262ba78-90599072',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'var' => 0,
    'fcbc_width' => 0,
    'fcbc_nbp' => 0,
    'fcbc_scheme' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5446fb026f13f8_77853543',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5446fb026f13f8_77853543')) {function content_5446fb026f13f8_77853543($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['fcbc_width'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_width'], null, 0);?>
<?php $_smarty_tpl->tpl_vars['fcbc_nbp'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_nbp'], null, 0);?>
<?php $_smarty_tpl->tpl_vars['fcbc_scheme'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_scheme'], null, 0);?>
<div id="fcbcfooter"><div id="fcbc"><div data-href="http://<?php echo $_SERVER['HTTP_HOST'];?>
<?php echo $_SERVER['REQUEST_URI'];?>
" class="fb-comments" data-width="<?php echo $_smarty_tpl->tpl_vars['fcbc_width']->value;?>
" data-num-posts="<?php echo $_smarty_tpl->tpl_vars['fcbc_nbp']->value;?>
"  data-colorscheme="<?php echo $_smarty_tpl->tpl_vars['fcbc_scheme']->value;?>
"></div></div></div><?php }} ?>
