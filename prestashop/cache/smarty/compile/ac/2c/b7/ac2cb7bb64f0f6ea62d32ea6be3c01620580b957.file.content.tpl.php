<?php /* Smarty version Smarty-3.1.19, created on 2014-09-24 11:02:47
         compiled from "C:\xampp\htdocs\prestashop\admin4942\themes\default\template\content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3048254224267adafd3-34802619%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac2cb7bb64f0f6ea62d32ea6be3c01620580b957' => 
    array (
      0 => 'C:\\xampp\\htdocs\\prestashop\\admin4942\\themes\\default\\template\\content.tpl',
      1 => 1406792456,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3048254224267adafd3-34802619',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_54224267b14dd1_62588587',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54224267b14dd1_62588587')) {function content_54224267b14dd1_62588587($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
