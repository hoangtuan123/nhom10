<?php /* Smarty version Smarty-3.1.19, created on 2014-10-22 07:32:32
         compiled from "/home/a1941222/public_html/prestashop/modules/facebookcomments/tab16.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14941924435446fb20f19559-88892728%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ade7654491707891c6e72e05ed31fbdd78014a0c' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/facebookcomments/tab16.tpl',
      1 => 1413937699,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14941924435446fb20f19559-88892728',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'var' => 0,
    'fcbc_scheme' => 0,
    'fcbc_width' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5446fb2108b9b1_40284207',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5446fb2108b9b1_40284207')) {function content_5446fb2108b9b1_40284207($_smarty_tpl) {?><section class="page-product-box">
    <h3 class="page-product-heading"><?php echo smartyTranslate(array('s'=>'Comments','mod'=>'facebookcomments'),$_smarty_tpl);?>
 (<fb:comments-count href="http://<?php echo $_SERVER['HTTP_HOST'];?>
<?php echo $_SERVER['REQUEST_URI'];?>
"></fb:comments-count>)</h3>
    <?php $_smarty_tpl->tpl_vars['fcbc_width'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_width'], null, 0);?>
    <?php $_smarty_tpl->tpl_vars['fcbc_nbp'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_nbp'], null, 0);?>
    <?php $_smarty_tpl->tpl_vars['fcbc_scheme'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_scheme'], null, 0);?>
    
    <style>
    .fb_ltr, .fb_iframe_widget, .fb_iframe_widget span {width: 100%!important}
    </style>
    
    <div id="fcbc" class="">
    <fb:comments href="http://<?php echo $_SERVER['HTTP_HOST'];?>
<?php echo $_SERVER['REQUEST_URI'];?>
" colorscheme="<?php echo $_smarty_tpl->tpl_vars['fcbc_scheme']->value;?>
"  width="<?php echo $_smarty_tpl->tpl_vars['fcbc_width']->value;?>
"></fb:comments>
    </div>
</section><?php }} ?>
