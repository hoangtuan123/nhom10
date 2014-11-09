<?php /* Smarty version Smarty-3.1.19, created on 2014-11-09 10:57:43
         compiled from "/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/authentication16.tpl" */ ?>
<?php /*%%SmartyHeaderCode:224450650545ee6377432d6-75295886%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3c4b1a5cc841aca0d25603cea49b925f088ec56' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/authentication16.tpl',
      1 => 1415155742,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '224450650545ee6377432d6-75295886',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_545ee6377e1fd1_59153896',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_545ee6377e1fd1_59153896')) {function content_545ee6377e1fd1_59153896($_smarty_tpl) {?>
$('<div class="form-group"><span id="recaptcha"><?php if ($_smarty_tpl->tpl_vars['error']->value) {?><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
<?php }?></span></div>').insertBefore($('#SubmitLogin').parent());<?php }} ?>
