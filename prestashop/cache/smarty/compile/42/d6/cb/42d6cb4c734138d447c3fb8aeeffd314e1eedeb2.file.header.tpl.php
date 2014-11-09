<?php /* Smarty version Smarty-3.1.19, created on 2014-10-22 08:16:45
         compiled from "/home/a1941222/public_html/prestashop/modules/facebooklike/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10950254795447057d87a786-58027671%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '42d6cb4c734138d447c3fb8aeeffd314e1eedeb2' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/facebooklike/header.tpl',
      1 => 1413940574,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10950254795447057d87a786-58027671',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fl_lang_code' => 0,
    'fl_default_image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5447057d9691f7_60148684',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5447057d9691f7_60148684')) {function content_5447057d9691f7_60148684($_smarty_tpl) {?><div id="fb-root"></div>
<script type="text/javascript">

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo $_smarty_tpl->tpl_vars['fl_lang_code']->value;?>
/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>
<?php if ($_smarty_tpl->tpl_vars['fl_default_image']->value) {?>
<meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['fl_default_image']->value;?>
" /> 
<link rel="image_src" href="<?php echo $_smarty_tpl->tpl_vars['fl_default_image']->value;?>
" />
<?php }?><?php }} ?>
