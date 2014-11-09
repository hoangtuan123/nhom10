<?php /* Smarty version Smarty-3.1.19, created on 2014-10-08 10:47:29
         compiled from "/home/a1941222/public_html/prestashop/modules/blockcategories/views/blockcategories_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19769628935434b3d1c17639-00123475%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c67fa65615777a992c5f62b5fbadd4845e9a7595' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/blockcategories/views/blockcategories_admin.tpl',
      1 => 1412650847,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19769628935434b3d1c17639-00123475',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'helper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5434b3d1c47a11_00371250',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5434b3d1c47a11_00371250')) {function content_5434b3d1c47a11_00371250($_smarty_tpl) {?><div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?php echo smartyTranslate(array('s'=>'You can upload a maximum of 3 images.','mod'=>'blockcategories'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Thumbnails','mod'=>'blockcategories'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-4">
		<?php echo $_smarty_tpl->tpl_vars['helper']->value;?>

	</div>
</div><?php }} ?>
