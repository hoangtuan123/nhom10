<?php /* Smarty version Smarty-3.1.19, created on 2014-10-14 09:29:07
         compiled from "/home/a1941222/public_html/prestashop/admin4942/themes/default/template/controllers/cms_content/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:687900853543c8a739f2825-49693005%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '214d0c21092d9282f7e0dc5aecbbfa756cda58ad' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/admin4942/themes/default/template/controllers/cms_content/content.tpl',
      1 => 1413213064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '687900853543c8a739f2825-49693005',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cms_breadcrumb' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_543c8a73a70f24_76195849',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_543c8a73a70f24_76195849')) {function content_543c8a73a70f24_76195849($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['cms_breadcrumb']->value)) {?>
	<ul class="breadcrumb cat_bar">
		<?php echo $_smarty_tpl->tpl_vars['cms_breadcrumb']->value;?>

	</ul>
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }} ?>
