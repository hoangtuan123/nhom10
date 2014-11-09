<?php /* Smarty version Smarty-3.1.19, created on 2014-11-05 09:58:16
         compiled from "/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/contact16.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1028766604545992481bb701-06592749%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '169a927ed0a4db8144f78435375a97ea2677bbb3' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/contact16.tpl',
      1 => 1415155742,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1028766604545992481bb701-06592749',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_545992481cb8e1_34375072',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_545992481cb8e1_34375072')) {function content_545992481cb8e1_34375072($_smarty_tpl) {?>
$('<div class="clearfix"><span id="recaptcha"><?php if ($_smarty_tpl->tpl_vars['error']->value) {?><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
<?php }?></span></div>').insertBefore($('#submitMessage').parent());<?php }} ?>
