<?php /* Smarty version Smarty-3.1.19, created on 2014-10-22 08:14:13
         compiled from "/home/a1941222/public_html/prestashop/modules/likealotmodule/top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:796278227544704e550d0f1-04851355%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df04d7e17abbad354a269d726985a44b921af747' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/likealotmodule/top.tpl',
      1 => 1413940356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '796278227544704e550d0f1-04851355',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'alreadyface' => 0,
    'lang' => 0,
    'app_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_544704e5525596_82359815',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_544704e5525596_82359815')) {function content_544704e5525596_82359815($_smarty_tpl) {?>
<?php if (!$_smarty_tpl->tpl_vars['alreadyface']->value) {?>
    <div id="fb-root"></div>
    <script type="text/javascript">
        var locProt = "//connect.facebook.net/<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
/all.js";
        
            window.fbAsyncInit = function() {
                FB.init({
                    appId: <?php echo $_smarty_tpl->tpl_vars['app_id']->value;?>
, 
                    status: true, 
                    cookie: true,
                    xfbml: true
                });
                fbInitializedCallback()
            };
            (function() {
                var e = document.createElement('script'); 
                e.src = document.location.protocol + locProt;
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());
            function fbInitializedCallback()
            {
                if (typeof fbInitializedLike == 'function')
                    fbInitializedLike();
                if (typeof fbInitializedCreateAccount == 'function')
                    fbInitializedCreateAccount();
            }
        
    </script>
<?php }?><?php }} ?>
