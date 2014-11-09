{if $opc}
	{assign var="back_order_page" value="order-opc.php"}
{else}
	{assign var="back_order_page" value="order.php"}
{/if}
<h3 class="sendsms_title">{l s='SMS Notification' mod='sendsms'}</h3>
<p class="checkbox">
	<input type="checkbox" name="sendsms" id="sendsms" value="1" {if $sendsmsPutInCart == 1}checked="checked"{/if} />
	<label for="sendsms">{l s='I want to receive notification by SMS when my order status change.' mod='sendsms'}</label>
	{if $sendsmsPrice > 0}
		({l s='Additional cost of' mod='sendsms'}
		<span class="price">{convertPrice price=$sendsmsPrice}</span>{if $use_taxes}{if $priceDisplay == 1} {l s='(tax excl.)' mod='sendsms'}{else} {l s='(tax incl.)' mod='sendsms'}{/if}{/if})
	{/if}
	<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	{if !$phone}<a href="{$link->getPageLink('address', true, NULL, 'id_address')}{$id_address}&back={$back_order_page}?step=2">{l s='Please enter a valid mobile phone number in your invoice address' mod='sendsms'}</a>{/if}
</p>