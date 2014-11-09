<?php /* Smarty version Smarty-3.1.19, created on 2014-10-13 22:38:34
         compiled from "/home/a1941222/public_html/prestashop/admin4942/themes/default/template/helpers/modules_list/modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6015777565434a1e48636e9-43070048%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7512dc4f48ea382843c507985a61e1339c27c47' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/admin4942/themes/default/template/helpers/modules_list/modal.tpl',
      1 => 1413213303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6015777565434a1e48636e9-43070048',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5434a1e48a1837_37028993',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5434a1e48a1837_37028993')) {function content_5434a1e48a1837_37028993($_smarty_tpl) {?><div class="modal fade" id="modules_list_container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smartyTranslate(array('s'=>'Recommended Modules'),$_smarty_tpl);?>
</h3>
			</div>
			<div class="modal-body">
				<div id="modules_list_container_tab_modal" style="display:none;"></div>
				<div id="modules_list_loader"><i class="icon-refresh icon-spin"></i></div>
			</div>
		</div>
	</div>
</div><?php }} ?>
