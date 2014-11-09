<?php /* Smarty version Smarty-3.1.19, created on 2014-10-08 09:40:37
         compiled from "/home/a1941222/public_html/prestashop/themes/default-bootstrap/modules/blockwishlist/blockwishlist-extra.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18078182275434a4253b1fb4-45956639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a6ecbc7fe83c67feb063871c1cf9c651d2b73c0' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/themes/default-bootstrap/modules/blockwishlist/blockwishlist-extra.tpl',
      1 => 1412652822,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18078182275434a4253b1fb4-45956639',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id_product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5434a4253dddb9_22570430',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5434a4253dddb9_22570430')) {function content_5434a4253dddb9_22570430($_smarty_tpl) {?>

<p class="buttons_bottom_block no-print">
	<a id="wishlist_button" href="#" onclick="WishlistCart('wishlist_block_list', 'add', '<?php echo intval($_smarty_tpl->tpl_vars['id_product']->value);?>
', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;" rel="nofollow"  title="<?php echo smartyTranslate(array('s'=>'Add to my wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
">
		<?php echo smartyTranslate(array('s'=>'Add to wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>

	</a>
</p>
<?php }} ?>
