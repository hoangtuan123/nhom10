{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    Needacart.com
*  @copyright 2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!-- recaptcha module -->
{if !$error}
<script type="text/javascript" src="//www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
{/if}
<script type="text/javascript">
jQuery(function($) {
{include file="./$include_template.tpl" scope=parent}
{if !$error}
{include file="./recaptcha.tpl" scope=parent}
    {if $debug}
    setTimeout(function() {
        if (RecaptchaState) {
            alert("RecaptchaState: "+JSON.stringify(RecaptchaState));
        }
    }, 3000);
    {/if}
{/if}
});
</script>
<!-- /recaptcha module -->