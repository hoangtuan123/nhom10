<?php /* Smarty version Smarty-3.1.19, created on 2014-10-22 08:14:13
         compiled from "/home/a1941222/public_html/prestashop/modules/likealotmodule/head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:760598239544704e53d55d5-00090534%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec561ed4e8ba6988387135d49515d44602983478' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/likealotmodule/head.tpl',
      1 => 1413940356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '760598239544704e53d55d5-00090534',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product' => 0,
    'link' => 0,
    'description' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_544704e544cde7_34569714',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_544704e544cde7_34569714')) {function content_544704e544cde7_34569714($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['product']->value) {?>
	<meta property="og:title" content="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
    <meta property="og:type" content="product"/>
    <meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'medium');?>
"/>
    <meta property="og:description" content="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['description']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
    <meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'];?>
<?php echo $_SERVER['REQUEST_URI'];?>
"/>
<?php }?><?php }} ?>
