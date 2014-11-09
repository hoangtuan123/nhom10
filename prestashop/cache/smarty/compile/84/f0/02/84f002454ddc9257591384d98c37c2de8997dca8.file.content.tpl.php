<?php /* Smarty version Smarty-3.1.19, created on 2014-10-13 22:38:49
         compiled from "/home/a1941222/public_html/prestashop/admin4942/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7811961165434a1fc09f686-08069824%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '84f002454ddc9257591384d98c37c2de8997dca8' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/admin4942/themes/default/template/content.tpl',
      1 => 1413212799,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7811961165434a1fc09f686-08069824',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5434a1fc0d9228_99513621',
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5434a1fc0d9228_99513621')) {function content_5434a1fc0d9228_99513621($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
