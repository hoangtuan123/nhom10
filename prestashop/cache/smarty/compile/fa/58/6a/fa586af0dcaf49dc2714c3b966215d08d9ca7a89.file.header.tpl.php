<?php /* Smarty version Smarty-3.1.19, created on 2014-10-22 07:31:49
         compiled from "/home/a1941222/public_html/prestashop/modules/facebookcomments/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16881653255446faf5539705-91731259%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa586af0dcaf49dc2714c3b966215d08d9ca7a89' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/facebookcomments/header.tpl',
      1 => 1413937699,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16881653255446faf5539705-91731259',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'var' => 0,
    'fcbc_appid' => 0,
    'fcbc_admins' => 0,
    'fcbc_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5446faf570c605_86167168',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5446faf570c605_86167168')) {function content_5446faf570c605_86167168($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['fcbc_appid'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_appid'], null, 0);?>
<?php $_smarty_tpl->tpl_vars['fcbc_admins'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_admins'], null, 0);?>
<?php $_smarty_tpl->tpl_vars['fcbc_lang'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_lang'], null, 0);?>
<?php $_smarty_tpl->tpl_vars['fcbc_appid'] = new Smarty_variable($_smarty_tpl->tpl_vars['var']->value['fcbc_appid'], null, 0);?> 

<meta property="fb:app_id" content="<?php echo $_smarty_tpl->tpl_vars['fcbc_appid']->value;?>
"/><meta property="fb:admins" content="<?php echo $_smarty_tpl->tpl_vars['fcbc_admins']->value;?>
"/><div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo $_smarty_tpl->tpl_vars['fcbc_lang']->value;?>
/all.js#xfbml=1&appId=<?php echo $_smarty_tpl->tpl_vars['fcbc_appid']->value;?>
";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script><?php }} ?>
