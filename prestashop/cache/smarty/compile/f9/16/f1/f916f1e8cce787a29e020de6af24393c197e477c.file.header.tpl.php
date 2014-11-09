<?php /* Smarty version Smarty-3.1.19, created on 2014-10-28 00:14:33
         compiled from "/home/a1941222/public_html/prestashop/modules/zopimfree/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:390361434544e7d79069766-75882173%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f916f1e8cce787a29e020de6af24393c197e477c' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/zopimfree/header.tpl',
      1 => 1414429850,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '390361434544e7d79069766-75882173',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'widgetid' => 0,
    'customerName' => 0,
    'customerEmail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_544e7d79264404_95110282',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_544e7d79264404_95110282')) {function content_544e7d79264404_95110282($_smarty_tpl) {?><?php if (!isset($_GET['content_only'])) {?>
<!--Start of Zopim Live Chat Script-->

<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//cdn.zopim.com/?<?php echo $_smarty_tpl->tpl_vars['widgetid']->value;?>
';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>

<?php if ($_smarty_tpl->tpl_vars['customerName']->value&&$_smarty_tpl->tpl_vars['customerEmail']->value) {?>

<script>
  $zopim(function() {
    $zopim.livechat.setName('<?php if ($_smarty_tpl->tpl_vars['customerName']->value) {?><?php echo $_smarty_tpl->tpl_vars['customerName']->value;?>
<?php }?>');
    $zopim.livechat.setEmail('<?php if ($_smarty_tpl->tpl_vars['customerEmail']->value) {?><?php echo $_smarty_tpl->tpl_vars['customerEmail']->value;?>
<?php }?>');
  });
</script>

<?php }?>
<!--End of Zopim Live Chat Script-->
<?php }?><?php }} ?>
