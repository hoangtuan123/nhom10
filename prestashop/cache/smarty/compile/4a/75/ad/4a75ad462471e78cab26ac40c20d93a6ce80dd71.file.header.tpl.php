<?php /* Smarty version Smarty-3.1.19, created on 2014-11-05 09:58:16
         compiled from "/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:91066289354599248104c39-00244616%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4a75ad462471e78cab26ac40c20d93a6ce80dd71' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/header.tpl',
      1 => 1415155742,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '91066289354599248104c39-00244616',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
    'debug' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5459924818a2e1_77857369',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5459924818a2e1_77857369')) {function content_5459924818a2e1_77857369($_smarty_tpl) {?>
<!-- recaptcha module -->
<?php if (!$_smarty_tpl->tpl_vars['error']->value) {?>
<script type="text/javascript" src="//www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<?php }?>
<script type="text/javascript">
jQuery(function($) {
<?php echo $_smarty_tpl->getSubTemplate ("./".((string)$_smarty_tpl->tpl_vars['include_template']->value).".tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 1);?>

<?php if (!$_smarty_tpl->tpl_vars['error']->value) {?>
<?php echo $_smarty_tpl->getSubTemplate ("./recaptcha.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 1);?>

    <?php if ($_smarty_tpl->tpl_vars['debug']->value) {?>
    setTimeout(function() {
        if (RecaptchaState) {
            alert("RecaptchaState: "+JSON.stringify(RecaptchaState));
        }
    }, 3000);
    <?php }?>
<?php }?>
});
</script>
<!-- /recaptcha module --><?php }} ?>
