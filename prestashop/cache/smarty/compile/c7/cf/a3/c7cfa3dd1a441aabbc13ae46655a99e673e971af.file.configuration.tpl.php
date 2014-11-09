<?php /* Smarty version Smarty-3.1.19, created on 2014-10-29 09:24:31
         compiled from "/home/a1941222/public_html/prestashop/modules/gsitemap/tpl/configuration.tpl" */ ?>
<?php /*%%SmartyHeaderCode:188373657954504fdf6faa31-02651449%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7cfa3dd1a441aabbc13ae46655a99e673e971af' => 
    array (
      0 => '/home/a1941222/public_html/prestashop/modules/gsitemap/tpl/configuration.tpl',
      1 => 1414549359,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188373657954504fdf6faa31-02651449',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gsitemap_store_url' => 0,
    'google_maps_error' => 0,
    'gsitemap_refresh_page' => 0,
    'module_dir' => 0,
    'gsitemap_number' => 0,
    'gsitemap_links' => 0,
    'gsitemap_link' => 0,
    'gsitemap_last_export' => 0,
    'gsitemap_customer_limit' => 0,
    'gsitemap_form' => 0,
    'gsitemap_frequency' => 0,
    'gsitemap_check_image_file' => 0,
    'store_metas' => 0,
    'store_meta' => 0,
    'gsitemap_disable_metas' => 0,
    'prestashop_version' => 0,
    'gsitemap_cron' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_54504fdfbd9395_14401073',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54504fdfbd9395_14401073')) {function content_54504fdfbd9395_14401073($_smarty_tpl) {?><div style="width: 700px; margin: 0 auto;">
</div>
<?php if (isset($_GET['validation'])) {?>
	<div class="conf confirm" style="width: 710px; margin: 0 auto;">
		<?php echo smartyTranslate(array('s'=>'Your Sitemaps were successfully created. Please do not forget to setup the url','mod'=>'gsitemap'),$_smarty_tpl);?>
 <a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_store_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
sitemap.xml" target="_blank"><span style="text-decoration: underline;"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_store_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
sitemap.xml</a></span> <?php echo smartyTranslate(array('s'=>'in your Google Webmaster account','mod'=>'gsitemap'),$_smarty_tpl);?>
.
</div>
<br/>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['google_maps_error']->value)) {?>
	<div class="error" style="width: 710px; margin: 0 auto;">		
		<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['google_maps_error']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<br />	
	</div>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['gsitemap_refresh_page']->value)) {?>
	<fieldset style="width: 700px; margin: 0 auto; text-align: center;">
		<legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Your Sitemaps','mod'=>'gsitemap'),$_smarty_tpl);?>
</legend>
		<p><?php echo intval($_smarty_tpl->tpl_vars['gsitemap_number']->value);?>
 <?php echo smartyTranslate(array('s'=>'Sitemaps were already created.','mod'=>'gsitemap'),$_smarty_tpl);?>
<br/>
		</p>
		<br/>
		<form action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_refresh_page']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="post" id="gsitemap_generate_sitmap">
			<img src="../img/loader.gif" alt=""/>
			<input type="submit" class="button" value="<?php echo smartyTranslate(array('s'=>'Continue','mod'=>'gsitemap'),$_smarty_tpl);?>
" style="display: none;"/>
		</form>
	</fieldset>
<?php } else { ?>
	<?php if ($_smarty_tpl->tpl_vars['gsitemap_links']->value) {?>
		<fieldset style="width: 700px; margin: 0 auto;">
			<legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Your Sitemaps','mod'=>'gsitemap'),$_smarty_tpl);?>
</legend>
			<?php echo smartyTranslate(array('s'=>'Please set up the following Sitemap URL in your Google Webmaster account:','mod'=>'gsitemap'),$_smarty_tpl);?>
<br/> 
			<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_store_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
sitemap.xml" target="_blank"><span style="color: blue;"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_store_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
sitemap.xml</span></a><br/><br/>
			<?php echo smartyTranslate(array('s'=>'This URL is the master Sitemap and refers to:','mod'=>'gsitemap'),$_smarty_tpl);?>

			<div style="max-height: 220px; overflow: auto;">
				<ul>
					<?php  $_smarty_tpl->tpl_vars['gsitemap_link'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['gsitemap_link']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gsitemap_links']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['gsitemap_link']->key => $_smarty_tpl->tpl_vars['gsitemap_link']->value) {
$_smarty_tpl->tpl_vars['gsitemap_link']->_loop = true;
?>
						<li><a target="_blank" style="color: blue;" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_store_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_link']->value['link'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_link']->value['link'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</a></li>
						<?php } ?>
				</ul>
			</div>
			<p><?php echo smartyTranslate(array('s'=>'Your last update was:','mod'=>'gsitemap'),$_smarty_tpl);?>
 <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_last_export']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
		</fieldset>
	<?php }?>
	<br/>
	<?php if (($_smarty_tpl->tpl_vars['gsitemap_customer_limit']->value['max_exec_time']<30&&$_smarty_tpl->tpl_vars['gsitemap_customer_limit']->value['max_exec_time']>0)||($_smarty_tpl->tpl_vars['gsitemap_customer_limit']->value['memory_limit']<128&&$_smarty_tpl->tpl_vars['gsitemap_customer_limit']->value['memory_limit']>0)) {?>
		<div class="warn" style="width: 700px; margin: 0 auto;">
			<p><?php echo smartyTranslate(array('s'=>'For a better use of the module, please make sure that you have','mod'=>'gsitemap'),$_smarty_tpl);?>
<br/>
			<ul>
				<?php if ($_smarty_tpl->tpl_vars['gsitemap_customer_limit']->value['memory_limit']<128&&$_smarty_tpl->tpl_vars['gsitemap_customer_limit']->value['memory_limit']>0) {?>
					<li><?php echo smartyTranslate(array('s'=>'a minimum memory limit of 128MB','mod'=>'gsitemap'),$_smarty_tpl);?>
</li>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['gsitemap_customer_limit']->value['max_exec_time']<30&&$_smarty_tpl->tpl_vars['gsitemap_customer_limit']->value['max_exec_time']>0) {?>
					<li><?php echo smartyTranslate(array('s'=>'a minimum max execution time of 30 sec','mod'=>'gsitemap'),$_smarty_tpl);?>
</li>
					<?php }?>
			</ul>
			<?php echo smartyTranslate(array('s'=>'You can edit these limits in your php.ini. For more details, please contact your hosting providers.','mod'=>'gsitemap'),$_smarty_tpl);?>
</p>
	</div>
<?php }?>
<br/>
<form action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_form']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="post">
	<fieldset style="width: 700px; margin: 0 auto;">
		<legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Configure your Sitemap','mod'=>'gsitemap'),$_smarty_tpl);?>
</legend>
		<p><?php echo smartyTranslate(array('s'=>'Several Sitemaps will be generated depending on how your server is configured and on the number of products activated in your catalog.','mod'=>'gsitemap'),$_smarty_tpl);?>
<br/></p>
		<div class="margin-form">
			<label for="gsitemap_frequency" style="width: 235px;"><?php echo smartyTranslate(array('s'=>'How often do you update your store?','mod'=>'gsitemap'),$_smarty_tpl);?>

				<select name="gsitemap_frequency">
					<option<?php if ($_smarty_tpl->tpl_vars['gsitemap_frequency']->value=='always') {?> selected="selected"<?php }?> value='always'><?php echo smartyTranslate(array('s'=>'always','mod'=>'gsitemap'),$_smarty_tpl);?>
</option>
					<option<?php if ($_smarty_tpl->tpl_vars['gsitemap_frequency']->value=='hourly') {?> selected="selected"<?php }?> value='hourly'><?php echo smartyTranslate(array('s'=>'hourly','mod'=>'gsitemap'),$_smarty_tpl);?>
</option>
					<option<?php if ($_smarty_tpl->tpl_vars['gsitemap_frequency']->value=='daily') {?> selected="selected"<?php }?> value='daily'><?php echo smartyTranslate(array('s'=>'daily','mod'=>'gsitemap'),$_smarty_tpl);?>
</option>
					<option<?php if ($_smarty_tpl->tpl_vars['gsitemap_frequency']->value=='weekly'||$_smarty_tpl->tpl_vars['gsitemap_frequency']->value=='') {?> selected="selected"<?php }?> value='weekly'><?php echo smartyTranslate(array('s'=>'weekly','mod'=>'gsitemap'),$_smarty_tpl);?>
</option>
					<option<?php if ($_smarty_tpl->tpl_vars['gsitemap_frequency']->value=='monthly') {?> selected="selected"<?php }?> value='monthly'><?php echo smartyTranslate(array('s'=>'monthly','mod'=>'gsitemap'),$_smarty_tpl);?>
</option>
					<option<?php if ($_smarty_tpl->tpl_vars['gsitemap_frequency']->value=='yearly') {?> selected="selected"<?php }?> value='yearly'><?php echo smartyTranslate(array('s'=>'yearly','mod'=>'gsitemap'),$_smarty_tpl);?>
</option>
					<option<?php if ($_smarty_tpl->tpl_vars['gsitemap_frequency']->value=='never') {?> selected="selected"<?php }?> value='never'><?php echo smartyTranslate(array('s'=>'never','mod'=>'gsitemap'),$_smarty_tpl);?>
</option>
				</select></label>
		</div>
		<label for="ggsitemap_check_image_file" style="width: 526px;"><?php echo smartyTranslate(array('s'=>'Check this box if you wish to check the presence of the image files on the server','mod'=>'gsitemap'),$_smarty_tpl);?>

			<input type="checkbox" name="gsitemap_check_image_file" value="1" <?php if ($_smarty_tpl->tpl_vars['gsitemap_check_image_file']->value) {?>checked<?php }?>></label>
		<label for="ggsitemap_check_all" style="width: 526px;"><span><?php echo smartyTranslate(array('s'=>'check all','mod'=>'gsitemap'),$_smarty_tpl);?>
</span>
			<input type="checkbox" name="gsitemap_check_all" value="1" class="check"></label>
		<br class="clear" />
		<p for="gsitemap_meta"><?php echo smartyTranslate(array('s'=>'Which page don\'t you want to include in your Sitemap:','mod'=>'gsitemap'),$_smarty_tpl);?>
</p>
		<ul>
			<?php  $_smarty_tpl->tpl_vars['store_meta'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['store_meta']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['store_metas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['store_meta']->key => $_smarty_tpl->tpl_vars['store_meta']->value) {
$_smarty_tpl->tpl_vars['store_meta']->_loop = true;
?>
				<li style="float: left; width: 200px; margin: 1px;">
					<input type="checkbox" class="gsitemap_metas" name="gsitemap_meta[]"<?php if (in_array($_smarty_tpl->tpl_vars['store_meta']->value['id_meta'],$_smarty_tpl->tpl_vars['gsitemap_disable_metas']->value)) {?> checked="checked"<?php }?> value="<?php echo intval($_smarty_tpl->tpl_vars['store_meta']->value['id_meta']);?>
" /> <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['store_meta']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 [<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['store_meta']->value['page'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
]
				</li>
			<?php } ?>
		</ul>
		<br/>
		<div class="margin-form" style="clear: both;">
			<input type="submit" style="margin: 20px;" class="button" name="SubmitGsitemap" onclick="$('#gsitemap_loader').show();" value="<?php echo smartyTranslate(array('s'=>'Generate Sitemap','mod'=>'gsitemap'),$_smarty_tpl);?>
" /><?php echo smartyTranslate(array('s'=>'This can take several minutes','mod'=>'gsitemap'),$_smarty_tpl);?>

		</div>
		<p id="gsitemap_loader" style="text-align: center; display: none;"><img src="../img/loader.gif" alt=""/></p>
	</fieldset>
</form><br />

<p class="info" style="width: 680px; margin: 10px auto;<?php if ($_smarty_tpl->tpl_vars['prestashop_version']->value=='1.4') {?> background: url('../img/admin/help2.png') no-repeat scroll 6px 6px #BDE5F8; border: 1px solid #00529B; border-radius: 3px 3px 3px 3px; color: #00529B; font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 12px; margin-bottom: 15px; min-height: 32px; padding: 10px 5px 5px 40px;<?php }?>">
	<b style="display: block; margin-top: 5px; margin-left: 3px;"><?php echo smartyTranslate(array('s'=>'You have two ways to generate Sitemap:','mod'=>'gsitemap'),$_smarty_tpl);?>
</b><br /><br />
	1. <b><?php echo smartyTranslate(array('s'=>'Manually:','mod'=>'gsitemap'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'using the form above (as often as needed)','mod'=>'gsitemap'),$_smarty_tpl);?>
<br />
	<br /><span style="font-style: italic;"><?php echo smartyTranslate(array('s'=>'-or-','mod'=>'gsitemap'),$_smarty_tpl);?>
</span><br /><br />
	2. <b><?php echo smartyTranslate(array('s'=>'Automatically:','mod'=>'gsitemap'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'Ask your hosting provider to setup a "Cron task" to load the following URL at the time you would like:','mod'=>'gsitemap'),$_smarty_tpl);?>

	<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_cron']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" target="_blank"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gsitemap_cron']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</a><br /><br />
	<?php echo smartyTranslate(array('s'=>'It will automatically generate your XML Sitemaps.','mod'=>'gsitemap'),$_smarty_tpl);?>
<br /><br />
</p>
<?php }?>
<script type="text/javascript">
$(document).ready(function() {
	
	if ($('.gsitemap_metas:checked').length == $('.gsitemap_metas').length)
		$('.check').parent('label').children('span').html("<?php echo smartyTranslate(array('s'=>'uncheck all','mod'=>'gsitemap'),$_smarty_tpl);?>
");
	
	
	$('.check').toggle(function() {
		$('.gsitemap_metas').attr('checked', 'checked');
		$(this).parent('label').children('span').html("<?php echo smartyTranslate(array('s'=>'uncheck all','mod'=>'gsitemap'),$_smarty_tpl);?>
");
	}, function() {
		$('.gsitemap_metas').removeAttr('checked');
		$(this).parent('label').children('span').html("<?php echo smartyTranslate(array('s'=>'check all','mod'=>'gsitemap'),$_smarty_tpl);?>
");
	});
});
</script>
<?php }} ?>
