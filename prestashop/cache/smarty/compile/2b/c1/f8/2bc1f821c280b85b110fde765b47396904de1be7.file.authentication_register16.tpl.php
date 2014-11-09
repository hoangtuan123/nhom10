<?php /* Smarty version Smarty-3.1.19, created on 2014-11-05 09:56:20
         compiled from "/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/authentication_register16.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1690761156545991d465b6f0-32787364%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2bc1f821c280b85b110fde765b47396904de1be7' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/authentication_register16.tpl',
      1 => 1415155742,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1690761156545991d465b6f0-32787364',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_545991d48a98f6_16233866',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_545991d48a98f6_16233866')) {function content_545991d48a98f6_16233866($_smarty_tpl) {?>
<!-- recaptcha module -->
<script type="text/javascript">
$('<div class="clearfix"><span id="recaptcha"><?php if ($_smarty_tpl->tpl_vars['error']->value) {?><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
<?php }?></span></div>').insertBefore($('#submitAccount').parent());
jQuery(function($) {
    $.getScript("//www.google.com/recaptcha/api/js/recaptcha_ajax.js", function() {
<?php if (!$_smarty_tpl->tpl_vars['error']->value) {?>
<?php echo $_smarty_tpl->getSubTemplate ("./recaptcha.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 1);?>

<?php }?> 
    });
});
</script>
<!-- /recaptcha module --><?php }} ?>
