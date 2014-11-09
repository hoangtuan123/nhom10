<?php /* Smarty version Smarty-3.1.19, created on 2014-11-05 09:56:20
         compiled from "/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/recaptcha.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1407370681545991d49b5846-48122226%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85cb295d1ef59c3d4fff94f2b6f8faf68f518aad' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/recaptcha/views/templates/hook/recaptcha.tpl',
      1 => 1415155742,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1407370681545991d49b5846-48122226',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'public_key' => 0,
    'theme' => 0,
    'lang_iso' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_545991d4aa2443_70629819',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_545991d4aa2443_70629819')) {function content_545991d4aa2443_70629819($_smarty_tpl) {?>
    Recaptcha.create('<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['public_key']->value);?>
', 'recaptcha', {
<?php if ($_smarty_tpl->tpl_vars['theme']->value) {?>
        theme: '<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['theme']->value);?>
',
<?php }?>
        lang: '<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['lang_iso']->value);?>
'
    });<?php }} ?>
